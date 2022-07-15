<?php 
    include 'includes/config.php';
    include 'includes/session.php';
    include 'includes/header.php';

    if(isset($_POST['updateprofile']))
    {
        $stu_id = $_POST['sid'];
        $stu_name = $_POST['sname'];
        $stu_address = $_POST['saddress'];
        $stu_class = $_POST['sclass'];
        $stu_phone = $_POST['sphone'];   
        $targetDir = "image/";
        $time = date("d-m-Y")."-".time();
        $fileName = basename($_FILES['filename']['name']);
        $fileName = $time."-".$fileName ;
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        $allowTypes = array('jpg','png','jpeg','gif','pdf');

        if(in_array($fileType, $allowTypes))
        {
            if(move_uploaded_file($_FILES["filename"]["tmp_name"], $targetFilePath))
            {
                $sql = "UPDATE student SET sname='$stu_name', saddress='$stu_address', sclass='$stu_class', sphone='$stu_phone', filename='$fileName' WHERE sid='$stu_id'";
                $result = mysqli_query($conn, $sql);
            
                //header("Location: index.php");
            }
        }
    }
?>
<head>
    <style>
        .image{
            display:flex;
            justify-content: flex-end;
            
        }
        .image > img{
            border: 1px solid #333;
        }
    </style>
</head>
<div id="main-content">
    <h2>Update Record</h2>
    <form class="post-form" action="view.php" method="post" enctype="multipart/form-data">
    <?php 
        $stu_id = $_GET['id'];
        $query = "SELECT * FROM student WHERE sid='$stu_id'";
        $showresult = mysqli_query($conn, $query) or die("Query unsuccessful.");

        if(mysqli_num_rows($showresult) > 0) 
        {
            while($row = mysqli_fetch_assoc($showresult))
            {
    ?>
    <div class="image">
        <figure>
                <img src="./image/<?php echo $row['filename'];?>"  max-width="120" height="120">
        </figure>
            </div><br>
    <div class="form-group my-3">
          <label>Name</label>
          <input type="hidden" name="sid" value="<?php echo $row['sid']; ?>"/>
          <input type="text" name="sname" placeholder="Full Name" value="<?php echo $row['sname']; ?>"/>
      </div>
      <div class="form-group">
          <label>Address</label>
          <input type="text" name="saddress" placeholder="Address" value="<?php echo $row['saddress']; ?>"/>
      </div>
      <div class="form-group">
          <label>Class</label>
          <?php
            $sql1 = "SELECT * FROM studentclass";
            $result1 = mysqli_query($conn, $sql1) or die("Query unsuccessful.");

        if(mysqli_num_rows($result1) > 0) 
        {
            echo '<select name="sclass">';
            while($row1 = mysqli_fetch_assoc($result1))
            {
                if($row['sclass'] == $row1['cid'])
                {
                    $select = "selected";
                }
                else
                {
                    $select = "";
                }
            echo "<option {$select} value='{$row1['cid']}'>{$row1['cname']}</option>";
            }
         echo "</select>";
        }
          ?>
      </div>
      <div class="form-group">
          <label>Phone</label>
          <input type="text" name="sphone" placeholder="Phone Number" value="<?php echo $row['sphone']; ?>" maxlength="10"/>
      </div>
      <div style="margin: 0 0 15px; display: flex; flex-direction: row; justify-content: space-between;">
      <div>
      <lable style="font-weight: bold;">Image</lable>
      </div>      
            <input type="file" name="filename" value="" />
      </div>
      <input class="submit" type="submit" name="updateprofile" value="Update"/>
    </form>
    <?php
        }
    }
    ?>
</div>
</div>
</body>
</html>
