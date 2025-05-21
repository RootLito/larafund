<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAC</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="w-full h-screen bg-gray-200 flex gap-10 justify-center items-center">


        @auth
            <form action="/logout" method="post"  class="flex flex-col">
                @csrf
                <p>You are logged in</p>
                <button class="w-full bg-red-400 py-2 mt-5 text-white cursor-pointer">Logout</button>
            </form>
        @else 
            <div class="w-100 h-120 bg-white p-10">
                <h2 class="text-xl font-black text-gray-600">Sign Up</h2>
                <p>Fill up all fields to create account</p>
                <form action="/register" method="post" class="mt-5 flex flex-col gap-2">
                    @csrf
                    <input type="text" name="name" id="" class="w-full py-2 border border-gray-300 p-2" placeholder="Name">
                    <input type="text" name="email" id="" class="w-full py-2 border border-gray-300 p-2" placeholder="Email">
                    <input type="text" name="password" id="" class="w-full py-2 border border-gray-300 p-2" placeholder="Password">
                    <button class="w-full bg-red-400 py-2 mt-2 text-white cursor-pointer">Sign Up</button>
                </form>
            </div>

            <div class="w-100 h-120 bg-white p-10">
                <h2 class="text-xl font-black text-gray-600">Log In</h2>
                <p>Welcome, login to your account</p>
                <form action="/login" method="post" class="mt-5 flex flex-col gap-2">
                    @csrf
                    <input type="text" name="lemail" id="" class="w-full py-2 border border-gray-300 p-2" placeholder="Email">
                    <input type="text" name="lpassword" id="" class="w-full py-2 border border-gray-300 p-2" placeholder="Password">
                    <button class="w-full bg-red-400 py-2 mt-2 text-white cursor-pointer">Login</button>
                </form>
            </div>
        @endauth




        

        
    </div>
</body>
</html>