<?php 
    include 'includes/config.php';
    include 'includes/session.php';
    include 'includes/header.php';
    
    if(isset($_POST['insert']))
    {
    $stu_name = $_POST['sname'];
    $stu_address = $_POST['saddress'];
    $stu_class = $_POST['class'];
    $stu_phone = $_POST['sphone'];
    $targetDir = "image/";
    $fileName = basename($_FILES['filename']['name']);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
 
    if(in_array($fileType, $allowTypes))
    {
        if(move_uploaded_file($_FILES["filename"]["tmp_name"], $targetFilePath))
        {
            $sql = "INSERT INTO student(sname, saddress, sclass, sphone, filename, createdate)
            VALUES('{$stu_name}', '{$stu_address}', '{$stu_class}', '{$stu_phone}', '{$fileName}', current_timestamp())";
            $result = mysqli_query($conn, $sql) or die("Query unsuccessful.");

            header("Location: index.php");
        }
    }
}
?>


<div id="main-content">
    <h2>Add New Record</h2>
    <form class="post-form" action="insert.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="sname" placeholder="Full Name"/>
        </div>
        <div class="form-group">
            <label>Address</label>
            <input type="text" name="saddress" placeholder="Address" />
        </div>
        <div class="form-group">
            <label>Class</label>
            <select name="class">
                <option value="" selected disabled>Select Class</option>
                <?php
                    include 'includes/config.php';

                    $sql = "SELECT * FROM studentclass";
                    $result = mysqli_query($conn, $sql) or die("Query unsuccessful.");

                    while($row = mysqli_fetch_assoc($result))
                    {
                ?>
                <option value="<?php echo $row['cid']; ?>"><?php echo $row['cname']; ?></option>
                <?php } ?>
                    </select>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="sphone" placeholder="Phone Number" maxlength="10"/>
        </div>
        <div style="margin: 0 0 15px; display: flex; flex-direction: row; justify-content: space-between;">
        <div>
        <lable style="font-weight: bold;">Image</lable>
        </div>      
            <input type="file" name="filename" value="" />
        </div>
        <input class="submit" type="submit" name="insert" value="Save"/>
    </form>
</div>
</div>
</body>
</html>
