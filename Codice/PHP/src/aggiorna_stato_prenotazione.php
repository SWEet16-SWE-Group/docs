<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

include "./conn.php";

$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['id_prenotazione']) && isset($data['stato']))
{
    $id = $data['id_prenotazione'];
    $stato = $data['stato'];

    if ($stato == 3)
      $res = $conn->execute_query("UPDATE prenotazione SET Stato = NULL WHERE ID_prenotazione = '$id'");  
    else
      $res = $conn->execute_query("UPDATE prenotazione SET Stato = '$stato' WHERE ID_prenotazione = '$id'");
}

?>