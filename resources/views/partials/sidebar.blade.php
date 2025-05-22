<div class="w-60 h-screen bg-white p-4 flex flex-col border border-l border-gray-200">
    <div class="w-full flex flex-col justify-between items-center gap-2">
        <div class="w-28 h-28 rounded-full bg-sky-700"></div>
        <h2 class="text-3xl font-bold text-sky-700">BFAR XI</h2>
    </div>


    <nav class="flex flex-col gap-2 mt-10">
        <a href="/dashboard" 
           class="flex items-center gap-2 h-10 font-medium text-gray-700 rounded-full hover:bg-sky-100 hover:text-sky-700 transition-all 
                  {{ request()->routeIs('dashboard') ? 'bg-sky-200 text-sky-700' : '' }}">
            <i class="fas fa-home-alt ml-5"></i>
            Dashboard
        </a>

        <a href="/tracking" 
           class="flex items-center gap-2 h-10 font-medium text-gray-700 rounded-full hover:bg-sky-100 hover:text-sky-700 transition-all 
                  {{ request()->routeIs('tracking') ? 'bg-sky-200 text-sky-700' : '' }}">
            <i class="fas fa-file ml-5"></i>
            Tracking
        </a>

        <a href="/users" 
           class="flex items-center gap-2 h-10 font-medium text-gray-700 rounded-full hover:bg-sky-100 hover:text-sky-700 transition-all 
                  {{ request()->routeIs('users') ? 'bg-sky-700 text-white' : '' }}">
            <i class="fas fa-user ml-5"></i>
            Users
        </a>

        <a href="/calendar" 
           class="flex items-center gap-2 h-10 font-medium text-gray-700 rounded-full hover:bg-sky-100 hover:text-sky-700 transition-all 
                  {{ request()->routeIs('calendar') ? 'bg-sky-200 text-sky-700' : '' }}">
            <i class="fas fa-calendar ml-5"></i>
            Calendar
        </a>
    </nav>


    <form action="/logout" method="post" class="mt-auto">
        <button class="bg-red-400 text-white font-bold text-sm rounded-full w-full h-10 cursor-pointer">Logout</button>
    </form>
</div>