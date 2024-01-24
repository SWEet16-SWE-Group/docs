<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

include "./conn.php";

$data = json_decode(file_get_contents('php://input'), true);


if(isset($data['id_cliente']) && isset($data['id_prodotto']) && isset($data['id_prenotazione']) && isset($data['quantita']) && isset($data['totale']))
{
    $id_cliente = $data['id_cliente'];
    $id_prodotto = $data['id_prodotto'];
    $id_prenotazione = $data['id_prenotazione'];
    $quantita = $data['quantita'];
    $totale = $data['totale'];

    if(isset($data['ingredienti_rimossi']))
    {
        $ingredienti = $data['ingredienti_rimossi'];
        $res = $conn->execute_query("INSERT INTO ordine (Id_cliente, Id_prodotto, Id_prenotazione, Quantita, Totale, Orario, Pagamento, Preparazione, Ingredienti_rimossi, Conferma) VALUES ('$id_cliente', '$id_prodotto', '$id_prenotazione', '$quantita', '$totale', CURRENT_TIMESTAMP(), 'Non pagato', 'Da fare', '$ingredienti', 0)");
    }
    else
    {
        $res = $conn->execute_query("INSERT INTO ordine (Id_cliente, Id_prodotto, Id_prenotazione, Quantita, Totale, Orario, Pagamento, Preparazione, Conferma) VALUES ('$id_cliente', '$id_prodotto', '$id_prenotazione', '$quantita', '$totale', CURRENT_TIMESTAMP(), 'Non pagato', 'Da fare', 0)");
    }
}