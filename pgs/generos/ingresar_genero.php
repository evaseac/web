<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Evaseac - Ingresando Parametros</title>
  </head>
  <body>
    <p>
      <!-- Retrieving Data from database -->
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
          $ID = mysqli_fetch_assoc($result)["ID"];
        else // Creates Temporada
        {
          $insrt = "INSERT INTO Temporada (Responsable, Temporada, IdSitio) VALUES ('".$responsable."', '".$date."-01', ".$idSitio.")";
          if (mysqli_query($conn, $insrt))
            echo "Temporada creada exitosamente";
          else
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);

          echo "<br>";

          $result = mysqli_query($conn, "SELECT ID FROM Temporada ORDER BY ID DESC LIMIT 1");
          $ID = mysqli_fetch_assoc($result)["ID"];
        }

        $qry = "SELECT C.Nombre AS Clase, O.Nombre AS Orden, F.Nombre AS Familia, G.Nombre AS Genero FROM Genero AS G, Familia AS F, Orden AS O, Clase AS C WHERE NOT EXISTS(SELECT NULL FROM GenerosSitios AS GS WHERE G.ID = GS.IdGenero AND GS.IdTemporada = ".$ID.") AND G.IdFamilia = F.ID AND F.IdOrden = O.ID AND O.IdClase = C.ID GROUP BY Genero ORDER BY Clase";
      ?>

      <!-- Assigning values -->
      <?php
        $result = mysqli_query($conn, "SELECT ID FROM Genero WHERE Nombre = '".$_POST['txtGenero']."'");
        $IdGen = mysqli_fetch_assoc($result)["ID"];

        $Numero = $_POST['txtNumero'];
        $Habitat = $_POST['txtHabitat'];
      ?>

      <!-- Inserting into database -->
      <?php
      $gen = "INSERT INTO GenerosSitios (IdGenero, IdTemporada, Numero, Habitat) VALUES (".$IdGen.", ".$ID.", ".$Numero.", '".$Habitat."')";

      // Inserting Familia
      if (mysqli_query($conn, $gen))
        echo "G??nero insertado exitosamente";
      else
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      echo "<br>";

      mysqli_close($conn);
      ?>

      <form action="generos.php" method="post" hidden>
        <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
        <input type="text" name="sitio" value="<?php echo $_POST['txtSitio']; ?>">
        <input type="text" name="responsable" value="<?php echo $_POST['txtResponsable']; ?>">
        <input type="text" name="qryGenero" value="<?php echo $qry; ?>">
        <input type="submit" value="Submit" id="btnSubmit">
      </form>
    </p>
  </body>
</html>
<script>
  window.onload = function(){
    document.getElementById('btnSubmit').click();
  }
</script>
