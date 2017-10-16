<?php
session_start();
require_once "../config/functions.php";

if (!is_logged_in())
    redirect_to("../login.php"); //Redirect user to Login if not logged in

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Content-type: application/json");

$book_query = sprintf("SELECT * FROM app_book WHERE isActive='%s' AND bookStatus='%s'", ACTIVE, STATE_SUCCESS);
$book_result = $connection->query($book_query);

$category_query = sprintf("SELECT * FROM app_category WHERE isActive='%s' AND categoryStatus='%s'", ACTIVE, STATE_SUCCESS);
$category_result = $connection->query($category_query);
$category_array = array();
while($category = mysqli_fetch_array($category_result))
{
    $category_array[$category['categoryID']] = $category['categoryName'];
}

$author_query = sprintf("SELECT * FROM app_author WHERE isActive='%s' AND authorStatus='%s'",ACTIVE,STATE_SUCCESS);
$author_result = $connection->query($author_query);
$author_array = array();
while($author = mysqli_fetch_array($author_result))
{
    $author_array[$author['authorID']] = $author['authorName'];
}

$data = array();
while ($book = $book_result->fetch_assoc()) {
    $book['authorName'] = $author_array[$book['authorID']];
    $book['categoryName'] =    $category_array[$book['categoryID']];

    $data[] = $book;
}

echo json_encode($data);