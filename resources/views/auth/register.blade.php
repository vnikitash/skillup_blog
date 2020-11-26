<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</head>
<body>
<div id="register_form" class="container">
    <h3>Register</h3>

    <div id="loader" style="display: none">
        Processing...
    </div>
    
    <div id="success" class="alert alert-success" role="alert" style="display:none;">Registration successful. Redirecting...</div>

    <div id="main">
        <div class="alert alert-danger" role="alert" id="error" style="display: none">ERROR OCCURRED!</div>
        <input id='email' type="email" placeholder="email@example.com" class="form-group"><br>
        <input id='password' type="password" placeholder="Your password" class="form-group"><br>
        <button class="btn btn-success" onclick="register()">Register</button>
    </div>
</div>
</body>
<script>
    function register()
    {
        window.document.getElementById("error").style.display = 'none';
        document.getElementById('loader').style.display = 'block';
        document.getElementById('main').style.display = 'none';
        let ema = window.document.getElementById('email').value;
        let pass = window.document.getElementById('password').value;

        let http = new XMLHttpRequest();
        let url = '/register';
        let params = JSON.stringify({email: ema, password: pass});
        http.open('POST', url, true);

        http.setRequestHeader('Content-type', 'application/json');
        http.setRequestHeader('Accept', 'application/json');

        http.onreadystatechange = function() {//Call a function when the state changes.
            if(http.readyState === 4 && http.status === 201) {
                document.getElementById('loader').style.display = 'none';
                document.getElementById('success').style.display = 'block';
                window.location.href = '/';
            } else if (http.readyState === 4 && http.status > 399) {
                let response = JSON.parse(http.responseText);
                window.document.getElementById("error").innerHTML = response.error;
                window.document.getElementById("error").style.display = 'block';
                document.getElementById('loader').style.display = 'none';
                document.getElementById('main').style.display = 'block';
            }
        };

        http.send(params);

    }
</script>
</html>