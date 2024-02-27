<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

include "./conn.php";

$data = json_decode(file_get_contents('php://input'), true);


if(isset($data['id_cliente']) && isset($data['id_tavolo']) && isset($data['id_ristorante']) && isset($data['codice_prenotazione']) && isset($data['numero_persone']) && isset($data['partecipanti']) && isset($data['giorno']) && isset($data['arrivo']) && isset($data['partenza']))
{
    $id_cliente = $data['id_cliente'];
    $id_tavolo = $data['id_tavolo'];
    $id_ristorante = $data['id_ristorante'];
    $codice = $data['codice_prenotazione'];
    $numero_persone = $data['numero_persone'];
    $partecipanti = $data['partecipanti'];
    $giorno = $data['giorno'];
    $arrivo = $data['arrivo'];
    $partenza = $data['partenza'];

    $res = $conn->execute_query("INSERT INTO prenotazione (Id_cliente, Id_tavolo, Id_ristorante, Codice, Num_persone, Partecipanti, Data_prenotazione, Orario_arrivo, Orario_partenza, Orario_prenotazione) VALUES ('$id_cliente', '$id_tavolo', '$id_ristorante', '$codice', '$numero_persone', '$partecipanti', '$giorno', '$arrivo', '$partenza', CURRENT_TIMESTAMP())");

    $insertedId = mysqli_insert_id($conn);

    $res = $conn->execute_query("SELECT * FROM prenotazione WHERE ID_prenotazione = '$insertedId'");
    $row = mysqli_fetch_assoc($res); 
    $res1=array($row);

    $decoded=json_encode($res1);

    echo $decoded;

}

if(isset($data['id_tavolo']) && isset($data['id_ristorante']) && isset($data['posti'])&& isset($data['giorno']) && isset($data['arrivo']) && isset($data['partenza']))
{
    $id_ristorante = $data['id_ristorante'];
    $numero_posti = $data['posti'];
    $codice = $data['codice'];
    $giorno = $data['giorno'];
    $arrivo = $data['arrivo'];
    $partenza = $data['partenza'];

    $res = $conn->execute_query("INSERT INTO tavolo (Codice, Num_posti, Data_prenotazione, Orario_arrivo, Orario_partenza, Id_ristorante) VALUES ('$codice','$numero_posti', '$giorno', '$arrivo', '$partenza', '$id_ristorante')");
}
?>