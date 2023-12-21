<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

    include "./conn.php";

    $res = $conn->execute_query("SELECT * FROM cliente WHERE ID_cliente = 1");
    $row = mysqli_fetch_assoc($res); 
    $res1=array($row);

    $decoded=json_encode($res1);

    echo $decoded;

?>