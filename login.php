<?php
include('connection.php');

$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);
$response = [];


if ($data !== null) {

    $email = $data['email'];
    $password = $data['password'];

    $query = $mysqli->prepare('select * from users where email=?');
    $query->bind_param('s', $email);
    $query->execute();
    $query->store_result();

    $query->bind_result($id, $username,$email, $hashed_password);
    $query->fetch();

    $num_rows = $query->num_rows();
    if ($num_rows == 0) {
        $response['status'] = "user not found";
    } else {
        if (password_verify($password, $hashed_password)) {
            $response['status'] = 'logged in';
            $response['user_id'] = $id;
            $response['username'] = $username;
            $response['email'] = $email;
            echo json_encode($response);
            return;
        } else {
            $response['status'] = "wrong password";
            echo json_encode($response);
            return;
        }
    }
}