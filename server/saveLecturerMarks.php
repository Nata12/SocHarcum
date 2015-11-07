<?php

try
{
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata,false);

    $data = SaveLecturerMarks($request);

    /* JSON Response */
    header('Content-type: application/json');
    echo( json_encode($data));
}
catch (Exception $e) {
    //  echo(   $e->getMessage());
    echo 'error';
}


function SaveLecturerMarks($marks)
{
    $status = array();

    include_once('db_Connection.php');
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if ($conn)
    {
        $login = "0";
        $subjectid = 0;
        $subjtype = 0;
        $lectid = 0;
        $qid = 0;
        $mark = 0;
        $ldescription = "0";

        $sqlstr = " insert into [dbo].[MarkLecturer] ([Login],[subjid],[subjtype],[lectid],[qid],[mark],[ldescription]) "
                  ." values (?,?,?,?,?,?,?) ";
        $params = array (&$login,&$subjectid,&$subjtype,&$lectid,&$qid,&$mark,&$ldescription);

        $stmt = sqlsrv_prepare( $conn, $sqlstr, $params);
        if( $stmt )
        {
            foreach ($marks as &$data)
            {
                $login = $data->login;
                $subjectid = $data->subjectid;
                $subjtype =  $data->subjtype;
                $lectid = $data->lectid;
                $qid= $data->qid;
                $mark=$data->mark;
                $ldescription= $data->description;

                if(!sqlsrv_execute( $stmt ))
                    array_push($status, "not inserted-L".$login."-S".$subjectid."-T".$subjtype."-L".$lectid."-Q".$qid);
            }
        }
        sqlsrv_close( $conn);
    }

    return $status;
}

?>