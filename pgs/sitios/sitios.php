<?php
  include '../../database/evaseacdb.php';

  $conn = open_database();
  if (!$conn)
    die("Error al conectar al servidor: " . mysqli_connect_error());

  // Parametros
  $query = "SELECT S.ID AS ID, S.Nombre AS Nombre, S.Abreviatura AS Abreviatura, S.Estado AS Estado FROM Sitio AS S WHERE NOT EXISTS(SELECT NULL FROM Temporada AS T, Parametros AS P WHERE S.ID = T.IdSitio && T.ID = P.IdTemporada && Temporada = '".$_POST['date']."-01')";
  $result = mysqli_query($conn, $query);

  mysqli_close($conn);
?>

<html>
  <head>
    <title>Evaseac - Sitios</title>

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
    </style>
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
          <li class="nav-item active">
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
      <form action="ingresar_sitio.php" method="post" class="needs-validation" novalidate>
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

        <!-- Controls -->
        <div class="form-group row">
          <label for="txtSaturacion1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">%Saturacion</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtSaturacion1" required step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtSaturacion2" required step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtCond1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Conductividad</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtCond1" required step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtCond2" required step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtOD1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">OD</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtOD1" required step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtOD2" required step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtPH1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">pH</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtPH1" required step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtPH2" required step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtSalinidad1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Salinidad</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtSalinidad1" required step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtSalinidad2" required step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtTempAgua1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Temp Agua</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtTempAgua1" required step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtTempAgua2" required step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtTempAire1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Temp Aire</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtTempAire1" required step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtTempAire2" required step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtTurbiedad1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Turbiedad</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtTurbiedad1" required step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtTurbiedad2" required step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtVelCorriente1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Velocidad de la Corriente</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtVelCorriente1" required step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtVelCorriente2" required step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtAltura1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Altura</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtAltura1" required step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtAltura2" required step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtVelViento1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Velocidad del Viento</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtVelViento1" required step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtVelViento2" required step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtColFec1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Col. Fec.</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtColFec1" required placeholder="Serie" step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtColFec2" required placeholder="No. más probable" step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtColTotal1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Col. Total</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtColTotal1" required placeholder="Serie" step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtColTotal2" required placeholder="No. más probable" step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtColor1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Color</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtColor1" required step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtColor2" required step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtDureza1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Dureza</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtDureza1" required placeholder="Gasto EDTA" step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtDureza2" required value="100" step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtNH31" class="col-lg-2 col-md-4 col-sm-12 col-form-label">NH3</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtNH31" required step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtNH32" required step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtNO21" class="col-lg-2 col-md-4 col-sm-12 col-form-label">NO2</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtNO21" required step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtNO22" required step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtNO31" class="col-lg-2 col-md-4 col-sm-12 col-form-label">NO3</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtNO31" required step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtNO32" required step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtNT1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">NT</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtNT1" required step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtNT2" required step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtOPO41" class="col-lg-2 col-md-4 col-sm-12 col-form-label">O-PO4</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtOPO41" required step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtOPO42" required step="0.00001">
          </div>
        </div>
        <hr />

        <div class="form-group row">
          <label for="txtPT1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">PT</label>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtPT1" required step="0.00001">
          </div>
          <div class="col-lg-5 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtPT2" required step="0.00001">
          </div>
        </div>
        <hr />

        <!-- Collapsed controls -->

        <!-- Alcalinidad -->
        <div class="form-group row">
          <label class="col-lg-2 col-md-3 col-sm-12 col-form-label"><b>Alcalinidad</b></label>
          <div class="col-lg-6 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtAlcalinidad" id="txtAlcalinidad" step="0.00001">
          </div>
          <div class="col-lg-4 col-md-5 col-sm-12">
          <button type="button" class="btn btn-dark" data-toggle="collapse" data-target="#Alcalinidad" id="btnAlcalinidad" value="txtAlcalinidad" onclick="ButtonClicked(this);">Ingresar valor final o valores</button>
          </div>
        </div>
        <div class="collapse" id="Alcalinidad">
          <div class="form-group row">
            <label for="txtAlcA1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Gasto del H2SO4</label>
            <div class="col-lg-5 col-md-4 col-sm-12">
              <input type="number" class="form-control" name="txtAlcA1" id="txtAlcA1" step="0.00001">
            </div>
            <div class="col-lg-5 col-md-4 col-sm-12">
              <input type="number" class="form-control" name="txtAlcA2" id="txtAlcA2" step="0.00001">
            </div>
          </div>
          <div class="form-group row">
            <label for="txtAlcB" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Normalidad H2SO4</label>
            <div class="col-lg-10 col-md-8 col-sm-12">
              <input type="number" class="form-control" name="txtAlcB" id="txtAlcB" value="0.02" step="0.000001">
            </div>
          </div>
          <div class="form-group row">
            <label for="txtAlcC" class="col-lg-2 col-md-4 col-sm-12 col-form-label">c</label>
            <div class="col-lg-10 col-md-8 col-sm-12">
              <input type="number" class="form-control" name="txtAlcC" id="txtAlcC" value="50000" step="0.00001">
            </div>
          </div>
          <div class="form-group row">
            <label for="txtAlcD" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Volumen de la muestra</label>
            <div class="col-lg-10 col-md-8 col-sm-12">
              <input type="number" class="form-control" name="txtAlcD" id="txtAlcD" value="10" step="0.00001">
            </div>
          </div>
        </div>
        <hr />
        <!-- Cloro -->
        <div class="form-group row">
          <label class="col-lg-2 col-md-3 col-sm-12 col-form-label"><b>Cloro</b></label>
          <div class="col-lg-6 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtCloro" id="txtCloro" step="0.00001">
          </div>
          <div class="col-lg-4 col-md-5 col-sm-12">
          <button type="button" class="btn btn-dark" data-toggle="collapse" data-target="#Cloro" id="btnCloro" value="txtCloro" onclick="ButtonClicked(this);">Ingresar valor final o valores</button>
          </div>
        </div>
        <div class="collapse" id="Cloro">
          <div class="form-group row">
            <label for="txtClA1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Gasto del H2SO4</label>
            <div class="col-lg-5 col-md-4 col-sm-12">
              <input type="number" class="form-control" name="txtClA1" id="txtClA1" step="0.00001">
            </div>
            <div class="col-lg-5 col-md-4 col-sm-12">
              <input type="number" class="form-control" name="txtClA2" id="txtClA2" step="0.00001">
            </div>
          </div>
          <div class="form-group row">
            <label for="txtClB" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Normalidad H2SO4</label>
            <div class="col-lg-10 col-md-8 col-sm-12">
              <input type="number" class="form-control" name="txtClB" id="txtClB"  value="0.1" step="0.00001">
            </div>
          </div>
          <div class="form-group row">
            <label for="txtClC" class="col-lg-2 col-md-4 col-sm-12 col-form-label">c</label>
            <div class="col-lg-10 col-md-8 col-sm-12">
              <input type="number" class="form-control" name="txtClC" id="txtClC" value="0.0127" step="0.00001">
            </div>
          </div>
          <div class="form-group row">
            <label for="txtClD" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Volumen de la muestra</label>
            <div class="col-lg-10 col-md-8 col-sm-12">
              <input type="number" class="form-control" name="txtClD" id="txtClD" value="35450" step="0.00001">
            </div>
          </div>
          <div class="form-group row">
            <label for="txtClF" class="col-lg-2 col-md-4 col-sm-12 col-form-label">f</label>
            <div class="col-lg-10 col-md-8 col-sm-12">
              <input type="number" class="form-control" name="txtClF" id="txtClF" value="10" step="0.00001">
            </div>
          </div>
        </div>
        <hr />
        <!-- DBO: OD1 -->
        <div class="form-group row">
          <label class="col-lg-2 col-md-3 col-sm-12 col-form-label"><b>DBO: OD1</b></label>
          <div class="col-lg-6 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtDBO_OD1" id="txtDBO_OD1" step="0.00001">
          </div>
          <div class="col-lg-4 col-md-5 col-sm-12">
          <button type="button" class="btn btn-dark" data-toggle="collapse" data-target="#DBO_OD1" id="btnDBO_OD1" value="txtDBO_OD1" onclick="ButtonClicked(this);">Ingresar valor final o valores</button>
          </div>
        </div>
        <div class="collapse" id="DBO_OD1">
          <div class="form-group row">
            <label for="txtDBO_OD1A1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Gasto de Tisulfato</label>
            <div class="col-lg-5 col-md-4 col-sm-12">
              <input type="number" class="form-control" name="txtDBO_OD1A1" id="txtDBO_OD1A1" step="0.00001">
            </div>
            <div class="col-lg-5 col-md-4 col-sm-12">
              <input type="number" class="form-control" name="txtDBO_OD1A2" id="txtDBO_OD1A2" step="0.00001">
            </div>
          </div>
          <div class="form-group row">
            <label for="txtDBO_OD1B" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Normalidad Tisulfato</label>
            <div class="col-lg-10 col-md-8 col-sm-12">
              <input type="number" class="form-control" name="txtDBO_OD1B" id="txtDBO_OD1B" value="0.0281" step="0.00001">
            </div>
          </div>
          <div class="form-group row">
            <label for="txtDBO_OD1C" class="col-lg-2 col-md-4 col-sm-12 col-form-label">c</label>
            <div class="col-lg-10 col-md-8 col-sm-12">
              <input type="number" class="form-control" name="txtDBO_OD1C" id="txtDBO_OD1C" value="8" step="0.00001">
            </div>
          </div>
          <div class="form-group row">
            <label for="txtDBO_OD1D" class="col-lg-2 col-md-4 col-sm-12 col-form-label">d</label>
            <div class="col-lg-10 col-md-8 col-sm-12">
              <input type="number" class="form-control" name="txtDBO_OD1D" id="txtDBO_OD1D" value="1000" step="0.00001">
            </div>
          </div>
          <div class="form-group row">
            <label for="txtDBO_OD1E1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Volumen de la muestra</label>
            <div class="col-lg-5 col-md-4 col-sm-12">
              <input type="number" class="form-control" name="txtDBO_OD1E1" id="txtDBO_OD1E1" step="0.00001">
            </div>
            <div class="col-lg-5 col-md-4 col-sm-12">
              <input type="number" class="form-control" name="txtDBO_OD1E2" id="txtDBO_OD1E2" step="0.00001">
            </div>
          </div>
        </div>
        <hr />
        <!-- DBO: OD5 -->
        <div class="form-group row">
          <label class="col-lg-2 col-md-3 col-sm-12 col-form-label"><b>DBO: OD5</b></label>
          <div class="col-lg-6 col-md-4 col-sm-12">
            <input type="number" class="form-control" name="txtDBO_OD5" id="txtDBO_OD5" step="0.00001">
          </div>
          <div class="col-lg-4 col-md-5 col-sm-12">
          <button type="button" class="btn btn-dark" data-toggle="collapse" data-target="#DBO_OD5" id="btnDBO_OD5" value="txtDBO_OD5" onclick="ButtonClicked(this);">Ingresar valor final o valores</button>
          </div>
        </div>
        <div class="collapse" id="DBO_OD5">
          <div class="form-group row">
            <label for="txtDBO_OD5A1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Gasto de Tisulfato</label>
            <div class="col-lg-5 col-md-4 col-sm-12">
              <input type="number" class="form-control" name="txtDBO_OD5A1" id="txtDBO_OD5A1" step="0.00001">
            </div>
            <div class="col-lg-5 col-md-4 col-sm-12">
              <input type="number" class="form-control" name="txtDBO_OD5A2" id="txtDBO_OD5A2" step="0.00001">
            </div>
          </div>
          <div class="form-group row">
            <label for="txtDBO_OD5B" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Normalidad Tisulfato</label>
            <div class="col-lg-10 col-md-8 col-sm-12">
              <input type="number" class="form-control" name="txtDBO_OD5B" id="txtDBO_OD5B" value="0.0281" step="0.00001">
            </div>
          </div>
          <div class="form-group row">
            <label for="txtDBO_OD5C" class="col-lg-2 col-md-4 col-sm-12 col-form-label">c</label>
            <div class="col-lg-10 col-md-8 col-sm-12">
              <input type="number" class="form-control" name="txtDBO_OD5C" id="txtDBO_OD5C" value="8" step="0.00001">
            </div>
          </div>
          <div class="form-group row">
            <label for="txtDBO_OD5D" class="col-lg-2 col-md-4 col-sm-12 col-form-label">d</label>
            <div class="col-lg-10 col-md-8 col-sm-12">
              <input type="number" class="form-control" name="txtDBO_OD5D" id="txtDBO_OD5D" value="1000" step="0.00001">
            </div>
          </div>
          <div class="form-group row">
            <label for="txtDBO_OD5E1" class="col-lg-2 col-md-4 col-sm-12 col-form-label">Volumen de la muestra</label>
            <div class="col-lg-5 col-md-4 col-sm-12">
              <input type="number" class="form-control" name="txtDBO_OD5E1" id="txtDBO_OD5E1" step="0.00001">
            </div>
            <div class="col-lg-5 col-md-4 col-sm-12">
              <input type="number" class="form-control" name="txtDBO_OD5E2" id="txtDBO_OD5E2" step="0.00001">
            </div>
          </div>
        </div>

        <!-- Boolean values for final values and Values needed for DB -->
        <div hidden>
          <input type="text" name="alcIsFinal" id="alcIsFinal">
          <input type="text" name="clIsFinal" id="clIsFinal">
          <input type="text" name="dbood1IsFinal" id="dbood1IsFinal">
          <input type="text" name="dbood5IsFinal" id="dbood5IsFinal">

          <input type="text" name="date" value="<?php echo $_POST['date']; ?>">
        </div>

        <div class="container">
          <button class="btn btn-primary" id="btnMainSubmit" type="submit" disabled>Ingresar</button>
        </div>
      </form>
    </div>

    <!-- Hidden required forms to update mysql table -->
    <form action="../setdate.php" method="post" hidden>
      <input type="text" name="page" id="txtPage" value="sitios/sitios.php">
      <input type="text" name="date" value="<?php echo $_POST['date']; ?>" id="date">
      <input type="text" name="sitio" value="">
      <input type="text" name="responsable" value="">
      <input type="submit" value="Submit" id="btnSubmit">
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
    // Enabling submit button if Site is selected
    var site = document.getElementById("txtSitio").value;
    if (site != "")
      $("#btnMainSubmit").prop("disabled", false);

    // Uncollapsing controls
    document.getElementById("btnAlcalinidad").click();
    document.getElementById("btnCloro").click();
    document.getElementById("btnDBO_OD1").click();
    document.getElementById("btnDBO_OD5").click();
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

  function SiteClicked(a)
  {
    document.getElementById('txtSitio').value = document.getElementById('txtSite').value = a.innerHTML;
    document.getElementById('btnSubmit2').click();
  }

  function ButtonClicked(button){
    if (document.getElementById(button.value).style.display != 'none')
    {
      document.getElementById(button.value).style.display = 'none';

      if (button.value == "txtAlcalinidad")
      {
        $('#txtAlcalinidad').removeAttr('required');

        $('#txtAlcA1').attr('required', 'required');
        $('#txtAlcA2').attr('required', 'required');
        $('#txtAlcB').attr('required', 'required');
        $('#txtAlcC').attr('required', 'required');
        $('#txtAlcD').attr('required', 'required');

        document.getElementById("alcIsFinal").value = "False";
      }
      else if (button.value == "txtCloro")
      {
        $('#txtCloro').removeAttr('required');

        $('#txtClA1').attr('required', 'required');
        $('#txtClA2').attr('required', 'required');
        $('#txtClB').attr('required', 'required');
        $('#txtClC').attr('required', 'required');
        $('#txtClD').attr('required', 'required');
        $('#txtClF').attr('required', 'required');

        document.getElementById("clIsFinal").value = "False";
      }
      else if (button.value == "txtDBO_OD1")
      {
        $('#txtDBO_OD1').removeAttr('required');

        $('#txtDBO_OD1A1').attr('required', 'required');
        $('#txtDBO_OD1A2').attr('required', 'required');
        $('#txtDBO_OD1B').attr('required', 'required');
        $('#txtDBO_OD1C').attr('required', 'required');
        $('#txtDBO_OD1D').attr('required', 'required');
        $('#txtDBO_OD1E1').attr('required', 'required');
        $('#txtDBO_OD1E2').attr('required', 'required');

        document.getElementById("dbood1IsFinal").value = "False";
      }
      else if (button.value = "txtDBO_OD5")
      {
        $('#txtDBO_OD5').removeAttr('required');

        $('#txtDBO_OD5A1').attr('required', 'required');
        $('#txtDBO_OD5A2').attr('required', 'required');
        $('#txtDBO_OD5B').attr('required', 'required');
        $('#txtDBO_OD5C').attr('required', 'required');
        $('#txtDBO_OD5D').attr('required', 'required');
        $('#txtDBO_OD5E1').attr('required', 'required');
        $('#txtDBO_OD5E2').attr('required', 'required');

        document.getElementById("dbood5IsFinal").value = "False";
      }
    }
    else
    {
      document.getElementById(button.value).style.display = '';

      if (button.value == "txtAlcalinidad")
      {
        $('#txtAlcalinidad').attr('required', 'required');

        $('#txtAlcA1').removeAttr('required');
        $('#txtAlcA2').removeAttr('required');
        $('#txtAlcB').removeAttr('required');
        $('#txtAlcC').removeAttr('required');
        $('#txtAlcD').removeAttr('required');

        document.getElementById("alcIsFinal").value = "True";
      }
      else if (button.value == "txtCloro")
      {
        $('#txtCloro').attr('required', 'required');

        $('#txtClA1').removeAttr('required');
        $('#txtClA2').removeAttr('required');
        $('#txtClB').removeAttr('required');
        $('#txtClC').removeAttr('required');
        $('#txtClD').removeAttr('required');
        $('#txtClF').removeAttr('required');

        document.getElementById("clIsFinal").value = "True";
      }
      else if (button.value == "txtDBO_OD1")
      {
        $('#txtDBO_OD1').attr('required', 'required');

        $('#txtDBO_OD1A1').removeAttr('required');
        $('#txtDBO_OD1A2').removeAttr('required');
        $('#txtDBO_OD1B').removeAttr('required');
        $('#txtDBO_OD1C').removeAttr('required');
        $('#txtDBO_OD1D').removeAttr('required');
        $('#txtDBO_OD1E1').removeAttr('required');
        $('#txtDBO_OD1E2').removeAttr('required');

        document.getElementById("dbood1IsFinal").value = "True";
      }
      else if (button.value = "txtDBO_OD5")
      {
        $('#txtDBO_OD5').attr('required', 'required');

        $('#txtDBO_OD5A1').removeAttr('required');
        $('#txtDBO_OD5A2').removeAttr('required');
        $('#txtDBO_OD5B').removeAttr('required');
        $('#txtDBO_OD5C').removeAttr('required');
        $('#txtDBO_OD5D').removeAttr('required');
        $('#txtDBO_OD5E1').removeAttr('required');
        $('#txtDBO_OD5E2').removeAttr('required');

        document.getElementById("dbood5IsFinal").value = "True";
      }
    }
  }
 </script>
