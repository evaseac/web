
<!-- PDF DRIVES MUST BE SAVED as https:/.../ (without the /view or /edit or etc) -->



<?php
  include '../../database/evaseacdb.php';

  $conn = open_database();
  if (!$conn)
    die("Error al conectar al servidor: " . mysqli_connect_error());

  $label = $_POST['txtLabel'];
  $query = "SELECT ID, FichaCurricular, Puesto, Grado, Foto, Correo, ResearchGate FROM Miembro WHERE Etiqueta='" . $label . "'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result);
  $id = $row['ID'];
  $curriculum = $row['FichaCurricular'];
  $position = $row['Puesto'];
  $grade = $row['Grado'];
  $email = $row['Correo'];
  $rg = $row['ResearchGate'];

  if (is_null($row['Foto']))
    $photo = "../../imgs/placeholder-user.jpg";
  else
    $photo = $row['Foto'];
?>
<html>
  <head>
    <title>Evaseac - <?php echo $label; ?></title>

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
    <!-- mdbootsrap icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

    <style media="screen">
      div.personalInfo {
        width: 100%;
        overflow-x: auto;
        padding-top: 10px;
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
            <a class="nav-link dropdown-toggle active" data-toggle="dropdown" data-target="#nav_conocenos" href="#">
              <font class="lead">Conócenos</font>
            </a>
            <div class="dropdown-menu" aria-labelledby="nav_conocenos">
              <a class="dropdown-item" href="../conocenos/grupo_trabajo.php">Grupo de trabajo</a>
              <a class="dropdown-item" href="../conocenos/investigacion.html">Investigación</a>
            </div>
          </li>
          <li class="nav-item" style="padding-right: 35px; padding-left: 35px;">
            <a class="nav-link" href="#" onclick="btnConsultar_Click();"><p class="lead">Consultar</p></a>
          </li>
          <li class="nav-item" style="padding-right: 35px; padding-left: 35px;">
            <a class="nav-link" href="../sitios/ingresar.html" onclick=""><p class="lead">Insertar</p></a>
          </li>
        </ul>
      </div>
    </nav>

    <br>

    <!-- Main profile card -->
    <div class="container">
      <div class="row bg-light">
        <div class="col-xs-12 col-sm-12 col-md-4">
          <img src="<?php echo $photo; ?>" class="img-responsive" style="padding: 20px; height: 250px; display: block; margin: auto;" />
        </div>
        <div class="col-xs-12 col-sm-12 col-md-8">
          <div class="personalInfo">
            <h2 class="media-heading"><?php echo $label; ?></h2>
            <hr>

            <?php
            $noinfo = 0;

            if (is_null($grade)) {
              $noinfo++;
            }
            else {
            ?>
            <!-- Grado -->
            <h6><?php echo $grade; ?></h6>
            <?php
            }
            if (is_null($position)) {
              $noinfo++;
            }
            else {
            ?>
            <!-- Puesto -->
            <p class="font-weight-light"><?php echo $position; ?></p>
            <?php
            }
            if (is_null($rg)) {
              $noinfo++;
            }
            else{
            ?>
            <div style="padding-bottom: 10px; padding-left: 1.5%;">
              <a href="<?php echo $rg; ?>" target="_blank"><i class="fab fa-researchgate fa-2x"></i></a>
            </div>
            <?php
            }
            if (is_null($email)) {
              $noinfo++;
            }
            else {
            ?>
            <!-- Correo -->
            <div style="padding-bottom: 20px;">
              <a href="mailto:<?php echo $email; ?>" target="_blank" class="btn btn-outline-primary"><?php echo $email; ?></a>
            </div>
            <?php
            }

            if ($noinfo == 4) {
            ?>
            <h6>Sin mas información por mostrar disponible.</h6>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
      <!-- Blue separator -->
      <div class="row">
        <div class="col-12">
          <div class="card bg-primary"></div>
        </div>
      </div>
    </div>
    </div>

    <br>

    <!-- Buttons to display info -->
    <div class="container">
      <div hidden>
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#curriculum" aria-expanded="false" aria-controls="curriculum" id="btnCurriculum">curriculum</button>
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#papers" aria-expanded="false" aria-controls="papers" id="btnPapers">papers</button>
      </div>
      <center>
        <p>
          <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-primary active" onclick="btnCurricular_Click();">
              <input type="radio" name="options" id="btnCurricular" autocomplete="off" checked> Ficha curricular
            </label>
            <label class="btn btn-primary" onclick="btnPublicaciones_Click();">
              <input type="radio" name="options" id="btnPublicaciones" autocomplete="off"> Publicaciones
            </label>
          </div>
        </p>
      </center>
      <!-- Curriculum -->
      <div class="collapse multi-collapse" id="curriculum">
        <div class="card card-body">
          <?php
          if (is_null($curriculum)) {
          ?>
          <h6>Sin ficha curricular disponible.</h6>
          <?php
          }
          else {
            echo $curriculum;
          }
          ?>
        </div>
      </div>
      <!-- Papers -->
      <?php
      $query = "SELECT IdPublicacion FROM PublicacionMiembros WHERE IdMiembro = $id";
      $result = mysqli_query($conn, $query);
      $num_rows = mysqli_num_rows($result);
      // retrieving ids from papers assosiated to member
      $idpapers = array();
      while ($row = mysqli_fetch_array($result)) {
        array_push($idpapers, $row["IdPublicacion"]);
      }

      $titles = array();
      $urls = array();
      $photos = array();

      foreach ($idpapers as $idpaper) {
        $query = "SELECT Titulo, url, Foto FROM Publicacion WHERE ID = $idpaper";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_array($result)) {
          array_push($titles, $row['Titulo']);
          array_push($urls, $row['url']);
          array_push($photos, $row['Foto']);
        }          
      }
      ?>
      <div class="collapse multi-collapse" id="papers">
        <div class="card card-body">
      <?php
        if (mysqli_num_rows($result) == 0) {
      ?>
          <h6>Sin publicaciones disponibles.</h6>
      <?php
        }
        else {
      ?>
          <center>
        <?php
        for ($i=0; $i < count($urls); $i += 3) {
        ?>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4">
                  <a href="<?php echo $urls[$i]; ?>" target="_blank">
                    <img src="<?php echo $photos[$i]; ?>" style="width:210px; height:280px;">
                  </a>
                  <br>
                  <h5 style="text-shadow: 2px 2px 0px #FFFFFF;"><?php echo $titles[$i]; ?></h5>
                </div>
                <br><br><br>
        <?php
          if ($i + 1 < count($urls)) {
        ?>
                <div class="col-xs-12 col-sm-12 col-md-4">
                  <a href="<?php echo $urls[$i + 1]; ?>" target="_blank">
                    <img src="<?php echo $photos[$i + 1]; ?>" style="width:210px; height:280px;">
                  </a>
                  <br>
                  <h5><?php echo $titles[$i + 1]; ?></h5>
                </div>
                <br><br><br>
        <?php
          }
          if ($i + 2 < count($urls)) {
        ?>
                <div class="col-xs-12 col-sm-12 col-md-4">
                  <a href="<?php echo $urls[$i + 2]; ?>" target="_blank">
                    <img src="<?php echo $photos[$i + 2]; ?>" style="width:210px; height:280px;">
                  </a>
                  <br>
                  <h5><?php echo $titles[$i + 2]; ?></h5>
                </div>
                <br><br><br>
        <?php
          }
        ?>
          </div>
        <?php
        }
      }
        ?>
        </center>
      </div>
      </div>
    </div>

    <!-- Hidden required form to update mysql table -->
    <form class="" action="../setdate.php" method="post" hidden>
      <input type="text" name="page" value="sitios/sitios.php">
      <input type="text" name="date" id="txtDate1" value="">
      <input type="text" name="sitio" value="">
      <input type="text" name="responsable" value="">
      <input type="submit" value="Sitios" id="btnSubmit1">
    </form>
    <form class="" action="../consultar/setinfo.php" method="post" hidden>
      <input type="text" name="date" id="txtDate2" value="">
      <input type="submit" value="Sitios" id="btnSubmit2">
    </form>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  </body>
</html>
<script type="text/javascript">
  var curriculumExpanded = false;

  window.onload = function(){
    var date = new Date();
    document.getElementById('txtDate1').value = document.getElementById('txtDate2').value = date.getFullYear() + "-" + ("0" + (date.getMonth() + 1)).slice(-2);

    $('#curriculum').collapse({
      toggle: true
    })
    curriculumExpanded = true;
  }

  function btnConsultar_Click(){
    document.getElementById('btnSubmit2').click();
  }

  // collapse Buttons
  function btnCurricular_Click(){
    if (!curriculumExpanded) {
      document.getElementById('btnPapers').click();
      document.getElementById('btnCurriculum').click();
      curriculumExpanded = true;
    }
  }
  function btnPublicaciones_Click(){
    if (curriculumExpanded) {
      document.getElementById('btnCurriculum').click();
      document.getElementById('btnPapers').click();
      curriculumExpanded = false;
    }
  }

</script>
