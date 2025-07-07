<div class="w-full h-16 bg-white flex justify-between items-center px-10 border-b-2 border-gray-200">
    <div class="flex gap-2">
        <img src="{{ asset('images/bfar.png') }}" alt="" width="18" height="36" class="lg:hidden">
        <h2 class="text-lg font-bold text-gray-700">BAC PR TRACKING SYSTEM</h2>
    </div>

    <div class="flex gap-2 items-center">
        <h2>{{ auth()->user()->name }}</h2>

        <div x-data="{ open: false }" class="relative">
            <!-- Bell Icon -->
            <i @click="open = !open" class="fa-solid fa-bell text-2xl cursor-pointer text-gray-600"></i>

            <!-- Notification Count Badge -->
            @if ($upcomingCount > 0)
                <span
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-4 h-4 flex items-center justify-center">
                    {{ $upcomingCount }}
                </span>
            @endif



            <!-- Notification Dropdown -->
            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute right-0 mt-5 w-64 bg-white border border-gray-200 rounded z-50">
                <div class="p-4 text-gray-700 font-semibold border-b">Notifications</div>
                <ul class="max-h-60 overflow-y-auto">
                    {{-- @forelse($upcomingNotifications as $notification)
                        <li class="px-4 py-2 hover:bg-gray-100 text-sm text-gray-800">
                            {{ $notification->title }}
                        </li>
                    @empty
                        <li class="px-4 py-2 text-sm text-gray-500">No new notifications</li>
                    @endforelse --}}
                </ul>

                <div class="w-full">
                    <button
                        class="cursor-pointer w-full bg-gray-100 text-gray-600 text-sm py-2 font-semibold hover:bg-gray-200 focus:outline-none rounded-b-md">
                        View All
                    </button>
                </div>
            </div>
        </div>





        <img src="{{ asset('images/bfar.png') }}" alt="" width="48">
    </div>

</div>
