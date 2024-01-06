<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

include "./conn.php";

$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['id_ristorante']))
{
    $id = $data['id_ristorante'];
    $num = $data['num_posti'];
    $date = $data['giorno'];

    $stmt = $conn->prepare("SELECT * FROM tavolo WHERE Id_ristorante = ? AND Num_posti = ? AND Data_prenotazione = ?");
    $stmt->bind_param("iss", $id, $num, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 0)
    {
        $stmt = $conn->prepare("SELECT * FROM tavolo WHERE Id_ristorante = ? AND Num_posti = ?");
        $stmt->bind_param("is", $id, $num);
        $stmt->execute();
        $result = $stmt->get_result();
    }
    
    $res1 = array();

    while ($row = $result->fetch_assoc()) {
        $res1[] = $row;
    }

    echo json_encode($res1);

}

?>