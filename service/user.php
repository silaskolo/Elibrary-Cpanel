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

        case 'register':

            //in this part we will handle the registration
            if(is_these_parameters_available(array('email','password','first_name','last_name','department','matric_no','level'),$input)){

                //getting the values
                $password = hash("sha256", $input['password']);
                $email = $input['email'];
                $fname = $input['first_name'];
                $lname = $input['last_name'];
                $matric_no = $input['matric_no'];
                $level = $input['level'];
                $department = $input['department'];


                //checking if the user is already exist with this email
                //as the email should be unique for every user
                $check_query = sprintf("SELECT * FROM app_user WHERE userEmail='%s'", $email);
                $check_result = $connection->query($check_query);

                //if the user already exist in the database
                if($check_result->num_rows > 0){
                    $response['error'] = true;
                    $response['message'] = 'User already registered';
                }else{
                    //if user is new creating an insert query
                    $args = [
                        "accessID" => 3, //app user
                        "departmentID" => $department,
                        "userPass" => $password,
                        "userFname" => $fname,
                        "userLname" => $lname,
                        "userEmail" => $email,
                        "userMatricNo" => $matric_no,
                        "userLevel" => $level,
                        "userStatus" => STATE_SUCCESS,
                        "isActive" => ACTIVE,
                    ];
                    $insert_id = insert_query($connection, "app_user", $args);

                    //if the user is successfully added to the database
                    if($insert_id){

                        //fetching the user back
                        $user_query = sprintf("SELECT * FROM app_user WHERE isActive='%s' AND userID='%s'", ACTIVE, $insert_id);
                        $user_result = $connection->query($user_query);
                        $user = $user_result->fetch_assoc();

                        //adding the user data in response
                        $response['error'] = false;
                        $response['message'] = 'User registered successfully';
                        $response['user'] = $user;
                    }
                }

            }else{
                $response['error'] = true;
                $response['message'] = 'required parameters are not available';
            }

            break;

        case 'login':

            //this part will handle the login
            if(is_these_parameters_available(array('email', 'password'),$input)){
                //getting values
                $email = $input['email'];
                $password = hash("sha256", $input['password']);

                $user_query = sprintf("SELECT * FROM app_user WHERE userEmail='%s' AND userPass='%s'", $email, $password);
                $user_result = $connection->query($user_query);
                //creating the query

                //if the user exist with given credentials
                if($user_result->num_rows > 0){

                    $user = $user_result->fetch_assoc();

                    $response['error'] = false;
                    $response['message'] = 'Login successful';
                    $response['user'] = $user;
                }else{
                    //if the user not found
                    $response['error'] = false;
                    $response['message'] = 'Invalid email or password';
                }
            }
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