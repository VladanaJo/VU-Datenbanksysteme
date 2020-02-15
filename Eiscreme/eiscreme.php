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
  <title> Eiscreme </title>
  <link rel="stylesheet" href="style(eiscreme).css">
  <link href="https://fonts.googleapis.com/css?family=Playball" rel="stylesheet">
  <script src="script.js"></script>
  <link rel="icon" href="logo2.jpg">
</head>

<body>



<meta name="viewport" content="width=device-width, initial-scale=1">
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
</style>

<a class="dropbtn" href='index.php'>Click to go back</a>
<h1 class="naslov">Eiscreme</h1>

<div class="suche">
  <form action='eiscreme.php' method='get'>
    <h2 class="sucheAlle">Suche nach Name: </h2>
    <input class="pretraga" id='search' name='search' type='text' size='20' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
    <input id='submit' type='submit' value='Suchen!' />
</div>


<div class="suche">;
<div class="dropdown">
<a class="dropbtn" href='eiscreme.php'>Alle Eiscreme</a>
</div>
</div>

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
</style>

<?php
// falls ein Search-Parameter vorhanden ist, dann müssen wir die Namen der Eiscreme anhand des Search-Parameters filtrieren
if (isset($_GET['search'])) {
  $sql = "SELECT * FROM Eiscreme WHERE Name like '%" . $_GET['search'] . "%'";
} else {
  $sql = "SELECT * FROM Eiscreme";  // ansonsten einfach alle Torten ausgeben
}

// das SQL-Befehl ausführen:
$stmt = oci_parse($conn, $sql);              // unser SQL-Befehl wird in der $sql Variable gespeichert. Hier wird ein Statement-Objekt erzeugt, mit dem SQL-Befehl
oci_execute($stmt);                        // das Befehl wird ausgeführt
?>

<div class="tabela">
<table>

  <tr>
    <th>Name</th>
    <th>vegan</th>
    <th>Geschmack</th>
  </tr>

  <?php
  while ($row = oci_fetch_assoc($stmt)) {    
    echo "<tr>";
    echo "<td>" . $row['NAME'] . "</td>";
    if($row['ISTVEGAN']=="j") {
      echo "<td>ja</td>";
    } else {
      echo "<td>nein</td>";
    }
    echo "<td>" . $row['GESCHMACK'] . "</td>";
    echo "</tr>";
  }
?>
</table>
</div> 

 <h2 class="sucheAlle"> Insgesamt <?php echo oci_num_rows($stmt); ?> Eiscreme gefunden! </h2> 
 <?php oci_free_statement($stmt);  ?>



<!--     ************************************************************************************************ -->
<!--     **************************************  NEUE EISCREME EINTRAGEN   ********************************* -->
<!--     ************************************************************************************************ -->



<!-- Formular für die Daten, die man eingeben soll : -->
<form action='eiscreme.php' method='get'>
<h2 class="sucheAlle"> Neue Eiscreme hinzufuegen: </h2>
<div class="tabela">
  <table>  <!-- wieder in Form einer Tabelle -->

	  <tr>
	    <th>Name</th>   <!-- die Spaltenüberschriften -->
	    <th>vegan (j/n)</th>
      <th>Geschmack</th>
      <th>Preis</th>
    </tr>
	  <tr>
      <td>
        <input class="tabelaUnos" name='Name' type='text' value='<?php if (isset($_GET['Name'])) echo $_GET['Name']; ?>' />
      </td>
		  <td>
		    <input class="tabelaUnos" name='istVegan' type='text' pattern="j|n" title="Nur j oder n zulässig!" value='<?php if (isset($_GET['istVegan'])) echo $_GET['istVegan']; ?>' />
		  </td>
		  <td>
		    <input class="tabelaUnos" name='Geschmack' type='text' value='<?php if (isset($_GET['Geschmack'])) echo $_GET['Geschmack']; ?>' />
      </td>
      <td>
		    <input class="tabelaUnos" name='Preis' type='number' step="0.01" value='<?php if (isset($_GET['Preis'])) echo $_GET['Preis']; ?>' />
		  </td>
	  </tr>

  </table>
  </div>
        <input id='submit' type='submit' value='Hinzufuegen!' />   <!-- der Insert-Button -->
</form>



<?php
  //Handle insert
  if (isset($_GET['Name']) && isset($_GET['istVegan']) && isset($_GET['Geschmack']) && isset($_GET['Preis'])) 
  {
    // Das SQL-Befehl wird hier anhand der Eingabe erzeugt:
    $sqlSuessigkeit = "INSERT INTO Suessigkeit(Name,Preis) VALUES('" . $_GET['Name'] . "'," . $_GET['Preis'] .")";
    $sqlEiscreme = "INSERT INTO Eiscreme(Name,istVegan,Geschmack) VALUES('" . $_GET['Name'] . "','"  . $_GET['istVegan'] . "','" . $_GET['Geschmack'] .  "')";

    // neues Statement-Objekt mit dem obigen SQL-Befehl erzeugen:
    $insertSuessigkeit = oci_parse($conn, $sqlSuessigkeit);
    $insertEiscreme = oci_parse($conn, $sqlEiscreme);
    // das Statement ausführen:
    oci_execute($insertSuessigkeit);
    oci_execute($insertEiscreme);
    // sollte es zu einem Verbindungsfehler kommen, dann wird er in die $con_err Variable gespeichert:
    $conn_err=oci_error($conn);
    // sollte es zu einem Fehler bei der Ausführung des SQL INSERT-Befehls kommen, dann wird die Fehlerangabe in die $insert_err Variable gespeichert:
    $insert_err=oci_error($insertSuessigkeit);

    // falls es keine Fehler gibt, einfach folgende Nachricht ausgeben
      if(!$conn_err & !$insert_err){
        echo("<script> alert('Neue Eiscreme wurde hinzugefuegt');</script>");
      } else{           // ansonsten eventuelle Fehler ausgeben:
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
