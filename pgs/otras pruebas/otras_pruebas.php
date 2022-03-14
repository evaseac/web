<?php
  include '../../database/evaseacdb.php';

  $conn = open_database();
  if (!$conn)
    die("Error al conectar al servidor: " . mysqli_connect_error());

  $query = "SELECT ID, Nombre, Abreviatura, Estado FROM Sitio";
  $result = mysqli_query($conn, $query);
?>

<html>
  <head>
    <title>Evaseac - Otras pruebas</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width = device-width, initial-scale = 1">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Datetimepicker -->
    <link rel="stylesheet" href="../../css/bootstrap-datepicker3.css">
    <!-- Styles -->
    <link rel="stylesheet" href="../../css/custom.css">
    <!-- Icon -->
    <link rel="icon" href="../../imgs/Evaseac.ico">
  </head>
  <body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">

      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbar_menu">
        <p><span class="navbar-toggler-icon"></span>Menú</p>
      </button>

      <div class="collapse navbar-collapse" id="navbar_menu">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="../../index.html">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="btnSitios_Click();">Sitios</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="#nav_cnslt" href="#">
              Macroinvertebrados <span class="caret"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="nav_cnslt">
              <a class="dropdown-item" href="#" onclick="btnFamilias_Click();">Familias</a>
              <a class="dropdown-item" href="#" onclick="btnGeneros_Click();">Géneros</a>
            </div>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="#" onclick="btnPruebas_Click();">Otras pruebas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="btnImagenes_Click();">Imagenes</a>
          </li>
        </ul>
      </div>
    </nav>

    <br><br><br>

    <!-- Search and filter -->
    <div class="container" id="Seleccionar_Sitio">
      <div class="row" style="margin-bottom: 7px;">
        <div class="col-lg-2 col-sm-12">
          <h4>Filtrar</h4>
        </div>
        <div class="col-lg-5 col-sm-6 col-xs-12">
          <input type="text" name="txtSrch" id="txtSrch" class="form-control" />
        </div>
        <div class="col-lg-5 col-sm-6 col-xs-12">
          <input class="form-control" id="txtDate" name="date" placeholder="yyyy-mm" type="text" value="<?php echo $_POST['date']; ?>" onchange="SetDate();" readonly/>
        </div>
      </div>

      <!-- Table -->

      <div class="table-responsive">
        <div class="table-wrapper-scroll-y my-custom-scrollbar">
          <table class="table table-bordered table-striped mb-0 table-sm" id="tblSts">
            <thead class="thead-dark">
              <tr id="trSts">
                <th width="5%">ID</th>
                <th width="40%">Nombre</th>
                <th width="15%">Abreviatura</th>
                <th width="40%">Estado</th>
              </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_array($result))
            {
            ?>
              <tr>
                <td width="5%"><?php echo $row["ID"]; ?></td>
                <td width="40%"><a href="#" onclick="SiteClicked(this);"><?php echo $row["Nombre"]; ?></a></td>
                <td width="15%"><?php echo $row["Abreviatura"]; ?></td>
                <td width="40%"><?php echo $row["Estado"]; ?></td>
              </tr>
            <?php
            }
            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <br>

    <!-- Submit form for database inserts -->
    <div class="container">
      <form action="ingresar_parametro.php" method="post" class="needs-validation" name="mainForm" novalidate>
        <div class="form-group row">
          <label for="txtSitio" class="col-lg-2 col-md-3 col-sm-12 col-form-label"><h5>Sitio escogido:</h5></label>
          <div class="col-lg-10 col-md-9 col-sm-12">
            <input type="text" class="form-control-plaintext" name="txtSitio" id="txtSitio" readonly required value="<?php echo $_POST['sitio']; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="txtResponsable" class="col-lg-2 col-sm-12 col-form-label">Responsable</label>
          <div class="col-lg-10 col-sm-12">
            <input type="text" class="form-control" name="txtResponsable" id="txtResponsable" placeholder="Nombre y apellido" required value="<?php echo $_POST['responsable']; ?>">
          </div>
        </div>

        <!-- Pruebas -->
        <div class="row" style="margin-bottom: 7px; margin-top: 40px;">
          <div class="col-lg-2 col-md-3 col-sm-12">
            <b>Escoger Prueba</b>
          </div>
          <div class="col-lg-10 col-md-9 col-sm-12">
            <input type="text" name="txtSrchTst" id="txtSrchTst" class="form-control" />
          </div>
        </div>
        <div class="table-responsive">
          <div class="table-wrapper-scroll-y my-custom-scrollbar">
            <table class="table table-bordered table-sm" id="tblTst">
              <thead class="thead-light">
                <tr id="trTst">
                  <th width="50%">Prueba</th>
                  <th width="50%">Número de parámetros</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $result = mysqli_query($conn, $_POST['qryPrueba']);
              mysqli_close($conn);

              while ($row = mysqli_fetch_array($result))
              {
              ?>
                <tr>
                  <td width="50%"><a href="#Seleccionar_Sitio" onclick="TestClicked(this);"><?php echo $row["Prueba"]; ?></a></td>
                  <td width="50%"><?php echo $row["Parametros"]; ?></td>
                </tr>
              <?php
              }
              ?>
              </tbody>
            </table>
          </div>
        </div>

        <br><hr>

        <!-- Ingresar parametro -->
        <div>
          <div class="form-row">
            <div class="form-group col-lg-8 col-md-8 col-sm-7">
              <label for="">Prueba escogida</label>
              <input type="text" class="form-control" name="txtPrueba" id="txtPrueba" readonly required value="">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-5">
              <label for="">Número de Parámetros</label>
              <input type="text" class="form-control" name="txtNoParams" id="txtNoParams" readonly required value="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-lg-1 col-md-1 col-sm-1">
              <label for="">#:</label>
              <input type="text" class="form-control" name="txtNoParam" id="txtNoParam" readonly required value="">
            </div>
            <div class="form-group col-lg-1 col-md-1 col-sm-1">
              <label for="">ID</label>
              <input type="text" class="form-control" name="txtID" id="txtID" readonly required value="">
            </div>
            <div class="form-group col-lg-5 col-md-5 col-sm-5">
              <label for="">Párametro</label>
              <input type="text" class="form-control" name="txtParam" id="txtParam" readonly required value="">
            </div>
            <div class="form-group col-lg-5 col-md-5 col-sm-5">
              <label for="">No. Repeticiones</label>
              <input type="text" class="form-control" name="txtNoRpts" id="txtNoRpts" readonly required value="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-2">
              <label for="">#:</label>
              <input type="text" class="form-control" name="txtNoValue" id="txtNoValue" readonly required value="">
            </div>
            <div class="form-group col-lg-9 col-md-9 col-sm-6 col-xs-7">
              <label for="">Ingrese el valor</label>
              <input type="number" class="form-control" name="txtValue" id="txtValue" value="" step="0.00001">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-5 col-xs-3">
              <label for="">⠀</label><br>
                <button class="btn btn-primary" type="button" id="btnSiguiente" onclick="btnSiguiente_Click();" disabled>Siguiente</button>
            </div>
          </div>
        </div>

        <hr>

        <div hidden>
          <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
          <input type="text" name="qryPrueba" value="<?php echo $_POST['qryPrueba']; ?>">
          <button class="btn btn-primary" type="submit" id="btnMainSubmit">Ingresar</button>
        </div>
      </form>
    </div>

    <!-- Hidden required form to update mysql table -->
    <form class="" action="../setdate.php" method="post" hidden>
      <input type="text" name="page" id="txtPage" value="otras pruebas/otras_pruebas.php">
      <input type="text" name="date" value="<?php echo $_POST['date']; ?>" id="date">
      <input type="text" name="sitio" value="">
      <input type="text" name="responsable" value="">
      <input type="submit" value="Cambiar fecha" id="btnSubmit" />
    </form>
    <!-- Retrieving site data -->
    <form action="getsdata.php" method="post" hidden>
      <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
      <input type="text" name="sitio" value="" id="txtSite">
      <input type="text" name="responsable" value="">
      <input type="submit" value="Submit" id="btnSubmit2">
    </form>
    <!-- Retrieving prueba data -->
    <form action="get_prueba.php" method="post" hidden>
      <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
      <input type="text" name="sitio" id="txtSite2" value="<?php echo $_POST['sitio']; ?>">
      <input type="text" name="responsable" value="<?php echo $_POST['responsable']; ?>">
      <input type="text" name="prueba" id="txtTest" value="">
      <input type="text" name="qryPrueba" value="<?php echo $_POST['qryPrueba']; ?>">
      <input type="text" class="form-control" name="responsable" value="<?php echo $_POST['responsable']; ?>">
      <input type="submit" value="Submit" id="btnSubmit3">
    </form>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="../../js/bootstrap-datepicker.min.js"></script>
  </body>
