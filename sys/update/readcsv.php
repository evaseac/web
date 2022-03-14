<?php

function getFileContent()
{
    $directory = getcwd().DIRECTORY_SEPARATOR;
    $target_file = $directory . basename($_FILES['file_name']['name']);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $file_number = 0;
    $data = array();
    if($file_type == "csv"){
        if(@move_uploaded_file($_FILES['file_name']['tmp_name'], $target_file)){
            if(($gestor = fopen($target_file,"r")) !== FALSE){
                while(($fila = fgetcsv($gestor)) !== FALSE){
                    $file_number++;
                    if($file_number === 0){
                        continue;
                    }
                    $data[$file_number - 1] = $fila;
                }
                fclose($gestor);
            }
            else{
                exit("Hubo un error al tratar de abrir el archivo copiado\n");
            }
            if(!unlink($target_file)){
                exit("Hubo un error al tratar de eliminar el archivo copiado\n");
            }
        }
        else{
            exit("Error al copiar el archivo subido\n");
        }
    }
    else{ 
        echo "Se debe subir un archivo csv\n";
    }
    return $data;
}

?>