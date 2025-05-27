<div class="hidden  w-60 h-screen bg-white p-4 lg:flex flex-col border-r-2 border-gray-200 sticky top-0 left-0">
    <div class="w-full flex flex-col justify-between items-center gap-2 mt-5">
        <img src="{{ asset('images/bfar.png') }}" alt="" width="150" height="150">
        <h2 class="text-2xl font-black text-gray-700">BFAR XI</h2>
    </div>


    <nav class="flex flex-col gap-2 mt-10">
        <a href="/dashboard"
            class="flex bg-gray-100 items-center gap-2 h-10 text-sm text-gray-700 rounded-full hover:bg-gray-200 hover:text-gray-600 transition-all 
                  {{ request()->routeIs('dashboard') ? 'bg-gray-300 text-gray-700' : '' }}">
            <i class="fas fa-home-alt ml-5"></i>
            Dashboard
        </a>

        <a href="/tracking"
            class="flex bg-gray-100 items-center gap-2 h-10 text-sm text-gray-700 rounded-full hover:bg-gray-200 hover:text-gray-600  transition-all 
                  {{ request()->routeIs('tracking') ? 'bg-gray-300 text-gray-700' : '' }}">
            <i class="fas fa-file ml-5"></i>
            Tracking
        </a>

        <a href="/users"
            class="flex bg-gray-100 items-center gap-2 h-10 text-sm text-gray-700 rounded-full hover:bg-gray-200 hover:text-gray-600  transition-all 
                  {{ request()->routeIs('users') ? 'bg-gray-300 text-gray-700' : '' }}">
            {{-- <i class="ml-5 {{ request()->routeIs('users') ? 'fas fa-user' : 'fa-regular fa-user' }}"></i> --}}
            <i class="fas fa-user ml-5"></i>

            Users
        </a>

        <a href="/calendar"
            class="flex bg-gray-100 items-center gap-2 h-10 text-sm text-gray-700 rounded-full hover:bg-gray-200 hover:text-gray-600 transition-all 
                  {{ request()->routeIs('calendar') ? 'bg-gray-300 text-gray-700' : '' }}">
            <i class="fas fa-calendar ml-5"></i>
            Calendar
        </a>
    </nav>


    <form action="/logout" method="post" class="mt-auto">
        <button class="bg-red-400 text-white font-bold text-sm rounded-full w-full h-10 cursor-pointer">Logout</button>
    </form>
</div>
