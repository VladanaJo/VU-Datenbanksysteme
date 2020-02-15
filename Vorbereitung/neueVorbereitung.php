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
  <title> Neue Vorbereitung </title>
  <link rel="stylesheet" href="style(vorbereitung).css">
  <link href="https://fonts.googleapis.com/css?family=Playball" rel="stylesheet">
  <script src="script.js"></script>
  <link rel="icon" href="logo2.jpg">
</head>

<body>
<a class="dropbtn" href='vorbereitung.php'>Click to go back</a>
<h1 class="naslov">Neue Vorbereitung</h1>


<style>
 .naslov{
   text-align: center;
   color: black;
   font-family: 'Playball', cursive;
  }

 table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
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

 .pretraga:focus {
  width: 45%;
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


  <div class="tabela">
    <form action='neueVorbereitung.php' method='get'>
        <table>

          <tr>
            <th>Name der Suessigkeits</th>
            <th>Personalnummer des Baeckers</th>
          </tr>

          <tr>
            <td>
                <input class="tabelaUnos" name='Name' type='text' value='<?php if (isset($_GET['Name'])) echo $_GET['Name']; ?>' />
            </td>
            <td>
                <input class="tabelaUnos" name='Personalnummer' type='number' value='<?php if (isset($_GET['Personalnummer'])) echo $_GET['Personalnummer']; ?>' />
            </td>
          </tr>

        </table>
        <input id='submit' type='submit' value='Hinzufuegen!' />   <!-- der Insert-Button -->
    </form>
  </div>




<?php
//Handle insert
if (isset($_GET['Name']) && isset($_GET['Personalnummer']) ) 
{
  // Das SQL-Befehl wird hier anhand der Eingabe erzeugt:
  $sqlNeueVorbereitung = "INSERT INTO Vorbereiten(Name, Personalnummer) VALUES('". $_GET['Name'] . "'," . $_GET['Personalnummer'] .")";
  // neues Statement-Objekt mit dem obigen SQL-Befehl erzeugen:
  $insertNeueVorbereitung = oci_parse($conn, $sqlNeueVorbereitung);
  // das Statement ausführen:
  oci_execute($insertNeueVorbereitung);
  // sollte es zu einem Verbindungsfehler kommen, dann wird er in die $con_err Variable gespeichert:
  $conn_err=oci_error($conn);
  // sollte es zu einem Fehler bei der Ausführung des SQL INSERT-Befehls kommen, dann wird die Fehlerangabe in die $insert_err Variable gespeichert:
  $insert_err=oci_error($insertNeueVorbereitung);

  // falls es keine Fehler gibt, einfach folgende Nachricht ausgeben
  if(!$conn_err & !$insert_err){
    echo("<script> alert('Neue Vorbereitung wurde hinzugefuegt.');</script>");
 } else{    // ansonsten eventuelle Fehler ausgeben:
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