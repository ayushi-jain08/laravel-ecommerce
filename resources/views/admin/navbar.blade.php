<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
   <nav class="navbar navbar-expand-lg bg-dark ps-3">
    <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active text-white" aria-current="page" href="{{route('admin.dashboard')}}">dashboard</a>
        </li>
        @if(auth()->guard('admin')->check())
        <li class="nav-item">
            <a href="{{route('admin.logout')}}" class="nav-link text-white">Logout</a>
        </li>  
        @endif
        @if(!auth()->guard('admin')->check())
        <li class="nav-item">
            <a href="{{route('admin.logout')}}" class="nav-link text-white">Login</a>
        </li>  
        @endif
        <li class="nav-item">
          <a class="nav-link text-white" href="#">Pricing</a>
        </li>
      </ul>
   </nav>
   @include('admin.navbar')
    @if(Session::has('success'))
    <div class="alert alert-success" role="alert">{{Session::get('success')}}</div>
    @endif  

@if(auth()->guard('admin')->check())
<p>{{auth()->guard('admin')->user()->name}}</p>
@endif
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>