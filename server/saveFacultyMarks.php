<?php

try
{
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata,false);

    $data = SaveFacultyMarks($request);

    /* JSON Response */
    header('Content-type: application/json');
    echo( json_encode($data));
}
catch (Exception $e) {
    //  echo(   $e->getMessage());
    echo 'error';
}


function SaveFacultyMarks($marks)
{
    $status = array();

    include_once('db_Connection.php');
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if ($conn)
    {
        $Login = "0";
        $facultyid = 0;
        $qid = 0;
        $mark = 0;
        $ldescription = "0";

        $sqlstr = " insert into [dbo].[MarkFaculty] ([Login],[facultyid],[qid],[mark],[ldescription]) "
                  ." values (?,?,?,?,?) ";
        $params = array (&$Login,&$facultyid,&$qid,&$mark,&$ldescription);

        $stmt = sqlsrv_prepare( $conn, $sqlstr, $params);
        if( $stmt )
        {
            foreach ($marks as &$data)
            {
                $Login = $data->login;
                $facultyid = $data->facultyid;
                $qid = $data->qid;
                $mark = $data->mark;
                $ldescription = $data->description;

                if(!sqlsrv_execute( $stmt ))
                    array_push($status, "not inserted-L".$Login."-F".$facultyid."-Q".$qid);
            }
        }
        sqlsrv_close( $conn);
    }

    return $status;
}

?>