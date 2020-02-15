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
  <title> Neues Rezept </title>
  <link rel="stylesheet" href="style(rezepte).css">
  <link href="https://fonts.googleapis.com/css?family=Playball" rel="stylesheet">
  <script src="script.js"></script>
  <link rel="icon" href="logo2.jpg">  
</head>

<body>
<a class="dropbtn" href='rezepte.php'>Click to go back</a>
<h1 class="naslov">Neues Rezept</h1>

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

<!--     ************************************************************************************************ -->
<!--     ************************************  NEUE BAECKER EINTRAGEN   ********************************* -->
<!--     ************************************************************************************************ -->



<!-- Formular für die Daten, die man eingeben soll : -->
<form  action='neuesRezept.php' method='get'>
  <h2 class="sucheAlle"> Neues Rezept hinzufuegen: </h2>
  
  <div class="tabela">
  <table>  <!-- wieder in Form einer Tabelle -->

	  <tr>
	    <th>Name</th>   <!-- die Spaltenüberschriften -->
      <th>Bezeichnung</th>
	    <th>Dauer</th>
	  </tr>


	  <tr>
      <td>
        <input class="tabelaUnos" name='Name' type='text' value='<?php if (isset($_GET['Name'])) echo $_GET['Name']; ?>' />
      </td>
		  <td>
		   <input class="tabelaUnos" name='Bezeichnung'  type='text' value='<?php if (isset($_GET['Bezeichnung'])) echo $_GET['Bezeichnung']; ?>' />
      </td>
      <td>
		   <input class="tabelaUnos" name='Dauer'  type='number' value='<?php if (isset($_GET['Dauer'])) echo $_GET['Dauer']; ?>' />
		  </td>
	  </tr>

  </table>
  </div>
  <input id='submit' type='submit' value='Hinzufuegen!' />   <!-- der Insert-Button -->
</form>



<?php
  //Handle insert
  if (isset($_GET['Name']) && isset($_GET['Bezeichnung']) && isset($_GET['Dauer'])) 
  {
    // Das SQL-Befehl wird hier anhand der Eingabe erzeugt:
    $sqlZutat = "INSERT INTO Zutat(Bezeichnung) VALUES('" . $_GET['Bezeichnung'] . "')";
    $sqlRezept = "INSERT INTO Rezept(Name,Dauer) VALUES('" . $_GET['Name'] . "',"  . $_GET['Dauer'] . ")";
    $sqlRezeptHatZutat = "INSERT INTO RezeptHatZutat(Name,Bezeichnung) VALUES('" . $_GET['Name'] . "','"  . $_GET['Bezeichnung'] . "')";

    // neues Statement-Objekt mit dem obigen SQL-Befehl erzeugen:
    $insertRezeptHatZutat = oci_parse($conn, $sqlRezeptHatZutat);
    $insertZutat = oci_parse($conn, $sqlZutat);
    $insertRezept = oci_parse($conn, $sqlRezept);
    // das Statement ausführen:
    oci_execute($insertRezeptHatZutat);
    oci_execute($insertZutat);
    oci_execute($insertRezept);
    // sollte es zu einem Verbindungsfehler kommen, dann wird er in die $con_err Variable gespeichert:
    $conn_err=oci_error($conn);
    // sollte es zu einem Fehler bei der Ausführung des SQL INSERT-Befehls kommen, dann wird die Fehlerangabe in die $insert_err Variable gespeichert:
    $insert_err=oci_error($insertRezeptHatZutat);

    // falls es keine Fehler gibt, einfach folgende Nachricht ausgeben
    if(!$conn_err & !$insert_err){
	    echo("<script> alert('Neuer Rezept wurde hinzugefuegt');</script>");
   } else{      // ansonsten eventuelle Fehler ausgeben:
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