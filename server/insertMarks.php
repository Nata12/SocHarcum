<?php
/* include db.config.php */
include_once('db_Connection.php');
try
{
//if($_SERVER['REQUEST_METHOD'] == "POST"){

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata,false);

    foreach ($request as &$lecturer)
     {
        $login = $lecturer->login;
        $subjectid = $lecturer->subjectid;
        $subjtype =  $lecturer->subjtype;
        $lectid = $lecturer->lectid;
        $qid= $lecturer->qid;
        $mark=$lecturer->mark;
        $description= $lecturer->description;

        $select=sqlsrv_query($conn,"INSERT INTO SocHarcumOnline.dbo.Marks  (Login,subjid,subjtype,lectid ,qid ,mark,ldescription) values (?,?,?,?,?,?,?)",array(&$login,&$subjectid,&$subjtype,&$lectid,&$qid,&$mark ,&$description));
        if($select)
            $data = array("result" => 0, "data" => "updated");
        else
            $data = array("result" =>0, "data" => "not updatetd :(");
     }
     /* JSON Response */
    header('Content-type: application/json');
    echo( json_encode($data));
}
 catch (Exception $e) {
  //  echo(   $e->getMessage());
   echo 'error';
}



?>