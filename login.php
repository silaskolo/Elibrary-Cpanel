<?php
session_start();

require_once "config/functions.php";

if (is_logged_in())
    redirect_to("index.php"); //Redirect user to Home Page if logged in

if (isset($_POST['action']) && $_POST['action'] == "login") {
    $email = $connection->escape_string(trim($_POST['txtEmail']));
    $password = $connection->escape_string(trim($_POST['txtPassword']));

    $has_error = false;
    $error_message = [];

    if (empty($email)) {
        $has_error = true;
        $error_message["txtEmail"] = "Please Enter Email";
    } elseif (strlen($email) < 4) {
        $has_error = true;
        $error_message["txtEmail"] = "Email is too Short";
    }

    if (empty($password)) {
        $has_error = true;
        $error_message["txtPassword"] = "Please Enter Password";
    } elseif (strlen($password) < 6) {
        $has_error = true;
        $error_message["txtPassword"] = "Password is too Short";
    }

    if ($has_error) {
        $error_message["form"] = sprintf("%d Error(s) found", count($error_message));
    } else {
        if (login_user($connection,$email, $password)) {
            redirect_to("index.php");
        } else {
            $error_message["form"] = "Email / Password is Incorrect";
        }
    }

}
include "includes/header.php";
?>
    <div class="container login-container">
        <div class="row">
            <div class="col logo-div">
                <img src="<?php echo APP_ROOT; ?>/assets/img/logo_white.png" alt="..." class="login-logo">
            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-md-auto form-portlet">
                <?php if(isset($error_message["form"])){ ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message["form"] ?>
                </div>
                <?php } ?>
                <form method="post" action="#">
                    <div class="form-group">
                        <label for="txtEmail">Email</label>
                        <input type="email" name="txtEmail" id="txtEmail"
                               class="form-control <?php echo isset($error_message['txtEmail'])?'is-invalid':'' ?>"
                               value="<?php echo isset($_POST['txtEmail']) ? $_POST['txtEmail'] : ''; ?>"/>
                        <div class="invalid-feedback">
                            <?php echo isset($error_message['txtEmail'])?$error_message['txtEmail']:'' ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txtPassword">Password</label>
                        <input type="password" name="txtPassword" id="txtPassword"
                               class="form-control <?php echo isset($error_message['txtPassword'])?'is-invalid':'' ?>"
                               />
                        <div class="invalid-feedback">
                            <?php echo isset($error_message['txtPassword'])?$error_message['txtPassword']:'' ?>
                        </div>
                    </div>
                    <button class="btn btn-danger" type="submit">Login</button>
                    <input type="hidden" name="action" value="login">
                </form>
            </div>
        </div>
    </div>
<?php

include "includes/footer.php";

?>