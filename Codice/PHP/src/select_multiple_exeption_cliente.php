<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

    include "./conn.php";

    $data = json_decode(file_get_contents('php://input'), true);

    if(isset($data['id_cliente']))
    {
        $id = $data['id_cliente'];

        $res = $conn->execute_query("SELECT * FROM cliente WHERE ID_cliente <> '$id'");
        $res1=array();
        while ($row = mysqli_fetch_assoc($res)) 
        {
            array_push($res1, $row);
        }

        $decoded=json_encode($res1);

        echo $decoded;
    }

?>