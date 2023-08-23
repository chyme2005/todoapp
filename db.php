<?php
$server="localhost";
//priviledges  root
$user1="root";
$password="";
$db="tododb";

//CREATE A CONNECTION
$conn= mysqli_connect($server,$user1,$password,$db);
//CHECK THE CONNECTION
if(!$conn){
    echo"connection failed";
    die("connection failed".mysqli_connect_error()); 
}
// else{
//     echo "connection successful";
//     //TO CLOSE CONNECTION
//     mysqli_close($conn);
// }