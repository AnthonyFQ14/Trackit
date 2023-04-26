<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

mysqli_free_result($result);

$sql2 = "SELECT projects.*
         FROM projects
         JOIN user_projects ON projects.id = user_projects.projectId
         WHERE user_projects.userId = {$_SESSION["user_id"]};";
            
    $result = $mysqli->query($sql2);
    
    // Check if the query was successful
    if (!$result) {
      die("Query failed: " . mysqli_error($conn));
    }

//    // Loop through the result set and print out each project name and description
//    while ($row = mysqli_fetch_assoc($result)) {
//      echo "<h3>" . $row["projectName"] . "</h3>";
//      echo "<p>" . $row["description"] . "</p>";
//    }
//    die();
//    // Free up the result set
//    mysqli_free_result($result);


?>


<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Trackit Plus</title>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
        
        <style>
            body{
                font-family: sans-serif;
                text-align: center;
            }
            .topBar{
                position: absolute;
                width: 101.2%;
                height: 16%;
                overflow-x: hidden;
                top: -50px;
                left: -20px;
                background-color: #5CF777;
                z-index: 0;
                border-bottom: 5px solid black;
            }
            h1{
                color: black;
                position: relative;
                text-align: left;
                font-size: 70px;
                padding-bottom: 75px;
                height: 200px;
                padding-left: 20px;
                padding-top: 20px;
                top: 10px;
                left: 20px;
            }
            .projectForm{
                display: none;
                background-color: white;
                border-radius: 20px;
                box-shadow: 1px 2px 2px rgba(0,0,0,1.0);
                padding: 50px;
                text-align: left;
                top: 250px;
                width: 20%;
                position: absolute;
                right: 650px;
                z-index: 1;
            }
            input{
                font-size: 20px;
                padding: 10px;
                border-radius: 15px;
                border: 1px solid #ccc;
                width: 100%;
                margin-bottom: 25px;
            }
            .top-right{
                position: absolute;
                top: 35px;
                right: 25px;
            }
            .column {
                float: left;
                width: 24%;
                padding: 5px;
                text-align: center;
                z-index: 0;
            }
            .row {
                content: "";
                display: table;
                clear: both;
            }
            .card {
                height: 650px;
                box-shadow: 0px 0px 10px #ccc;
                background-color: cornflowerblue;
                padding: 20px;
                overflow-y: auto;
                border-radius: 10px;
            }
            br{
                color: black;
            }
            .projectTitle{
                position: absolute;
                font-weight: 600;
                font-size: 40px;
                position: sticky;
                height:120px;
                vertical-align: bottom;
                line-height: 200px;
                z-index: 1;
                background-color: lightgrey;
                bottom: 0;
                
                
            }
            .left-nav{
                position: absolute;
                top: 110px;
                left: 0;
                bottom: 95px;
                width: 200px;
                background-color: lightgrey;
                overflow-y: scroll;
                overflow-x: visible;
                text-align: center;
                padding-top: 20px;
                
            }
            .left-nav h2 {
                margin-top: -5px;
                margin-bottom: -18px; 
                border-bottom: 2px solid;
                padding-bottom: 10px;
                border-color: black;
            }
            .left-nav a{
                overflow: visible;
                display: block;
                font-size: 30px;
                color: black;
                padding: 20px;
                width: 160px;
                
                text-decoration: none;
                border-bottom: 1px solid grey;
            }
            .left-nav a:hover{
                background-color: grey;
                color: white;
            }
            .rowOfColumns{
                top: 100px;
                left: 218px;
                position: absolute;
                margin-left: auto;
                width: 87%;
                align-content: right;
                z-index: 0;
                
            }
            .logout{
                margin-left:10px;
                font-size: 25px;
                border-radius: 5px;
                background-color: white;
                border: none;
                border-style: none;
                font-weight: 500;
                padding-left: 10px;
                padding-right: 10px;
            }
            
            .logout:hover{
                transition: 0.5s ease;
                background-color: cornflowerblue; /* change background color on hover */
                box-shadow: 1px 2px 2px rgba(0,0,0,1.0);
            }
            .logout:focus {
                outline: none; /* remove focus outline */
            }
            
            .logoutLabel{
                font-size: 25px;
                font-weight: 600;
            }
            label {
                pointer-events: none;
            }
            
            .submit{
                display: block;
                margin: 0 auto;
                background-color: #5CF777;
                border-radius: 5px;
                border: none;
                border-style: none;
                font-size: 35px;
                font-weight: 500;
                padding-left: 20px;
                padding-right: 20px;
            }
            .submit:hover{
                transition: 0.5s ease;
                box-shadow: 1px 2px 2px rgba(0,0,0,1.0);
            }
            
            .cancelButton{
                display: block;
                margin: 0 auto;
                background-color: lightgray;
                border-radius: 5px;
                border-style: none;
                font-size: 20px;
                padding-left: 10px;
                padding-right: 10px;
                margin-top: 30px;
            }
            .cancelButton:hover{
                transition: 0.5s ease;
                box-shadow: 1px 2px 2px rgba(0,0,0,1.0);
            }
            .addTicket{
                position: absolute;
                bottom: 25px;
                right: 25px;
                background-color: #5CF777;
                color: black;
                font-weight: 600;
                padding: 10px 20px;
                border-radius: 5px;
                font-size: 20px;
                text-align: center;
                border: none;
                border-style: none;
            }
            .addTicket:hover{
                transition: 0.5s ease;
                background-color: cornflowerblue;
                box-shadow: 1px 2px 2px rgba(0,0,0,1.0);
            }
            .createProject{
                position: absolute;
                bottom: 25px;
                left: 375px;
                background-color: #5CF777;
                padding: 10px 20px;
                font-weight: 600;
                color: black;
                border-radius: 5px;
                font-size: 20px;
                text-align: center;
                border: none;
                border-style: none;
            }
            .createProject:hover{
                transition: 0.5s ease;
                background-color: cornflowerblue;
                box-shadow: 1px 2px 2px rgba(0,0,0,1.0);
            }
            
            .joinProject{
                position: absolute;
                color: black;
                text-align: center;
                bottom: 25px;
                left: 198px;
                background-color: #5CF777;
                font-weight: 600;
                padding: 10px 20px;
                padding-left: 30px;
                padding-right: 32px;
                border-radius: 5px;
                font-size: 20px;
                text-align: center;
                border: none;
                border-style: none;
            }
            
            .joinProject:hover{
                transition: 0.5s ease;
                background-color: cornflowerblue;
                box-shadow: 1px 2px 2px rgba(0,0,0,1.0);
            }
            
            .leaveProject{
                position: absolute;
                color: black;
                text-align: center;
                bottom: 25px;
                left: 5px;
                background-color: #5CF777;
                font-weight: 600;
                padding: 10px 20px;
                padding-left: 30px;
                padding-right: 32px;
                border-radius: 5px;
                font-size: 20px;
                text-align: center;
                border: none;
                border-style: none;
            }
            .leaveProject:hover{
                transition: 0.5s ease;
                background-color: red;
                box-shadow: 1px 2px 2px rgba(0,0,0,1.0);
            }
            
            .showProjectId{
                position: absolute;
                bottom: 0px;
                left: 220px;
            }
            
        
            .ticketForm{
                display: none;
                background-color: white;
                border-radius: 20px;
                box-shadow: 1px 2px 2px rgba(0,0,0,1.0);
                top: 250px;
                padding: 50px;
                text-align: left;
                width: 20%;
                position: absolute;
                right: 650px;
                z-index: 1;
            }
            
            .joinProjectForm{
                display: none;
                background-color: white;
                border-radius: 20px;
                box-shadow: 1px 2px 2px rgba(0,0,0,1.0);
                padding: 50px;
                top: 250px;
                text-align: left;
                width: 20%;
                position: absolute;
                right: 650px;
                z-index: 1;
            }
            
            .selected-project {
                background-color: white;
                font-weight: bold;
            }
            .break{
                background-color: black;
            }
            
            .ticket{
                display: block;
                position: relative;
                border-style: solid;
                text-decoration: none;
                padding: 10px;
                font-size: 20px;
                font-weight: 600;
                margin-bottom: 15px;
                color: black;
                border-color: black;
                border-radius: 5px;
                background-color: floralwhite;
            }
            .ticket:hover{
                transition: 0.3s ease;
                background-color: #5CF777;
                box-shadow: 1px 2px 2px rgba(0,0,0,1.0);
            }
            .error{
                position: fixed;
                text-align: center;
                left: 650px;
                top: 305px;
            }
            .ticketDisplay{
                display: none;
                position: absolute;
                height: 400px;
                width: 500px;
                left: 40%;
                top: 25%;
                box-shadow: 0px 0px 3px #000;
                background-color: mintcream;
                padding: 20px;
                overflow-y: auto;
                border-radius: 10px;
                z-index: 2;
            }
            .ticketDisplayName{
                margin-top: 0px;
                font-size: 40px;
            }
            .ticketCategory{
                font-size: 30px;
                margin-bottom: 50px;
            }
            .ticketDescription{
                font-size: 20px;
            }
            .statusButton{
                font-size: 30px;
            }
            .statusLabel{
                font-size: 20px;
            }
            
            .deleteTicket{
                margin-top: 20px;
                padding: 15px;
                border-radius: 5px;
                border: none;
                background-color: darkgrey;
                font-size: 18px;
                font-weight: 600;
            }
            .deleteTicket:hover{
                transition: 0.5s ease;
                background-color: red;
                box-shadow: 1px 2px 2px rgba(0,0,0,1.0);
            }
            
            .ticketCloseButton{
                margin-top: 15px;
                padding: 10px;
                border-radius: 5px;
                border: none;
                font-size: 15px;
                font-weight: 500;
            }
            .ticketCloseButton:hover{
                transition: 0.5s ease;
                background-color: cornflowerblue;
                box-shadow: 1px 2px 2px rgba(0,0,0,1.0);
            }
            
            .anchor-container {
                position: relative;
                display: inline-block;
                margin: 0;
                  padding: 0;
            }

            .tooltip {
                width: 400px;
                height: 75px;
                position: fixed;
                bottom: 100px;
                left: 420px;
                transform: translateX(-50%);
                background-color: #333;
                color: #fff;
                padding: 5px;
                font-size: 20px;
                border-radius: 5px;
                z-index: 1;
                display: none;
            }
            .tooltip::before {
                content: " ";
                position: fixed;
                transform: rotate(270deg);
                left: -22.5px;
                bottom: 31px;
                margin-left: -5px;
                color: #333;
                border-width: 14px;
                border-style: solid;
                border-color: transparent transparent #333 transparent;
            }

            .anchor-container:hover .tooltip {
                display: block;
            }
            
            .bottomBar{
                position: absolute;
                width: 101.2%;
                overflow-x: hidden;
                height: 90px;
                bottom: 0px;
                left: -20px;
                background-color: lightgray;
                z-index: -1;
                border-top: 5px solid black;
            }
            button{
                cursor: pointer;
                font-weight: bold;
            }
            .message{
                position: absolute;
                left: 270px;
                top: 300px;
                width: 1500px;
            }
        </style>
    </head>
    
    <body>
       <div class="topBar">
          <h1>Trackit Plus</h1>
      </div>
       
        <div class="top-right">
            <label class="logoutLabel" id="logoutLabel" for="logout">Welcome, User</label>
            <button class="logout" id="logout">Logout</button>
        </div>
       
        <?php if (isset($user)): ?>
            
            <script>
                document.getElementById("logoutLabel").textContent = "Welcome, <?= htmlspecialchars($user["username"]) ?>";
            </script>
            
        <?php else: ?>
            
            <script>
                window.location.href = "loginPage.php";
            </script>
