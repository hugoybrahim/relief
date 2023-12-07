<?php
/**
 * Template Name: Account Info
 *
 */

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
    <title>My account</title>
</head>
<body>
    <header>
        <?php get_header() ?>
    </header>
    <section class="sidebar-section">
        <div id="sidebar">
            <h1>Sidebar Title</h1>
            <?php
                wp_nav_menu(array(
                    'theme_location' => 'sidebar-menu',
                    'container'      => 'ul',
                    'menu_id'        => 'menu',
                ));
            ?>
        </div>
        <button id="toggleSidebar" class="hamburger">&#9776;</button>
    </section>
    <section class="account">
        <div class="container">
            <div class="form-customer">
                <form method="post" action="">
                    <div class="two-labels">
                        <div class="col-md-6">
                            <!-- <label for="first">First Name</label> -->
                            <input type="text" name="first" placeholder="First Name*" value="<?php echo get_user_meta($user_id, 'first_name', true)?>">
                        </div>
                        <div class="col-md-6">
                            <!-- <label for="last">Last Name</label> -->
                            <input type="text" name="last" placeholder="Last Name*" value="<?php echo get_user_meta($user_id, 'last_name', true) ?>">
                        </div>
                    </div>

                    <div class="two-labels">
                        <div class="col-md-6">
                            <!-- <label for="company">Company</label> -->
                            <input type="text" name="company" placeholder="Company*" value="<?php echo get_user_meta($user_id, 'company', true) ?>">
                        </div>
                        <div class="col-md-6">
                            <!-- <label for="tin">TIN</label> -->
                            <input type="text" name="tin" placeholder="TIN*" value="<?php echo get_user_meta($user_id, 'tin', true) ?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- <label for="address"> Address Line 1</label> -->
                        <input type="text" name="address" placeholder="Address Line 1*" value="<?php echo get_user_meta($user_id, 'address', true) ?>">
                    </div>
                    <div class="col-md-12">
                        <!-- <label for="address2"> Address Line 2</label> -->
                        <input type="text" name="address2" placeholder="Address Line 2" value="<?php echo get_user_meta($user_id, 'address2', true) ?>">
                    </div>
                    <div class="col-md-12">
                        <!-- <label for="city"> City</label> -->
                        <input type="text" name="city" placeholder="City*"  value="<?php echo get_user_meta($user_id, 'city', true) ?>">
                    </div>
                    <div class="col-md-12">
                        <!-- <label for="country"> Country</label> -->
                        <select class="select-country" name="select-country" id="select-country" style="width:100%; border: 1px solid #ddd;">
                            <?php
                                $id=get_user_meta($user_id, 'country', true);
                                $countryp=get_post(intval($id));
                            ?>
                            <option value="<?php echo $countryp->ID ?>" > <?php echo $countryp->post_title ?></option>
                            <?php
                                $countries = get_posts(array(
                                    'post_type'      => 'country',
                                    'posts_per_page' => -1,
                                ));
                                if (!empty( $countries )){
                                    foreach ($countries as $country) {
                                        echo "<option value='{$country->ID}'> {$country->post_title} </option>";
        
                                    }
                                }
                            ?>  
                        </select>
                    </div>
                    <div class="col-md-12">
                        <!-- <label for="state"> State/Province </label> -->
                        <input type="text" name="state" placeholder="State/Province*" value="<?php echo get_user_meta($user_id, 'state', true) ?>"> 
                    </div>
                    <div class="col-md-12">
                        <!-- <label for="zip"> Zip/Postral Code</label> -->
                        <input type="text" name="zip" placeholder="Zip/Postral Code*" value="<?php echo get_user_meta($user_id, 'zip_code', true) ?>">
                    </div>

                    <div class="col-md-12">
                        <!-- <label for="email"> Email</label> -->
                        <input type="email" name="email" placeholder="Email*" value="<?php echo $user_info->user_email ?>">
                    </div>

                    <div class="two-labels">
                       <!--  <div class="col-md-4">
                            <select name="phone-country" class="form-control" value="<?php ?>">
                                <option>Country Code*</option>
                                <option value="+1">United States (+1)</option>
                                <option value="+44">United Kingdom (+44)</option>
                            </select>
                        </div> -->
                        <div class="col-md-12">  
                            <!-- <label for="phone"> Phone Number</label> -->
                            <input type="tel" name="phone" placeholder="Phone Number*" value="<?php echo get_user_meta($user_id, 'phone', true) ?>"> 
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- <label for="user"> Username</label> -->
                        <input type="text" name="user" placeholder="Username*" value="<?php echo get_user_meta($user_id, 'nickname', true) ?>">
                    </div>
                    <div class="col-md-12">
                        <input type="submit" name="update" value="Update">
                    </div>
                </form>
                
            </div>
        </div>
    </section>
</body>
</html>
<?php
cambiar_enlace_login_logout();

if (isset($_POST['update'])) {
    $first_name = sanitize_text_field($_POST['first']);
    $last_name = sanitize_text_field($_POST['last']);
    $company = sanitize_text_field($_POST['company']);
    $tin = sanitize_text_field($_POST['tin']);
    $address = sanitize_text_field($_POST['address']);
    $address2 = sanitize_text_field($_POST['address2']);
    $city = sanitize_text_field($_POST['city']);
    $country = sanitize_text_field($_POST['select-country']);
    $state = sanitize_text_field($_POST['state']);
    $zip_code = sanitize_text_field($_POST['zip']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $username = sanitize_text_field($_POST['user']);


    update_user_meta($user_id, 'first_name', $first_name);
    update_user_meta($user_id, 'last_name', $last_name);
    update_user_meta($user_id, 'company', $company);
    update_user_meta($user_id, 'tin', $tin);
    update_user_meta($user_id, 'address', $address);
    update_user_meta($user_id, 'address2', $address2);
    update_user_meta($user_id, 'city', $city);
    update_user_meta($user_id, 'country', $country);
    update_user_meta($user_id, 'state', $state);
    update_user_meta($user_id, 'zip_code', $zip_code);
    update_user_meta($user_id, 'user_email', $email);
    update_user_meta($user_id, 'phone', $phone);
    update_user_meta($user_id, 'nickname', $username);

    wp_redirect(home_url('/my-account'));
    exit;
}


