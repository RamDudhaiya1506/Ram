<?php
header("Content-Type: application/json"); 
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Mehtods: DELETE");
header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,Content-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");

$data=json_decode(file_get_contents("php://input"),TRUE); 

include "include/database.php";

$id = $_POST['sid'];

$sql="SELECT * FROM student WHERE sid = '$id'";
$result=mysqli_query($conn,$sql);

if(mysqli_num_rows($result) > 0)
{
	$sql1="DELETE FROM student WHERE sid = '$id'";
	$result1 = mysqli_query($conn, $sql1);
	if($result1 == 1)
	{
	 	echo json_encode(array("status"=> 1, "message"=> "Record Deleted")); 
    }
	else
	{
		echo json_encode(array("status"=> 0, "message"=> "Record Not Deleted"));
	}
}
else
{
	echo json_encode(array("status"=> 0, "message"=> "Record Does Not Exist"));
}
?>