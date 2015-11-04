<?php
/* include db.config.php */
include_once('db_Connection.php');

// Get user id
$id = isset($_GET['id']) ? mysql_real_escape_string($_GET['id']) :"";



//$select = sqlsrv_query($conn,'SELECT top 10 LecturerName COLLATE Cyrillic_General_CI_AI as LName FROM Lecturer');

$select=sqlsrv_query($conn,"Select Lecturer.lecturerid,LecturerSurname+' '+LecturerName+' '+LecturerlastName as LName, SocHarcumSchedule.SubjectID ,newSubjectName as SubjectName, SocScheduleWithGroups.ScheduleWithGroupsId,SocHarcumSchedule.ExamTypeId,0 as  mark  from SocHarcumSchedule  join SocScheduleWithGroups  on SocHarcumSchedule.ScheduleID =SocScheduleWithGroups.ScheduleID join Lecturer on SocScheduleWithGroups.LecturerID =Lecturer.LecturerID join SubjectNew on SocHarcumSchedule.SubjectID =SubjectNew.sbjAutoId where SocHarcumSchedule.AcadYear=8 and SocScheduleWithGroups.GroupID =21630");
$result = array();
while($data = sqlsrv_fetch_object($select)) {

$result[] = $data;
}

$data = array("result" => count($result),"data" => $result);



/* JSON Response */
header('Content-type: application/json');
echo json_encode($data);