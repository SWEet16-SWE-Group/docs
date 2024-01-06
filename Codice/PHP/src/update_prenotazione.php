<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

include "./conn.php";

$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['id_prenotazione']) && isset($data['lista']))
{
    $id = $data['id_prenotazione'];
    $usernames = $data['lista'];

    $res = $conn->execute_query("UPDATE prenotazione SET Partecipanti = '$usernames' WHERE ID_prenotazione = '$id'");
}

?>