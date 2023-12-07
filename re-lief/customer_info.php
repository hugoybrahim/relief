<?php
/**
 * Template Name: Customer Info
 *
 */

?>

<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__) . 'style.css'; ?>">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Information</title>
</head>
<body>
    <header>
        <?php get_header()  ?>
    </header>
    <section class="form">
        <div class="container">
            <div class="form-customer">
                <form onsubmit="return validatePassword()" method="post" action="">
                    <div class="two-labels">
                        <div class="col-md-6">
                            <!-- <label for="first">First Name</label> -->
                            <input type="text" name="first" placeholder="First Name*" required>
                        </div>
                        <div class="col-md-6">
                            <!-- <label for="last">Last Name</label> -->
                            <input type="text" name="last" placeholder="Last Name*" required>
                        </div>
                    </div>

                    <div class="two-labels">
                        <div class="col-md-6">
                            <!-- <label for="company">Company</label> -->
                            <input type="text" name="company" placeholder="Company*" required>
                        </div>
                        <div class="col-md-6">
                            <!-- <label for="tin">TIN</label> -->
                            <input type="text" name="tin" placeholder="TIN*" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- <label for="address"> Address Line 1</label> -->
                        <input type="text" name="address" placeholder="Address Line 1*" required>
                    </div>
                    <div class="col-md-12">
                        <!-- <label for="address2"> Address Line 2</label> -->
                        <input type="text" name="address2" placeholder="Address Line 2" >
                    </div>
                    <div class="col-md-12">
                        <!-- <label for="city"> City</label> -->
                        <input type="text" name="city" placeholder="City*"  required>
                    </div>
                    <div class="col-md-12">
                        <!-- <label for="country"> Country</label> -->
                        <!-- <input type="text" name="country" placeholder="Country*" required> -->
                        <select class="select-country" name="select-country" id="select-country" style="width:100%; border: 1px solid #ddd;">
                            <?php
                                $country=get_post(intval($_POST['selected_country']));
                            ?>
                            <option value="<?php echo $country->ID ?>" > <?php echo $country->post_title ?></option>
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
                        <input type="text" name="state" placeholder="State/Province*" required> 
                    </div>
                    <div class="col-md-12">
                        <!-- <label for="zip"> Zip/Postral Code</label> -->
                        <input type="text" name="zip" placeholder="Zip/Postral Code*" required>
                    </div>

                    <div class="col-md-12">
                        <!-- <label for="email"> Email</label> -->
                        <input type="email" name="email" placeholder="Email*" required>
                    </div>

                    <div class="two-labels">
                        <!-- <div class="col-md-4"> -->
                            <!-- <label for="country">Country</label> -->
                           <!--  <select name="phone-country" class="form-control" required>
                                <option>Country Code*</option>
                                <option value="+1">United States (+1)</option>
                                <option value="+44">United Kingdom (+44)</option>
                            </select>
                        </div> -->
                        <!-- <div class="col-md-8"> -->
                        <div class="col-md-12">
                            <!-- <label for="phone"> Phone Number</label> -->
                            <input type="tel" name="phone" placeholder="Phone Number*" required> 
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- <label for="user"> Username</label> -->
                        <input type="text" name="user" placeholder="Username*" required>
                    </div>
                    
                    <div class="two-labels">
                        <div class="col-md-6">
                            <!-- <label for="password"> Password</label> -->
                            <input type="password" name="password" placeholder="Password*" required>
                        </div>
                        <div class="col-md-6">

                            <!-- <label for="password_confirmation"> Password Confirmation</label> -->
                            <input type="password" name="password_confirmation" placeholder="Password Confirmation*" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <input type="submit" name="submit" value="Send">
                    </div>
                </form>
                
            </div>
        </div>
    </section>

</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Recuperar datos del formulario
    $first = sanitize_user($_POST['first']);
    $last = sanitize_text_field($_POST['last']);
    $company  = sanitize_text_field($_POST['company']);
    $tin = sanitize_text_field($_POST['tin']);
    $address  = sanitize_text_field($_POST['address']);
    $address2  = sanitize_text_field($_POST['address2']);
    $city   = sanitize_text_field($_POST['city']);
    $country = sanitize_text_field($_POST['select-country']);
    $state = sanitize_text_field($_POST['state']);
    $zip = sanitize_text_field($_POST['zip']);
    $email = sanitize_email($_POST['email']);
    //$phone_country = sanitize_text_field($_POST['phone-country']);
    $phone = sanitize_text_field($_POST['phone']);
    $user = sanitize_text_field($_POST['user']);
    $password = $_POST['password'];

    $user_data = array(
        'user_login'    => $user,
        'user_pass'     => $password,
        'user_email'    => $email,
        'role'          => 'subscriber', 
        'first_name'    => $first,
        'last_name'     => $last,
        'email'         => $email,
    );
    
/*     echo '<pre>';
    var_dump($user_data);
    echo '</pre>';
    die(); */

    $user_id = wp_insert_user($user_data);

    update_user_meta($user_id, 'address', $address);
    update_user_meta($user_id, 'address2', $address2);
    update_user_meta($user_id, 'zip_code', $zip);
    update_user_meta($user_id, 'company', $company);
    update_user_meta($user_id, 'tin', $tin);
    update_user_meta($user_id, 'city', $city);
    update_user_meta($user_id, 'country', $country);
    update_user_meta($user_id, 'state', $state);
    update_user_meta($user_id, 'phone', $phone);

    if (is_wp_error($user_id)) {
        echo 'Error al crear el usuario: ' . $user_id->get_error_message();
    } else {
        echo 'Usuario creado exitosamente. ID del usuario: ' . $user_id;
        
        $creds = array(
            'user_login'    => $user,
            'user_password' => $password,
            'remember'      => true,
        );

        $user = wp_signon($creds);

        if (is_wp_error($user)) {
            echo 'Error al iniciar sesión: ' . $user->get_error_message();
        } else {
            wp_redirect(home_url('/plans/'));
           exit;
        }
    }
}  
?>
<script>
    function validatePassword() {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('password_confirmation').value;

        if (password !== confirmPassword) {
            alert('Las contraseñas no coinciden. Por favor, inténtalo de nuevo.');
            return false; 
        }
        return true; 
    }
</script>