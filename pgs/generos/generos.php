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
    <title>Evaseac - Géneros</title>

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
          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="#nav_cnslt" href="#">
              Macroinvertebrados <span class="caret"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="nav_cnslt">
              <a class="dropdown-item" href="#" onclick="btnFamilias_Click();">Familias</a>
              <a class="dropdown-item" href="#" onclick="btnGeneros_Click();">Géneros</a>
            </div>
          </li>
          <li class="nav-item">
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
    <div class="container">
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
      <form action="ingresar_genero.php" method="post" class="needs-validation" novalidate>
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

        <br>

        <!-- Macroinvertebrados -->
        <div class="row" style="margin-bottom: 7px;">
          <div class="col-lg-2 col-md-3 col-sm-12">
            <b>Escoger Género</b>
          </div>
          <div class="col-lg-10 col-md-9 col-sm-12">
            <input type="text" name="txtSrchGen" id="txtSrchGen" class="form-control" />
          </div>
        </div>
        <div class="table-responsive">
          <div class="table-wrapper-scroll-y my-custom-scrollbar">
            <table class="table table-bordered table-sm" id="tblGen">
              <thead class="thead-light">
                <tr id="trGen">
                  <th width="25%">Clase</th>
                  <th width="25%">Orden</th>
                  <th width="25%">Familia</th>
                  <th width="25%">Genero</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $result = mysqli_query($conn, $_POST['qryGenero']);
              mysqli_close($conn);

              while ($row = mysqli_fetch_array($result))
              {
              ?>
                <tr>
                  <td width="25%"><?php echo $row["Clase"]; ?></td>
                  <td width="25%"><?php echo $row["Orden"]; ?></td>
                  <td width="25%"><?php echo $row["Familia"]; ?></td>
                  <td width="25%"><a href="#Ingresar_Genero" onclick="GenusClicked(this);"><?php echo $row["Genero"]; ?></a></td>
                </tr>
              <?php
              }
              ?>
              </tbody>
            </table>
          </div>
        </div>

        <br>

        <div class="form-row" id="Ingresar_Genero">
          <div class="form-group col-lg-4 col-md-4 col-sm-12">
            <label for="">Género escogido</label>
            <input type="text" class="form-control" name="txtGenero" id="txtGenero" readonly value="">
          </div>
          <div class="form-group col-lg-4 col-md-4 col-sm-12">
            <label for="">Número</label>
            <input type="text" class="form-control" name="txtNumero" id="txtNumero" required value="">
          </div>
          <div class="form-group col-lg-4 col-md-4 col-sm-12">
            <label for="">Hábitat</label>
            <input type="text" class="form-control" name="txtHabitat" id="txtHabitat" required value="">
          </div>
        </div>

        <div hidden>
          <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
        </div>

        <div class="container">
          <button class="btn btn-primary" type="submit" id="btnMainSubmit" disabled>Ingresar</button>
        </div>
      </form>
    </div>

    <!-- Hidden required form to update mysql table -->
    <form class="" action="../setdate.php" method="post" hidden>
      <input type="text" name="page" id="txtPage" value="generos/generos.php">
      <input type="text" name="date" value="<?php echo $_POST['date']; ?>" id="date">
      <input type="text" name="sitio" value="">
      <input type="text" name="responsable" value="">
      <input type="submit" value="Cambiar fecha" id="btnSubmit" />
    </form>
    <form action="getsdata.php" method="post" hidden>
      <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
      <input type="text" name="sitio" value="" id="txtSite">
      <input type="text" name="responsable" value="">
      <input type="submit" value="Submit" id="btnSubmit2">
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
  window.onload = function(){
    //Disabling responsable if has value
    var resp = "val:<?php echo $_POST['responsable']; ?>";
    if (resp != "val:")
      document.getElementById('txtResponsable').readOnly = true;
  }

  // Searching in table
  //Main Table
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
  //Gen Table
  $(document).ready(function(){
    $('#txtSrchGen').keyup(function(){
      search_table($(this).val());
    });
    function search_table(value){
      $('#tblGen tr').each(function(){
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

      $('#trGen').show();
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

  function GenusClicked(a){
    document.getElementById('txtGenero').value = a.innerHTML;
    $('#tblGen tr').each(function(){
      $(this).show();
    });

    document.getElementById('txtSrchGen').value = "";

    // Enabling main button
    if (document.getElementById("txtSitio").value != "" && document.getElementById('txtGenero').value != "")
      $("#btnMainSubmit").prop("disabled", false);
  }
 </script>
