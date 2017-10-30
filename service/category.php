<?php
//getting the database connection
require_once "../config/functions.php";

//an array to display response
$response = array();

//if it is an api call
//that means a get parameter named api call is set in the URL
//and with this parameter we are concluding that it is an api call
if(isset($_GET['action'])){
    $input = array_map('trim', $_POST);

    switch($_GET['action']){

        case 'all':

            $data = array();
            $category_query = sprintf("SELECT * FROM app_category WHERE isActive='%s' AND categoryStatus='%s'", ACTIVE, STATE_SUCCESS);
            $category_result = $connection->query($category_query);

            while($category = mysqli_fetch_assoc($category_result))
            {
                $data[] = $category;
            }

            $response['error'] = false;
            $response['message'] = 'Data Received';
            $response['category'] =  $data;

            break;

        case 'books':

            if(empty($_GET['categoryID'])){
                $response['error'] = true;
                $response['message'] = 'Invalid Parameters';
                break;
            }
            $data = array();
            $books_query = sprintf("SELECT * FROM app_book WHERE isActive='%s' AND bookStatus='%s' AND categoryID='%s'", ACTIVE, STATE_SUCCESS, $_GET['categoryID']);
            $books_result = $connection->query($books_query);

            while($book = mysqli_fetch_assoc($books_result))
            {
                $data[] = $book;
            }

            $response['error'] = false;
            $response['message'] = 'Data Received';
            $response['books'] =  $data;

            break;

        case 'search':

            if(empty($_GET['searchText'])){
                $response['error'] = true;
                $response['message'] = 'Invalid Parameters';
                break;
            }
            $data = array();
            $searchString = strtolower(trim($_GET['searchText']));
            $category_query = "SELECT * FROM app_category WHERE isActive='".ACTIVE."' AND categoryStatus='".STATE_SUCCESS."' AND LOWER(categoryName) LIKE '%".$searchString."%'";

            $category_result = $connection->query($category_query);

            if($category_result->num_rows <= 0){
                $response['error'] = true;
                $response['message'] = 'No Results Returned';
                break;
            }

            $category_array = array();
            while ($category = mysqli_fetch_array($category_result)) {
                $category_array[] = $category['categoryID'];
            }

            if(empty($category_array)){
                $response['error'] = true;
                $response['message'] = 'No Results Returned';
                break;
            }

            $books_query = sprintf("SELECT * FROM app_book WHERE isActive='%s' AND bookStatus='%s' AND categoryID IN (%s)", ACTIVE, STATE_SUCCESS,implode(",",$category_array));
            $books_result = $connection->query($books_query);

            while($book = mysqli_fetch_assoc($books_result))
            {
                $data[] = $book;
            }

            $response['error'] = false;
            $response['message'] = 'Data Received';
            $response['books'] =  $data;

            break;
        default:
            $response['error'] = true;
            $response['message'] = 'Invalid Operation Called';
    }

}else{
    //if it is not api call
    //pushing appropriate values to response array
    $response['error'] = true;
    $response['message'] = 'Invalid API Call';
}

//displaying the response in json structure
echo json_encode($response);