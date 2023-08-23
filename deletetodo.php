<?php 
require("db.php");
//GET IS ALSO USED TO GET DATA SENT IN THE URL
$id=$_GET['id'];
echo($id);
$sql="DELETE FROM `todoApp` WHERE (id = $id)";
    //MYSQLI_QUERY IS USED TO PERFORM A GIVEN FUNCTION ON A DATABASE
    mysqli_query($conn,$sql);
    
     header('Location:dashboard.php?mess=success');
?>