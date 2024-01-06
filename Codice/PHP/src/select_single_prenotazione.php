<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

    include "./conn.php";

    $data = json_decode(file_get_contents('php://input'), true);
    
    
    if(isset($data['id_cliente']) && isset($data['id_tavolo']) && isset($data['id_ristorante']) && isset($data['numero_persone']) && isset($data['partecipanti']) && isset($data['giorno']) && isset($data['arrivo']) && isset($data['partenza']))
    {
        $id_cliente = $data['id_cliente'];
        $id_tavolo = $data['id_tavolo'];
        $id_ristorante = $data['id_ristorante'];
        $numero_persone = $data['numero_persone'];
        $partecipanti = $data['partecipanti'];
        $giorno = $data['giorno'];
        $arrivo = $data['arrivo'];
        $partenza = $data['partenza'];

        $res = $conn->execute_query("SELECT * FROM prenotazione WHERE Id_cliente = '$id_cliente' AND Id_tavolo = '$id_tavolo' AND Id_ristorante = '$id_ristorante' AND Num_persone = '$numero_persone' AND Partecipanti = '$partecipanti' AND Data_prenotazione = '$giorno' AND Orario_arrivo = '$arrivo' AND Orario_partenza = '$partenza' AND Orario_prenotazione = CURRENT_TIMESTAMP();");
        $row = mysqli_fetch_assoc($res); 
        $res1=array($row);

        $decoded=json_encode($res1);

        echo $decoded;
    }

?>