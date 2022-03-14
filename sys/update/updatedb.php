<?php

$insert1st = "";
$params = "";

include 'readcsv.php';
include '../../database/evaseacdb.php';
$link = open_database();

$messages = array();
$messages["error_queries"] = array();
$messages["error_mysql"] = array();

$updates = array();
$first = "";

if(isset($_FILES['file_name'])){
    $data = getFileContent();
    $noRow = -1;

    foreach($data as $row){
        $query = "";

        $counter = 0;
        $noRow++;
        $col_num = count($row);
        foreach ($row as $col) {
            $counter++;
            if (isTableName($col)) {
                $tableName = substr($col, 1, strlen($col) - 2);
                // Deleting from top to bottom
                if (mysqli_query($link, "DELETE FROM " . $tableName) === FALSE) {
                    array_push($messages["error_queries"], "DELETE FROM " . $tableName);
                    array_push($messages["error_mysql"], "MySQL Error(" . mysqli_errno($link) . "):\n" . mysqli_error($link));
                }

                $insert1st = "INSERT INTO " . $tableName;
                $noRow = 1;
            }
            else if ($noRow == 2) {
                if ($counter == 1) 
                    $params = "($col";
                else
                    $params .= $col;

                if ($counter != $col_num)
                    $params .= ", ";
                else
                    $params .= ") VALUE";
            }
            else if ($counter == 1)
                $query = "$insert1st $params (" . getDateTimeValue($col);
            else
                $query .=  getDateTimeValue($col);

            if ($noRow > 2) {
                if ($counter != $col_num)
                    $query .= ", ";
                else if (!isTableName($col)) {
                    $query .= ")";
                    array_push($updates, $query);
                }
            }
        }
    }

    // Updating from bottom to top
    while (!empty($updates)) {
        $query = array_pop($updates);
        if (mysqli_query($link, $query) == FALSE) {
            array_push($messages["error_queries"], $query);
            array_push($messages["error_mysql"], "MySQL Error(" . mysqli_errno($link) . "):\n" . mysqli_error($link));
        }
    }

    // updating sys_config
    if (count($messages["error_mysql"]) == 0) {
        date_default_timezone_set('America/Mexico_City');
        
        $query = "UPDATE sys_config SET last_import = '" . date('Y-m-d H:i:s') . "' WHERE id = '" . SYS_ID . "'";
        if (mysqli_query($link, $query) == FALSE) {
            array_push($messages["error_queries"], $query);
            array_push($messages["error_mysql"], "MySQL Error(" . mysqli_errno($link) . "):\n" . mysqli_error($link));
        }
    }

    mysqli_close($link);
}

function isTableName($string) {
    if (empty($string))
        return false;
    if ($string[0] == "-" && $string[strlen($string) - 1] == "-")
        return true;
    return false;
}

function getDateTimeValue($val)
{
    if (strcontains($val, "12:00:00")) {
        $splitted_datetime = explode(" ", $val);

        // filling date with ##/##/#### format
        $date = substr($splitted_datetime[0], 1); // gets date
        $splitted_date = explode("/", $date); // splits in MM/dd/yyyy
        // fills with zeros
        $month = str_pad($splitted_date[0], 2, "0", STR_PAD_LEFT);
        $day = str_pad($splitted_date[1], 2, "0", STR_PAD_LEFT);
        $year = $splitted_date[2]; // gets year

        $time = "00:00:00"; // gets time

        $formatted_datetime = "'" . $month . "-" . $day . "-" . $year . " " . $time . "'";
        $datetime = "STR_TO_DATE($formatted_datetime, '%m-%d-%Y %H:%i:%s')";

        return $datetime;
    }

    return $val;
}

function strcontains(string $haystack, string $needle): bool
{
    return '' === $needle || false !== strpos($haystack, $needle);
}

echo json_encode($messages);

?>