<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDoApp</title>
    <link rel="stylesheet" href="style.css">
   
</head >

<body>
<?php 
require("db.php");
$fname=$lname=$uname=$email=$pword=$pword2="";
$successmessage="";
//include 'form2action.php';
    $nameError="";
    $lnameError="";
    $UnameError="";
    $EmailError="";
    $PasswordError="";
    $Password2Error="";
    //FOR INPUT VALIDATION
function validateInput($data){
    //REMOVE WHITESPACES
    $data =trim($data);
    //REMOVED \\ 
    $data=stripslashes($data);
    //
    $data=str_replace('/',"",$data);
    //to convert all java script into normal text
    $data=htmlspecialchars($data);
    
    return $data;
}



//requestr method returns the type of request being processsed

if($_SERVER['REQUEST_METHOD']=="POST"){
    if (empty($_POST['firstname'])){
        $nameError="name is required";
    }
    else{
       $fname=validateInput($_POST['firstname']);
    }
   
    
   //ERROR FOR LAST NAME 
if (empty($_POST['lastname'])){
    $lnameError="lastname is required";
}
else{
    $lname=validateInput($_POST['lastname']);
}
  //error for username
if (empty($_POST['loginname'])){
    $UnameError="Username is required";
}
 else{
    $uname=validateInput($_POST['loginname']);
 }
 if (empty($_POST['email'])){
    $EmailError="Email is required";
 }
 else{
    $email=validateInput($_POST['email']);
 }


    
   if(empty($_POST['password'])){
    $PasswordError="password is required";
   }
   else if(strlen($_POST['password'])<7){
    $PasswordError="A minimum of 7 characters is required";
   }
   else if(preg_match("/[a-z]/i", $_POST['password'])==0){
    $PasswordError="Password must contain at least one letter \"A-Z\".";

   }
   else if(preg_match("/[0-9]/", $_POST['password'])==0){
    $PasswordError="Password must contain at least one number \"0-9\".";

   }
   else{
    $pword=validateInput($_POST['password']);
   }


//
   if($_POST['password'] != $_POST['password2']){
    $Password2Error="Passwords do not match";
    
}
    else{
    $pword2= $_POST['password2'];

} 

if(isset($_POST['password2'])){

    //CHECKING FOR DUPLICATES
    $find="SELECT * FROM `userlogin` WHERE (username='$uname'OR email='$email')";
    $res=mysqli_query($conn,$find);
    //CHECKING WHETHER NUMBER OF RETURNED ROWS IS GREATER THAN 0 MEANING THERS A DUPLICATE
    if(mysqli_num_rows($res)>0){
        //CONVERTING RESULT TO AN ASSOCIATIVE ARRAY 
        $row=mysqli_fetch_assoc($res);
        if(($row['email']==$email)and($row['username']!=$uname) ){
              $successmessage="email already exists";
        }
        elseif(($row['email']!=$email)and($row['username']==$uname) ){
            $successmessage="username already exists";
        }
        //THE ONLY OTHER POSSIBLE CONDITION FOR  if(mysqli_num_rows($res)
        //TO BE GREATER THAN 0 IS IF BOTH EXISTS
        else{
            $successmessage="username and email already exist";
        }
    }
    //insert into db
    else{
        //Hashing password
        $pwordhash=password_hash($pword2,PASSWORD_DEFAULT);
        $sql="INSERT INTO `login` (firstname,lastname,username,email,password)
        VALUES('$fname','$lname','$uname','$email','$pwordhash')";
      
          if(mysqli_query($conn,$sql)){
              $successmessage="account created successfully";
              //SESSION BEGINS
              session_start();
              //SET VALUE OF A SESSION
                $_SESSION['username']=$uname;
               
              //REDIRECT TO DASHBOARD PAGE
         header("Location:dashboard.php");
            exit();
          }
          else{
              $successmessage="error in creating account";
          }
      }
    }


}  

    ?>
     
    <form method='POST' action="<?php $_SERVER['PHP_SELF'];?>" class="form">
        <h1 class="title">SIGN UP</h1>
        
        <input type="text" value="" name="firstname" 
        placeholder="firstname" class="logindetails">
        <p class="error"><?php echo $nameError;?></p>
        <br/>

        
        <input type="text" value="" name="lastname"
         placeholder="lastname" class="logindetails">
        <p class="error"><?php echo $lnameError;?></p>
        <br/>

        <input type="text" value="" name="loginname"
         placeholder="username"class="logindetails">
        <p class="error"><?php echo $UnameError;?></p>
        <br/>

        <input type="email" value="" name="email" 
        placeholder="email@gmail.com"class="logindetails">
        <p class="error"><?php echo $EmailError;?></p>
        <br/>


        
        <input type="password" value="" name="password" id="password"
         placeholder="password"class="logindetails">
        <p class="error"><?php echo $PasswordError;?></p>
        <br/>

        <input type="password" value="" name="password2" id="Retype Password"
         placeholder="Confirm Password"class="logindetails">
        <p class="error"><?php echo $Password2Error;?></p>
        <br/>
       
        <input type="submit" value="Register" class="loginbutton">
        <p class="success"><?php echo$successmessage; ?></p>
        <p class="link"><a href=login.php>Click to login</a></p>
       
    </form>
    
</body>
</html> 