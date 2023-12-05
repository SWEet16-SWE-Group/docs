<html>

<body>
  <h1>prova con php di connessione a mysql</h1>
  <p>
    <?php

    $conn = mysqli_connect('mysql', 'root', 'root', 'easymeal');
    $res = mysqli_query($conn, 'select * from t1;');
    echo "<p>=============================================================</p>";
    while ($row = mysqli_fetch_assoc($res)) {
      echo "<p>";
      foreach ($row as $i => $a) {
        echo "$i -> " . (json_encode($a)) . "; ";
      }
      echo "</p>";
      echo "<p>=============================================================</p>";
    }

    ?>
  </p>
</body>

</html>
