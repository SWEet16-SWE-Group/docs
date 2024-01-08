<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

    include "./conn.php";

    $data = json_decode(file_get_contents('php://input'), true);
    
{
    $id_prenotazione = $data["id_prenotazione"];
    
    $stmt = $conn->prepare("SELECT p.*, r.Ragione_sociale, t.Codice FROM `prenotazione` p, `ristorante` r, `tavolo` t WHERE p.Id_ristorante=r.ID_ristorante AND p.Id_tavolo=t.ID_tavolo AND p.ID_prenotazione = ?");
    $stmt->bind_param("s", $id_prenotazione);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $res1 = array();

    while ($row = $result->fetch_assoc()) {
        $res1[] = $row;
    }
    echo json_encode($res1);

}

?>