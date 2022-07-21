<?php
    header("Content-Type: application/json");      
    header("Access-Control-Allow-Origin: *");     
    header("Access-Control-Allow-Mehtods: GET");  
    header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,Content-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");
    
    include 'include/database.php';
    
    $sql = "SELECT * FROM student WHERE student.sclass ORDER BY sid ASC ";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0)
    {
        $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        echo json_encode(array("status"=> 1, "message"=> "Student Record Found Successfully!"));
        echo json_encode(array($output));
    }
    else
    {   
        echo json_encode(array('message' => 'No Record Found.', 'status' => 0));
    }
?>