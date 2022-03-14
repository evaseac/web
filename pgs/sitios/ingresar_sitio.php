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
      ?>

      <!-- Assigning values -->
      <?php
        $saturacion = (($_POST['txtSaturacion1'] + $_POST['txtSaturacion2']) / 2);
        $conductividad = (($_POST['txtCond1'] + $_POST['txtCond2']) / 2);
        $od = (($_POST['txtOD1'] + $_POST['txtOD2']) / 2);
        $ph = (($_POST['txtPH1'] + $_POST['txtPH2']) / 2);
        $salinidad = (($_POST['txtSalinidad1'] + $_POST['txtSalinidad2']) / 2);
        $tempAgua = (($_POST['txtTempAgua1'] + $_POST['txtTempAgua2']) / 2);
        $tempAire = (($_POST['txtTempAire1'] + $_POST['txtTempAire2']) / 2);
        $turbiedad = (($_POST['txtTurbiedad1'] + $_POST['txtTurbiedad2']) / 2);
        $velCorriente = (($_POST['txtVelCorriente1'] + $_POST['txtVelCorriente2']) / 2);
        $altura = (($_POST['txtAltura1'] + $_POST['txtAltura2']) / 2);
        $velViento = (($_POST['txtVelViento1'] + $_POST['txtVelViento2']) / 2);
        $colFec = (($_POST['txtColFec1'] + $_POST['txtColFec2']) / 2);
        $colTotal = (($_POST['txtColTotal1'] + $_POST['txtColTotal2']) / 2);
        $color = (($_POST['txtColor1'] + $_POST['txtColor2']) / 2);
        $dureza = ($_POST['txtDureza1'] * $_POST['txtDureza2']);
        $nh3 = (($_POST['txtNH31'] + $_POST['txtNH32']) / 2);
        $no2 = (($_POST['txtNO21'] + $_POST['txtNO22']) / 2);
        $no3 = (($_POST['txtNO31'] + $_POST['txtNO32']) / 2);
        $nt = (($_POST['txtNT1'] + $_POST['txtNT2']) / 2);
        $opo4 = (($_POST['txtOPO41'] + $_POST['txtOPO42']) / 2);
        $pt = (($_POST['txtPT1'] + $_POST['txtPT2']) / 2);

        $alcIsFinal = $_POST['alcIsFinal'];
        $clIsFinal = $_POST['clIsFinal'];
        $dbood1IsFinal = $_POST['dbood1IsFinal'];
        $dbood5IsFinal = $_POST['dbood5IsFinal'];

        $txtAlcA1 = $txtAlcA2 = $txtClA1 = $txtClA2 = $txtDbood1A1 = $txtDbood1A2 = $txtDbood1E1 = $txtDbood1E2 = $txtDbood5A1 = $txtDbood5A2 = $txtDbood5E1 = $txtDbood5E2 = 0;

        if ($alcIsFinal != "True")
        {
          $alcalinidad = (((($_POST['txtAlcA1'] + $_POST['txtAlcA2']) / 2) * $_POST['txtAlcB'] * $_POST['txtAlcC']) / $_POST['txtAlcD']);
          $txtAlcA1 = $_POST['txtAlcA1'];
          $txtAlcA2 = $_POST['txtAlcA2'];
        }
        else
          $txtAlcA1 = $alcalinidad = $_POST['txtAlcalinidad'];

        if ($clIsFinal != "True")
        {
          $cloro = ((((($_POST['txtClA1'] + $_POST['txtClA2']) / 2) -  $_POST['txtClB']) * $_POST['txtClC'] * $_POST['txtClD']) / $_POST['txtClF']);
          $txtClA1 = $_POST['txtClA1'];
          $txtClA2 = $_POST['txtClA2'];
        }
        else
          $txtClA1 = $cloro = $_POST['txtCloro'];

        if ($dbood1IsFinal != "True")
        {
          $dbo_od1 = (( ( ($_POST['txtDBO_OD1A1'] +  $_POST['txtDBO_OD1A2']) / 2 ) *  $_POST['txtDBO_OD1B'] *  $_POST['txtDBO_OD1C'] * $_POST['txtDBO_OD1D']) /  (($_POST['txtDBO_OD1E1'] +  $_POST['txtDBO_OD1E2']) / 2));
          $txtDbood1A1 = $_POST['txtDBO_OD1A1'];
          $txtDbood1A2 = $_POST['txtDBO_OD1A2'];
          $txtDbood1E1 = $_POST['txtDBO_OD1E1'];
          $txtDbood1E2 = $_POST['txtDBO_OD1E2'];
        }
        else
          $txtDbood1A1 = $dbo_od1 = $_POST['txtDBO_OD1'];

        if ($dbood5IsFinal != "True")
        {
          $dbo_od5 = (( ( ($_POST['txtDBO_OD5A1'] +  $_POST['txtDBO_OD5A2']) / 2 ) *  $_POST['txtDBO_OD5B'] *  $_POST['txtDBO_OD5C'] * $_POST['txtDBO_OD5D']) /  (($_POST['txtDBO_OD5E1'] +  $_POST['txtDBO_OD5E2']) / 2));
          $txtDbood5A1 = $_POST['txtDBO_OD5A1'];
          $txtDbood5A2 = $_POST['txtDBO_OD5A2'];
          $txtDbood5E1 = $_POST['txtDBO_OD5E1'];
          $txtDbood5E2 = $_POST['txtDBO_OD5E2'];
        }
        else
          $txtDbood5A1 = $dbo_od5 = $_POST['txtDBO_OD5'];

        $dbo = $dbo_od5 - $dbo_od1;

        $params = "INSERT INTO Parametros(IdTemporada, Saturacion, Conductividad, OD, pH, Salinidad, TempAgua, TempAire, Turbiedad, VelocidadCorriente, Altura
          , VelocidadViento, Alcalinidad, Cloro, ColFec, ColTotal, Color, DBO, Dureza, NH3, NO2, NO3, NT, OPO4, PT)
          VALUES (".$ID.", ".$saturacion.", ".$conductividad.", ".$od.", ".$ph.", ".$salinidad.", ".$tempAgua.", ".$tempAire.", ".$turbiedad.", ".$velCorriente.",
           ".$altura.", ".$velViento.", ".$alcalinidad.", ".$cloro.", ".$colFec.", ".$colTotal.", ".$color.", ".$dbo.", ".$dureza.", ".$nh3.",
          ".$no2.", ".$no3.", ".$nt.", ".$opo4.", ".$pt.")";
        $rawParams = "INSERT INTO ParametrosCrudo (IdTemporada, Saturacion_1, Saturacion_2, Conductividad_1, Conductividad_2, OD_1, OD_2, pH_1, pH_2, Salinidad_1, Salinidad_2
                , TempAgua_1, TempAgua_2, TempAire_1, TempAire_2, Turbiedad_1, Turbiedad_2, VelocidadCorriente_1, VelocidadCorriente_2, Altura_1
                , Altura_2, VelocidadViento_1, VelocidadViento_2, Alcalinidad_1, Alcalinidad_2, Cloro_a1, Cloro_a2, ColFec, ColTotal, Color_1, Color_2, DBOOD1_a1
                , DBOOD1_a2, DBOOD1_e1, DBOOD1_e2, DBOOD5_a1, DBOOD5_a2, DBOOD5_e1, DBOOD5_e2, NH3_1, NH3_2, NO2_1, NO2_2, NO3_1, NO3_2, NT_1, NT_2
                , OPO4_1, OPO4_2, PT_1, PT_2)
                VALUES (".$ID.", ".$_POST['txtSaturacion1'].", ".$_POST['txtSaturacion2'].", ".$_POST['txtCond1'].", ".$_POST['txtCond2'].",
                  ".$_POST['txtOD1'].", ".$_POST['txtOD2'].", ".$_POST['txtPH1'].", ".$_POST['txtPH2'].", ".$_POST['txtSalinidad1'].",
                  ".$_POST['txtSalinidad2'].", ".$_POST['txtTempAgua1'].", ".$_POST['txtTempAgua2'].", ".$_POST['txtTempAire1'].", ".$_POST['txtTempAire2'].",
                  ".$_POST['txtTurbiedad1'].", ".$_POST['txtTurbiedad2'].", ".$_POST['txtVelCorriente1'].", ".$_POST['txtVelCorriente2'].", ".$_POST['txtAltura1'].",
                  ".$_POST['txtAltura2'].", ".$_POST['txtVelViento1'].", ".$_POST['txtVelViento2'].",
                  ".$txtAlcA1.", ".$txtAlcA2.", ".$txtClA1.", ".$txtClA2.",
                  ".$_POST['txtColFec1'].", ".$_POST['txtColTotal1'].", ".$_POST['txtColor1'].", ".$_POST['txtColor2'].",
                  ".$txtDbood1A1.", ".$txtDbood1A2.", ".$txtDbood1E1.", ".$txtDbood1E2.", ".$txtDbood5A1.", ".$txtDbood5A2.", ".$txtDbood5E1.", ".$txtDbood5E2.",
                  ".$_POST['txtNH31'].", ".$_POST['txtNH32'].", ".$_POST['txtNO21'].", ".$_POST['txtNO22'].", ".$_POST['txtNO31'].",
                  ".$_POST['txtNO32'].", ".$_POST['txtNT1'].", ".$_POST['txtNT2'].", ".$_POST['txtOPO41'].", ".$_POST['txtOPO42'].",
                  ".$_POST['txtPT1'].", ".$_POST['txtPT2'].")";
      ?>

      <!-- Inserting into database -->
      <?php
      // Inserting Parametros
      if (mysqli_query($conn, $params))
        echo "Parametros insertados exitosamente";
      else
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      echo "<br>";
      // Inserting Parametros Crudos
      if (mysqli_query($conn, $rawParams))
        echo "Parametros crudos insertados exitosamente";
      else
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);

      mysqli_close($conn);
      ?>

      <form action="sitios.php" method="post" hidden>
        <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
        <input type="text" name="sitio" value="">
        <input type="text" name="responsable" value="">
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
