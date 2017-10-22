<?php
// Start Browser Session
session_start();

require_once "../config/functions.php";

//Check is User Session Exist i.e if user is logged in
if (!is_logged_in())
    redirect_to(APP_ROOT . "/login.php"); //Redirect user to Login if not logged in

$department_query = sprintf("SELECT * FROM app_department WHERE isActive='%s' AND departmentStatus='%s'", ACTIVE, STATE_SUCCESS);
$department_result = $connection->query($department_query);

$level_query = sprintf("SELECT * FROM app_level WHERE isActive='%s' AND levelStatus='%s'", ACTIVE, STATE_SUCCESS);
$level_result = $connection->query($level_query);

$course_query = sprintf("SELECT * FROM app_course WHERE isActive='%s' AND courseStatus='%s'", ACTIVE, STATE_SUCCESS);
$course_result = $connection->query($course_query);

if (isset($_POST['action']) && $_POST['action'] == 'addCourse') {

    $name = $connection->escape_string(trim($_POST['txtCourseName']));
    $department = $connection->escape_string(trim($_POST['selectDepartment']));
    $level = $connection->escape_string(trim($_POST['selectLevel']));

    $has_error = false;
    $error_message = [];

    if (empty($name)) {
        $has_error = true;
        $error_message["txtCourseName"] = "Please Enter Course Name";
    }

    if (empty($department)) {
        $has_error = true;
        $error_message["selectDepartment"] = "Please Select Department";
    }

    if (empty($level)) {
        $has_error = true;
        $error_message["selectLevel"] = "Please Select Level";
    }

    if ($has_error) {
        $error_message["form"] = sprintf("%d Error(s) found", count($error_message));
    } else {
        $args = [
            "courseName" => $name,
            "departmentID" => $department,
            "levelID" => $level,
            "courseStatus" => STATE_SUCCESS,
            "isActive" => ACTIVE
        ];
        $insert_id = insert_query($connection, "app_course", $args);

        if ($insert_id) {
            $success_message = "Course Successfully Added";
            header("Refresh:0");
        } else {
            $error_message["form"] = "Unable to Add Course At the Moment. Please Try again Later";
        }
    }
}

include "../includes/header.php";
include "../includes/navbar.php"
?>
<div class="container">
    <div class="row mt-5">
        <div class="col form-portlet">
            <?php if (isset($error_message["form"])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message["form"] ?>
                </div>
            <?php } elseif (isset($success_message)) { ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success_message ?>
                </div>
            <?php } ?>
            <form method="post" action="#" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtCourseName">Course Name</label>
                    <input type="text"
                           class="form-control  <?php echo isset($error_message['txtCourseName']) ? 'is-invalid' : '' ?>"
                           id="txtCourseName" name="txtCourseName">
                    <div class="invalid-feedback">
                        <?php echo isset($error_message['txtCourseName']) ? $error_message['txtCourseName'] : '' ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="selectLevel">Level</label>
                    <select
                            class="form-control  <?php echo isset($error_message['selectLevel']) ? 'is-invalid' : '' ?>"
                            name="selectLevel" id="selectLevel">
                        <option value="" disabled>Select Level</option>
                        <?php
                        $level_array = array();
                        while ($level = $level_result->fetch_assoc()) {
                            $level_array[$level['levelID']] = $level['levelName'];
                            ?>
                            <option
                                    value="<?php echo $level['levelID']; ?>"
                                <?php echo isset($_POST['selectLevel']) && $_POST['selectLevel'] == $level['levelID'] ? "selected" : "" ?>
                            ><?php echo $level['levelName']; ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">
                        <?php echo isset($error_message['selectLevel']) ? $error_message['selectLevel'] : '' ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="selectDepartment">Department Name</label>
                    <select
                            class="form-control  <?php echo isset($error_message['selectDepartment']) ? 'is-invalid' : '' ?>"
                            name="selectDepartment" id="selectDepartment">
                        <option value="" disabled>Select Department</option>
                        <?php
                        $department_array = array();
                        while ($department = $department_result->fetch_assoc()) {
                            $department_array[$department['departmentID']] = $department['departmentName'];
                            ?>
                            <option
                                    value="<?php echo $department['departmentID']; ?>"
                                <?php echo isset($_POST['selectDepartment']) && $_POST['selectDepartment'] == $department['departmentID'] ? "selected" : "" ?>
                            ><?php echo $department['departmentName']; ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">
                        <?php echo isset($error_message['selectDepartment']) ? $error_message['selectDepartment'] : '' ?>
                    </div>
                </div>
                <button class="btn btn-danger" type="submit">Add Course</button>
                <input type="hidden" name="action" value="addCourse">

            </form>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col">
            <table class="table table-light">
                <thead class="thead-default">
                <tr>
                    <th>#</th>
                    <th>Course Name</th>
                    <th>Department Name</th>
                    <th>Level</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php

                if ($course_result && $course_result->num_rows) {
                    $count = 0;
                    while ($course = $course_result->fetch_assoc()) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo ++$count; ?></th>
                            <td><?php echo $course['courseName']; ?></td>
                            <td><?php echo $department_array[$course['departmentID']]; ?></td>
                            <td><?php echo $level_array[$course['levelID']]; ?></td>
                            <td><?php echo $course['courseID']; ?></td>
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
