<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

    include "./conn.php";

    $data = json_decode(file_get_contents('php://input'), true);
    
    if(isset($data["id_prenotazione"]))
    {
        $id_prenotazione = $data["id_prenotazione"];
        
        $stmt = $conn->prepare("SELECT p.Descrizione, o.Quantita, p.Prezzo, p.Allergeni FROM `ordine` o, `prodotto` p WHERE Id_prenotazione = ? AND o.Id_prodotto = p.ID_prodotto");
        $stmt->bind_param("i", $id_prenotazione);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $res1 = array();

        while ($row = $result->fetch_assoc()) {
            $res1[] = $row;
        }
        echo json_encode($res1);

    }

?>