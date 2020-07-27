<h1> index sale </h1>

<ol>
        @foreach ($sale as $u)
        <li>{{  $u['name']  }}</li>
        @endforeach
</ol>