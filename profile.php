<?php
    include 'includes/session.php';
    include 'includes/config.php';
    
    if(isset($_POST['updateprofile']))
    {
        $name=$_POST['name'];
        $mobile=$_POST['mobile'];
        $dob=$_POST['dob'];
        $address=$_POST['useraddress'];
        $city=$_POST['city'];
        $country=$_POST['country']; 
        $email=$_SESSION['email'];
        $targetDir = "image/";
        $time = date("d-m-Y")."-".time();
        $fileName = basename($_FILES['file']['name']);
        $fileName = $time."-".$fileName ;
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        $allowTypes = array('jpg','png','jpeg','gif','pdf');

        if(in_array($fileType, $allowTypes)){
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
        $sql = "UPDATE user SET fullname='$name', mobile='$mobile', dob='$dob', useraddress='$address', city='$city', country='$country', filename='$fileName' WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if($result)
        {
            echo "
            <script>
                alert('Profile Updated Successfully!');
                window.location.href='index.php';
            </script>
            ";
        }
        else
        {
            echo "
            <script>
                alert('Something Went Wrong! Please try again.');
            </script>
            ";
        }
    }
}
    }

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        body{
            background-color: #bfcdd2;
        }
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
        .image{
            display:flex;
            justify-content: center;
            
        }
        .image > img{
            border: 1px solid #000;
        }
       
    </style>
    <title>Login</title>
  </head>
  <body>
    <div class="wrapper">
    <div class="container-fluid">
    <div class="row">
    <div class="col-md-12">
    <div class="container my-3">
            <h2 class="text-center">PROFILE</h2>
            <form action="profile.php" method="post" enctype="multipart/form-data">
            <?php
                $useremail = $_SESSION['email'];
                $result = mysqli_query($conn, "SELECT * FROM user WHERE email='$useremail'"); 
                if(mysqli_num_rows($result) > 0) 
                {
                    while($row = mysqli_fetch_assoc($result))
                    {
            ?>
            <div class="image">
                    <img src="./image/<?php echo $row['filename'];?>"  width="120" height="120" alt="">
            </div>
            <div class="form-group my-3">
                <label class="control-label">Full Name</label>
                <input type="text" maxlength="30" class="form-control" placeholder="Full Name" id="name" name="name" value="<?php echo $row['fullname'];?>" required="true">
            </div>
            <div class="form-group">
                <label class="control-label">Email</label>
                <input type="email" maxlength="30" class="form-control" placeholder="Email" id="email" name="email" value="<?php echo $row['email'];?>" aria-describedby="emailHelp" readonly="true">
            </div>
            <div class="form-group">
                <label class="control-label">Mobile Number</label>
                <input type="text" maxlength="10" class="form-control" placeholder="Your Number" id="mobile" name="mobile" value="<?php echo $row['mobile'];?>" required="true">
            </div>
            <div class="form-group">
                <label class="control-label">Date of Birth&nbsp;(mm/dd/yyyy)</label>
                <input type="date" class="form-control" name="dob" placeholder="mm/dd/yyyy" id="birth-date" value="<?php echo $row['dob'];?>">
            </div>
            <div class="form-group">
                <label class="control-label">Address</label>
                <input type="text" class="form-control" name="useraddress" placeholder="address" id="useraddress" value="<?php echo $row['useraddress'];?>">
            </div>
            <div class="form-group">
                <label class="control-label">City</label>
                <input type="text" class="form-control" placeholder="City" id="city" name="city" value="<?php echo $row['city'];?>" required="true">
            </div>
            <div class="form-group">
                <label class="control-label">Country</label>
                <input type="text" class="form-control" placeholder="Country" id="country" name="country" value="<?php echo $row['country'];?>" required="true">
            </div>
            <div class="form-group ">
                <label class="control-label" style="color: #000;">Create Date - <?php echo $row['create date'];?></label>
            </div>
            <div class="form-group">
                <label class="control-label" style="color: #000;">Update Date - <?php echo $row['update date'];?></label>
            </div>
            <div class="form-group">
                <input class="" type="file" name="file" value=""/>
            </div>
            
            <?php
                }
            }
            ?>
            <div class="form-group">
                <button type="submit" name="updateprofile" class="btn btn-primary">Update<span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
                <a href='index.php' class='btn btn-primary'>Back</a>
            </div>
        </form>
    </div>
    </div>
    </div>        
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>