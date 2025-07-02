<div class="w-full h-16 bg-white flex justify-between items-center px-10 border-b-2 border-gray-200">
    <div class="flex gap-2">
        <img src="{{ asset('images/bfar.png') }}" alt="" width="18" height="36" class="lg:hidden">
        <h2 class="text-lg font-bold text-gray-700">BAC PR TRACKING SYSTEM</h2>
    </div>

    <div class="flex gap-2 items-center">
        <h2>{{ auth()->user()->name }}</h2>
        <img src="{{ asset('images/bfar.png') }}" alt="" width="48">
    </div>
</div>
