<?php
$grp=$_GET["grp"];
$data = GetFacultyQuestions($grp);
header('Content-type: application/json');
echo json_encode($data);

function GetFacultyQuestions($groupid)
{
    include_once('db_Connection.php');
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    $questionvalues=array();
    $questions = array();
    $faculty = array();
    $facultyquestions = array();

    if ($conn)
    {
        //----get acadyear-------------------
        $acid=0;
        $sqlstr = " SELECT [AcadYearID] FROM [dbo].[Groups] where [groupid]=? ";
        $params = array ($groupid);
        $sqlquery = sqlsrv_query( $conn, $sqlstr, $params);
        if( $sqlquery )
        {
            while( $row = sqlsrv_fetch_array( $sqlquery, SQLSRV_FETCH_ASSOC) )
            {
                $acid=$row['AcadYearID'];
            }
            sqlsrv_free_stmt( $sqlquery);
        }

  $sqlstr = " SELECT [questionTypeId],[value],[text] "
                    ." FROM [dbo].[QuestionValues] "
                    ." order by questionTypeId ";

              //  $params = array ($acid);
                 $sqlquery = sqlsrv_query( $conn, $sqlstr);
                if( $sqlquery )
                {
                    while( $row = sqlsrv_fetch_object( $sqlquery))
                    {
                        $questionvalues[]=$row;
                    }
                    sqlsrv_free_stmt( $sqlquery);
                }

        //----get question array-------------------
        $sqlstr = " SELECT [QuestionID],[QueastionText],[questionType],[maxmark],-1 as mark,'' as description "
            ." FROM [dbo].[Questions] "
            ." where [QuestionLecturer]=0 "
            ." and [Acadyear]=? ";
        $params = array ($acid);
        $sqlquery = sqlsrv_query( $conn, $sqlstr, $params);
        if( $sqlquery )
        {
            while( $row = sqlsrv_fetch_object( $sqlquery) )
            {
                   $row->questionValues=array();
                    foreach ($questionvalues as &$questValue )
                    {
                        if($questValue->questionTypeId===$row->questionType)
                         {
                                array_push( $row->questionValues,$questValue);
                         }

                    }
                    $questions[]=$row;
            }
            sqlsrv_free_stmt( $sqlquery);
        }

        //----get faculty-------------------
        $sqlstr = " SELECT [FacultyID],[FacultyName] FROM [dbo].[Groups] "
                  ." where [groupid]=? ";
        $params = array ($groupid);

        $sqlquery = sqlsrv_query( $conn, $sqlstr, $params);
        if( $sqlquery ) {
            while ($row = sqlsrv_fetch_object($sqlquery)) {
                $row->quests = $questions;
                $faculty[] = $row;
            }

            $facultyquestions = array("result" => 0, "data" => $faculty);
        }

        sqlsrv_close( $conn);
    }

    return $facultyquestions;
}

?>