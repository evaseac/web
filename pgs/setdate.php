<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form action="<?php echo $_POST['page']; ?>" method="post" hidden>
      <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
      <input type="text" name="sitio" value="<?php echo $_POST['sitio']; ?>">
      <input type="text" name="responsable" value="<?php echo $_POST['responsable']; ?>">
      <input type="text" name="qryFamilia" value="SELECT C.Nombre AS Clase, O.Nombre AS Orden, F.Nombre AS Familia FROM Familia AS F INNER JOIN Orden AS O ON O.ID = F.IdOrden INNER JOIN Clase AS C ON C.ID = O.IdClase WHERE F.Nombre != 'no identificado'">
      <input type="text" name="qryGenero" value="SELECT C.Nombre AS Clase, O.Nombre AS Orden, F.Nombre AS Familia, G.Nombre AS Genero FROM Genero AS G INNER JOIN Familia AS F ON F.ID = G.IdFamilia INNER JOIN Orden AS O ON O.ID = F.IdOrden INNER JOIN Clase AS C ON C.ID = O.IdClase ORDER BY Clase">
      <input type="text" name="qryPrueba" value="SELECT P.Nombre AS Prueba, Parametros FROM Prueba AS P">
      <input type="text" name="qryP" value="SELECT NULL FROM Prueba">
      <input type="text" name="query_image" value="SELECT NULL AS url">
      <input type="submit" value="Submit" id="btnSubmit">
    </form>
  </body>
</html>

<script>
  window.onload = function(){
    document.getElementById('btnSubmit').click();
  }
</script>
