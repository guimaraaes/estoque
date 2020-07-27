<h1> index user </h1>

<ol>
        @foreach ($user as $u)
        <li>{{  $u['name']  }}</li>
        @endforeach
</ol>