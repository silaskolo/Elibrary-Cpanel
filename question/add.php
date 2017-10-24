<?php
// Start Browser Session
session_start();

require_once "../config/functions.php";

//Check is User Session Exist i.e if user is logged in
if (!is_logged_in())
    redirect_to(APP_ROOT . "/login.php"); //Redirect user to Login if not logged in

$course_query = sprintf("SELECT * FROM app_course WHERE isActive='%s' AND courseStatus='%s'", ACTIVE, STATE_SUCCESS);
$course_result = $connection->query($course_query);

$semester_query = sprintf("SELECT * FROM app_semester WHERE isActive='%s' AND semesterStatus='%s'", ACTIVE, STATE_SUCCESS);
$semester_result = $connection->query($semester_query);

$type_query = sprintf("SELECT * FROM app_past_question_type WHERE isActive='%s' AND typeStatus='%s'", ACTIVE, STATE_SUCCESS);
$type_result = $connection->query($type_query);

$years = range(1990, date('Y'));

if (isset($_POST['action']) && $_POST['action'] == 'addQuestion') {

    $course = $connection->escape_string(trim($_POST['selectCourse']));
    $year = $connection->escape_string(trim($_POST['selectYear']));
    $semester = $connection->escape_string(trim($_POST['selectSemester']));
    $type = $connection->escape_string(trim($_POST['selectType']));
    $file = $connection->escape_string(trim($_FILES['fileQuestion']['name']));

    $has_error = false;
    $error_message = [];

    if (empty($type)) {
        $has_error = true;
        $error_message["selectType"] = "Please Enter Type";
    }

    if (empty($semester)) {
        $has_error = true;
        $error_message["selectSemester"] = "Please Enter Semester";
    } 

    if (empty($course)) {
        $has_error = true;
        $error_message["selectCourse"] = "Please Enter Question Course";
    } 
    
    if (empty($year)) {
        $has_error = true;
        $error_message["selectYear"] = "Please Enter Question Year";
    }


    if (empty($file)) {
        $has_error = true;
        $error_message["fileQuestion"] = "Please Add Question File";
    } else {
        $questionFileType = pathinfo(basename($_FILES['fileQuestion']["name"]), PATHINFO_EXTENSION);

        if (!in_array($questionFileType, ["pdf"])) {
            $has_error = true;
            $error_message["fileQuestion"] = "Invalid Extension";
        }elseif ($_FILES['fileQuestion']["size"] > 5000000) {
            $has_error = true;
            $error_message["fileQuestion"] = "File is too Large";
        }
    }
    


    if ($has_error) {
        $error_message["form"] = sprintf("%d Error(s) found", count($error_message));
    } else {
        
            $args = [
                "typeID" => $type,
                "semesterID" => $semester,
                "courseID" => $course,
                "questionYear" => $year,
                "questionStatus" => STATE_PENDING,
                "isActive" => ACTIVE
            ];
            $insert_id = insert_query($connection, "app_past_questions", $args);

            if ($insert_id) {
                $success_message = "Question Successfully Added";

                $file_response = upload_files(
                    [
                        "filename" => $insert_id . "_file",
                        "FILES" => $_FILES['fileQuestion']
                    ], "questions/");

                if (!$file_response['status']) {
                    $error_message["fileQuestion"] = $file_response['message'];
                }

                if ($file_response['status']) {
                    $args = [
                        "questionFileLocation" => $file_response['name'],
                        "questionStatus" => STATE_SUCCESS
                    ];
                    update_query($connection, "app_past_questions", $args, [
                        "questionID" => $insert_id
                    ]);
                }

            } else {
                $error_message["form"] = "Unable to Add Question At the Moment. Please Try again Later";
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
                    <label for="selectCourse">Course Name</label>
                    <select
                        class="form-control  <?php echo isset($error_message['selectCourse']) ? 'is-invalid' : '' ?>"
                        name="selectCourse" id="selectCourse">
                        <option value="">Select Course</option>
                        <?php while ($course = $course_result->fetch_assoc()) {
                            ; ?>
                            <option
                                value="<?php echo $course['courseID']; ?>"
                                <?php echo isset($_POST['selectCourse']) && $_POST['selectCourse'] == $course['courseID'] ? "selected" : "" ?>
                            ><?php echo $course['courseName']; ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">
                        <?php echo isset($error_message['selectCourse']) ? $error_message['selectCourse'] : '' ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="selectType">Type</label>
                    <select
                        class="form-control  <?php echo isset($error_message['selectType']) ? 'is-invalid' : '' ?>"
                        name="selectType" id="selectType">
                        <option value="">Select Type</option>
                        <?php while ($type = $type_result->fetch_assoc()) {
                            ; ?>
                            <option
                                value="<?php echo $type['typeID']; ?>"
                                <?php echo isset($_POST['selectType']) && $_POST['selectType'] == $type['typeID'] ? "selected" : "" ?>
                            ><?php echo $type['typeName']; ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">
                        <?php echo isset($error_message['selectType']) ? $error_message['selectType'] : '' ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="selectSemester">Semester</label>
                    <select
                        class="form-control  <?php echo isset($error_message['selectSemester']) ? 'is-invalid' : '' ?>"
                        name="selectSemester" id="selectSemester">
                        <option value="">Select Semester</option>
                        <?php while ($semester = $semester_result->fetch_assoc()) {
                            ; ?>
                            <option
                                value="<?php echo $semester['semesterID']; ?>"
                                <?php echo isset($_POST['selectSemester']) && $_POST['selectSemester'] == $semester['semesterID'] ? "selected" : "" ?>
                            ><?php echo $semester['semesterName']; ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">
                        <?php echo isset($error_message['selectSemester']) ? $error_message['selectSemester'] : '' ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="selectYear">Question Year</label>
                    <select
                        class="form-control  <?php echo isset($error_message['selectYear']) ? 'is-invalid' : '' ?>"
                        name="selectYear" id="selectYear">
                        <option value="">Select Year</option>
                        <?php foreach ($years as $year) { ?>
                            <option
                                value="<?php echo $year; ?>"
                                <?php echo isset($_POST['selectYear']) && $_POST['selectYear'] == $year ? "selected" : "" ?>
                            ><?php echo $year; ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">
                        <?php echo isset($error_message['selectYear']) ? $error_message['selectYear'] : '' ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="fileQuestion">Question File</label>
                    <input type="file"
                           class="form-control-file form-control <?php echo isset($error_message['fileQuestion']) ? 'is-invalid' : '' ?>"
                           name="fileQuestion" id="fileQuestion">
                    <div class="invalid-feedback">
                        <?php echo isset($error_message['fileQuestion']) ? $error_message['fileQuestion'] : '' ?>
                    </div>
                </div>
                <button class="btn btn-danger" type="submit">Add Question</button>
                <input type="hidden" name="action" value="addQuestion">

            </form>
        </div>
    </div>
</div>
<?php
include "../includes/footer.php";
?>
