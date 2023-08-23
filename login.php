<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQLForm</title>
    <link rel="stylesheet" href="style.css">
   
</head >

<body>
<?php 
require("db.php");
$fname=$lname=$uname=$email=$pword="";
//include 'form2action.php';
    $nameError="";
    $lnameError="";
    $UnameError="";
    $EmailError="";
    $PasswordError="";
    $successmessage="";
    //FOR INPUT VALIDATION
function validateInput($data){
    //REMOVE WHITESPACES
    $data =trim($data);
    //REMOVED \\ 
    $data=stripslashes($data);
    $data=str_replace('/',"",$data);
    //to convert all java script into normal text
    $data=htmlspecialchars($data);
    
    return $data;
}





if($_SERVER['REQUEST_METHOD']=="POST"){
      
   //ERROR FOR LAST NAME 

  //error for username
if (empty($_POST['loginname'])){
    $UnameError="Username is required";
}
 else{
    $uname=validateInput($_POST['loginname']);
 }
 

   if(empty($_POST['password'])){
    $PasswordError="password is required";
   }
   else{
    $pword=validateInput($_POST['password']);
   }
   //isset checks if variable is accepted
if(isset($_POST['password'])){
    //CHECKING FOR DUPLICATES
    $find="SELECT * FROM `login` WHERE (username='$uname')";
    $res=mysqli_query($conn,$find);
   // echo $res;
    if(mysqli_num_rows($res)>0){
        //CONVERTING RESULT TO AN ASSOCIATIVE ARRAY 
        $row=mysqli_fetch_assoc($res);
       
        if(password_verify($pword,$row['password'])){
              $successmessage="login successful";
               //SESSION BEGINS
               session_start();
               //SET VALUE OF A SESSION
                 $_SESSION['username']=$uname;
                
              //REDIRECT AFTER SUCCESSFUL LOGIN
              header('Location:dashboard.php');
              mysqli_close($conn);
              exit();
        }
       
        //THE ONLY OTHER POSSIBLE CONDITION FOR  if(mysqli_num_rows($res)
        //TO BE GREATER THAN 0 IS IF BOTH EXISTS
        else{
            $successmessage="INCORRECT PASSWORD";
        }
    }
    
 else{
   $successmessage="username does not exist";
    }


}
}

    


    ?>
     
    <form method='POST' action="<?php $_SERVER['PHP_SELF'];?>" class="form">
        <h1 class="title">LOG-IN</h1>

        <input type="text" value="" name="loginname"
         placeholder="username"class="logindetails">
        <p class="error"><?php echo $UnameError;?></p>
        <br/>
 
        <input type="password" value="" name="password" id="password1"
         placeholder="password"class="logindetails">
        <p class="error"><?php echo $PasswordError;?></p>
        <br/>

        <input type="submit" value="Login" class="loginbutton">
        <p class="success"><?php echo$successmessage; ?></p>
        <p class="link"><a href=signup.php>Click to sign-up</a></p>
    </form>
    
</body>
</html> 