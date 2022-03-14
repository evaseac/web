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

      $prueba = $_POST['txtPrueba'];
      $no_params = $_POST['txtNoParams'];

      $result = mysqli_query($conn, "SELECT ID FROM Prueba WHERE Nombre = '".$_POST['txtPrueba']."'");
      $row = mysqli_fetch_array($result);
      $id_tst = $row["ID"];

      $id_param = $_POST['txtID'];
      $valor = $_POST['txtValue'];

      $qryPrueba = $_POST['qryPrueba'];

      $qryP = "SELECT  PP.ID AS ID, PP.Nombre AS Nombre, PP.Repeticiones FROM ParametrosP AS PP WHERE NOT EXISTS(SELECT NULL FROM ParametrosPSitios AS PPS WHERE PP.ID = PPS.IdParametrosP AND PPS.IdTemporada = ".$id_temp.") AND PP.IdPrueba = ".$id_tst;
      $no_parametro = $_POST['txtNoParam'] + 1;
    ?>

    <!-- Inserting data -->
    <?php
      $parametro = "INSERT INTO ParametrosPSitios (IdParametrosP, IdTemporada, Valor) VALUES (".$id_param.", ".$id_temp.", ".$valor.")";

      // Inserting Parametro
      if (mysqli_query($conn, $parametro))
        echo "Parametro insertado exitosamente";
      else
        echo "Error: " . $parametro . "<br>" . mysqli_error($conn);
      echo "<br>";

      $result = mysqli_query($conn, $qryP);
      if (mysqli_num_rows($result) == 0)
      {
        $qryP = "SELECT NULL FROM Prueba";
        $qryPrueba = "SELECT P.Nombre AS Prueba, Parametros FROM Prueba AS P";
        $sitio = $responsable = $prueba = $no_parametro = $no_params = "";
      }

      mysqli_close($conn);
    ?>

    <form action="otras_pruebas.php" method="post">
      <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
      <input type="text" name="sitio" id="txtSite2" value="<?php echo $sitio; ?>">
      <input type="text" name="responsable" value="<?php echo $responsable; ?>">
      <input type="text" name="qryPrueba" value="<?php echo $qryPrueba; ?>">
      <input type="text" name="prueba" id="txtTest "value="<?php echo $prueba; ?>">
      <input type="text" name="noParametros" value="<?php echo $no_params; ?>">
      <input type="text" name="qryP" value="<?php echo $qryP; ?>">
      <input type="text" name="no_parametro" value="<?php echo $no_parametro; ?>">

      <input type="submit" name="submit" id="btnSubmit" value="Submit">
    </form>
  </body>
</html>
<script>
window.onload = function(){
  document.getElementById('btnSubmit').click();
}
</script>
