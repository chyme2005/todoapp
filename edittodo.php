<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="todoapp2.css">
</head>
<body>
<?php
require("db.php");
$id=$_GET['id'];
// echo $id;
$select=" SELECT activity FROM `todoapp` WHERE id = '$id'";
$result=mysqli_query($conn,$select);
$row=mysqli_fetch_assoc($result);
//echo($row['activity']);
?>

<?php if($_SERVER['REQUEST_METHOD']=="POST"){
            if (empty($_POST['activity'])){
                $message="Field cannot be empty";
                
                header("Location:dashboard.php?mess=$message");
            }
            else{
               
                $activity=$_POST['activity'];
                
                $sql="INSERT INTO `todoApp` (activity)
                VALUES('$activity')";
                mysqli_query($conn,$sql);

                header('Location:dashboard.php?mess=success');
        }
    }
    ?>
    <div class="addsection">
<form action="<?php $_SERVER['PHP_SELF'];?>" method="">
<input type="text" name="" id="edit" value="<?php echo($row['activity'])?>">
    <button type="submit">EDIT &nbsp;<span>&harr;</span></button>
   
</form>
</div>


    
</body>
</html>
