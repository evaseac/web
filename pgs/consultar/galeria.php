<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>Evaseac - Galeria</title>

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
    <!-- Font awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <!-- Lightbox -->
    <link rel="stylesheet" href="../../css/lightbox.min.css">
    <script src="../../js/lightbox-plus-jquery.min.js"></script>

    <style media="screen">
      .image-gallery {
        height: 225px;
        overflow: hidden;
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px;
      }

      .gallery img:hover {
        filter: grayscale(50%);
        transform: scale(1.1);
      }
    </style>
  </head>
  <body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
      <button type="button" class="btn btn-default" aria-label="Left Align" onclick="btnRegresar_Click();">
        <i class="fas fa-angle-left"></i> Regresar
      </button>
      </div>
    </nav>

    <br><br><br>

    <!-- Info -->
    <div class="container">
      <center>
        <h1 class="display-3">Galería</h1>
      </center>
      <div class="jumbotron">
        <h1 class="display-4"><?php echo $_POST['sitio']; ?></h1>
        <p class="h6"><?php echo $_POST['date']; ?></p>
      </div>
    </div>

    <!-- Gallery -->
    <div class="container">
      <div class="gallery">
        <?php
          include '../../database/evaseacdb.php';

          $conn = open_database();

          $result = mysqli_query($conn, $_POST['query_imagenes']);

          $urls = array();

          while ($row = mysqli_fetch_array($result)) {
            array_push($urls, $row["url"]);
          }
        ?>

        <?php
          for ($i=0; $i < count($urls); $i+=3) {
        ?>
        <div class="row">
          <div class="col-lg-4 col-md-12">
            <div class="image-gallery">
              <a href="<?php echo $urls[$i]; ?>" data-lightbox="mygallery"><img class="img-fluid" src="<?php echo $urls[$i]; ?>" style="width: 100%;"></a>
            </div>
          </div>
        <?php
            if ($i + 1 < count($urls)) {
        ?>
          <div class="col-lg-4 col-md-12">
            <div class="image-gallery">
              <a href="<?php echo $urls[$i + 1]; ?>" data-lightbox="mygallery"><img class="img-fluid" src="<?php echo $urls[$i + 1]; ?>" style="width: 100%;"></a>
            </div>
          </div>
        <?php
            }
            if ($i + 2 < count($urls)) {
        ?>
          <div class="col-lg-4 col-md-12">
            <div class="image-gallery">
              <a href="<?php echo $urls[$i + 2]; ?>" data-lightbox="mygallery"><img class="img-fluid" src="<?php echo $urls[$i + 2]; ?>" style="width: 100%;"></a>
            </div>
          </div>
        <?php
            }
        ?>
        </div>
        <?php
          }
        ?>
      </div>
    </div>

    <?php
      mysqli_close($conn);
    ?>

    <br>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
<script type="text/javascript">
  function btnRegresar_Click() {
    history.back();
  }
</script>
