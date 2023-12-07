<?php
/**
 * Template Name: Info-login
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
    <title>Create Account</title>
</head>

<body>
    <header>
        <?php get_header()  ?>
    </header>
    <section class="title">
        <div class="container">
            <h2>Information</h2>
            <div class="info-p">
                <p> Relief the most advance booking system.	</p>
                <p> Regardless of the type of business, if you have to manage the services you provide on an hourly basis, with Relief you will be able to:</p>
                <ul>
                    <li>
                        Create the best booking experience for your customers.
                    </li>
                    <li>
                        Offer a possibility to share and exchange bookings securely in the Marketplace/waiting list.
                    </li>
                    <li>
                        Keep your business full, minimize the risk of empty bookings and reduce idle capacity without creating barriers to entry for your customers.
                    </li>
                </ul>
                <p>If you are interested in signing up for Relief, we have two plans so you can choose the plan that best fits your business. In any case, we want to be sure that Relief brings a qualitative leap in the management of your business, so we allow you one month of free trials so you can explore all that Relief can offer you:</p>
                <h2>Start now</h2>
                <div class="separator"></div>
            </div>
        </div>
    </section>

    <section class="selects">
        <div class="container">
            <form id="info-form" method="post">
                <div class="space">
                    <div class="country">
                        <span>Select a country</span>
                        <select class="select-country" name="selected_country" id="select-country">
                            <option value=""></option>
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
                        <i></i>
                    </div>
                    <div class="business">
                        <span>Select a Business</span>
                        <select class="select-business" name="selected_business" id="select-business">
                            <option value=""></option>
                            <?php
                                $business = get_posts(array(
                                    'post_type'      => 'business',
                                    'posts_per_page' => -1,
                                ));
                                if (!empty( $business )){
                                    foreach ($business as $key) {
                                        echo "<option value='{$key->ID}'> {$key->post_title} </option>";
        
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="sign-button">
                    <input type="submit" class="mepr-submit" name="sing" value="Sign Up">   
                </div>
            </form>
            <input type="hidden" id="hidden-country" name="hidden_country">
            <input type="hidden" id="hidden-business" name="hidden_business">
        </div>
        </section>
    
</body>
</html>

<script>
        $(document).ready(function () {
        $("#info-form").submit(function (event) {
            event.preventDefault();

            var selectedCountry = $("#select-country").val();
            var selectedBusiness = $("#select-business").val();

            var dynamicForm = $("<form>", {
                action: "/customer-information",
                method: "post"
            });

            dynamicForm.append(
                $("<input>", {
                    type: "hidden",
                    name: "selected_country",
                    value: selectedCountry
                }),
                $("<input>", {
                    type: "hidden",
                    name: "selected_business",
                    value: selectedBusiness
                })
            );

            $("body").append(dynamicForm);
            dynamicForm.submit();
        });
    });
</script>
