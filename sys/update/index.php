<?php
session_start();
include_once '../../database/evaseacdb.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Actualizar base de datos</title>
    <meta name='viewport'
        content='width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no' />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Icon -->
    <link rel="icon" href="../../imgs/Evaseac.ico">
</head>

<body>

    <!-- Modal container -->
    <div class="container">
        <!-- Button trigger modal -->
        <button id="authModalButton" type="button" class="btn btn-primary" data-toggle="modal" data-target="#authModal"
            hidden>
            Authenticate
        </button>

        <!-- Modal -->
        <div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="authModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h5 class="modal-title">Autenticación</h5>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-row">
                                <label for="user" class="col-form-label">Usuario:</label>
                                <input type="text" class="form-control" id="user" required>
                            </div>
                            <div class="form-row">
                                <label for="password" class="col-form-label">Contraseña:</label>
                                <input type="password" class="form-control" id="password" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button id="btnAuth" type="submit" class="btn btn-primary">Ingresar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card" style="padding-top: 5%;">
            <div class="card-header text-center">
                <h2>Actualización de la base de datos</h2>
            </div>
            <div class="card-body">
                <form>
                <div class="form-group">
                    <label for="csvfile">Escoja su archivo CSV que actualizará la base de datos en el servidor</label>
                    <input type="file" class="form-control-file" id="csvfile">
                </div>
                <div class="row" style="padding-top: 15px; padding-left: 12px;">
                    <input class="btn btn-primary" type="button" value="Actualizar" id="btnUpload">
                </div>    
            </form>
            </div>
            <div class="card-footer text-muted">
            <?php
            $link = open_database();
            $query = "SELECT last_import FROM sys_config WHERE id = '" . SYS_ID . "'";
            $last_import = mysqli_fetch_assoc(mysqli_query($link, $query))['last_import'];
            if ($last_import == null)
                $last_import = "No se ha importado ningún archivo al sistema";
            ?>
                Última actualicación: <?php echo $last_import; ?>
            </div>
        </div>
    </div>

    <div id="editor"></div>

    <div class="scripts">
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
        </script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </div>

    <?php
    mysqli_close($link);
    ?>
</body>

</html>

<script>
    var validAuth = false;

    $(document).ready(function () {
        // showing auth modal
        if ("<?php echo isset($_SESSION["user"]); ?>" != "1")
            $("#authModalButton").click();
    });

    function mensaje(tipo,icono,titulo,texto) {
        if(tipo == 1) {
            swal({
            icon: icono,
            title: titulo,
            }).then(function()
            {
            window.location.reload();
            });
        }
        else {
            swal({
            icon: icono,
            title: titulo,
            text: texto
            }).then(function()
            {
            window.location.reload();
            });
        }
    }

    // closing event from Modal
    $('#authModal').on('hidden.bs.modal', function (e) {
        // verify authentication

        if (validAuth) {
            return;
        }

        // invalid
        alert("Necesita autenticarse para poder usar esta página");
        $('#authModal').modal('show');
    });

    // authentication
    $("#btnAuth").click(function () {
        $.ajax({
            url: "./auth.php",
            method: "POST",
            data: {
                user: $("#user").val(),
                password: $("#password").val()
            },
            cache: false,
            success: function (respax) {
                if (respax == "true") {
                    validAuth = true;
                    $('#authModal').modal('hide');
                } else {
                    alert("Autenticación fallida: Usuario y/o contraseña incorrectas");
                }
            }
        });
    });

    $("#btnUpload").click(function (){        
        var file = $("#csvfile").prop('files')[0];
        if (file == undefined) {
            alert("Seleccione un archivo");
            return;
        }
        else if (file.name.split('.').pop() !== "csv") {
            alert("Seleccione un archvio csv");
            return;
        }

        const uri = "updatedb.php";
        const xhr = new XMLHttpRequest();
        const fd = new FormData();
        xhr.open("POST", uri, true);
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200){
                let res = JSON.parse(xhr.responseText);
                if (res["error_mysql"].length > 0) {
                    errMsg = "";
                    res["error_mysql"].forEach(err => {
                        errMsg += err + "\n-----\n";
                    });

                    mensaje(2, "error", "Error al importar datos a la Base de Datos", errMsg);
                }
                else {
                    mensaje(1, "success", "Datos importados correctamente", "");
                }
            }
        };
        fd.append('file_name', file);
        xhr.send(fd);
    });

</script>