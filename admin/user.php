<?php
// Start Browser Session
session_start();

require_once "../config/functions.php";

//Check is User Session Exist i.e if user is logged in
if (!is_logged_in())
    redirect_to("login.php"); //Redirect user to Login if not logged in

$user_query = sprintf("SELECT * FROM app_user WHERE isActive='%s' AND userStatus='%s'", ACTIVE, STATE_SUCCESS);
$user_result = $connection->query($user_query);

$access_query = sprintf("SELECT * FROM app_user_access WHERE isActive='%s' AND accessStatus='%s'", ACTIVE, STATE_SUCCESS);
$access_result = $connection->query($access_query);
$access_array = array();
while($access = mysqli_fetch_array($access_result))
{
    $access_array[$access['accessID']] = $access['accessName'];
}

include "../includes/header.php";
include "../includes/navbar.php"
?>
<div class="container">
    <div class="row mt-5">
        <div class="col">
            <table class="table table-light">
                <thead class="thead-default">
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>User Access</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php

                if ($user_result && $user_result->num_rows) {
                    $count = 0;
                    while ($user = $user_result->fetch_assoc()) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo ++$count; ?></th>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['userFname']; ?></td>
                            <td><?php echo $user['userLname']; ?></td>
                            <td><?php echo $user['userEmail']; ?></td>
                            <td><?php echo $access_array[$user['accessID']]; ?></td>
                            <td><?php echo $user['userID']; ?></td>
                        </tr>
                        <?php
                    }
                } else {

                    ?>
                    <tr>
                        <th colspan="7" class="text-center">It's Lonely Here</th>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
include "../includes/footer.php";
?>
