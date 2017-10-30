<?php
//getting the database connection
require_once "../config/functions.php";

//an array to display response
$response = array();

//if it is an api call
//that means a get parameter named api call is set in the URL
//and with this parameter we are concluding that it is an api call
if (isset($_GET['action'])) {
    $input = array_map('trim', $_POST);

    switch ($_GET['action']) {

        case 'recommended':


            $book_query = sprintf("SELECT * FROM app_book WHERE isActive='%s' AND bookStatus='%s'", ACTIVE, STATE_SUCCESS);
            $book_result = $connection->query($book_query);

            $category_query = sprintf("SELECT * FROM app_category WHERE isActive='%s' AND categoryStatus='%s'", ACTIVE, STATE_SUCCESS);
            $category_result = $connection->query($category_query);
            $category_array = array();
            while ($category = mysqli_fetch_array($category_result)) {
                $category_array[$category['categoryID']] = $category['categoryName'];
            }

            $author_query = sprintf("SELECT * FROM app_author WHERE isActive='%s' AND authorStatus='%s'", ACTIVE, STATE_SUCCESS);
            $author_result = $connection->query($author_query);
            $author_array = array();
            while ($author = mysqli_fetch_array($author_result)) {
                $author_array[$author['authorID']] = $author['authorName'];
            }

            $data = array();
            while ($book = $book_result->fetch_assoc()) {
                $book['authorName'] = $author_array[$book['authorID']];
                $book['categoryName'] = $category_array[$book['categoryID']];

                $data[] = $book;
            }

            $response['error'] = false;
            $response['message'] = 'Data Received';
            $response['books'] = $data;

            break;
        case 'new':


            $book_query = sprintf("SELECT * FROM app_book WHERE isActive='%s' AND bookStatus='%s' ORDER BY dateAdded DESC", ACTIVE, STATE_SUCCESS);
            $book_result = $connection->query($book_query);

            $category_query = sprintf("SELECT * FROM app_category WHERE isActive='%s' AND categoryStatus='%s'", ACTIVE, STATE_SUCCESS);
            $category_result = $connection->query($category_query);
            $category_array = array();
            while ($category = mysqli_fetch_array($category_result)) {
                $category_array[$category['categoryID']] = $category['categoryName'];
            }

            $author_query = sprintf("SELECT * FROM app_author WHERE isActive='%s' AND authorStatus='%s'", ACTIVE, STATE_SUCCESS);
            $author_result = $connection->query($author_query);
            $author_array = array();
            while ($author = mysqli_fetch_array($author_result)) {
                $author_array[$author['authorID']] = $author['authorName'];
            }

            $data = array();
            while ($book = $book_result->fetch_assoc()) {
                $book['authorName'] = $author_array[$book['authorID']];
                $book['categoryName'] = $category_array[$book['categoryID']];

                $data[] = $book;
            }

            $response['error'] = false;
            $response['message'] = 'Data Received';
            $response['books'] = $data;

            break;
        case 'personal':


            $book_query = sprintf("SELECT * FROM app_book WHERE isActive='%s' AND bookStatus='%s' ORDER BY dateAdded DESC", ACTIVE, STATE_SUCCESS);
            $book_result = $connection->query($book_query);

            $category_query = sprintf("SELECT * FROM app_category WHERE isActive='%s' AND categoryStatus='%s'", ACTIVE, STATE_SUCCESS);
            $category_result = $connection->query($category_query);
            $category_array = array();
            while ($category = mysqli_fetch_array($category_result)) {
                $category_array[$category['categoryID']] = $category['categoryName'];
            }

            $author_query = sprintf("SELECT * FROM app_author WHERE isActive='%s' AND authorStatus='%s'", ACTIVE, STATE_SUCCESS);
            $author_result = $connection->query($author_query);
            $author_array = array();
            while ($author = mysqli_fetch_array($author_result)) {
                $author_array[$author['authorID']] = $author['authorName'];
            }

            $data = array();
            while ($book = $book_result->fetch_assoc()) {
                $book['authorName'] = $author_array[$book['authorID']];
                $book['categoryName'] = $category_array[$book['categoryID']];

                $data[] = $book;
            }

            $response['error'] = false;
            $response['message'] = 'Data Received';
            $response['books'] = $data;

            break;
        case 'preview':

            if (empty($_GET['bookID'])) {
                $response['error'] = true;
                $response['message'] = 'Invalid Parameters';
                break;
            }
            $book_query = sprintf("SELECT * FROM app_book WHERE isActive='%s' AND bookStatus='%s' AND bookID='%s' ORDER BY dateAdded DESC", ACTIVE, STATE_SUCCESS, $_GET['bookID']);
            $book_result = $connection->query($book_query);

            $category_query = sprintf("SELECT * FROM app_category WHERE isActive='%s' AND categoryStatus='%s'", ACTIVE, STATE_SUCCESS);
            $category_result = $connection->query($category_query);
            $category_array = array();
            while ($category = mysqli_fetch_array($category_result)) {
                $category_array[$category['categoryID']] = $category['categoryName'];
            }

            $author_query = sprintf("SELECT * FROM app_author WHERE isActive='%s' AND authorStatus='%s'", ACTIVE, STATE_SUCCESS);
            $author_result = $connection->query($author_query);
            $author_array = array();
            while ($author = mysqli_fetch_array($author_result)) {
                $author_array[$author['authorID']] = $author['authorName'];
            }


            $book = $book_result->fetch_assoc();
            $book['authorName'] = $author_array[$book['authorID']];
            $book['categoryName'] = $category_array[$book['categoryID']];


            $response['error'] = false;
            $response['message'] = 'Data Received';
            $response['book'] = $book;

            break;
        case 'search':

            if (empty($_GET['searchText'])) {
                $response['error'] = true;
                $response['message'] = 'Invalid Parameters';
                break;
            }
            $data = array();
            $searchString = strtolower(trim($_GET['searchText']));
            $books_query = "SELECT * FROM app_book WHERE isActive='".ACTIVE."' AND bookStatus='".STATE_SUCCESS."' AND bookName LIKE '%".$searchString."%'";

            $books_result = $connection->query($books_query);

            if($books_result->num_rows <= 0){
                $response['error'] = true;
                $response['message'] = 'No Results Returned';
                break;
            }
            while ($book = mysqli_fetch_assoc($books_result)) {
                $data[] = $book;
            }

            $response['error'] = false;
            $response['message'] = 'Data Received';
            $response['books'] = $data;

            break;
        default:
            $response['error'] = true;
            $response['message'] = 'Invalid Operation Called';
    }

} else {
    //if it is not api call
    //pushing appropriate values to response array
    $response['error'] = true;
    $response['message'] = 'Invalid API Call';
}

//displaying the response in json structure
echo json_encode($response);