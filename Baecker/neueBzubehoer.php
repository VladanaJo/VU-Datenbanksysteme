<?php
  $user = '***';
  $pass = '***';
  $database = '***';
 
  // establish database connection
  $conn = oci_connect($user, $pass, $database);
  if (!$conn) exit;
?>

<html>
<head>
  <title> Neues Backzubehoer </title>
  <link rel="stylesheet" href="style(baecker).css">
  <link href="https://fonts.googleapis.com/css?family=Playball" rel="stylesheet">
  <script src="script.js"></script>
  <link rel="icon" href="logo2.jpg">
</head>

<body>

<a class="dropbtn" href='baecker.php'>Click to go back</a>
<h1 class="naslov">Neues Backzubehör</h1>

<style>
  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }

  tr{
    background-color: rgba(234, 236, 239,0.4);
  }

  tr:nth-child(even) {
    background-color: #dddddd;
  }

   .pretraga {
    width: 35%;
  } 

  .pretraga, .tabelaUnos {
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    background-color: white;
    background-image: url('searchicon.png');
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 12px 20px 12px 40px;
    -webkit-transition: width 0.4s ease-in-out;
    transition: width 0.4s ease-in-out;
 }


</style>

<form action='neueBzubehoer.php' method='get'>
  <table>

  <tr>
      <th>Personalnummer</th>
      <th>Name</th>
      <th>Material</th>
  </tr>
  <tr>
    <td>   
        <div>
          <input class="tabelaUnos" name='PNr' readonly type='text' size='20' value='<?php if (isset($_GET['PNr'])) echo $_GET['PNr']; ?>' />
        </div>
    </td>
    <td>   
        <div>
          <input class="tabelaUnos" name='Name' type='text' size='20' value='<?php if (isset($_GET['Name'])) echo $_GET['Name']; ?>' />
        </div>
    </td>
    <td>  
        <div>
          <input class="tabelaUnos" name='Material' type='text' size='20' value='<?php if (isset($_GET['Material'])) echo $_GET['Material']; ?>' />
        </div>
    </td>
  </tr>
  </table>

  <input id='submit' type='submit' value='Hinzufuegen!' />
</form>

<?php
// falls ein Search-Parameter vorhanden ist, dann müssen wir die Namen der Torte anhand des Search-Parameters filtrieren
if ( isset($_GET['PNr']) && isset($_GET['Name']) && isset($_GET['Material']) ){
   // Das SQL-Befehl wird hier anhand der Eingabe erzeugt:
   $sqlZubehoer = "INSERT INTO Backzubehoer(Name,Material,Personalnummer) VALUES('" . $_GET['Name'] . "','" . $_GET['Material'] . "',".  $_GET['PNr'] .")";
  
   // neues Statement-Objekt mit dem obigen SQL-Befehl erzeugen:
   $insertZubehoer = oci_parse($conn, $sqlZubehoer);
   // das Statement ausführen:
   oci_execute($insertZubehoer);
   // sollte es zu einem Verbindungsfehler kommen, dann wird er in die $con_err Variable gespeichert:
   $conn_err=oci_error($conn);
   // sollte es zu einem Fehler bei der Ausführung des SQL INSERT-Befehls kommen, dann wird die Fehlerangabe in die $insert_err Variable gespeichert:
   $insert_err=oci_error($insertZubehoer);

   // falls es keine Fehler gibt, einfach folgende Nachricht ausgeben
   if(!$conn_err & !$insert_err){
     echo("<script> alert('Neues Backzubehoer wurde hinzugefuegt');</script>");
  } else{    // ansonsten eventuelle Fehler ausgeben:
      print($conn_err);
      print_r($insert_err);
      print("<br>");
  }
   // Statement ordentlich freigeben:
   oci_free_statement($insert);
   oci_close($conn);
}
?>


</body>
</html>