<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

    include "./conn.php";

    $data = json_decode(file_get_contents('php://input'), true);
    
    if(isset($data["id_cliente"]))
    {
        $id_cliente = $data["id_cliente"];
        $username = $data["username"];
        $oggi = date("Y-m-d");
        
        $res = $conn->execute_query("SELECT * FROM prenotazione WHERE Data_prenotazione = '$oggi' AND (Id_cliente = '$id_cliente' OR Partecipanti LIKE '%$username%') AND Stato = 1");
        $row = mysqli_fetch_assoc($res); 
        $res1=array($row);

    echo json_encode($res1);
    }

?>