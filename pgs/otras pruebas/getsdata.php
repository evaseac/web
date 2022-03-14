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
      $result = mysqli_query($conn, "SELECT ID, Responsable FROM Temporada WHERE IdSitio = ".$ID." && Temporada = '".$_POST['date']."-01'");
      $row = mysqli_fetch_assoc($result);
      if (mysqli_num_rows($result) > 0) {
        $IdTemp = $row["ID"];

        $qry = "SELECT P.Nombre AS Prueba, Parametros FROM Prueba AS P, ParametrosP AS PP WHERE NOT EXISTS(SELECT NULL FROM ParametrosPSitios AS PS WHERE PP.ID = PS.IdParametrosP AND PS.IdTemporada = ".$IdTemp.") AND PP.IdPrueba = P.ID GROUP BY Prueba";
      }
      else
        $qry = "SELECT P.Nombre AS Prueba, Parametros FROM Prueba AS P";

      $responsable = $row["Responsable"];

      mysqli_close($conn);
    ?>

    <form action="otras_pruebas.php" method="post" hidden>
      <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
      <input type="text" name="sitio" value="<?php echo $_POST['sitio']; ?>">
      <input type="text" name="responsable" value="<?php echo $responsable; ?>">
      <input type="text" name="qryPrueba" value="<?php echo $qry; ?>">
      <input type="text" name="qryP" value="SELECT NULL FROM Prueba">
      <input type="submit" value="Submit" id="btnSubmit">
    </form>
  </body>
</html>
<script>
window.onload = function(){
  document.getElementById('btnSubmit').click();
}
</script>
