<?php
if (isset($_POST['username']))
{
    $errors = array ();
    $groupid = -1;

    $username = $_POST['username'];

    if (empty ($username))
    {
        $errors [] = "Please enter the password";
    }
    else
    {
        $groupid = CheckLogin($username);

        if ($groupid<0)
        {
            switch ($groupid)
            {
                case -1:
                    $errors [] = "Don't exists";
                    break;
                case -2:
                    $errors [] = "Not printed";
                    break;
                case -3:
                    $errors [] = "Password already used";
                    break;
                case -4:
                    $errors [] = "Shut e";
                    break;
                case -5:
                    $errors [] = "Ush e";
                    break;
                default:
                    $errors [] = "Wrong password";
                    break;
            }
        }
    }

    if (!empty ($errors))
    {
        foreach ($errors as $error)
        {
            echo '<strong>', $error ,'</strong><br />';
        }
    }
    else
    {
        header("Location:MarkForm.php?grp=".$groupid."&log=".$username."");
    }
}



function CheckLogin($user)
{
    $groupid=-1;

    include_once('db_Connection.php');
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if ($conn)
    {
        $sqlstr = " SELECT [groupID],[Login],[LoginUsed],[LoginPrinted] FROM [dbo].[StudentsLogin] where [Login]=?";
        $params = array ($user);

        $sqlquery = sqlsrv_query( $conn, $sqlstr, $params);
        if( $sqlquery )
        {
            $pirnted=1;
            $used=0;
            $count = 0;
            while( $row = sqlsrv_fetch_array( $sqlquery, SQLSRV_FETCH_ASSOC) )
            {
                $groupid=$row['groupID'];
                $pirnted=$row['LoginPrinted'];
                $used=$row['LoginUsed'];
                $count++;
            }

            if ($count==1)
            {
                if ($pirnted==0) { $groupid = -2; }
                if ($used==1) { $groupid = -3; }
            }
            else
            {
                $groupid=-1;
            }
            sqlsrv_free_stmt( $sqlquery);
        }

        if ($groupid>0)
        {
            $sqlstr = "SELECT GETDATE(),[StartDate],[EndDate],year(GETDATE()-[StartDate]) as starty,year([EndDate]-GETDATE()) as endy "
                      ." FROM [SocHarcumOnLine].[dbo].[Groups] where [groupID]=?";
            $params = array ($groupid);

            $sqlquery = sqlsrv_query( $conn, $sqlstr, $params);
            if( $sqlquery )
            {
                $st=0;
                $ed=0;
                while( $row = sqlsrv_fetch_array( $sqlquery, SQLSRV_FETCH_ASSOC) )
                {
                    $st=$row['starty'];
                    $ed=$row['endy'];
                }

                if ($st<1900) { $groupid=-4; }
                if ($ed<1900) { $groupid=-5; }
                sqlsrv_free_stmt( $sqlquery);
            }
        }
        sqlsrv_close( $conn);
    }
    return $groupid;
}

?>
