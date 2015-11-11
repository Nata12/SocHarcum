<?php
$grp=$_GET["grp"];
$data = GetScheduleWithQuestions($grp);
header('Content-type: application/json');
echo json_encode($data);


function GetScheduleWithQuestionsOLD($groupid)
{
    include_once('db_Connection.php');
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    $questionvalues=array();
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

function GetScheduleWithQuestions($groupid)
{
     include_once('db_Connection.php');
        $conn = sqlsrv_connect( $serverName, $connectionInfo);

        $questionvalues=array();
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
           

             //----get schadule array-------------------
                    $sqlstr = " SELECT distinct [SubjID],[SubjName],[STypeID],[STypeName],0 as SelectedLectID "
                        ." FROM [dbo].[Schedule] "
                        ." WHERE groupID=? "
                        ." order by [SubjID],[STypeID] ";
            
                      $params = array ($groupid);
					  
                      $sqlquery = sqlsrv_query( $conn, $sqlstr, $params);
                      if( $sqlquery ) 
					  {
                        while ($row = sqlsrv_fetch_object($sqlquery))
						{
						
							$sb = $row->SubjID;
                            $st = $row->STypeID;
						$row->lect=array();
							$sqlstr = " SELECT distinct [LectID],[LectName] "
                                ." FROM [dbo].[Schedule] "
                                ." WHERE groupID=? "
                                ." and subjID=? "
                                ." and STypeID=? ";
							$params = array ($groupid,$sb,$st);
							$sqlquerylect = sqlsrv_query( $conn, $sqlstr, $params);
							if( $sqlquerylect )
							{
							
								while ($rowlect = sqlsrv_fetch_object($sqlquerylect))
								{
									

            
            //                  	  foreach ($row->lect as $lect)
            //                    {
									$rowlect->quests=$questions;
                                   // array_push(   $rowlect->quests,$questions);
									array_push( $row->lect , $rowlect);
            //                    }
								}
							}
            
                            $schedule[] = $row;
						}
					}
						 
                       
        }
                        $schedulequestions = array("result" => 0, "data" => $schedule);                   
        
           

        return $schedulequestions;
}

?>