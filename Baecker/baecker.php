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
  <title> Baecker </title>
  <link rel="stylesheet" href="style(baecker).css">
  <link href="https://fonts.googleapis.com/css?family=Playball" rel="stylesheet">
  <script src="script.js"></script>
  <link rel="icon" href="logo2.jpg">
</head>

<body>

<a class="dropbtn" href='index.php'>Click to go back</a>
<h1 class="naslov">Bäcker</h1>

<div class="suche">
  <form id='pretraga' action='baecker.php' method='get'>
    <h2 class="sucheAlle">Suche nach Erfahrung: </h2>
    <input class="pretraga" id='search' name='search' type='text' size='20' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
    <input id='submit' type='submit' value='Suchen!' />
</div>


<meta name="viewport" content="width=device-width, initial-scale=1">
<style> 
 input[type=text] {
  width: 130px;
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

 input[type=text]:focus {
  width: 35%;
 }
</style>

<div class="suche">
<div class="dropdown">
<a class="dropbtn" href='baecker.php'>Alle Bäcker</a> 
<a class="dropbtn" href='neueBaecker.php'>Neue Bäcker</a>
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
  background-color: rgba(234, 236, 239,0.6);
 }

 tr:nth-child(even) {
  background-color: #dddddd;
 }
</style>

<?php
// falls ein Search-Parameter vorhanden ist, dann müssen wir die Namen der Torte anhand des Search-Parameters filtrieren
if (isset($_GET['search'])) {
  $sql = "SELECT * FROM Mitarbeiter INNER JOIN Baecker ON Mitarbeiter.Personalnummer=Baecker.Personalnummer WHERE Erfahrung like '%" . $_GET['search'] . "%'";
} else {
  $sql = "SELECT * FROM Mitarbeiter INNER JOIN Baecker ON Mitarbeiter.Personalnummer=Baecker.Personalnummer";  // ansonsten einfach alle Torten ausgeben
}

// das SQL-Befehl ausführen:
$stmt = oci_parse($conn, $sql);              // unser SQL-Befehl wird in der $sql Variable gespeichert. Hier wird ein Statement-Objekt erzeugt, mit dem SQL-Befehl
oci_execute($stmt);                        // das Befehl wird ausgeführt
?>

<div class="tabela">
<table>
  <tr>
    <th>Personalnummer</th>
    <th>Name</th>
    <th>Ausbildung</th>
    <th>Erfahrung</th>
    <th>Optionen</th>
  </tr>

  <?php
  while ($row = oci_fetch_assoc($stmt)) {    
    echo "<tr>";
    echo "<td>" . $row['PERSONALNUMMER'] . "</td>";    
    echo "<td>" . $row['NAME'] . "</td>";
    echo "<td>". $row['AUSBILDUNG'] . "</td>";
    echo "<td>" . $row['ERFAHRUNG'] . "</td>";
    echo "<td> <a class='neueBackzubehoer' href='neueBzubehoer.php?PNr=" . $row['PERSONALNUMMER'] ."'> + Backzubehoer</a> </td>";
    echo "</tr>";
  }
?>
</table>
</div>

<div> <h2 class="sucheAlle"> Insgesamt <?php echo oci_num_rows($stmt); ?> Baecker gefunden! </h2> </div>
</form>
<?php  
oci_free_statement($stmt); 
oci_close($conn);
?>

</body>
</html>
