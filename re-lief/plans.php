<?php
/**
 * Template Name: Plans
 *
 */
global $wpdb;
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url());
    exit;
}


$user_id = get_current_user_id();
$user_info = get_userdata($user_id);

?>

<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__) . 'style.css'; ?>">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="<?php echo plugin_dir_url(__FILE__) . 'script.js'; ?>"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plans</title>
</head>
<body>
    <header>
        <?php get_header() ?>
    </header>
    <section class="plans">
        <div class="container"> 
            <div class="selector">
                <?php
                    $sql = "SELECT p.*, pm.meta_value AS price
                            FROM {$wpdb->prefix}posts p
                            INNER JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id
                            WHERE p.post_type = 'memberpressproduct' 
                            AND pm.meta_key = '_mepr_product_price'
                            ORDER BY CAST(pm.meta_value AS DECIMAL(10,2))";
                    $results = $wpdb->get_results($sql);
                    foreach ($results as $result) {
                ?>
                <div class="single-plan col-md-4">
                    <div class="plan-content">
                        <h2><?php echo $result->post_title; ?></h2> 
                         <p><?php echo $result->post_content; ?></p>        
                    </div>  
                   <div class="price">
                    <form method="post">
                        <input type="hidden" name="plan_id" id="selected_plan_id" value="<?php echo $result->ID ?>">
                        <input type="hidden" name="price" id="price" value="<?php echo $result->price ?>">
                        <?php
                            $precio_en_euros = number_format($result->price, 2, ',', '.') . ' €';
                            echo "<button class='add-plan-btn' data-plan-id='{$result->ID}' data-price='{$precio_en_euros}'>$precio_en_euros</button>";

                        ?>
                    </form>
                   </div>
                </div>
                <?php
                    }

                ?>
            </div>            
        </div>
    </section>
     
</body>
</html>
<?php


if (is_plugin_active('memberpress/memberpress.php')) {
    
    $memberpress_dir = plugin_dir_path(WP_PLUGIN_DIR . '/memberpress/memberpress.php');
    require_once $memberpress_dir . 'app/controllers/MeprTransactionsCtrl.php';
    require_once $memberpress_dir . 'app/controllers/MeprApiCtrl.php';
    
    
    if (isset($_POST['plan_id'])) {
            $plan_id = sanitize_text_field($_POST['plan_id']);
            $table_name = $wpdb->prefix . 'mepr_subscriptions';
            $sql = $wpdb->prepare(
                "SELECT ID FROM $table_name
                WHERE user_id = %d AND product_id = %d AND status = %s",
                $user_id,
                $plan_id,
                'active'
            );
            $subscription_id = $wpdb->get_var($sql);

            if ($subscription_id){
                $error_message = __('This user has already a subscription', 're-lief');
                echo $error_message;
            } else {
                $price =floatval($_POST['price']);
                if ($price === 0.00) {
                    $subscription = new MeprSubscription();
                    $subscription->user_id = $user_id;
                    $subscription->product_id = $plan_id;
                    $subscription->status = MeprSubscription::$active_str;
                    $result = $subscription->store();
                    if ($result) {
                        $txn = new MeprTransaction();
                        $txn->user_id = $user_id;               
                        $txn->product_id = $plan_id;
                        $txn->txn_type = MeprTransaction::$payment_str;
                        $txn->status = MeprTransaction::$complete_str;
                        $txn->subscription_id = $result;
                        $txn_id = $txn->store();
                        if ($txn_id) {
                            $message = __("Subscription and Transaction created successfully. Subscription ID: {$subscription->id}, Transaction ID: {$txn_id}", "re-lief");
                            echo $message;
                            wp_redirect(home_url('/my-account/'));
                            exit;
                        } else if (is_wp_error($txn_id)) {
                            $error_message = __('Error creating transaction: ' . $txn_id->get_error_message(), 're-lief');
                            echo $error_message;
                        } else {
                            $error_message = __("Something isn't working right", 're-lief');
                            echo $error_message;
                        } 
                    } else if (is_wp_error($result)) {
                        $error_message = __('Error creating subscription: ' . $result->get_error_message(), 're-lief');
                        echo $error_message; 
                    } else {
                        $error_message = __("Error creating subscription", 're-lief');
                        echo $error_message;
                    }
                } else {
                    $error_message = __("Se necesita pago con stripe", 're-lief');
                    echo $error_message; 
                }
            }
        }
    }
?>
