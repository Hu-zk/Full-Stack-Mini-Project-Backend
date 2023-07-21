<?php
include('connection.php');


$json_data = file_get_contents('php://input');
$_POST = json_decode($json_data, true);



$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

$check_email = $mysqli->prepare('select email from users where email=?');
$check_email->bind_param('s', $email);
$check_email->execute();
$check_email->store_result();
$email_exists = $check_email->num_rows();

if ($email_exists == 0) {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $query = $mysqli->prepare('insert into users(username,email,password) values(?,?,?)');
    $query->bind_param('sss', $username,$email, $hashed_password);
    $query->execute();
    
    $response['status'] = "success";
    $response['message'] = "User logged in succesfully";
}
else{
    $response['status'] = "failed";
    $response['message'] = "There is already a user with this email!";
}
header('Content-Type: application/json'); 
echo json_encode($response);
