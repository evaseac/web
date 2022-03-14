<?php
  include '../../database/evaseacdb.php';

  $conn = open_database();
  if (!$conn)
    die("Error al conectar al servidor: " . mysqli_connect_error());

  // Parametros
  $query = "SELECT ID, Nombre, Abreviatura, Estado FROM Sitio";
  $result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>Evaseac - Imagenes</title>

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
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="btnPruebas_Click();">Otras pruebas</a>
          </li>
          <li class="nav-item active">
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
      <form action="ingresar_imagen.php" method="post" class="needs-validation" name="mainForm" novalidate>
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

        <div class="table-responsive">
          <div class="table-wrapper-scroll-y my-custom-scrollbar">
            <table class="table table-bordered table-sm" id="tbl_urls">
              <thead class="thead-light">
                <tr id="tr_url">
                  <th width="5%"> </th>
                  <th width="95%">URL</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $result = mysqli_query($conn, $_POST['query_image']);
                mysqli_close($conn);

                while ($row = mysqli_fetch_array($result))
                {
                ?>
                  <tr>
                    <td width="5%"><a href="#" onclick="deleteUrl_Click(this);"><center>x</center></a></td>
                    <td width="95%" style="white-space: nowrap;"><?php echo $row["url"]; ?></td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>

        <br>

        <div class="form-row" id="ingresar_imagen">
          <label for="txtUrl" class="col-lg-2 col-md-3 col-sm-12 col-form-label">URL de la imagen</label>
          <div class="col-lg-10 col-md-9 col-sm-12">
            <input type="text" class="form-control" name="txtUrl" required id="txtUrl">
          </div>
        </div>

        <br>

        <div class="container">
          <button class="btn btn-primary" id="btnInsert" type="button" disabled onclick="btnInsert_Click();">Ingresar</button>
        </div>

        <div hidden>
          <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
          <input type="text" name="query_image" value="<?php echo $_POST['query_image']; ?>">
          <input type="submit" name="btnMainSubmit" id="btnMainSubmit" value="Submit">
        </div>
      </form>
    </div>

    <br>

    <!-- Hidden required form to update mysql table -->
    <form class="" action="../setdate.php" method="post" hidden>
      <input type="text" name="page" id="txtPage" value="imagenes/imagenes.php">
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

    <!-- Form to delete urls -->
    <form class="" action="eliminar_imagen.php" method="post" hidden>
      <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
      <input type="text" name="sitio" value="<?php echo $_POST['sitio']; ?>">
      <input type="text" name="responsable" value="<?php echo $_POST['responsable']; ?>">
      <input type="text" name="query_image" value="<?php echo $_POST['query_image']; ?>">
      <input type="text" name="url_to_delete" id="url_to_delete" value="">
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
<script type="text/javascript">
  var index = 0;
  var val = 0;

  window.onload = function(){
    //Disabling responsable if has value
    var resp = "val:<?php echo $_POST['responsable']; ?>";
    if (resp != "val:")
      document.getElementById('txtResponsable').readOnly = true;
    // Enabling submit button if Site is selected
    var site = document.getElementById("txtSitio").value;
    if (site != "")
      $("#btnInsert").prop("disabled", false);
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

  function btnInsert_Click() {
    var table = document.getElementById("tbl_urls");
    var sameUrl = false;

    for (var i = 1, row; row = table.rows[i]; i++) {
      if (table.rows[i].cells[1].innerHTML == document.getElementById("txtUrl").value) {
        sameUrl = true;
        break;
      }
    }

    if (!sameUrl)
      document.getElementById("btnMainSubmit").click();
    else
      alert("La URL a ingresar ya ha sido ingresada");
  }

  function deleteUrl_Click(a) {
    var table = document.getElementById("tbl_urls");
    var url = table.rows[a.parentNode.parentNode.rowIndex].cells[1].innerHTML;

    if (url != "") {
      document.getElementById("url_to_delete").value = url;
      document.getElementById("btnSubmit3").click();
    }
  }
</script>
