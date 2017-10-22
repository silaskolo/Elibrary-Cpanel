<?php
// Start Browser Session
session_start();

require_once "../config/functions.php";

//Check is User Session Exist i.e if user is logged in
if (!is_logged_in())
    redirect_to(APP_ROOT . "/login.php"); //Redirect user to Login if not logged in

$question_query = sprintf("SELECT * FROM app_past_questions WHERE isActive='%s' AND questionStatus='%s'", ACTIVE, STATE_SUCCESS);
$question_result = $connection->query($question_query);

$course_query = sprintf("SELECT * FROM app_course WHERE isActive='%s' AND courseStatus='%s'", ACTIVE, STATE_SUCCESS);
$course_result = $connection->query($course_query);
$course_array = array();
while($course = mysqli_fetch_array($course_result))
{
    $course_array[$course['courseID']] = $course['courseName'];
}

$semester_query = sprintf("SELECT * FROM app_semester WHERE isActive='%s' AND semesterStatus='%s'",ACTIVE,STATE_SUCCESS);
$semester_result = $connection->query($semester_query);
$semester_array = array();
while($semester = mysqli_fetch_array($semester_result))
{
    $semester_array[$semester['semesterID']] = $semester['semesterName'];
}

$type_query = sprintf("SELECT * FROM app_past_question_type WHERE isActive='%s' AND typeStatus='%s'",ACTIVE,STATE_SUCCESS);
$type_result = $connection->query($type_query);
$type_array = array();
while($type = mysqli_fetch_array($type_result))
{
    $type_array[$type['typeID']] = $type['typeName'];
}

include "../includes/header.php";
include "../includes/navbar.php"
?>
<div class="container">
    <div class="row mt-5">
        <div class="col">
            <a href="json.php" class="btn btn-danger btn-lg" role="button" target="_blank">View JSON</a>
            <br />
            <table class="table table-light">
                <thead class="thead-default">
                <tr>
                    <th>#</th>
                    <th>Question Course</th>
                    <th>Question Year</th>
                    <th>Question Semester</th>
                    <th>Question Type</th>
                    <th>Question File</th>
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
                            <td><?php echo $course_array[$question['courseID']]; ?></td>
                            <td><?php echo $question['questionYear']; ?></td>
                            <td><?php echo $semester_array[$question['semesterID']]; ?></td>
                            <td><?php echo $type_array[$question['typeID']]; ?></td>
                            <td><a target="_blank" class="btn btn-primary" href="<?php echo APP_UPLOADS."questions/".$question['questionFileLocation']; ?>">View</a></td>
                            <td><a class="btn btn-danger" href="edit.php?questionID=<?php echo $question['questionID']; ?>">Edit</a></td>
                        </tr>
                        <?php
                    }
                } else {

                    ?>
                    <tr>
                        <th colspan="6" class="text-center">It's Lonely Here</th>
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
