<?php
session_start();
require_once "../config/functions.php";

if (!is_logged_in())
    redirect_to("../login.php"); //Redirect user to Login if not logged in

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Content-type: application/json");

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
$data = array();
while ($question = $question_result->fetch_assoc()) {


    $question['courseName'] = $course_array[$question['courseID']];
    $question['semesterName'] =    $semester_array[$question['semesterID']];
    $question['typeName'] =     $type_array[$question['typeID']];

    $data[] = $question;
}

echo json_encode($data);