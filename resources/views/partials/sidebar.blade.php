<div class="hidden  w-60 h-screen bg-white p-4 lg:flex flex-col border-r-2 border-gray-200 sticky top-0 left-0">
    <div class="w-full flex flex-col justify-between items-center gap-2 mt-5">
        <img src="{{ asset('images/bfar.png') }}" alt="" width="150" height="150">
        <h2 class="text-2xl font-black text-gray-700">BFAR XI</h2>
    </div>


    <nav class="flex flex-col gap-2 mt-10">
        <a href="/dashboard"
            class="flex bg-gray-100 items-center gap-2 h-10 text-sm font-semibold text-gray-700 rounded-md hover:bg-gray-200 hover:text-gray-600 transition-all 
                  {{ request()->is('dashboard*') ? 'bg-gray-300 text-gray-700' : '' }}">
            <i class="fas fa-home-alt ml-5"></i>
            Dashboard
        </a>

        <a href="/tracking"
            class="flex bg-gray-100 items-center gap-2 h-10 font-semibold text-sm text-gray-700 rounded-md hover:bg-gray-200 hover:text-gray-600  transition-all 
                  {{ request()->routeIs('tracking') ? 'bg-gray-300 text-gray-700' : '' }}">
            <i class="fas fa-file ml-5"></i>
            Tracking
        </a>

        @auth
            @if (auth()->user()->role === 'admin')
                <a href="/users"
                    class="flex bg-gray-100 items-center gap-2 h-10 text-sm font-semibold text-gray-700 rounded-md hover:bg-gray-200 hover:text-gray-600 transition-all 
                     {{ request()->is('users*') ? 'bg-gray-300 text-gray-700' : '' }}">
                    <i class="fas fa-user ml-5"></i>
                    Users
                </a>
            @endif
        @endauth


        <a href="/calendar"
            class="flex bg-gray-100 items-center gap-2 h-10 text-sm font-semibold text-gray-700 rounded-md hover:bg-gray-200 hover:text-gray-600 transition-all 
                  {{ request()->routeIs('calendar') ? 'bg-gray-300 text-gray-700' : '' }}">
            <i class="fas fa-calendar ml-5"></i>
            Calendar
        </a>


        @auth
            @if (auth()->user()->role === 'admin')
                <a href="/logs"
                    class="flex bg-gray-100 items-center gap-2 h-10 text-sm font-semibold text-gray-700 rounded-md hover:bg-gray-200 hover:text-gray-600 transition-all 
          {{ request()->is('logs*') ? 'bg-gray-300 text-gray-700' : '' }}">
                    <i class="fa-solid fa-table-list ml-5"></i>
                    Activity Logs
                </a>
            @endif
        @endauth
    </nav>


    <form action="/logout" method="post" class="mt-auto">
        <div x-data="clock()" x-init="start()" id="clock" x-text="time"
            class="text-sm text-senter mb-5"></div>

        <script>
            function clock() {
                return {
                    time: '',
                    start() {
                        this.update();
                        setInterval(() => this.update(), 1000);
                    },
                    update() {
                        const now = new Date();
                        this.time = now.toLocaleString('en-US', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit',
                            hour12: true
                        });
                    }
                }
            }
        </script>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="bg-red-400 text-white font-bold text-sm rounded-md w-full h-10 cursor-pointer">
                Logout
            </button>
        </form>
    </form>
</div>
