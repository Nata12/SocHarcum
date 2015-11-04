<?php
/* include db.config.php */
include_once('db_Connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
// Get data


$login = isset($_POST['login']) ? $_POST['login'] : "" ;
$subjectid = isset($_POST['subjectid']) ? $_POST['subjectid'] : "" ;
$subjtype = isset($_POST['subjtype']) ? $_POST['subjtype'] : "" ;
$lectid = isset($_POST['lectid']) ? $_POST['lectid'] : "" ;
$qid=isset($_POST['qid']) ? $_POST['qid'] : "" ;
$mark=isset($_POST['mark']) ? $_POST['mark'] : "" ;
$description=isset($_POST['description']) ? $_POST['description'] : "" ;



$select=sqlsrv_query($conn,"INSERT INTO SocHarcumOnline.dbo.Marks  (Login,subjid,subjtype,lectid ,qid ,mark,ldescription) values (?,?,?,?,?,?,?)",array(&$login,&$subjectid,&$subjtype,&$lectid,&$qid,&$mark ,&$description));

if($select)
$data = array("result" => 0, "data" => "updated","login"=>$login,"SERVER"=>$_SERVER['REQUEST_METHOD'],"POST"=>$_POST);
else
$data = array("result" => sqlsrv_errors(), "data" => "not updatetd :(");




/* JSON Response */
header('Content-type: application/json');
echo json_encode($data);
}
else
echo 'error';
?>