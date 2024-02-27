<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

    include "./conn.php";

    $data = json_decode(file_get_contents('php://input'), true);
    
    if(isset($data["id_ristorante"]))
    {
        $id_ristorante = $data["id_ristorante"];
        
        $res = $conn->execute_query("SELECT * FROM ristorante WHERE ID_ristorante = $id_ristorante");
        $row = mysqli_fetch_assoc($res); 
        $res1=array($row);

    echo json_encode($res1);
    }

?>