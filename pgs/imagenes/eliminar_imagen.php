<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Evaseac - Recogiendo datos de base de datos...</title>
  </head>
  <body>
    <!-- Retrieving data -->
    <?php
      include '../../database/evaseacdb.php';

      $conn = open_database();
      if (!$conn)
        die("Error al conectar al servidor: " . mysqli_connect_error());

      $sitio = $_POST['sitio'];
      $responsable = $_POST['responsable'];
      $date = $_POST['date'];

      $result = mysqli_query($conn, "SELECT ID FROM Sitio WHERE Nombre = '".$sitio."'");
      $idSitio = mysqli_fetch_assoc($result)["ID"];

      // Retrieving or creating IdTemporada
      $result =  mysqli_query($conn, "SELECT ID FROM Temporada WHERE IdSitio = ".$idSitio." && Temporada = '".$date."-01'");
      if (mysqli_num_rows($result) > 0)
        $id_temp = mysqli_fetch_assoc($result)["ID"];
      else // Creates Temporada
        die("Error al recoger los datos de la temporada");

      $url = $_POST['url_to_delete'];
      $query_image = "SELECT url FROM Imagenes WHERE IdTemporada = " . $id_temp;
    ?>

    <!-- Deleting data -->
    <?php
      $delete = "DELETE FROM Imagenes WHERE IdTemporada = " . $id_temp . " && url = '" . $url . "'";

      // Deleting
      if (mysqli_query($conn, $delete))
        echo "URL eliminada exitosamente";
      else
        echo "Error: " . $delete . "<br>" . mysqli_error($conn);

      echo "<br>";
    ?>

    <form action="imagenes.php" method="post">
      <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
      <input type="text" name="sitio" id="txtSite2" value="<?php echo $sitio; ?>">
      <input type="text" name="responsable" value="<?php echo $responsable; ?>">
      <input type="text" name="query_image" value="<?php echo $query_image; ?>">

      <input type="submit" name="submit" id="btnSubmit" value="Submit">
    </form>
  </body>
</html>
<script>
window.onload = function(){
  document.getElementById('btnSubmit').click();
}
</script>
