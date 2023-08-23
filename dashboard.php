<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="todoapp2.css">
</head>
<body>
    
    <?php 
    session_start();
    $uname=$_SESSION['username'];
    echo ("<h1 class='greeting'> Hello $uname</h1>");
    $message="";

    if(isset($_GET['mess'])){
        $message=$_GET['mess'];
    } 
    
    

    ?>
    <div class="mainsection">
        <div class="addsection">
            <form method='POST' action="addtodo.php">
                <input type=text name="activity" placeholder="activities">
                <button type="submit">Add &nbsp;<span>&#43;</span></button>

            </form>
            <p class="message">
                <?php echo $message;?>
            </p>
        </div>
            <div class="todosection">
                <?php
                  require ("db.php");
                  $sql="SELECT * FROM `todoapp` WHERE(user ='$uname') ";
                  $result=mysqli_query($conn,$sql);
                  //NUMBER OF ROWS RETURNED FROM THE QUERY 
                  if (mysqli_num_rows($result) <= 0){?>
                         <div class="empty">
                        <img src="todoImg.PNG">
                        </div>
                        <?php   }

                  else{
                    //FETCES AS AN ASSOCIATIVE ARRAY
                    while( $row=mysqli_fetch_assoc($result)){
                        //PRINTING OUT THE RESULT IN KEY VALUE PAIR
                        // foreach($row as $key => $val){
                        //     echo ("key =" .$key .", value = ".$val);
                        //     echo ("</br>");
                        // }
                         if($row['completed']){?>
                            <div class=todoitem>
                            <input type="checkbox" name="completed" checked> 
                            <h2 style ="color:fff; text-decoration:line-through"><?php echo $row['activity']?></h2>
                            <!-- GETTING THE ID TO PRINT IN THE DELETETODO URL
                                 WHICH COULD LATER BE RETRIEVED USING THE GET SUPERGLOBAL -->
                                 <div class = "links">
                                <a href="edittodo.php?id=<?php echo $row['id']?>"class = "edittodo"><span >E</span></a>
                           <a href="deletetodo.php?id=<?php echo $row['id']?>"class = "removetodo"><span >X</span></a> <br/>
                         </div>
                            <small><?php echo("created : ". $row['dateTime'])?></small>
                       </div>

                       <?php 
                         }

                        else{?>
                            
                     <div class=todoitem>
                     <input type="checkbox" name="completed" > 
                     <h2><?php echo $row['activity']?></h2>
                     <!-- GETTING THE ID TO PRINT IN THE DELETETODO URL
                      WHICH COULD LATER BE RETRIEVED USING THE GET SUPERGLOBAL -->
                      <div class = "links">
                                <a href="edittodo.php?id=<?php echo $row['id']?>"class = "edittodo"><span >E</span></a>
                           <a href="deletetodo.php?id=<?php echo $row['id']?>"class = "removetodo"><span >X</span></a> <br/>
                         </div>
                     <small><?php echo("created : ". $row['dateTime'])?></small>
                    </div>

                       <?php }
                  
                  
                 
                  }
                }
             
                 ?>


            </div>
    </div>
    </body> 
</html>
