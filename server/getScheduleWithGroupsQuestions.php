<?php
$grp=$_GET["grp"];
$data = GetScheduleWithQuestions($grp);
header('Content-type: application/json');
echo json_encode($data);


function GetScheduleWithQuestions($groupid)
{
    include_once('db_Connection.php');
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    $questions = array();
    $schedule = array();
    $schedulequestions = array();

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

        //----get question array-------------------
        $sqlstr = " SELECT [QuestionID],[QueastionText],[questionType],[maxmark],[NeedDescription],-1 as mark,'' as description "
            ." FROM [dbo].[Questions] "
            ." where [QuestionLecturer]=1 "
            ." and [Acadyear]=? ";
        $params = array ($acid);
         $sqlquery = sqlsrv_query( $conn, $sqlstr, $params);
        if( $sqlquery )
        {
            while( $row = sqlsrv_fetch_object( $sqlquery))
            {
                $questions[]=$row;
            }
            sqlsrv_free_stmt( $sqlquery);
        }

        //----get schadule array-------------------
        $sqlstr = " SELECT distinct [SubjID],[SubjName],[STypeID],[STypeName], [LectID], [LectName] "
            ." FROM [dbo].[Schedule] "
            ." WHERE groupID=? "
            ." order by [SubjID],[STypeID] ";
        $params = array ($groupid);

        $sqlquery = sqlsrv_query( $conn, $sqlstr, $params);
        if( $sqlquery ) {
            while ($row = sqlsrv_fetch_object($sqlquery)) {
                $row->quests = $questions;
                $schedule[] = $row;
            }

            $schedulequestions = array("result" => 0, "data" => $schedule);
        }

        sqlsrv_close( $conn);
    }

    return $schedulequestions;
}

?>