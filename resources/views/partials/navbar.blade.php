<div class="w-full h-16 bg-white flex justify-between items-center px-10 border-b-2 border-gray-200">
    <div class="flex gap-2">
        <img src="{{ asset('images/bfar.png') }}" alt="" width="18" height="36" class="lg:hidden">
        <h2 class="text-lg font-bold text-gray-700">BAC PR TRACKING SYSTEM</h2>
    </div>

    <div class="flex gap-5 items-center">
        <h2>{{ auth()->user()->name }}</h2>

        <div x-data="{ open: false }" class="relative">
            <i @click="open = !open" class="fa-solid fa-bell text-2xl cursor-pointer text-gray-600"></i>

            @if ($upcomingCount > 0)
                <span
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-4 h-4 flex items-center justify-center">
                    {{ $upcomingCount }}
                </span>
            @endif

            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute right-0 mt-5 w-64 bg-white border border-gray-200 rounded-lg z-50">
                <div class="p-4 text-gray-700 font-semibold border-b border-gray-300">Reminders</div>
                <div class="p-4 text-sm text-gray-700 border-b border-gray-300">
                    You have <strong>{{ $upcomingCount }}</strong> upcoming Post Qualification Presentation(s).

                    @php
                        // Group $upcomingDates (a collection of Carbon dates) by formatted date string
                        $groupedDates = $upcomingDates
                            ->groupBy(fn($date) => $date->format('F j, Y'))
                            ->map(fn($group) => $group->count());
                    @endphp

                    @if ($groupedDates->isNotEmpty())
                        <div class="py-2 text-sm text-gray-600">
                            <strong>Dates:</strong>
                            <ul class="list-disc list-inside mt-1 max-h-40 overflow-y-auto">
                                @foreach ($groupedDates as $dateString => $count)
                                    <li>
                                        {{ $dateString }}
                                        @if ($count > 1)
                                            <span class="text-gray-500">(x{{ $count }})</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="w-full">
                    <a href="/dashboard/reminders"
                        class="block text-center w-full bg-gray-100 text-gray-600 text-sm py-2 font-semibold hover:bg-gray-200 focus:outline-none rounded-b-md">
                        View All
                    </a>
                </div>
            </div>
        </div>

        <img src="{{ asset('images/bfar.png') }}" alt="" width="48">
    </div>
</div>
