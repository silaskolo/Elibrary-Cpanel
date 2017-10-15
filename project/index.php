<?php
// Start Browser Session
session_start();

require_once "../config/functions.php";

//Check is User Session Exist i.e if user is logged in
//if (!is_logged_in())
//redirect_to("login.php"); //Redirect user to Login if not logged in

$project_query = sprintf("SELECT * FROM app_project WHERE isActive='%s' AND bookStatus='%s'", ACTIVE, STATE_SUCCESS);
$project_result = $connection->query($project_query);

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
                    <th>Project Name</th>
                    <th>Project Year</th>
                    <th>Project Course</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php

                if ($project_result) {
                    $count = 0;
                    while ($project = $project_result->fetch_assoc()) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo ++$count; ?></th>
                            <td><?php echo $project['projectName']; ?></td>
                            <td><?php echo $project['projectYear']; ?></td>
                            <td><?php echo $project['courseID']; ?></td>
                            <td><?php echo $project['projectID']; ?></td>
                        </tr>
                        <?php
                    }
                } else {

                    ?>
                    <tr>
                        <th colspan="5" class="text-center">It's Lonely Here</th>
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
