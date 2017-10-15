<?php
// Start Browser Session
session_start();

require_once "config/functions.php";

//Check is User Session Exist i.e if user is logged in
//if (!is_logged_in())
    //redirect_to("login.php"); //Redirect user to Login if not logged in

$book_query = sprintf("SELECT COUNT(*) FROM app_book WHERE isActive='%s' AND bookStatus='%s'",ACTIVE,STATE_SUCCESS);
$book_result = $connection->query($book_query);


$book_count = $book_result?$book_result->fetch_array()[0]:0;

$question_query = sprintf("SELECT COUNT(*) FROM app_past_questions WHERE isActive='%s' AND questionStatus='%s'",ACTIVE,STATE_SUCCESS);
$question_result = $connection->query($question_query);

$question_count = $question_result?$question_result->fetch_array()[0]:0;

$project_query = sprintf("SELECT COUNT(*) FROM app_project WHERE isActive='%s' AND projectStatus='%s'",ACTIVE,STATE_SUCCESS);
$project_result = $connection->query($project_query);

$project_count = $project_result?$project_result->fetch_array()[0]:0;

$category_query = sprintf("SELECT COUNT(*) FROM app_category WHERE isActive='%s' AND projectStatus='%s'",ACTIVE,STATE_SUCCESS);
$category_result = $connection->query($category_query);

$category_count = $category_result?$category_result->fetch_array()[0]:0;

$user_query = sprintf("SELECT COUNT(*) FROM app_user WHERE isActive='%s' AND projectStatus='%s'",ACTIVE,STATE_SUCCESS);
$user_result = $connection->query($user_query);

$user_count = $user_result?$user_result->fetch_array()[0]:0;

$course_query = sprintf("SELECT COUNT(*) FROM app_course WHERE isActive='%s' AND projectStatus='%s'",ACTIVE,STATE_SUCCESS);
$course_result = $connection->query($course_query);

$course_count = $course_result?$course_result->fetch_array()[0]:0;

$department_query = sprintf("SELECT COUNT(*) FROM app_project WHERE isActive='%s' AND projectStatus='%s'",ACTIVE,STATE_SUCCESS);
$department_result = $connection->query($department_query);

$department_count = $department_result?$department_result->fetch_array()[0]:0;

$faculty_query = sprintf("SELECT COUNT(*) FROM app_project WHERE isActive='%s' AND projectStatus='%s'",ACTIVE,STATE_SUCCESS);
$faculty_result = $connection->query($faculty_query);

$faculty_count = $faculty_result?$faculty_result->fetch_array()[0]:0;

    include "includes/header.php";
    include "includes/navbar.php"
?>
<div class="container">
    <div class="row mt-5">
        <div class="col-sm-4">
            <div class="card bg-danger text-white mb-3">
                <div class="card-header">Books</div>
                <div class="card-body">
                    <h4 class="card-title"><?php echo $book_count; ?></h4>
                    <p class="card-text">Total</p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Past Questions</div>
                <div class="card-body">
                    <h4 class="card-title"><?php echo $question_count; ?></h4>
                    <p class="card-text">Total</p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card text-white bg-dark mb-3">
                <div class="card-header">Projects</div>
                <div class="card-body">
                    <h4 class="card-title"><?php echo $project_count; ?></h4>
                    <p class="card-text">Total</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm mb-2">
            <div class="card">
                <div class="card-body">
                    Category: <?php echo $category_count; ?>
                </div>
            </div>
        </div>
        <div class="col-sm mb-2">
            <div class="card">
                <div class="card-body">
                    Users: <?php echo $user_count; ?>
                </div>
            </div>
        </div>
        <div class="col-sm mb-2">
            <div class="card">
                <div class="card-body">
                     Courses: <?php echo $course_count; ?>
                </div>
            </div>
        </div>
        <div class="col-sm mb-2">
            <div class="card">
                <div class="card-body">
                   Department: <?php echo $department_count; ?>
                </div>
            </div>
        </div>
        <div class="col-sm mb-2">
            <div class="card">
                <div class="card-body">
                    Faculty: <?php echo $faculty_count; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "includes/footer.php";
?>
