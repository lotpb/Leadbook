<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>
<?php
define('SERVER', 'localhost');  //Your server host
define('USRNAME', 'root');  //Your DB user name
define('PASS', 'root');  //Your db Password
define('DBNAME', 'Leadbook');  //You db name


  $ccyymmdd = date("Ymd");
  $file = fopen("backups/backup".$ccyymmdd.".sql","w");
  $line_count = create_backup_sql($file);
  fclose($file);
  $message = "Backup Complete<br />lines written: ".$line_count;

  function create_backup_sql($file) {
    $line_count = 0;
    $db_connection = db_connect();
    mysql_select_db (db_name()) or exit();
    $tables = mysql_list_tables(db_name());
    $sql_string = NULL;
    while ($table = mysql_fetch_array($tables)) {   
      $table_name = $table[0];
      $sql_string = "TRUNCATE TABLE $table_name";
      $table_query = mysql_query("SELECT * FROM `$table_name`");
      $num_fields = mysql_num_fields($table_query);
      while ($fetch_row = mysql_fetch_array($table_query)) {
        $sql_string .= "INSERT INTO $table_name VALUES(";
        $first = TRUE;
        for ($field_count=1;$field_count<=$num_fields;$field_count++){
          if (TRUE == $first) {
            $sql_string .= "'".mysql_real_escape_string($fetch_row[($field_count - 1)])."'";
            $first = FALSE;            
          } else {
            $sql_string .= ", '".mysql_real_escape_string($fetch_row[($field_count - 1)])."'";
          }
        }
        $sql_string .= ");";
        if ($sql_string != ""){
          $line_count = write_backup_sql($file,$sql_string,$line_count);        
        }
        $sql_string = NULL;
      }    
    }
    return $line_count;
  }

  function write_backup_sql($file, $string_in, $line_count) { 
    fwrite($file, $string_in);
    return ++$line_count;
  }
  
  function db_name() {
      return (DBNAME);
  }
  
  function db_connect() {
    $db_connection = mysql_connect(SERVER, USRNAME, PASS);
    return $db_connection;
  }  
?>
<body>
</body>
</html>
