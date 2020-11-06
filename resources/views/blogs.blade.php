Hello,
@if($userEmail)
    {{$userEmail}} <a href="logout">Logout</a>
@else
    Guest <a href="/login">Login</a> - <a href="/register">Register</a>
@endif

<br>
    @if ($userEmail)
        <form action="/blogs" method="POST">
            <input type="text" name="title" placeholder="Title">
            <input type="text" name="text" placeholder="Text">
            <input type="submit" value="create">
        </form>
    @endif



<table border="1">
    <thead>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Text</th>
        <th>User ID</th>
    </tr>
    </thead>
    <tbody>
        @foreach($blogs as $blog)
            <tr>
                <td>{{$blog['id']}}</td>
                <td>{{$blog['title']}}</td>
                <td>{{$blog['text']}}</td>
                <td>{{$blog['user_id']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>