<?php
  include '../../database/evaseacdb.php';

  $conn = open_database();
  if (!$conn)
    die("Error al conectar al servidor: " . mysqli_connect_error());

  //Retrieving data
  $date = $_POST['date'];

  //Selecting temp
  if (!isset($_POST['site_selected']) || $_POST['site_selected'] == "")
    $query = "SELECT ID, Responsable, IdSitio FROM Temporada WHERE Temporada = '" . $date . "-01' ORDER BY ID DESC LIMIT 1";
  else
  {
    $result = mysqli_query($conn, "SELECT ID FROM Sitio WHERE Nombre = '" . $_POST['site_selected'] . "'");
    $query = "SELECT ID, Responsable, IdSitio FROM Temporada WHERE Temporada = '" . $date . "-01' AND IdSitio = " . mysqli_fetch_array($result)["ID"];
  }

  $consultar = "consultar.php";
  $query_imagenes = "SELECT NULL AS url";

  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result);
  if (mysqli_num_rows($result) > 0){
    //Setting temp data
    $id_sitio = $row["IdSitio"];
    $id_temp = $row["ID"];
    $responsable = $row["Responsable"];
    //Selecting info sitio
    $query = "SELECT P.Nombre AS Proyecto, Financiamiento, S.Nombre AS Sitio, Estado, Abreviatura, RioCuenca, Norte, Oeste, Altitud
      FROM Sitio AS S
      INNER JOIN Proyecto AS P ON P.ID = S.IdProyecto
      WHERE S.ID = " . $id_sitio;
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    //Setting main data
    $proyecto = $row["Proyecto"];
    $financiamiento = $row["Financiamiento"];
    $sitio = $row["Sitio"];
    $estado = $row["Estado"];
    $abreviatura = $row["Abreviatura"];
    $rio_cuenca = $row["RioCuenca"];
    $norte = $row["Norte"];
    $oeste = $row["Oeste"];
    $altitud = $row["Altitud"];
    //Setting queries
    $query_macroinvertebrados = "SELECT a.* FROM(".
        "SELECT C.Nombre AS Clase, O.Nombre AS Orden, F.Nombre AS Familia, NULL AS Genero, FS.Habitat AS Habitat, FS.Numero AS Numero " .
        "FROM Familia AS F " .
        "INNER JOIN FamiliasSitios AS FS ON F.ID = FS.IdFamilia " .
        "INNER JOIN Orden AS O ON O.ID = F.IdOrden " .
        "INNER JOIN Clase AS C ON C.ID = O.IdClase " .
        "WHERE FS.IdTemporada = " . $id_temp .
        " UNION ALL " .
        "SELECT C.Nombre AS Clase, O.Nombre AS Orden, F.Nombre AS Familia, G.Nombre AS Genero, GS.Habitat AS Habitat, GS.Numero AS Numero " .
        "FROM Genero AS G " .
        "INNER JOIN GenerosSitios AS GS ON G.ID = GS.IdGenero " .
        "INNER JOIN Familia AS F ON F.ID = G.IdFamilia " .
        "INNER JOIN Orden AS O ON O.ID = F.IdOrden " .
        "INNER JOIN Clase AS C ON C.ID = O.IdClase " .
        "WHERE GS.IdTemporada = " . $id_temp .
      ") AS a " .
      "ORDER BY Clase";
    $query_parametros = "SELECT a.* FROM(" .
        "SELECT 'Saturacion' AS Parametro, Saturacion AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'Conductividad' AS Parametro, Conductividad AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'OD' AS Parametro, OD AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'pH' AS Parametro, pH AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'Salinidad' AS Parametro, Salinidad AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'TempAgua' AS Parametro, TempAgua AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'TempAire' AS Parametro, TempAire AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'Turbiedad' AS Parametro, Turbiedad AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'VelocidadCorriente' AS Parametro, VelocidadCorriente AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'Altura' AS Parametro, Altura AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'VelocidadViento' AS Parametro, VelocidadViento AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'Alcalinidad' AS Parametro, Alcalinidad AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'Cloro' AS Parametro, Cloro AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'ColFec' AS Parametro, ColFec AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'ColTotal' AS Parametro, ColTotal AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'DBO' AS Parametro, DBO AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'Dureza' AS Parametro, Dureza AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'NH3' AS Parametro, NH3 AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'NO2' AS Parametro, NO2 AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'NO3' AS Parametro, NO3 AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'NT' AS Parametro, NT AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'OPO4' AS Parametro, OPO4 AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'PT' AS Parametro, PT AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp . " UNION ALL " .
        "SELECT 'Color' AS Parametro, Color AS Valor FROM Parametros WHERE IdTemporada = " . $id_temp .
      ") AS a";
    $query_pruebas = "SELECT P.Nombre AS Prueba, Pp.Nombre AS Parametro, Valor " .
      "FROM ParametrosPSitios AS Pps " .
      "INNER JOIN ParametrosP AS Pp ON Pp.ID = Pps.IdParametrosP " .
      "INNER JOIN Prueba AS P ON P.ID = Pp.IdPrueba " .
      "INNER JOIN Temporada AS T ON T.ID = Pps.IdTemporada " .
      "WHERE IdTemporada = " . $id_temp .
      " ORDER BY Prueba";

    // Images
    $result = mysqli_query($conn, "SELECT url FROM Imagenes WHERE IdTemporada = " . $id_temp . " LIMIT 9");
    if (mysqli_num_rows($result) > 0)
    {
      $consultar = "consultar_sitio.php";
      $query_imagenes = "SELECT url FROM Imagenes WHERE IdTemporada = " . $id_temp . " LIMIT 9";
    }
  }
  else{
    $sitio = "Sin información disponible";
    $abreviatura = $estado = $rio_cuenca = $altitud = $proyecto = $financiamiento = $responsable = "";
    $norte = 19.453298;
    $oeste = -99.172450;
    $query_macroinvertebrados = "SELECT NULL AS Clase, NULL AS Orden, NULL AS Familia, NULL AS Genero";
    $query_parametros = "SELECT NULL AS Parametro, NULL AS Valor";
    $query_pruebas = "SELECT NULL AS Prueba, NULL AS Parametro, NULL AS Valor";
  }
  mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Evaseac - Recogiendo datos de base de datos...</title>
  </head>
  <body>
    <form  id="main" action="<?php echo $consultar; ?>" method="post" hidden>
      <!-- Sitio -->
      <input type="text" name="sitio" value="<?php echo $sitio; ?>">
      <input type="text" name="abreviatura" value="<?php echo $abreviatura; ?>">
      <input type="text" name="estado" value="<?php echo $estado; ?>">
      <input type="text" name="rio_cuenca" value="<?php echo $rio_cuenca; ?>">
      <input type="text" name="altitud" value="<?php echo $altitud; ?>">
      <input type="text" name="norte" value="<?php echo $norte; ?>">
      <input type="text" name="oeste" value="<?php echo $oeste; ?>">
      <!-- Proyecto -->
      <input type="text" name="proyecto" value="<?php echo $proyecto; ?>">
      <input type="text" name="financiamiento" value="<?php echo $financiamiento; ?>">
      <!-- Temporada -->
      <input type="text" name="responsable" value="<?php echo $responsable; ?>">
      <input type="text" name="date" value="<?php echo $date; ?>">
      <!-- Datos temporada -->
      <input type="text" name="query_macroinvertebrados" value="<?php echo $query_macroinvertebrados; ?>">
      <input type="text" name="query_parametros" value="<?php echo $query_parametros; ?>">
      <input type="text" name="query_pruebas" value="<?php echo $query_pruebas; ?>">
      <!-- Imagenes -->
      <input type="text" name="query_imagenes" value="<?php echo $query_imagenes; ?>">
      <!-- Submit button -->
      <input type="submit" name="submit" value="Submit">
    </form>
  </body>
</html>
<script>
  window.onload = function(){
    document.forms["main"]["submit"].click();
  }
</script>
