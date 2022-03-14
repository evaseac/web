<!-- Initial data -->
<?php
  include '../../database/evaseacdb.php';

  $conn = open_database();
  if (!$conn)
    die("Error al conectar al servidor: " . mysqli_connect_error());

  $query = "SELECT S.Nombre AS Nombre, S.Abreviatura AS Abreviatura, S.Estado AS Estado " .
    "FROM Sitio AS S " .
    "INNER JOIN Temporada AS T ON S.ID = T.IdSitio " .
    "WHERE T.Temporada = '" . $_POST['date'] . "-01' ".
    "ORDER BY Nombre";
  $result = mysqli_query($conn, $query);
?>
<html>
  <head>
    <title>Evaseac - Consultar</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width = device-width, initial-scale = 1">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Datetimepicker -->
    <link rel="stylesheet" href="../../css/bootstrap-datepicker3.css">
    <!-- Styles -->
    <link href="../../css/custom.css" rel="stylesheet">
    <!-- Icon -->
    <link rel="icon" href="../../imgs/Evaseac.ico">
    <!-- OpenStreetMap -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>

    <style media="screen">
      .my-custom-scrollbar2 {
        position: relative;
        min-height: 60px;
        max-height: 180px;
        overflow: auto;
      }
    </style>
  </head>
  <body>

    <!-- Header -->
    <div class="jumbotron"
      style="margin-bottom: 0px;
      height: 175px;
      background-image: url('../../imgs/header.png');
      background-repeat: no-repeat;
      background-position: center;
      ">
    </div>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-primary sticky-top">

      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbar_menu">
        <p><span class="navbar-toggler-icon"></span>Menú</p>
      </button>

      <div class="collapse navbar-collapse justify-content-md-center" id="navbar_menu">
        <ul class="navbar-nav" style="margin-bottom: -20px; margin-top: -10px">
          <li class="nav-item" style="padding-right: 35px; padding-left: 35px;">
            <a class="nav-link" href="../../index.html"><p class="lead">Inicio</p></a>
          </li>
          <li class="nav-item dropdown" style="padding-right: 35px; padding-left: 35px;">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="#nav_conocenos" href="#">
              <font class="lead">Conócenos</font>
            </a>
            <div class="dropdown-menu" aria-labelledby="nav_conocenos">
              <a class="dropdown-item" href="../conocenos/grupo_trabajo.php">Grupo de trabajo</a>
              <a class="dropdown-item" href="../conocenos/investigacion.html">Investigación</a>
            </div>
          </li>
          <li class="nav-item" style="padding-right: 35px; padding-left: 35px;">
            <a class="nav-link active" href="#"><p class="lead">Consultar</p></a>
          </li>
          <li class="nav-item" style="padding-right: 35px; padding-left: 35px;">
            <a class="nav-link" href="../sitios/ingresar.html" onclick=""><p class="lead">Insertar</p></a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Search and filter -->
    <div class="container" style="margin-bottom: 20px;">
      <div class="row" style="margin-bottom: 7px; margin-top: 15px;">
        <div class="col-lg-2 col-sm-12">
          <h4>Buscar</h4>
        </div>
        <div class="col-lg-5 col-sm-6 col-xs-12">
          <input type="text" name="txtSrch" id="txtSrch" class="form-control" />
        </div>
        <div class="col-lg-5 col-sm-6 col-xs-12">
          <input class="form-control" id="txtDate" name="date" placeholder="yyyy-mm" type="text" onchange="SetDate();" value="<?php echo $_POST['date']; ?>" readonly/>
        </div>
      </div>

      <!-- Table -->

      <div class="table-responsive">
        <div class="table-wrapper-scroll-y my-custom-scrollbar">
          <table class="table table-bordered table-striped mb-0 table-sm" id="tblSts">
            <thead class="thead-dark">
              <tr id="trSts">
                <th width="45%">Nombre</th>
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
                <td width="45%"><a href="#" onclick="SiteClicked(this);"><?php echo $row["Nombre"]; ?></a></td>
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

    <hr>

    <!-- Displaying info -->
    <div class="container">
      <!-- Title -->
      <div class="jumbotron" style="height: 200px;">
        <h1 class="display-4"><?php echo $_POST['sitio']; ?></h2>
          <p class="lead">
            Abreviatura: <i><?php echo $_POST['abreviatura']; ?></i>
          </p>
      </div>
      <hr>
      <!-- Sitio, temporada info -->
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div class="jumbotron">
            <div class="form-group row" style="margin-bottom: 0; margin-top: 0px;">
              <label for="txtProyecto" class="col-lg-4 col-md-3 col-sm-12 col-form-label"><h5>Proyecto:</h5></label>
              <div class="col-lg-8 col-md-9 col-sm-12">
                <input type="text" class="form-control-plaintext" id="txtProyecto" readonly value="<?php echo $_POST['proyecto']; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="txtFinanciamiento" class="col-lg-4 col-md-3 col-sm-12 col-form-label"><h5>Financiamiento:</h5></label>
              <div class="col-lg-8 col-md-9 col-sm-12">
                <input type="text" class="form-control-plaintext" id="txtFinanciamiento" readonly value="<?php echo $_POST['financiamiento']; ?>">
              </div>
            </div>
            <hr>
            <div class="form-group row" style="margin-bottom: 0;">
              <label for="txtEstado" class="col-lg-4 col-md-3 col-sm-12 col-form-label"><h5>Estado:</h5></label>
              <div class="col-lg-8 col-md-9 col-sm-12">
                <input type="text" class="form-control-plaintext" id="txtEstado" readonly value="<?php echo $_POST['estado']; ?>">
              </div>
            </div>
            <div class="form-group row" style="margin-bottom: 0;">
              <label for="txtRioCuenca" class="col-lg-4 col-md-3 col-sm-12 col-form-label"><h5>Río o cuenca:</h5></label>
              <div class="col-lg-8 col-md-9 col-sm-12">
                <input type="text" class="form-control-plaintext" id="txtRioCuenca" readonly value="<?php echo $_POST['rio_cuenca']; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="txtAltitud" class="col-lg-4 col-md-3 col-sm-12 col-form-label"><h5>Altitud:</h5></label>
              <div class="col-lg-8 col-md-9 col-sm-12">
                <input type="text" class="form-control-plaintext" id="txtAltitud" readonly value="<?php echo $_POST['altitud']; ?>">
              </div>
            </div>
            <hr>
            <div class="form-group row" style="margin-bottom: 0;">
              <label for="txtResponsable" class="col-lg-4 col-md-3 col-sm-12 col-form-label"><h5>Responsable:</h5></label>
              <div class="col-lg-8 col-md-9 col-sm-12">
                <input type="text" class="form-control-plaintext" id="txtResponsable" readonly value="<?php echo $_POST['responsable']; ?>">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12">
          <div class="center">
            <div id="mapDiv" style="width: 100%; height: 450px"></div>
            <script>
              // position we will use later
              var lat = <?php echo $_POST['norte']; ?>;
              var lon = <?php echo $_POST['oeste']; ?>;
              // initialize map
              map = L.map('mapDiv').setView([lat, lon], 13);
              // set map tiles source
              L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
                maxZoom: 18,
              }).addTo(map);
              // add marker to the map
              marker = L.marker([lat, lon]).addTo(map);
              // add popup to the marker
              marker.bindPopup("<b><?php
                if ($_POST['sitio'] == "Sin información disponible")
                  echo "ENCB";
                else
                  echo $_POST['sitio'];
              ?></b><br /><?php
                echo $_POST['date'];
              ?>").openPopup();
            </script>
          </div>
        </div>
      </div>
    </div>

    <br>

    <!-- Images -->
    <div>
      <?php
        $result = mysqli_query($conn, $_POST['query_imagenes']);
        $urls = array();

        while ($row = mysqli_fetch_array($result)) {
          array_push($urls, $row["url"]);
        }

        $i = 0;
        $j = 0;
        $k = 1;

        $imgs = array();
        for ($i=0; $i < 9; $i++) {
          array_push($imgs, $urls[$j]);
          $j = ($j + $k) % count($urls);

          if (count($urls) > 2 && $i != 1 && ($i % count($urls)) == 0) {
            $k = rand(1, count($urls) - 1);
            $j = rand(0, count($urls) - 1);
          }
        }
      ?>

      <a href="#" onclick="verImagenes_Click();">

        <div class="container">
          <table class="table table-bordered" style="table-layout: fixed;">
            <tr>
              <td>
                <div style="height: 50px; overflow:hidden; text-align: center;">
                  <img src="<?php echo $imgs[0]; ?>" style="width: 100%;">
                </div>
              </td>
              <td>
                <div style="height: 50px; overflow:hidden; text-align: center;">
                  <img src="<?php echo $imgs[1]; ?>" style="width: 100%;">
                </div>
              </td>
              <td>
                <div style="height: 50px; overflow:hidden; text-align: center;">
                  <img src="<?php echo $imgs[2]; ?>" style="width: 100%;">
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <div style="height: 50px; overflow:hidden; text-align: center;">
                  <img src="<?php echo $imgs[3]; ?>" style="width: 100%;">
                </div>
              </td>
              <td>
                <div style="height: 50px; overflow:hidden; text-align: center;">
                  <img src="<?php echo $imgs[4]; ?>" style="width: 100%;">
                </div>
              </td>
              <td>
                <div style="height: 50px; overflow:hidden; text-align: center;">
                  <img src="<?php echo $imgs[5]; ?>" style="width: 100%;">
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <div style="height: 50px; overflow:hidden; text-align: center;">
                  <img src="<?php echo $imgs[6]; ?>" style="width: 100%;">
                </div>
              </td>
              <td>
                <div style="height: 50px; overflow:hidden; text-align: center;">
                  <img src="<?php echo $imgs[7]; ?>" style="width: 100%;">
                </div>
              </td>
              <td>
                <div style="height: 50px; overflow:hidden; text-align: center;">
                  <img src="<?php echo $imgs[8]; ?>" style="width: 100%;">
                </div>
              </td>
            </tr>
          </table>

          <table class="table table-bordered">
            <tr>
              <td>
                <center>
                  Ver imagenes
                </center>
              </td>
            </tr>
          </table>
        </div>

      </a>
    </div>

    <!-- Tables -->
    <!-- Macroinvertebrados -->
    <div>
      <div class="container-fluid bg-dark" style="margin-top: 15px;">
        <div class="container">
          <h2 class="font-weight-light text-white-50">Macroinvertebrados</h2>
        </div>
      </div>
      <div class="container">
        <div class="table-responsive">
          <div class="table-wrapper-scroll-y my-custom-scrollbar2">
            <table class="table table-bordered table-sm">
              <thead class="thead-light">
                <tr>
                  <th width="25%">Clase</th>
                  <th width="25%">Orden</th>
                  <th width="25%">Familia</th>
                  <th width="25%">Genero</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $result = mysqli_query($conn, $_POST['query_macroinvertebrados']);
              while ($row = mysqli_fetch_array($result))
              {
              ?>
                <tr>
                  <td width="25%"><?php echo $row["Clase"]; ?></td>
                  <td width="25%"><?php echo $row["Orden"]; ?></td>
                  <td width="25%"><?php echo $row["Familia"]; ?></td>
                  <td width="25%"><?php echo $row["Genero"]; ?></td>
                </tr>
              <?php
              }
              ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Parametros -->
    <div>
      <div class="container-fluid bg-dark" style="margin-top: 15px;">
        <div class="container">
          <h2 class="font-weight-light text-white-50">Parametros</h2>
        </div>
      </div>
      <div class="container">
        <div class="table-wrapper-scroll-y my-custom-scrollbar2">
          <table class="table table-bordered table-sm">
            <thead class="thead-light">
              <tr>
                <th width="50%">Parámetro</th>
                <th width="50%">Valor</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $result = mysqli_query($conn, $_POST['query_parametros']);
            while ($row = mysqli_fetch_array($result))
            {
            ?>
              <tr>
                <td width="50%"><?php echo $row["Parametro"]; ?></td>
                <td width="50%"><?php echo $row["Valor"]; ?></td>
              </tr>
            <?php
            }
            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Otras pruebas -->
    <div>
      <div class="container-fluid bg-dark" style="margin-top: 15px;">
        <div class="container">
          <h2 class="font-weight-light text-white-50">Otras pruebas</h2>
        </div>
      </div>
      <div class="container">
        <div class="table-wrapper-scroll-y my-custom-scrollbar2">
          <table class="table table-bordered table-sm">
            <thead class="thead-light">
              <tr>
                <th width="35%">Prueba</th>
                <th width="35%">Parámetro</th>
                <th width="30%">Valor</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $result = mysqli_query($conn, $_POST['query_pruebas']);
            while ($row = mysqli_fetch_array($result))
            {
            ?>
              <tr>
                <td width="35%"><?php echo $row["Prueba"]; ?></td>
                <td width="35%"><?php echo $row["Parametro"]; ?></td>
                <td width="30%"><?php echo $row["Valor"]; ?></td>
              </tr>
            <?php
            }
            mysqli_close($conn);
            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <br>



    <!-- Required insert form -->
    <form action="../setdate.php" method="post" hidden>
      <input type="text" name="page" value="sitios/sitios.php">
      <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
      <input type="text" name="sitio" value="">
      <input type="text" name="responsable" value="">
      <input type="submit" value="Sitios" id="btnSubmit1">
    </form>
    <!-- Changing site -->
    <form id="main" action="setinfo.php" method="post" hidden>
      <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
      <input type="text" name="site_selected">
      <input type="submit" value="Sitios" id="btnSubmit2">
    </form>
    <!-- Gallery -->
    <form class="" action="galeria.php" method="post" hidden>
      <input type="text" name="query_imagenes" value="<?php echo $_POST['query_imagenes']; ?>">
      <input type="text" name="sitio" value="<?php echo $_POST['sitio']; ?>">
      <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
      <input type="submit" id="submit_image" value="Submit">
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

  function SetDate(){
    document.forms["main"]["date"].value = document.getElementById('txtDate').value;
    // document.forms["main"]["site_selected"].value = "";
    document.getElementById('btnSubmit2').click();
  }

  function SiteClicked(a){
    document.forms["main"]["site_selected"].value = a.innerHTML;
    document.getElementById('btnSubmit2').click();
  }

  function btnInsertar_Click(){
    document.getElementById('btnSubmit1').click();
  }

  function verImagenes_Click(){
    document.getElementById('submit_image').click();
  }
</script>
