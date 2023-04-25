<?php

    session_start();

    $mysqli = require __DIR__ . "/database.php";

?>

<script>
    const validation2 = new JustValidate("#joinForm", {
      // Specify the error message container
      errorMessageClass: "error-message"
    });

    var userId = "<?php echo($_SESSION['userId']); ?>";
    console.log(userId);
    
    validation2
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