<!--            <p><a href="loginPage.php">Log in</a> or <a href="signUpPage.php" >sign up</a></p>-->

        <?php endif; ?>
        
        
        
        
        <div class="left-nav">
            <h2 class="projectTitle">Projects</h2>
            <br>
            <?php foreach ($result as $project): ?>
                <div class="anchor-container">
                  <a href="setProjectId.php?id=<?= $project['id'] ?>" class="<?php if ($project['id'] == $_SESSION['projectId']) { echo 'selected-project'; } ?>" data-projectid= "<?= $project['id'] ?>">
                    <?= $project['projectName'] ?>
                    <span class="tooltip">
                      Project ID: <?= $project['id'] ?><br>
                      <?= $project['description'] ?>
                    </span>
                  </a>
                </div>
            <?php endforeach; ?>
        </div>
            
        <div class="message">
            <h1>Please Select, Create or Join a Project</h1>
        </div>
        
        
        <div class="projectForm">
            <form method="post" action="addProject.php">
                <label for="projectName">Project Name:</label>
                <input type="text" id="projectName" name="projectName" required>
                <br><br>
                
                <label for="projectDescription">Project Description:</label>
                <input type="text" id="projectDescription" name="projectDescription" required>
                <br><br>
                
                <button class="submit" type="submit">Submit</button>
            </form>
            <button id="cancelProject" class="cancelButton">Cancel</button>
        </div>
        
        
        <div class="joinProjectForm">
            <form id="joinForm" class="joinForm" method="post" action="joinProject.php">
                <label for="projectId">Please Enter the Project Id:</label>
                <input type="text" id="projectId" name="projectId" required>
                <p class="error"></p>
                <br><br>
                
                <button class="submit" type="submit">Submit</button>
                
            </form>
            <button id="cancelJoin" class="cancelButton">Cancel</button>
        </div>
        
        <button class="addTicket" id="addTicket">+ New Ticket</button>
        <button class="leaveProject" id="leaveProject">Leave Project</button>
        <button class="createProject" id="createProject">Create Project</button>
        <button class="joinProject" id="joinProject">Join Project</button>
        
        <div class="bottomBar"> <h1>hello</h1></div>
        
        <script>
            
            document.getElementById("logout").addEventListener("click", function() {
              window.location.href = "logout.php";
            });
            // Get the add project button and form
            const addProjectButton = document.querySelector(".createProject");
            const projectForm = document.querySelector(".projectForm");
            const addTicketButton = document.querySelector(".addTicket");
            const ticketForm = document.querySelector(".ticketForm");
            const joinProjectForm = document.querySelector(".joinProjectForm");
            const joinProjectButton = document.querySelector(".joinProject");
            

            // Hide the form when the cancel button is clicked
            const cancelJoin = document.getElementById("cancelJoin");
                cancelJoin.addEventListener("click", function() {
                
                joinProjectForm.style.display = "none";
            });

            // Show the form when the add project button is clicked
            addProjectButton.addEventListener("click", function() {
                projectForm.style.display = "block";
                projectForm.style.margin = "auto";
                
            });
            
            joinProjectButton.addEventListener("click", function() {
                joinProjectForm.style.display = "block";
                joinProjectForm.style.margin = "auto";

            });
            
            // Hide the form when the cancel button is clicked
            const cancelProject = document.getElementById("cancelProject");
                cancelProject.addEventListener("click", function() {
                
                projectForm.style.display = "none";
            
            });
            
            const validation = new JustValidate("#joinForm", {
                
                errorsContainer: document.querySelector('.error')
            });
            
            var userId = "<?php echo($_SESSION['user_id']); ?>";

            validation
                .addField("#projectId",[
                    {
                        rule: "required",
                        errorMessage: "Please enter a project ID"
                    },
                    {
                        rule: "integer",
                        errorMessage: "Please enter a valid integer"
                    },
                    {
                        validator: (value) => () => {
                            return fetch("validateProjectId.php?projectId=" + encodeURIComponent(value))
                                .then(function(response){
                                    return response.json();
                                })
                                .then(function(json){
                                    return json.valid;
                                });
                        },
                        errorMessage: "Invalid Project Id"
                    },
                    {
                        validator: (value) => () => {
                            return fetch("validateAlreadyJoined.php?userId="+ userId +"&projectId=" + encodeURIComponent(value))
                                .then(function(response){
                                    return response.json();
                                })
                                .then(function(json){
                                    if(json.isJoined){
                                        return false;
                                    }
                                    else{
                                        return true;
                                    }
                                    return json.notJoined;
                                });
                        },
                        errorMessage: "You are already a member of this project"
                    }
                ])
                .onSuccess((event) => {
                    document.getElementById("joinForm").submit();
                });
        </script>
        
    </body>
    
</html>
