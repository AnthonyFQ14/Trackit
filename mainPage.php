<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Trackit Plus</title>
        
        <?php
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        
            $servername = "127.0.0.1";
            $user = "root";
            $pword = "12345678";
            $dbase = "Trackit";
            $table = "users";

            // Create connection
            $mydb = new mysqli($servername, $user, $pword, $dbase);
                if ($mydb->connect_error) {
                        die("Database connection failed: " . mysqli_connect_error());
                    }

            $users = "SELECT * FROM $table";
            
            $result = $mydb->query($users);

            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
            $id = array_column($row, "id");
            
            $mydb->close();
        ?>
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
            .form-container{
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
                top: 53px;
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
                background-color: lightblue;
                padding: 20px;
                border-radius: 10px;
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
            .left-nav a{
                display: block;
                font-size: 30px;
                color: black;
                padding: 20px;
                text-decoration: none;
                border-bottom: 1px solid grey;
            }
            .left-nav a:hover{
                background-color: grey;
                color: white;
            }
            .rowOfColumns{
                
                margin-left: auto;
                width: 87%;
                align-content: right;
                z-index: 0;
                
            }
            .logout{
                margin-left:20px;
                font-size: 20px;
            }
            .logoutLabel{
                font-size: 30px;
            }
            .addTicket{
                position: absolute;
                bottom: 25px;
                right: 25px;
                background-color: lightgreen;
                padding: 10px 20px;
                border-radius: 15px;
                font-size: 20px;
                text-align: center;
            }
            .createProject{
                position: absolute;
                bottom: 25px;
                left: 14px;
                background-color: lightcoral;
                padding: 10px 20px;
                border-radius: 15px;
                font-size: 20px;
                text-align: center;
            }
            button{
                border-radius: 10px;
            }
            .submitNewProject{
                background-color: lightgreen;
            }
            .addTicketForm{
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
        </style>
    </head>
    
    <body>
        <h1>Trackit Plus</h1>
        <div class="top-right">
            <label class="logoutLabel" id="logoutLabel" for="logout">Welcome, User</label>
            <button class="logout" id="logout">Logout</button>
        </div>
        
        <div class="left-nav">
            <a href="#">Project 1</a>
            <a href="#">Project 2</a>
            <a href="#">Project 3</a>
        </div>
        
        
        <div class="rowOfColumns">
            <div class="column">
                <h2>To Do</h2>
                <div class="card">
                    <p id="bug1">Bug 1</p>
                    <p>Bug 2</p>
                </div>
            </div>
            <div class="column">
                <h2>In Progress</h2>
                <div class="card">
                    <p>Bug 3</p>
                    <p>Bug 4</p>
                </div>
            </div>
            <div class="column">
                <h2>In Review</h2>
                <div class="card">
                    <p>Bug 5</p>
                    <p>Bug 6</p>
                </div>
            </div>
            <div class="column">
                <h2>Done</h2>
                <div class="card">
                    <p>Bug 7</p>
                    <p>Bug 8</p>
                </div>
            </div>
        </div>
        
        <button class="addTicket" id="addTicket">+ New Ticket</button>
        <button class="createProject" id="createProject">Create Project</button>
        
        <!-- Add Project Form -->
        <div class="form-container">
            <form>
                <label for="project-name">Project Name:</label>
                <input type="text" id="project-name" name="project-name">
                <br><br>
                <label for="invitees">Invite People:</label>
                <input type="text" id="invitees" name="invitees">
                <br><br>
                <input class="submitNewProject" type="submit" value="Submit">
                <button id="cancel-button" class="cancel-button">Cancel</button>
            </form>
        </div>
        <div class="addTicketForm">
            <form>
                <label for="ticketName">Ticket Name:</label>
                <input type="text" id="ticketName" name="project-name">
                <br><br>
                <label for="category">Category:</label>
                <input type="text" id="category" name="category">
                <br><br>
                <label for="subcategory">Subcategory:</label>
                <input type="text" id="subcategory" name="subcategory">
                <br><br>
                <label for="bugDescription">Bug Description:</label>
                <input type="text" id="bugDescription" name="bugDescription">
                <br><br>
                <input class="submitNewProject" type="submit" value="Submit">
                <button id="cancel-button" class="cancel-button">Cancel</button>
            </form>
        </div>
        
        <script>
            document.getElementById('bug1').textContent = '<?php echo($id[0]);?>';
        </script>
        
        <script>
            
            // Get the add project button and form
            const createProjectButton = document.querySelector(".createProject");
            const addProjectForm = document.querySelector(".form-container");
            const addTicketButton = document.querySelector(".addTicket");
            const addTicketForm = document.querySelector(".addTicketForm");
            

            // Show the form when the add project button is clicked
            createProjectButton.addEventListener("click", function() {
                addProjectForm.style.display = "block";
                addProjectForm.style.margin = "auto";
                
            });
            
            addTicketButton.addEventListener("click", function() {
                addTicketForm.style.display = "block";
                addTicketForm.style.margin = "auto";
                
            });
            // Hide the form when the cancel button is clicked
            const cancelButton = document.getElementById("cancel-button");
            cancelButton.addEventListener("click", function() {
              addTicketForm.style.display = "none";
            });
        </script>
        
    </body>
</html>
