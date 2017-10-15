<?php
// Start Browser Session
session_start();

require_once "../config/functions.php";

//Check is User Session Exist i.e if user is logged in
//if (!is_logged_in())
//redirect_to("login.php"); //Redirect user to Login if not logged in

$question_query = sprintf("SELECT * FROM app_question WHERE isActive='%s' AND bookStatus='%s'", ACTIVE, STATE_SUCCESS);
$question_result = $connection->query($question_query);

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
                    <th>Question Year</th>
                    <th>Question Course</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php

                if ($question_result) {
                    $count = 0;
                    while ($question = $question_result->fetch_assoc()) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo ++$count; ?></th>
                            <td><?php echo $question['questionYear']; ?></td>
                            <td><?php echo $question['courseID']; ?></td>
                            <td><?php echo $question['questionID']; ?></td>
                        </tr>
                        <?php
                    }
                } else {

                    ?>
                    <tr>
                        <th colspan="4" class="text-center">It's Lonely Here</th>
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
