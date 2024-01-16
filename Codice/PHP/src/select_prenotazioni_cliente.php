<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

    include "./conn.php";

    $data = json_decode(file_get_contents('php://input'), true);
    
    if(isset($data["utente"]))
    {
        $username = $data["utente"];
        
        $stmt = $conn->prepare("SELECT p.ID_prenotazione, r.Ragione_sociale, p.Num_persone, date_format(p.Data_prenotazione,'%d/%m/%Y') Data_prenotazione, p.Orario_arrivo, p.Orario_partenza, p.Stato FROM `prenotazione` p, `ristorante` r, `tavolo` t WHERE p.Partecipanti like '%$username%' AND DATE(p.Data_prenotazione) >= CURDATE() AND p.Id_ristorante=r.ID_ristorante AND p.Id_tavolo=t.ID_tavolo ORDER BY p.Data_prenotazione, p.Orario_arrivo");
        $stmt->execute();
        $result = $stmt->get_result();
        $res1 = array();

        while ($row = $result->fetch_assoc()) {
            $res1[] = $row;
        }
        echo json_encode($res1);

    }

?>
