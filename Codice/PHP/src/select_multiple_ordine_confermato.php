<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

include "./conn.php";

$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['id_prenotazione']))
{
    $id_prenotazione = $data['id_prenotazione'];

    $res = $conn->execute_query("SELECT ordine.*, prodotto.Nome, prodotto.Ingredienti, cliente.Username FROM ordine JOIN prodotto ON ordine.Id_prodotto = prodotto.ID_prodotto JOIN cliente ON ordine.Id_cliente = cliente.ID_cliente WHERE ordine.Id_prenotazione = '$id_prenotazione' AND ordine.Conferma = 1");

    $res1=array();
    while ($row = mysqli_fetch_assoc($res)) 
    {
        array_push($res1, $row);
    }

    $decoded=json_encode($res1);

    echo $decoded;
}

?>