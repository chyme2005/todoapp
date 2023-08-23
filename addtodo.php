 <?php
 session_start();
 $uname=$_SESSION['username'];
 
        require ("db.php");
         if($_SERVER['REQUEST_METHOD']=="POST"){
            if (empty($_POST['activity'])){
                $message="Field cannot be empty";
                
                header("Location:dashboard.php?mess=$message");
            }
            else{
                echo date_default_timezone_set("Africa/Lagos");

                $date=date("d/m/Y h:i:sa");
                echo $date;
                $activity=$_POST['activity'];
                
                $sql="INSERT INTO `todoApp` (user,activity,dateTime)
                VALUES('$uname','$activity','$date')";
                mysqli_query($conn,$sql);

                header('Location:dashboard.php?mess=success');
        }
    }
  ?>
