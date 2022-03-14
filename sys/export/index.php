<?php 
    include '../../database/evaseacdb.php';
    
    $content = '';
    $table_names = array("publicacionmiembros", "parametroscrudo", "parametros", "imagenes", "parametrospsitios", "parametrosp", "prueba", "generossitios", "genero", "familiassitios", "familia",
        "orden", "clase", "temporada", "sitio", "proyecto", "publicacion", "miembro", "area", "usuario");
    $conn = open_database();
    if (!$conn)
        die("Error al conectar al servidor: " . mysqli_connect_error());

    foreach ($table_names as $table) {
        // table names
        $content .= "-" . $table . "-\n";

        // table info
        // column names
        $result = mysqli_query($conn, "SHOW COLUMNS FROM " . $table);
        if($result) {
            while ($row = mysqli_fetch_array($result)) {
                $content .= $row['Field'] . ",";
            }
            $content = rtrim($content, ", ");
            $content .= "\n";
        }
        // table data
        $query = "SELECT * FROM " . $table;
        $result = mysqli_query($conn, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                foreach ($row as $key => $value) {
                    if (is_int($key)) {
                        $content .= get_sql_value($value) . ",";
                    }
                }
                $content = rtrim($content, ", ");
                $content .= "\n";
            }
        }
    }

    // echo $content;

    // downloads 
    $file_name = date("Y-m-d") . "-ev.csv";
    header('Content-Type: application/octet-stream');   
    header("Content-Transfer-Encoding: Binary"); 
    header("Content-disposition: attachment; filename=\"".$file_name."\"");  
    echo $content; exit;

    header("../");
?>