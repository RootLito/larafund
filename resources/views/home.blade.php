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
        <div class="w-100 h-120 bg-white p-10">
            <h2 class="text-xl font-black text-gray-600">Sign Up</h2>
            <form action="/register" method="post" class="mt-5 flex flex-col gap-2">
                <input type="text" name="" id="" class="w-full py-2 border border-gray-300 p-2" placeholder="Name">
                <input type="text" name="" id="" class="w-full py-2 border border-gray-300 p-2" placeholder="Email">
                <input type="text" name="" id="" class="w-full py-2 border border-gray-300 p-2" placeholder="Password">
                <button class="w-full bg-red-400 py-2 mt-2">Sign Up</button>
            </form>
        </div>

        <div class="w-100 h-120 bg-white p-10">
            <h2 class="text-xl font-black text-gray-600">Log In</h2>
            <form action="/login" method="post" class="mt-5 flex flex-col gap-2">
                <input type="text" name="" id="" class="w-full py-2 border border-gray-300 p-2" placeholder="Email">
                <input type="text" name="" id="" class="w-full py-2 border border-gray-300 p-2" placeholder="Password">
                <button class="w-full bg-red-400 py-2 mt-2">Login</button>
            </form>
        </div>
    </div>
</body>
</html>