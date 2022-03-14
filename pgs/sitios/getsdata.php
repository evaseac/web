<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Evaseac - Recogiendo datos de base de datos...</title>
  </head>
  <body>
    <?php
      include '../../database/evaseacdb.php';

      $conn = open_database();
      if (!$conn)
        die("Error al conectar al servidor: " . mysqli_connect_error());

      // Getting ID
      $result = mysqli_query($conn, "SELECT ID FROM Sitio WHERE Nombre = '".$_POST['sitio']."'");
      $ID = mysqli_fetch_array($result)["ID"];
      // Getting Responsable
      $result = mysqli_query($conn, "SELECT Responsable FROM Temporada WHERE IdSitio = ".$ID." && Temporada = '".$_POST['date']."-01'");
      $responsable = mysqli_fetch_array($result)["Responsable"];

      mysqli_close($conn);
    ?>

    <form action="sitios.php" method="post" hidden>
      <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
      <input type="text" name="sitio" value="<?php echo $_POST['sitio']; ?>">
      <input type="text" name="responsable" value="<?php echo $responsable; ?>">
      <input type="submit" value="Submit" id="btnSubmit">
    </form>
  </body>
</html>
<script>
window.onload = function(){
  document.getElementById('btnSubmit').click();
}
</script>
