<?php
// Start Browser Session
session_start();

require_once "../config/functions.php";

//Check is User Session Exist i.e if user is logged in
if (!is_logged_in())
    redirect_to(APP_ROOT . "/login.php"); //Redirect user to Login if not logged in

$faculty_query = sprintf("SELECT * FROM app_faculty WHERE isActive='%s' AND facultyStatus='%s'",ACTIVE,STATE_SUCCESS);
$faculty_result = $connection->query($faculty_query);

$department_query = sprintf("SELECT * FROM app_department WHERE isActive='%s' AND departmentStatus='%s'", ACTIVE, STATE_SUCCESS);
$department_result = $connection->query($department_query);

if (isset($_POST['action']) && $_POST['action'] == 'addDepartment') {

    $name = $connection->escape_string(trim($_POST['txtDepartmentName']));
    $faculty = $connection->escape_string(trim($_POST['selectFaculty']));

    $has_error = false;
    $error_message = [];

    if (empty($name)) {
        $has_error = true;
        $error_message["txtDepartmentName"] = "Please Enter Department Name";
    }

    if (empty($faculty)) {
        $has_error = true;
        $error_message["selectFaculty"] = "Please Select Faculty";
    }

    if ($has_error) {
        $error_message["form"] = sprintf("%d Error(s) found", count($error_message));
    } else {
        $args = [
            "departmentName" => $name,
            "facultyID" => $faculty,
            "departmentStatus" => STATE_SUCCESS,
            "isActive" => ACTIVE
        ];
        $insert_id = insert_query($connection, "app_department", $args);

        if ($insert_id) {
            $success_message = "Department Successfully Added";
            header("Refresh:0");
        } else {
            $error_message["form"] = "Unable to Add Department At the Moment. Please Try again Later";
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
                    <label for="txtDepartmentName">Department Name</label>
                    <input type="text"
                           class="form-control  <?php echo isset($error_message['txtDepartmentName']) ? 'is-invalid' : '' ?>"
                           id="txtDepartmentName" name="txtDepartmentName">
                    <div class="invalid-feedback">
                        <?php echo isset($error_message['txtDepartmentName']) ? $error_message['txtDepartmentName'] : '' ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="selectFaculty">Faculty Name</label>
                    <select
                        class="form-control  <?php echo isset($error_message['selectFaculty']) ? 'is-invalid' : '' ?>"
                        name="selectFaculty" id="selectFaculty">
                        <option value="" disabled>Select Faculty</option>
                        <?php
                        $faculty_array = array();
                        while ($faculty = $faculty_result->fetch_assoc()){
                            $faculty_array[$faculty['facultyID']] = $faculty['facultyName'];
                            ?>
                            <option
                                value="<?php echo $faculty['facultyID'];?>"
                                <?php echo isset($_POST['selectFaculty']) && $_POST['selectFaculty'] == $faculty['facultyID']?"selected":"" ?>
                            ><?php echo $faculty['facultyName'];?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">
                        <?php echo isset($error_message['selectFaculty']) ? $error_message['selectFaculty'] : '' ?>
                    </div>
                </div>
                <button class="btn btn-danger" type="submit">Add Department</button>
                <input type="hidden" name="action" value="addDepartment">

            </form>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col">
            <table class="table table-light">
                <thead class="thead-default">
                <tr>
                    <th>#</th>
                    <th>Department Name</th>
                    <th>Faculty Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php

                if ($department_result && $department_result->num_rows) {
                    $count = 0;
                    while ($department = $department_result->fetch_assoc()) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo ++$count; ?></th>
                            <td><?php echo $department['departmentName']; ?></td>
                            <td><?php echo $faculty_array[$department['facultyID']]; ?></td>
                            <td><?php echo $department['departmentID']; ?></td>
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
