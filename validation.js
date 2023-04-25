const validation = new JustValidate("#signup");


validation
    .addField("#username",[
        {
            rule: "required"
        },
        {
            validator: (value) => () => {
                return fetch("validateUsername.php?username=" + encodeURIComponent(value))
                    .then(function(response){
                        return response.json();
                    })
                    .then(function(json){
                        return json.available;
                    });
            },
            errorMessage: "Username Already Taken"
        }
    ])
    .addField("#password",[
        {
            rule: "required"
        },
        {
            rule: "password"
        }
    ])
    .addField("#passwordConfirm",[
        {
            validator: (value, fields) => {
                return value === fields["#password"].elem.value;
            },
            errorMessage: "Passwords Should Match"
        }
    ])
    .onSuccess((event) => {
        document.getElementById("signup").submit();
    });

