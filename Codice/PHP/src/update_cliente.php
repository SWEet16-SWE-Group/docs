<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

include "./conn.php";

$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['id_cliente']) && isset($data['username']))
{
    $id = $data['id_cliente'];
    $username = $data['username'];

    $res = $conn->execute_query("UPDATE cliente SET Username = '$username' WHERE ID_cliente = '$id'");
}

if(isset($data['id_cliente']) && isset($data['email']))
{
    $id = $data['id_cliente'];
    $email = $data['email'];

    $res = $conn->execute_query("UPDATE cliente SET Email = '$email' WHERE ID_cliente = '$id'");
}

if(isset($data['id_cliente']) && isset($data['password']))
{
    $id = $data['id_cliente'];
    $password = $data['password'];

    $res = $conn->execute_query("UPDATE cliente SET Password = '$password' WHERE ID_cliente = '$id'");
}

?>