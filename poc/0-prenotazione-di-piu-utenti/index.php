<?php

if(count($_POST) > 0){
  echo "<html><body>";
  echo "<p>" . json_encode($_POST) . "</p>";
  echo "</body></html>";
  $richieste = json_decode(file_get_contents("richieste.json"));
  $richieste[] = $_POST;
  file_put_contents("richieste.json",json_encode($richieste));
  die;
}

if(!file_exists("richieste.json")){
  file_put_contents("richieste.json",json_encode([]));
}

$richieste = json_decode(file_get_contents("richieste.json"));
if($richieste == null){
  $richieste = [];
}

$u = null;
$user_key = 'u';
$users = [ "0", "1", "2" ];

if(array_key_exists($user_key,$_GET) && in_array($_GET[$user_key],$users)){
  $u = $_GET[$user_key];
}else{
  echo "<html><body>";
  echo "<p>utente invalido</p>";
  echo "<p>gli utenti validi sono : <ul>";
  foreach($users as $user){
    echo "<a href='./?u=$user'><li>$user</li></a>";
  }
  echo "</ul>";
  echo "</body></html>";
  die;
}

$users = array_filter($users,function ($obj) use($u) { return $obj != $u ;} );
$richieste = array_filter($richieste,function ($obj) use($u) { return property_exists($obj,$u);});

?>

<html>
  <head>
  </head>
  <body>
    <p> sei l'utente <?php echo $u ; ?> </p>
    <p>gli altri utenti sono :</p>
    <ul>
      <?php
  foreach($users as $user){
    echo "<a href='./?u=$user'><li>$user</li></a>";
  }
      ?>
  </ul>
    <p> ============================================================================================= </p>
    <form action=./ method=post>
        <label> Ristoranti </label><br/>
        <input type=radio name=risotrante value='Pizzeria'           ><label for='Pizzeria'           >Pizzeria            </label><br>
        <input type=radio name=risotrante value='Pizzeria napoletana'><label for='Pizzeria napoletana'>Pizzeria napoletana </label><br>
        <input type=radio name=risotrante value='Pizzeria romana'    ><label for='Pizzeria romana'    >Pizzeria romana     </label><br>
        <input type=radio name=risotrante value='Pizzeria new york'  ><label for='Pizzeria new york'  >Pizzeria new york   </label><br>
        <input type=radio name=risotrante value='carne'              ><label for='carne'              >carne               </label><br>
        <input type=radio name=risotrante value='vegano'             ><label for='vegano'             >vegano              </label><br>
        <br/><label> Data </label><br/>
      <input type=datetime-local name=orario><br>
        <?php echo "<input type=text name=author style='display:none;' value=$u>";?>
        <br/><label> Amici da invitare </label><br/>
      <?php
      foreach(array_values($users) as $k => $user){
        echo "<input type=checkbox name=$user value=$user><label for='$user'>$user</label><br>";
      }
      ?><br/>
      <input type=submit>
      </form>

    <p> ============================================================================================= </p>
    <p> sei l'utente <?php echo $u ; ?> </p>
    <p> i tuoi amici vorrebbero invitarti a uscire a mangiare a : </p>
    <ul>

    <?php
      foreach($richieste as $r){
        echo "<li>" . json_encode($r) .  "</li>";
      }
    ?>

    </ul>

  </body>
</html>
