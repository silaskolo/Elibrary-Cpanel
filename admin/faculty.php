<?php
// Start Browser Session
session_start();

require_once "../config/functions.php";

//Check is User Session Exist i.e if user is logged in
if (!is_logged_in())
    redirect_to(APP_ROOT . "/login.php"); //Redirect user to Login if not logged in


$faculty_query = sprintf("SELECT * FROM app_faculty WHERE isActive='%s' AND facultyStatus='%s'", ACTIVE, STATE_SUCCESS);
$faculty_result = $connection->query($faculty_query);

if (isset($_POST['action']) && $_POST['action'] == 'addFaculty') {

    $name = $connection->escape_string(trim($_POST['txtFacultyName']));

    $has_error = false;
    $error_message = [];

    if (empty($name)) {
        $has_error = true;
        $error_message["txtFacultyName"] = "Please Enter Faculty Name";
    }

    if ($has_error) {
        $error_message["form"] = sprintf("%d Error(s) found", count($error_message));
    } else {
        $args = [
            "facultyName" => $name,
            "facultyStatus" => STATE_SUCCESS,
            "isActive" => ACTIVE
        ];
        $insert_id = insert_query($connection, "app_faculty", $args);

        if ($insert_id) {
            $success_message = "Faculty Successfully Added";
            header("Refresh:0");
        } else {
            $error_message["form"] = "Unable to Add Faculty At the Moment. Please Try again Later";
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
                    <label for="txtFacultyName">Faculty Name</label>
                    <input type="text"
                           class="form-control  <?php echo isset($error_message['txtFacultyName']) ? 'is-invalid' : '' ?>"
                           id="txtFacultyName" name="txtFacultyName">
                    <div class="invalid-feedback">
                        <?php echo isset($error_message['txtFacultyName']) ? $error_message['txtFacultyName'] : '' ?>
                    </div>
                </div>
                <button class="btn btn-danger" type="submit">Add Faculty</button>
                <input type="hidden" name="action" value="addFaculty">

            </form>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col">
            <table class="table table-light">
                <thead class="thead-default">
                <tr>
                    <th>#</th>
                    <th>Faculty Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php

                if ($faculty_result && $faculty_result->num_rows) {
                    $count = 0;
                    while ($faculty = $faculty_result->fetch_assoc()) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo ++$count; ?></th>
                            <td><?php echo $faculty['facultyName']; ?></td>
                            <td><?php echo $faculty['facultyID']; ?></td>
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
