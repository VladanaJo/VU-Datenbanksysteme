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
  <title> Neue Verkaeufer </title>
  <link rel="stylesheet" href="style(verkaeufer).css">
  <link href="https://fonts.googleapis.com/css?family=Playball" rel="stylesheet">
  <script src="script.js"></script>
  <link rel="icon" href="logo2.jpg">
</head>

<body>

<style>

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

 .pretraga:focus {
  width: 45%;
 }

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
</style>


<!-- Formular für die Daten, die man eingeben soll : -->
<form  action='neueVerkaeufer.php' method='get'>
<a class="dropbtn" href='verkaeufer.php'>Click to go back</a>
 <h1 class="naslov">Neue Verkaeufer</h1>
  <div class="tabela">
  <table>  <!-- wieder in Form einer Tabelle -->

	  <tr>
	    <th>Personalnummer</th>   <!-- die Spaltenüberschriften -->
	    <th>Kassa</th>
        <th>Geschlecht</th>
        <th>Name</th>
        <th>Gehalt</th>
	  </tr>


  <tr>
    <td>
        <input class="tabelaUnos" name='Personalnummer' type='text' value='<?php if (isset($_GET['Personalnummer'])) echo $_GET['Personalnummer']; ?>' />
    </td>
    <td>
        <input class="tabelaUnos" name='Kassa' type='number' value='<?php if (isset($_GET['Kassa'])) echo $_GET['Kassa']; ?>' />
    </td>
    <td>
        <input class="tabelaUnos" name='Geschlecht' type='text' value='<?php if (isset($_GET['Geschlecht'])) echo $_GET['Geschlecht']; ?>' />
    </td>
    <td>
        <input class="tabelaUnos" name='Name' type='text' value='<?php if (isset($_GET['Name'])) echo $_GET['Name']; ?>' />
    </td>
    <td>
        <input class="tabelaUnos" name='Gehalt' type='number' step="0.01" value='<?php if (isset($_GET['Gehalt'])) echo $_GET['Gehalt']; ?>' />
    </td>
  </tr>

  </table>
  </div>
        <input id='submit' type='submit' value='Hinzufuegen!' />   <!-- der Insert-Button -->
</form>



<?php
  //Handle insert
  if (isset($_GET['Personalnummer']) && isset($_GET['Kassa']) && isset($_GET['Geschlecht']) && isset($_GET['Name']) && isset($_GET['Gehalt'])) 
  {
    // Das SQL-Befehl wird hier anhand der Eingabe erzeugt:
    $sqlMitarbeiter = "INSERT INTO Mitarbeiter(Personalnummer,Name, Gehalt) VALUES(" . $_GET['Personalnummer'] . ",'" . $_GET['Name'] ."'," . $_GET['Gehalt'] .")";
    $sqlVerkaeufer = "INSERT INTO Verkaeufer(Personalnummer,Kassa,Geschlecht) VALUES(" . $_GET['Personalnummer'] . ","  . $_GET['Kassa'] . ",'" . $_GET['Geschlecht'] .  "')";

    // neues Statement-Objekt mit dem obigen SQL-Befehl erzeugen:
    $insertMitarbeiter = oci_parse($conn, $sqlMitarbeiter);
    $insertVerkaeufer = oci_parse($conn, $sqlVerkaeufer);
    // das Statement ausführen:
    oci_execute($insertMitarbeiter);
    oci_execute($insertVerkaeufer);
    // sollte es zu einem Verbindungsfehler kommen, dann wird er in die $con_err Variable gespeichert:
    $conn_err=oci_error($conn);
    // sollte es zu einem Fehler bei der Ausführung des SQL INSERT-Befehls kommen, dann wird die Fehlerangabe in die $insert_err Variable gespeichert:
    $insert_err=oci_error($insertMitarbeiter);

    // falls es keine Fehler gibt, einfach folgende Nachricht ausgeben
    if(!$conn_err & !$insert_err){
	    echo("<script> alert('Neuer Verkaeufer wurde hinzugefuegt');</script>");
   } else{       // ansonsten eventuelle Fehler ausgeben:
       print($conn_err);
       print_r($insert_err);
       print("<br>");
   }
    // Statement ordentlich freigeben:
    oci_free_statement($insert);
}
?>



   <?php
    // Verbindung schließen
    oci_close($conn);
   ?>

</body>
</html>
