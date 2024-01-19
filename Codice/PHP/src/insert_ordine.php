<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

include "./conn.php";

$data = json_decode(file_get_contents('php://input'), true);


if(isset($data['id_cliente']) && isset($data['id_tavolo']) && isset($data['id_ristorante']) && isset($data['id_prodotto']) && isset($data['quantita']) && isset($data['totale']))
{
    $id_cliente = $data['id_cliente'];
    $id_tavolo = $data['id_tavolo'];
    $id_ristorante = $data['id_ristorante'];
    $id_prodotto = $data['id_prodotto'];
    $quantita = $data['quantita'];
    $totale = $data['totale'];

    if(isset($data['ingredienti_rimossi']))
    {
        $ingredienti = $data['ingredienti_rimossi'];
        $res = $conn->execute_query("INSERT INTO ordine (Id_cliente, Id_tavolo, Id_ristorante, Id_prodotto, Quantita, Totale, Orario, Pagamento, Preparazione, Ingredienti_rimossi) VALUES ('$id_cliente', '$id_tavolo', '$id_ristorante', '$id_prodotto', '$quantita', '$totale', CURRENT_TIMESTAMP(), 'Non pagato', 'Da fare', '$ingredienti')");
    }
    else
    {
        $res = $conn->execute_query("INSERT INTO ordine (Id_cliente, Id_tavolo, Id_ristorante, Id_prodotto, Quantita, Totale, Orario, Pagamento, Preparazione) VALUES ('$id_cliente', '$id_tavolo', '$id_ristorante', '$id_prodotto', '$quantita', '$totale', CURRENT_TIMESTAMP(), 'Non pagato', 'Da fare')");
    }
}