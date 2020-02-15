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
  <title> Torte </title>
  <link rel="stylesheet" href="style(torte).css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Playball" rel="stylesheet">
  <script src="script.js"></script>
  <link rel="icon" href="logo2.jpg">

</head>

<body>
<!-- STYLE TEIL -->
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
  background-color: rgba(234, 236, 239,0.7);
 }

 tr:nth-child(even) {
  background-color: #dddddd;
  }
</style>

<a class="dropbtn" href='index.php'>Click to go back</a> 
<h1 class="naslov">Torte</h1>

<!--     ************************************************************************************************ -->
<!--     *************************************  TORTE SUCHEN  ******************************************* -->
<!--     ************************************************************************************************ -->



<div class="suche">
  <form action='torte.php' method='get'>
    <h2 class="sucheAlle">Suche nach Name: </h2>
    <input class="pretraga" id='search' name='search' type='text' size='20' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
    <input id='submit' type='submit' value='Suchen!'? />  
</form>
</div>


<div class="suche">
<div class="dropdown">
<a class="dropbtn" href='torte.php'>Alle Torten</a> 
</div>
</div>

<?php
    // falls ein Search-Parameter vorhanden ist, dann müssen wir die Namen der Torte anhand des Search-Parameters filtrieren
    if (isset($_GET['search'])) {
     $sql = "SELECT * FROM Torte WHERE Name like '%" . $_GET['search'] . "%'";
    } else {
     $sql = "SELECT * FROM Torte";  // ansonsten einfach alle Torten ausgeben
    }
   // das SQL-Befehl ausführen:
   $stmt = oci_parse($conn, $sql);     // unser SQL-Befehl wird in der $sql Variable gespeichert. Hier wird ein Statement-Objekt erzeugt, mit dem SQL-Befehl
   oci_execute($stmt);                 // das Befehl wird ausgeführt
   oci_fetch_all($stmt);
  ?>

<div class="tabela">
<table>
  <tr>
    <th>Name</th>
    <th>Form</th>
    <th>Gewicht (kg)</th>
  </tr>
  <?php
    while ($row = oci_fetch_assoc($stmt)) {    
     echo "<tr>";
     echo "<td>" . $row['NAME'] . "</td>";
     echo "<td>". $row['FORM'] . "</td>";
     echo "<td>" . $row['GEWICHT'] . "</td>";
     echo "</tr>";
    }
 ?>
</table>
</div>
<h2 class="sucheAlle"> Insgesamt <?php echo oci_num_rows($stmt); ?> Torten gefunden! </h2>
<?php oci_free_statement($stmt);  ?>





<!--     ************************************************************************************************ -->
<!--     **************************************  NEUE TORTE EINTRAGEN   ********************************* -->
<!--     ************************************************************************************************ -->



<!-- Formular für die Daten, die man eingeben soll : -->
<form action='torte.php' method='get'>
  <h2 class="sucheAlle"> Neue Torte hinzufuegen: </h2>
<div class="tabela">
  <table>  <!-- wieder in Form einer Tabelle -->

	  <tr>
	    <th>Name</th>   <!-- die Spaltenüberschriften -->
	    <th>Form</th>
      <th>Gewicht (kg)</th>
      <th> Preis </th>
    </tr>
	  <tr>
      <td>
        <input class="tabelaUnos" name='Name' type='text' value='<?php if (isset($_GET['Name'])) echo $_GET['Name']; ?>' />
      </td>
		  <td>
		    <input class="tabelaUnos" name='Form' type='text' value='<?php if (isset($_GET['Form'])) echo $_GET['Form']; ?>' />
		  </td>
		  <td>
		    <input class="tabelaUnos" name='Gewicht' type='number' step="0.01" value='<?php if (isset($_GET['Gewicht'])) echo $_GET['Gewicht']; ?>' />
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
  if (isset($_GET['Name']) && isset($_GET['Form']) && isset($_GET['Gewicht']) && isset($_GET['Preis'])) 
  {
    // Das SQL-Befehl wird hier anhand der Eingabe erzeugt:
    $sqlSuessigkeit = "INSERT INTO Suessigkeit(Name,Preis) VALUES('" . $_GET['Name'] . "'," . $_GET['Preis'] .")";
    $sqlTorte = "INSERT INTO Torte(Name,Form,Gewicht) VALUES('" . $_GET['Name'] . "','"  . $_GET['Form'] . "'," . $_GET['Gewicht'] .  ")";

    // neues Statement-Objekt mit dem obigen SQL-Befehl erzeugen:
    $insertSuessigkeit = oci_parse($conn, $sqlSuessigkeit);
    $insertTorte = oci_parse($conn, $sqlTorte);
    // das Statement ausführen:
    oci_execute($insertSuessigkeit);
    oci_execute($insertTorte);
    // sollte es zu einem Verbindungsfehler kommen, dann wird er in die $con_err Variable gespeichert:
    $conn_err=oci_error($conn);
    // sollte es zu einem Fehler bei der Ausführung des SQL INSERT-Befehls kommen, dann wird die Fehlerangabe in die $insert_err Variable gespeichert:
    $insert_err=oci_error($insertSuessigkeit);

    // falls es keine Fehler gibt, einfach folgende Nachricht ausgeben
      if(!$conn_err & !$insert_err){
        echo("<script> alert('Neue Torte wurde hinzugefuegt');</script>");
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
