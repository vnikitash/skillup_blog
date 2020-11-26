<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <h3>POSTS</h3>

    @if($user = \Illuminate\Support\Facades\Auth::user())
        <a href="/logout" class="btn btn-primary">Logout {{$user->email}}</a>
        <br>
        <br>
        <div id="success" class="alert alert-success" role="alert" style="display:none;">Successfully created!</div>
        <div id="loader"  style="display:none;">Creating...</div>
        <div id="createForm">
            <input type="text" placeholder="comment" id="comment"><button class="btn btn-success" id="createComment">Create</button>
        </div>
    @else
        <a href="/register" class="btn btn-primary">Register</a>
        <a href="/login" class="btn btn-success">Login</a>
    @endif

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Author</th>
            <th>Likes</th>
        </tr>
        </thead>
        <tbody id="posts">
        @foreach ($posts as $post)
            <tr>
                <td>{{$post->id}}</td>
                <td>{{$post->text}}</td>
                <td>{{$post->user->email}}</td>
                <td>(<span id="lc_{{$post->id}}">{{$post->likesCount}}</span>) @if ($user)<span style="color: red" id="heart_{{$post->id}}">@if($post->liked)<i class="fas fa-heart" onclick="setLike({{$post->id}})" style="cursor: pointer"></i>@else<i  style="cursor: pointer" class="far fa-heart" onclick="setLike({{$post->id}})"></i>@endif</span>@endif</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


</body>

<script>
document.getElementById('createComment').addEventListener('click', function () {

    document.getElementById('loader').style.display = 'block';
    document.getElementById('createForm').style.display = 'none';


    let comment = document.getElementById('comment').value;

    document.getElementById('comment').value = '';

    let http = new XMLHttpRequest();
    http.open('POST', '/', true);

    http.setRequestHeader('Content-type', 'application/json');
    http.setRequestHeader('Accept', 'application/json');

    http.onreadystatechange = function() {//Call a function when the state changes.
        if(http.readyState === 4 && http.status === 201) {
            let data = JSON.parse(http.responseText);

            document.getElementById("success").style.display = 'block';
            setTimeout(function () {
                document.getElementById("success").style.display = 'none';
            }, 3200);

            document.getElementById('posts').innerHTML += '<tr>\n' +
                '            <td>' + data.data.id + '</td>\n' +
                '            <td>' + data.data.text + '</td>\n' +
                '            <td>' + data.data.user.email + '</td>\n' +
                '            <td>(0) <span style="color: red"><i style="cursor:pointer" class="far fa-heart"></i></span></td>\n' +
                '        </tr>';

        }

        if (http.readyState === 4) {
            document.getElementById('loader').style.display = 'none';
            document.getElementById('createForm').style.display = 'block';
        }
    };

    http.send(JSON.stringify({comment:comment}));
});

    function setLike(postId) {

        let http = new XMLHttpRequest();

        http.open('PUT', '/' + postId + '/likes', true);
        http.setRequestHeader('Content-type', 'application/json');
        http.setRequestHeader('Accept', 'application/json');

        http.onreadystatechange = function() {//Call a function when the state changes.
            if(http.readyState === 4 && http.status === 201) {
                console.log('LIKED!');
                let count = parseInt(document.getElementById('lc_' + postId).innerText);
                count++;

                document.getElementById('lc_' + postId).innerText = count;
                document.getElementById('heart_' + postId).innerHTML = '<i class="fas fa-heart" onclick="setLike(' + postId + ')" style="cursor: pointer"></i>';
            }

            if(http.readyState === 4 && http.status === 202) {
                console.log('LIKE REMOVED!');
                let count = parseInt(document.getElementById('lc_' + postId).innerText);
                count--;
                document.getElementById('lc_' + postId).innerText = count;
                document.getElementById('heart_' + postId).innerHTML = '<i class="far fa-heart" onclick="setLike(' + postId + ')" style="cursor: pointer"></i>';
            }
        };

        http.send();
    }
</script>

</html>