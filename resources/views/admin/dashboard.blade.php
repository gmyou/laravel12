<h1>Dashboard</h1>

@auth
Welcome, {{ auth()->user()->name }}!
<form action="{{ route('logout.store') }}" method="POST">
    @csrf
    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
</form>
@else
<a href="/login">Login</a>
@endauth