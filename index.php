<?php
// Login Daten
$user = '***';
$pass = '***';
$database = '***';
 
  // Verbindung mit der Datenbank:
  $conn = oci_connect($user, $pass, $database);
  if (!$conn) exit;
?>


<html>
<head>
  <title> Konditorei </title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Playball" rel="stylesheet">
  <script src="script.js"></script>
  <link rel="icon" href="logo2.jpg">
</head>

<body>
<div class="meni">
    <!-- komentar -->
    <div class="dropdown">
        <a onclick="showDropdown()" class="dropbtn">Süßigkeit</a>
          <div id="myDropdown" class="dropdown-content">
          <a class="dropbtn" href='torte.php'>Torte</a>
          <a class="dropbtn" href='eiscreme.php'>Eiscreme</a>
        </div>
    </div>

    <div class="dropdown">
          <a onclick="showDropdown2()" class="dropbtn">Mitarbeiter</a>
          <div id="myDropdown2" class="dropdown-content">
            <a class="dropbtn" href='baecker.php'>Bäcker</a>
            <a class="dropbtn" href='verkaeufer.php'>Verkäufer</a>
          </div>
    </div>

    <div class="dropdown">
      <a class="dropbtn" href='rezepte.php'>Rezepte und Zutaten</a>
    </div>

    <div class="dropdown">
      <a class="dropbtn" href='vorbereitung.php'>Vorbereitung</a>
    </div>



</div>

</body>
</html>
