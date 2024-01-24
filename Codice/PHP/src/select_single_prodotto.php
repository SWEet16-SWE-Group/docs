<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");

    include "./conn.php";

    $data = json_decode(file_get_contents('php://input'), true);

    if(isset($data["id_prodotto"]))
    {
        $id_prodotto = $data["id_prodotto"];

        $res = $conn->execute_query("SELECT * FROM prodotto WHERE ID_prodotto = $id_prodotto");
        $res1=array();
        while ($row = mysqli_fetch_assoc($res)) 
        {
            if(!empty($row["Immagine"]))
            $row["Immagine"]=base64_encode($row["Immagine"]);
            if(!empty($row["Immagine_2"]))
                $row["Immagine_2"]=base64_encode($row["Immagine_2"]);
            if(!empty($row["Immagine_3"]))
                $row["Immagine_3"]=base64_encode($row["Immagine_3"]);
            if(!empty($row["Immagine_4"]))
                $row["Immagine_4"]=base64_encode($row["Immagine_4"]);
            if(!empty($row["Immagine_5"]))
                $row["Immagine_5"]=base64_encode($row["Immagine_5"]);
            array_push($res1, $row);
        }

        $decoded=json_encode($res1);

        echo $decoded;
    }

?>