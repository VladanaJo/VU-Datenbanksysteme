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
  <title> Rezepte und Zutaten </title>
  <link rel="stylesheet" href="style(rezepte).css">
  <link href="https://fonts.googleapis.com/css?family=Playball" rel="stylesheet">
  <script src="script.js"></script>
  <link rel="icon" href="logo2.jpg">
</head>

<body>

<a class="dropbtn" href='index.php'>Click to go back</a>
<h1 class="naslov">Rezepte und Zutaten</h1>

<div class="suche">
  <form id='searchform' action='rezepte.php' method='get'>
    <h2 class="sucheAlle">Suche nach Zutat: </h2>
    <input class="searchform" id='search' name='search' type='text' size='20' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
    <input id='submit' type='submit' value='Suchen!' />
  </form>
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


<!--     ************************************************************************************************ -->
<!--     *************************************  TORTE SUCHEN  ******************************************* -->
<!--     ************************************************************************************************ -->


<div class="suche">
<div class="dropdown">
<a class="dropbtn" href='rezepte.php'>Alle Rezepte</a> <a class="dropbtn" href='neuesRezept.php'>Neues Rezept</a>
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

 tr:nth-child(even) {
  background-color: #dddddd;
 }
</style>

<?php
// falls ein Search-Parameter vorhanden ist, dann müssen wir die Namen der Torte anhand des Search-Parameters filtrieren
if (isset($_GET['search'])) {
  $sql = "SELECT * FROM RezeptHatZutat WHERE Bezeichnung like '%" . $_GET['search'] . "%'";
} else {
  $sql = "SELECT * FROM RezeptHatZutat";  // ansonsten einfach alle Torten ausgeben
}

// das SQL-Befehl ausführen:
$stmt = oci_parse($conn, $sql);              // unser SQL-Befehl wird in der $sql Variable gespeichert. Hier wird ein Statement-Objekt erzeugt, mit dem SQL-Befehl
oci_execute($stmt);                        // das Befehl wird ausgeführt
?>


<div class="tabela">
<table>
  <tr>
    <th>Name</th>
    <th>Zutaten</th>
  </tr>
  <?php
  while ($row = oci_fetch_assoc($stmt)) {    
    echo "<tr>";
    echo "<td>" . $row['NAME'] . "</td>";
    echo "<td>". $row['BEZEICHNUNG'] . "</td>";
    echo "</tr>";
  }
?>
</table>
</div>

<div> <h2 class="sucheAlle"> Insgesamt <?php echo oci_num_rows($stmt); ?> Rezepte gefunden! </h2> </div>
</form>
<?php  
oci_free_statement($stmt); 
oci_close($conn);
?>

</body>
</html>



