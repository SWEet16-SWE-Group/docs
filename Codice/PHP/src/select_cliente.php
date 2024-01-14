<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

    include "./conn.php";

    $data = json_decode(file_get_contents('php://input'), true);
    
{
    $id_cliente = $data["id_cliente"];

    $res = $conn->execute_query("SELECT * FROM cliente WHERE ID_cliente = $id_cliente");
    $row = mysqli_fetch_assoc($res); 
    $res1=array($row);

   echo json_encode($res1);
}

?>