<?php
/* include db.config.php */
include_once('db_Connection.php');

// Get user id
$id = $_GET['id'] ;

$tsql = "SELECT count(*) as loginExist from StudentNew where persnumber='?'";

;
/* Prepare the statement. */
$select =sqlsrv_query( $conn, $tsql, array(&$id));

$result = array();
while($data = sqlsrv_fetch_object($select)) {

$result[] = $data;
}

$data = array("result" => 0, "data" => $result);



/* JSON Response */
header('Content-type: application/json');
echo json_encode($data);