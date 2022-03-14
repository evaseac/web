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
      // Getting user
      $result = mysqli_query($conn, "SELECT password FROM Usuario WHERE usuario = '".$_POST['usuario']."'");
      $row = mysqli_fetch_assoc($result);

      //Validating user and possword
      $valid = 0;
      if (mysqli_num_rows($result) > 0){
        if ($_POST['password'] == $row["password"]){
          $valid = 1;
        }
      }

      mysqli_close($conn);
    ?>

    <form action="sitios.php" method="post" hidden>
      <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
      <input type="text" name="sitio" value="">
      <input type="text" name="responsable" value="">
      <input type="submit" value="Submit" id="btnSubmit">
    </form>
    <form class="" action="datos_incorrectos.html" method="post" hidden>
      <input type="submit" name="Submit1" id="btnSubmit1" value="Submit">
    </form>
  </body>
</html>
<script>
  window.onload = function(){
    if ("<?php echo $valid; ?>" == "1"){
      console.log("Correcto");
      document.getElementById('btnSubmit').click();
    }
    else {
      console.log("Incorrecto");
      document.getElementById('btnSubmit1').click();
    }
  }
</script>
