<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/bfar.png') }}" type="image/x-icon">
    <title>BAC</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="w-full h-screen bg-gray-200 flex gap-10 justify-center items-center">
        @auth
            <form action="/logout" method="post" class="flex flex-col">
                @csrf
                <p>You are logged in</p>
                <button class="w-full bg-red-400 py-2 mt-5 text-white cursor-pointer">Logout</button>
            </form>
        @else
            <div class="w-100 bg-white p-10 rounded-lg">
                <img src="{{ asset('images/bfar.png') }}" alt="" width="250" height="250" class="mx-auto">
                <h2 class="font-black my-7 text-2xl text-gray-700 text-center">BAC PR Tracking System</h2>
                <h2 class="text-xl font-black text-gray-600">Log In</h2>

                <form action="{{ route('login') }}" method="POST" class="mt-5 flex flex-col gap-2">
                    @csrf
                    <input type="text" name="username" required
                        class="w-full py-2 border border-gray-300 bg-gray-100 rounded text-sm p-2" placeholder="Username">
                    <input type="text" name="password" required
                        class="w-full py-2 border border-gray-300 bg-gray-100 rounded text-sm p-2" placeholder="Password">
                    <button class="w-full bg-red-400 py-2 mt-2 text-white cursor-pointer rounded text-sm">Login</button>
                </form>

            </div>
        @endauth
    </div>
</body>
</html>
