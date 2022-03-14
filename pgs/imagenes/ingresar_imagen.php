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

      $sitio = $_POST['txtSitio'];
      $responsable = $_POST['txtResponsable'];
      $date = $_POST['date'];

      $result = mysqli_query($conn, "SELECT ID FROM Sitio WHERE Nombre = '".$sitio."'");
      $idSitio = mysqli_fetch_assoc($result)["ID"];

      // Retrieving or creating IdTemporada
      $result =  mysqli_query($conn, "SELECT ID FROM Temporada WHERE IdSitio = ".$idSitio." && Temporada = '".$date."-01'");
      if (mysqli_num_rows($result) > 0)
        $id_temp = mysqli_fetch_assoc($result)["ID"];
      else // Creates Temporada
      {
        $insrt = "INSERT INTO Temporada (Responsable, Temporada, IdSitio) VALUES ('".$responsable."', '".$date."-01', ".$idSitio.")";
        if (mysqli_query($conn, $insrt))
          echo "Temporada creada exitosamente";
        else
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);

        echo "<br>";

        $result = mysqli_query($conn, "SELECT ID FROM Temporada ORDER BY ID DESC LIMIT 1");
        $id_temp = mysqli_fetch_assoc($result)["ID"];
      }

      $url = $_POST['txtUrl'];
      $query_image = "SELECT url FROM Imagenes WHERE IdTemporada = " . $id_temp;
    ?>

    <!-- Inserting data -->
    <?php
      $insert = "INSERT INTO Imagenes (IdTemporada, url) VALUES (" . $id_temp . ", '" . $url . "')";

      // Inserting
      if (mysqli_query($conn, $insert))
        echo "URL ingresada exitosamente";
      else
        echo "Error: " . $insert . "<br>" . mysqli_error($conn);

      echo "<br>";

      $result = mysqli_query($conn, $query_image);
      if (mysqli_num_rows($result) == 0)
      {
        $query_image = "SELECT NULL AS url";
        $sitio = $responsable = "";
      }

      mysqli_close($conn);
    ?>

    <form action="imagenes.php" method="post" hidden>
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
