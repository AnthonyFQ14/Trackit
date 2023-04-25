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
            h1{
                text-align: left;
                font-size: 50px;
                padding-bottom: 75px;
                padding-left: 20px;
            }
            
            .top-right{
                position: absolute;
                top: 53px;
                right: 25px;
            }
            br{
                color: black;
            }
            .projectTitle{

                font-weight: 600;
                font-size: 35px;
                
            }
            .left-nav{
                position: absolute;
                top: 120px;
                left: 0;
                bottom: 0;
                width: 200px;
                background-color: lightgrey;
                text-align: center;
                padding-top: 20px;
                
            }
            .left-nav h2 {
                margin-top: -5px;
                margin-bottom: 0px; 
                border-bottom: 2px solid;
                padding-bottom: 10px;
                border-color: black;
            }
            .left-nav a{
                
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
            
            .logout{
                margin-left:20px;
                font-size: 25px;
                border-radius: 8px;
                background-color: lightgray;
                border: none;
                border-style: none;
                font-weight: 500;
                padding-left: 10px;
                padding-right: 10px;
            }
            .logout:hover{
                transition: 0.5s ease;
                background-color: cornflowerblue; /* change background color on hover */
                box-shadow: 0 2px 4px rgba(0, 0, 0, 1.8); /* add box shadow */
            }
            .logout:focus {
                outline: none; /* remove focus outline */
            }
            
            .logoutLabel{
                font-size: 25px;
            }
            label{
              pointer-events: none;
            }
            
            input{
                font-size: 20px;
                padding: 10px;
                border-radius: 15px;
                border: 1px solid #ccc;
                width: 100%;
                margin-bottom: 25px;
            }
            
            .message{
                position: absolute;
                left: 450px;
                top: 300px;
            }
            
            .addTicket{
                position: absolute;
                bottom: 25px;
                right: 25px;
                background-color: #5CF777;
                color: black;
                font-weight: 600;
                padding: 10px 20px;
                border-radius: 10px;
                font-size: 20px;
                text-align: center;
                border: none;
                border-style: none;
            }
            .addTicket:hover{
                transition: 0.5s ease;
                background-color: cornflowerblue;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 1.8); /* add box shadow */
            }
            
            
            .createProject{
                position: absolute;
                bottom: 25px;
                left: 14px;
                background-color: mintcream;
                padding: 10px 20px;
                font-weight: 600;
                color: black;
                border-radius: 10px;
                font-size: 20px;
                text-align: center;
                border: none;
                border-style: none;
            }
            .createProject:hover{
                transition: 0.5s ease;
                background-color: cornflowerblue;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 1.8); /* add box shadow */
            }
            
            
            .joinProject{
                position: absolute;
                color: black;
                text-align: center;
                bottom: 80px;
                left: 14px;
                background-color: #5CF777;
                font-weight: 600;
                padding: 10px 20px;
                padding-left: 30px;
                padding-right: 32px;
                border-radius: 10px;
                font-size: 20px;
                text-align: center;
                border: none;
                border-style: none;
            }
            .joinProject:hover{
                transition: 0.5s ease;
                background-color: cornflowerblue;
                box-shadow: 0 2px 4px rgba(50, 50, 0, 1.8); /* add box shadow */
            }
            
            
            .showProjectId{
                position: absolute;
                bottom: 0px;
                left: 220px;
            }
            
            /* Tooltip container */
            .tooltip {
                
                position: relative;
                display: inline-block;
            }

            /* Tooltip text */
            .tooltip .tooltiptext {
                visibility: hidden;
                width: 200px;
                height: 75px;
                background-color: black;
                color: #fff;
                text-align: center;
                border-radius: 6px;
                padding: 5px;
                position: absolute;
                z-index: 1;
                top: 12px;
                left: 108%;
            }

            /* Tooltip arrow */
            .tooltip .tooltiptext::before {
                content: " ";
                position: absolute;
                transform: rotate(270deg);
                left: -11%;
                top: 28%;
                margin-left: -5px;
                border-width: 14px;
                border-style: solid;
                border-color: transparent transparent black transparent;
            }

            /* Show the tooltip text when you mouse over the tooltip container */
            .tooltip:hover .tooltiptext {
                visibility: visible;
            }
            
            .submit{
                display: block;
                margin: 0 auto;
                background-color: lightgreen;
                border-radius: 10px;
                border: none;
                border-style: none;
                font-size: 35px;
                padding-left: 20px;
                padding-right: 20px;
            }
            .submit:hover{
                transition: 0.5s ease;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 1.8); /* add box shadow */
            }
            
            .cancelButton{
                display: block;
                margin: 0 auto;
                background-color: lightgray;
                border-radius: 10px;
                border-style: none;
                font-size: 20px;
                padding-left: 10px;
                padding-right: 10px;
                margin-top: 30px;
            }
            .cancelButton:hover{
                transition: 0.5s ease;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 1.8); /* add box shadow */
            }
            
            .projectForm{
                display: none;
                background-color: white;
                border-radius: 20px;
                box-shadow: 0px 0px 10px #ccc;
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
                box-shadow: 0px 0px 10px #ccc;
                padding: 50px;
                text-align: left;
                width: 20%;
                position: absolute;
                right: 650px;
                z-index: 1;
            }
            .error{
                position: fixed;
                text-align: center;
                left: 650px;
                top: 305px;
            }
            
            
            
        </style>
    </head>
    
    <body>
       <h1>Trackit Plus</h1>
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

        <?php endif; ?>
        
        
<!--
         <div class="left-nav">
          <?php foreach ($result as $project): ?>
            <a href="#" class="project-link" data-tooltip="<?= $project['description'] ?>">
              <?= $project['projectName'] ?>
            </a>
          <?php endforeach; ?>
        </div>
-->
        
        <div class="left-nav">
         <h2 class="projectTitle">Projects</h2>
          <?php foreach ($result as $project): ?>
            <div class="tooltip">
              <a href="setProjectId.php?id=<?= $project['id'] ?>" class="project-link" data-projectid= "<?= $project['id'] ?>">
                <?= $project['projectName'] ?>
              </a>
              <span class="tooltiptext"><?= $project['description'] ?></span>
            </div>
          <?php endforeach; ?>
        </div>
        
        
        <div class="message">
            <h1>Please Select, Create or Join a Project</h1>
        </div>
        
        <!-- Add Project Form -->
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
            <form id="joinForm" class="joinForm" method="post" action="joinProject.php" novalidate>
                <label for="projectId">Please Enter the Project Id:</label>
                <input type="text" id="projectId" name="projectId">
                <p class="error"></p>
                <br><br>
                
                <button class="submit" type="submit">Submit</button>
            </form>
            <button id="cancelJoin" class="cancelButton">Cancel</button>
        </div>
        
        
        <button class="addTicket" id="addTicket">+ New Ticket</button>
        <button class="createProject" id="createProject">Create Project</button>
        <button class="joinProject" id="joinProject">Join Project</button>
        
        
        <p class="showProjectId">Current Project Id: None Selected</p>
        
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
