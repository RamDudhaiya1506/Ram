<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true)
{
    header("location: login.php");
    exit;
}
?>
<?php

include 'includes/header.php';
?>
<div id="main-content">
    <h2>All Records</h2>
    <?php
        include 'includes/config.php';

        $limit = 8;
        if (isset($_REQUEST["page"])) 
        {
            $page_number = $_REQUEST["page"]; 
        } 
        else
        { 
            $page_number=1;
        };  
        $start_from = ($page_number-1) * $limit;  

        $sql = "SELECT * FROM student JOIN studentclass WHERE student.sclass = studentclass.cid ORDER BY sid ASC LIMIT $start_from, $limit";
        $result = mysqli_query($conn, $sql) or die("Query unsuccessful.");

        if(mysqli_num_rows($result) > 0) 
        {

    ?>
    <?php
        if(isset($_GET['delete_id']))
        {
            $sql_query="DELETE FROM student WHERE sid=".$_GET['delete_id'];
            mysqli_query($conn,$sql_query);
            header("Location: index.php");
        }
    ?>
    <head>
    <script type="text/javascript">
    function delete_id(sid)
    {
	    if(confirm('Are You Sure! You Want to Delete This Record?'))
	{
		window.location.href='index.php?delete_id='+sid;
	}
}
</script>
    </head>
    <table cellpadding="8px">
        <thead>
        <th>Id</th>
        <th>Name</th>
        <th>Address</th>
        <th>Class</th>
        <th>Phone</th>
        <th>Image</th>
        <th>Action</th>
        </thead>
        <tbody>
            <?php
                while($row = mysqli_fetch_assoc($result))
                {
            ?>
            <tr>
                <td><?php echo $row['sid']; ?></td>
                <td><?php echo $row['sname'];?></td> 
                <td><?php echo $row['saddress'];?></td>
                <td><?php echo $row['cname'];?></td>
                <td><?php echo $row['sphone'];?></td>
                <td>
                    <figure>
                        <img src="./image/<?php echo $row['filename'];?>"  width="100" height="90">
                    </figure>
                </td>
                <td>
                    <a href='view.php?id=<?php echo $row['sid']; ?>'>View</a>
                    <a href="javascript:delete_id(<?php echo $row['sid']; ?>)">Delete</a>
                </td>
            </tr>
            <?php } ?>
</tbody>

    </table>
            <?php } 
            $sql1 = "SELECT COUNT(sid) FROM student";
            $result_db = mysqli_query($conn,$sql1); 
            $row_db = mysqli_fetch_row($result_db);  
            $total_records = $row_db[0];  
            $total_pages = ceil($total_records / $limit); 
            $pageURL = "";    
            echo '<ul class="pagination">';           
            if($page_number>=2){  
                echo "<a href='index.php?page=".($page_number-1)."'>  Prev </a>";   
            }                          
            for ($i=1; $i<=$total_pages; $i++) 
            {   
                if ($i == $page_number) 
                {   
                    $pageURL .= "<a class = 'active' href='index.php?page="  
                                                    .$i."'>".$i." </a>";   
                }               
                else  
                {   
                    $pageURL .= "<a href='index.php?page=".$i."'>   
                                                    ".$i." </a>";     
                }   
            };     
            echo $pageURL;    
            if($page_number<$total_pages)
            {   
                echo "<a href='index.php?page=".($page_number+1)."'>  Next </a>"; 
                echo '</ul>';  
            } 
            mysqli_close($conn);
            ?>    
            
</div>
</div>
</body>
</html>
