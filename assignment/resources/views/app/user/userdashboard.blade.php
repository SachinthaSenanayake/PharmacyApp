<nav class="navbar navbar-light navbar-expand-lg mb-5">
    <div class="container">
        <a class="navbar-brand mr-auto" >User Dashboard</a>


    </div>
</nav>


<form action="{{route('logout')}}" method="POST">
    @method('post')
    @csrf
    <button>Logout</button>
</form>