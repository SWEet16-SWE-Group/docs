<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

include "./conn.php";

$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['id_cliente']) && isset($data['id_prenotazione']))
{
    $id_cliente = $data['id_cliente'];
    $id_prenotazione = $data['id_prenotazione'];

    $res = $conn->execute_query("UPDATE ordine SET Conferma = 1 WHERE ID_cliente = '$id_cliente' AND Id_prenotazione = '$id_prenotazione'");
}

?>