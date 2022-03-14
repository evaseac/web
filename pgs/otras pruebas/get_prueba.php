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

      $result = mysqli_query($conn, "SELECT ID, Parametros FROM Prueba WHERE Nombre = '".$_POST['prueba']."'");
      $row = mysqli_fetch_array($result);
      $ID = $row["ID"];
      $no_params = $row["Parametros"];

      $qryP = "SELECT ID, Nombre, Repeticiones FROM ParametrosP WHERE IdPrueba = ".$ID;

      mysqli_close($conn);
    ?>

    <form action="otras_pruebas.php" method="post" hidden>
      <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
      <input type="text" name="sitio" id="txtSite2" value="<?php echo $_POST['sitio']; ?>">
      <input type="text" class="form-control" name="responsable" value="<?php echo $_POST['responsable']; ?>">
      <input type="text" name="prueba" id="txtTest "value="<?php echo $_POST['prueba']; ?>">
      <input type="text" name="noParametros" value="<?php echo $no_params; ?>">
      <input type="text" name="qryPrueba" value="<?php echo $_POST['qryPrueba']; ?>">
      <input type="text" name="qryP" value="<?php echo $qryP; ?>">
      <input type="text" name="no_parametro" value="1">

      <input type="submit" name="submit" id="btnSubmit" value="Submit">
    </form>
  </body>
</html>
<script>
window.onload = function(){
  document.getElementById('btnSubmit').click();
}
</script>
