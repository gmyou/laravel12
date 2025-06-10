<h1>Dashboard</h1>

@if (Route::has('login'))
    Welcome, {{ auth()->user()->name }}!
    <nav class="flex items-center justify-end gap-4">
        @auth
            <a
                href="{{ url('/admin/dashboard') }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
            >
                Dashboard
            </a>
            <form action="{{ route('logout.store') }}" method="POST">
                @csrf
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
            </form>
        @else
            <a
                href="{{ route('login') }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
            >
                Log in
            </a>

            @if (Route::has('register'))
                <a
                    href="{{ route('register') }}"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                    Register
                </a>
            @endif
        @endauth
    </nav>
@endif