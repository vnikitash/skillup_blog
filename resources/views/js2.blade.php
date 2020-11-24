<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</head>
<body>
        <div id="register_form">
            <h3>Register</h3>
            <span id='emailErrorSpan' style="color: red; display: none"></span>
            <input id='email' type="email" placeholder="email@example.com" class="form-group"><br>

            <span id='passwordErrorSpan' style="color: red; display: none"></span>
            <input id='password' type="password" placeholder="Your password" class="form-group"><br>

            <span id='nameErrorSpan' style="color: red; display: none"></span>
            <input id='name' type="text" placeholder="Your name" class="form-group"><br>

            <button class="btn btn-success" onclick="register()">Send</button>
        </div>

        <div>
        <div id="registered" style="display: none"></div>
            <button class="btn btn-primary" onclick="logout()">Logout</button>
            <button class="btn btn-warning" onclick="checkToken()">UserMe</button>
        </div>

</body>

<script>

    let data = window.sessionStorage.getItem('user');
    if (data) {
        user = JSON.parse(data);
        document.getElementById('register_form').style.display = 'none';
        document.getElementById('registered').style.display = 'block';
        document.getElementById('registered').innerText = user.email;
    }


    function register()
    {

        let validFields = true;

        document.getElementById("emailErrorSpan").style.display = "none";
        document.getElementById("passwordErrorSpan").style.display = "none";
        document.getElementById("nameErrorSpan").style.display = "none";

        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        let name = document.getElementById('name').value;

        if (password.length < 6) {
            document.getElementById("passwordErrorSpan").style.display = "block";
            document.getElementById("passwordErrorSpan").innerText = "Password should be at least 6 symbols!";
            validFields = false;
        }

        if (name.length < 2) {
            document.getElementById("nameErrorSpan").style.display = "block";
            document.getElementById("nameErrorSpan").innerText = "Password should be at least 6 symbols!";
            validFields = false;
        }

        if (email.indexOf('@') === -1 || email.indexOf('.') === -1) {
            document.getElementById("emailErrorSpan").style.display = "block";
            document.getElementById("emailErrorSpan").innerText = "Email format is invalid";
            validFields = false;
        }


        if (validFields) {

            let requestData = {
                email: email,
                password: password,
                name: name
            };

            let http = new XMLHttpRequest();
            let url = '/api/auth/register';

            http.open('POST', url, true);

            http.setRequestHeader('Content-type', 'application/json');
            http.setRequestHeader('Accept', 'application/json');

            http.onreadystatechange = function() {//Call a function when the state changes.
                console.log(http.readyState);
                if(http.readyState === 4 && http.status === 201) {
                    window.sessionStorage.setItem('user', http.responseText);
                    user = JSON.parse(http.responseText);
                    document.getElementById('register_form').style.display = 'none';
                    document.getElementById('registered').style.display = 'block';
                    document.getElementById('registered').innerText = user.email;
                }
            };

            http.send(JSON.stringify(requestData));

        }
    }


    function logout()
    {
        window.sessionStorage.removeItem('user');
        document.getElementById('register_form').style.display = 'block';
        document.getElementById('registered').style.display = 'none';
        user = null;
    }


    function checkToken()
    {
        //user/me
        let token = '';
        if (typeof user !== 'undefined' && user !== null) {
            token = user.token;
        }

        let http = new XMLHttpRequest();
        let url = '/api/user/me';

        http.open('GET', url, true);



        http.setRequestHeader('Accept', 'application/json');
        http.setRequestHeader('Authorization', 'Bearer ' + token);

        http.onreadystatechange = function() {//Call a function when the state changes.
            console.log(http.readyState);
            if(http.readyState === 4 && http.status === 200) {
                alert("SUCCESS: " + http.responseText);
            } else if (http.readyState === 4 && http.status > 399)
            {
                alert("ERROR: " + http.responseText);
            }

        };

        http.send();
    }

</script>

</html>