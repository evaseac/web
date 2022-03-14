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

        $qry = "SELECT C.Nombre AS Clase, O.Nombre AS Orden, F.Nombre AS Familia FROM Familia AS F, Orden AS O, Clase AS C WHERE NOT EXISTS(SELECT NULL FROM FamiliasSitios AS FS WHERE F.ID = FS.IdFamilia AND FS.IdTemporada = ".$IdTemp.") AND F.IdOrden = O.ID AND O.IdClase = C.ID AND F.Nombre != 'no identificado' GROUP BY Familia";
      }
      else
        $qry = "SELECT C.Nombre AS Clase, O.Nombre AS Orden, F.Nombre AS Familia FROM Familia AS F INNER JOIN Orden AS O ON O.ID = F.IdOrden INNER JOIN Clase AS C ON C.ID = O.IdClase WHERE F.Nombre != 'no identificado'";

      $responsable = $row["Responsable"];

      mysqli_close($conn);
    ?>

    <form action="familias.php" method="post" hidden>
      <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
      <input type="text" name="sitio" value="<?php echo $_POST['sitio']; ?>">
      <input type="text" name="responsable" value="<?php echo $responsable; ?>">
      <input type="text" name="qryFamilia" value="<?php echo $qry; ?>">
      <input type="submit" value="Submit" id="btnSubmit">
    </form>
  </body>
</html>
<script>
window.onload = function(){
  document.getElementById('btnSubmit').click();
}
</script>
