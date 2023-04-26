<?php 

    $is_invalid = false;

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        
        $mysqli = require __DIR__ . "/database.php";
        
        $sql = sprintf("SELECT * FROM users
                    WHERE username = '%s'",
                   $mysqli->real_escape_string($_POST["username"]));
    
        $result = $mysqli->query($sql);

        $user = $result->fetch_assoc();
        
        if($user){
            
            if(password_verify($_POST["password"], $user["password"])){
                
                session_start();
                
                session_regenerate_id();
                
                $_SESSION["user_id"] = $user["id"];
                
                $_SESSION["projectId"] = 0;
                
                header("Location: landingPage.php");
                exit;
            }
            
        }
        
        $is_invalid = true;
    }
?>


<!DOCTYPE HTML>
<html>
   <head>
       <meta charset="utf-8">
       <title>Trackit Login Page</title>
       
       <style>
           body{
               font-family: sans-serif;
               background-color: #f2f2f2;
               text-align: center;
           }
           h1{
            font-size: 50px;
            padding-bottom: 50px;
          }
          .form-container{
            display: inline-block;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0px 0px 10px #ccc;
            padding: 50px;
            width: 500px;
            text-align: left;
          }
          label{
            font-size: 25px;
            padding-bottom: 10px;
            display: block;
          }
          input{
            font-size: 20px;
            padding: 10px;
            border-radius: 15px;
            border: 1px solid #ccc;
            width: 100%;
            
            margin-bottom: 25px;
          }
          button{
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border-radius: 15px;
            border: none;
            cursor: pointer;
            font-size: 20px;
            width: 100%;
            margin-top: 20px;
          }
          .form-footer{
            text-align: center;
            padding-top: 20px;
          }
          em{
            
              position: absolute;
              left: 785px;
              top: 435px;
              font-size: 20px;
              color: red;
              text-align: center;
              
         }
        </style>
  </head>
  <body>
   
   <h1>Bug Tracker Website</h1>
   
   <div class="form-container">
     
      <form method="post">
       
        <label for="username">Username:</label>
        <input id="username" value="<?= htmlspecialchars  ($_POST["username"] ?? "") ?>" type="text" name="username" required>
        
        <label for="password">Password:</label>
        <input id="password" type="password" name="password" required>
        
        <?php if($is_invalid): ?>
           <em>Invalid Login</em>
        <?php endif; ?>
        
        <button type="submit">Login</button>
        
      </form>
      
      <div class="form-footer">
        Not a member yet? <a href="signUpPage.php">Sign Up</a>
      </div>
      
    </div>
    
  </body>
  
</html>
