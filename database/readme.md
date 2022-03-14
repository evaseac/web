# evaseacdb.php
This directory originally contains a basic php file where the connection to the MySQL Database is done. This file is used in many other files so it is really **important** to implement it.

The code has a structure as described below:

```php
<?php
  define("SYS_ID", "default");

  function open_database() {
    $host = "database";
    $uid = "root";
    $pwd = "tiger";
    $database = "●●●●●●";
    $port = "●●●●●●";

    $connection = mysqli_connect($host, $uid, $pwd, $database, $port);
    if (mysqli_connect_errno($connection))
      echo "Failed to connect to MySQL: " . mysqli_connect_error();

    return $connection;
  }
?>
```

The `SYS_ID` constant is meant to be used as a system profile, so it can have different configurations and stores some information about the whole system system.