<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

include "./conn.php";

$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['username']) && $data['email'] && $data['password'])
{
    $id = $data['id_cliente'];
    $username = $data['username'];
    $email = $data['email'];
    $password = $data['password'];

    $res = $conn->execute_query("UPDATE cliente SET Username = '$username', Email = '$email', Password = '$password')");
}
?>