<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Trackit Sign Up Page</title>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
        <script src="validation.js" defer></script>
        
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
          }
          .form-footer{
            text-align: center;
            padding-top: 20px;
          }
        </style>
    </head>

    <body>
        <h1>Bug Tracker Website</h1>
        <div class="form-container">
          <form action="addUser.php" id="signup" method="post" novalidate>
           
            <label for="username">Username:</label>
            <input id="username" type="text" name = "username">
            
            <label for="password">Password:</label>
            <input id="password" type="password" name = "password" required>
            
            <label for="passwordConfirm">Confirm Password:</label>
            <input id="passwordConfirm" type="password" name="passwordConfirm" required>
            
            <button>Sign Up</button>
          </form>
          
          <div class="form-footer">
            Already have an account? <a href="loginPage.php">Sign In</a>
          </div>
        </div>
        
    </body>
    <script>
        
    </script>
</html>