</html>
<script>
  var index = 0;
  var val = 0;

  window.onload = function(){
    //Disabling responsable if has value
    var resp = "val:<?php echo $_POST['responsable']; ?>";
    if (resp != "val:")
      document.getElementById('txtResponsable').readOnly = true;
    //Loading prueba
    LoadPrueba();
    if (document.getElementById('txtParam').value != "")
      $("#btnSiguiente").prop("disabled", false);
  }

  // Searching in table
  $(document).ready(function(){
    $('#txtSrch').keyup(function(){
      search_table($(this).val());
    });
    function search_table(value){
      $('#tblSts tr').each(function(){
        var found = 'false';
        $(this).each(function(){
          if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0)
            found = 'true';
        });
        if(found == 'true')
          $(this).show();
        else
          $(this).hide();
      });

      $('#trSts').show();
    }
  });
  //Tst Table
  $(document).ready(function(){
    $('#txtSrchTst').keyup(function(){
      search_table($(this).val());
    });
    function search_table(value){
      $('#tblTst tr').each(function(){
        var found = 'false';
        $(this).each(function(){
          if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0)
            found = 'true';
        });
        if(found == 'true')
          $(this).show();
        else
          $(this).hide();
      });

      $('#trTst').show();
    }
  });

  // Datetimepicker
  $(document).ready(function(){
    var date_input=$('input[name="date"]');
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      date_input.datepicker({
       viewMode: 'years',
       format: 'yyyy-mm',
       container: container,
       autoclose: true,
      });
  });

  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();

  function SetDate(){
    document.getElementById('date').value = document.getElementById('txtDate').value;
    document.getElementById('btnSubmit').click();
  }

  function btnSitios_Click(){
    document.getElementById('txtPage').value = "sitios/sitios.php";
    document.getElementById('btnSubmit').click();
  }

  function btnFamilias_Click(){
    document.getElementById('txtPage').value = "familias/familias.php";
    document.getElementById('btnSubmit').click();
  }

  function btnGeneros_Click(){
    document.getElementById('txtPage').value = "generos/generos.php";
    document.getElementById('btnSubmit').click();
  }

  function btnPruebas_Click(){
    document.getElementById('txtPage').value = "otras pruebas/otras_pruebas.php";
    document.getElementById('btnSubmit').click();
  }

  function btnImagenes_Click(){
    document.getElementById('txtPage').value = "imagenes/imagenes.php";
    document.getElementById('btnSubmit').click();
  }

  function SiteClicked(a){
    document.getElementById('txtSitio').value = document.getElementById('txtSite').value = a.innerHTML;
    document.getElementById('btnSubmit2').click();
  }

  function TestClicked(a){
    if (document.getElementById('txtSitio').value != "")
    {
      document.getElementById('txtTest').value = document.getElementById('txtPrueba').value = a.innerHTML;
      document.getElementById('btnSubmit3').click();
    }
    else
      alert("Seleccione un sitio");
  }

  function btnSiguiente_Click(){
    if (document.getElementById('txtResponsable').value != "")
    {
      var x = document.forms["mainForm"]["txtValue"].value;
      if (x != "")
      {
        index++;
        document.getElementById('txtNoValue').value = index + 1;

        val += Number(document.getElementById('txtValue').value);

        if (index == document.getElementById('txtNoRpts').value){
          val /= index; // Calculates value
          document.getElementById('txtValue').value = val; // Enters result

          //Inserts into database
          document.getElementById('btnMainSubmit').click();
        }
        else
          document.getElementById('txtValue').value = "";

        //Changing main button value
        if ((index + 1) == document.getElementById('txtNoRpts').value){
          if (document.getElementById('txtNoParam').value == document.getElementById('txtNoParams').value)
            document.getElementById('btnSiguiente').value = "Finalizar";
          else
            document.getElementById('btnSiguiente').value = "Ingresar";
        }
      }
      else
        alert("Ingrese un valor");
    }
    else
      alert("Ingrese el responsable");
  }

  function LoadPrueba(){
    // Getting params
    <?php
      $conn = open_database();
      //Getting parametro
      $result = mysqli_query($conn, $_POST['qryP']);
      $row = mysqli_fetch_array($result);

      $tst = $no_params = $noParam = $idParam = $param = $rpts = $index = "";

      if ($_POST['qryP'] != "SELECT NULL FROM Prueba" && mysqli_num_rows($result) > 0){
        $tst = $_POST['prueba'];
        $no_params = $_POST['noParametros'];

        $noParam = $_POST['no_parametro'];
        $idParam = $row["ID"];
        $param = $row["Nombre"];
        $rpts = $row["Repeticiones"];

        $index = 1;
      }

      mysqli_close($conn);
    ?>

    document.getElementById('txtPrueba').value = "<?php echo $tst; ?>";
    document.getElementById('txtNoParams').value = "<?php echo $no_params; ?>";

    document.getElementById('txtNoParam').value = "<?php echo $noParam; ?>";
    document.getElementById('txtID').value = "<?php echo $idParam; ?>";
    document.getElementById('txtParam').value = "<?php echo $param; ?>";
    document.getElementById('txtNoRpts').value = "<?php echo $rpts; ?>";

    document.getElementById('txtNoValue').value = "<?php echo $index; ?>";
  }
 </script>
