@extends('layout.app')

@section('title', 'Users')

@section('content')
    <div class="w-full h-full grid grid-cols-[1fr_2fr] gap-10 p-10">
        <div class="flex flex-col h-full bg-white p-6 rounded-lg ">
            <h2 class="text-xl font-bold text-gray-700 mb-6">New User</h2>
            <form action="" method="post">
                @csrf

                <small>Select Profile <span class="text-red-500">*</span></small>
                <input type="file" name=""
                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded-md cursor-pointer mb-2">

                <small>Name <span class="text-red-500">*</span></small>
                <input type="text" name=""
                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded-md mb-2">

                <small>Role <span class="text-red-500">*</span></small>
                <input type="text" name=""
                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded-md mb-2">

                <small>Username <span class="text-red-500">*</span></small>
                <input type="text" name=""
                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded-md mb-2">

                <small>Password <span class="text-red-500">*</span></small>
                <input type="text" name=""
                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded-md mb-2">




                <button class="w-full bg-red-400 py-2 mt-5 text-white cursor-pointer rounded-md text-sm">Save</button>
            </form>

        </div>

        <div class="flex flex-col h-full bg-white p-6 rounded-lg ">
            <h2 class="text-xl font-bold text-gray-700 mb-6">User Lists</h2>
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead class="border-b border-gray-300">
                    <tr class="bg-gray-100 text-gray-600">
                        <th class="px-4 py-2 text-left text-sm">Profile</th>
                        <th class="px-4 py-2 text-left text-sm">Name</th>
                        <th class="px-4 py-2 text-left text-sm">Role</th>
                        <th class="px-4 py-2 text-left text-sm">Username</th>
                        <th class="px-4 py-2 text-left text-sm">Paasword</th>
                        <th class="px-4 py-2 text-left text-sm">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="border-b border-gray-300">
                        <td class="px-4 py-2 text-sm text-gray-600">
                            <div class="w-8 h-8 rounded-full bg-gray-600">

                            </div>
                        </td>
                        <td class="px-4 py-2 text-left text-sm">Alice Johnson</td>
                        <td class="px-4 py-2 text-left text-sm">Manager</td>
                        <td class="px-4 py-2 text-left text-sm">alicej</td>
                        <td class="px-4 py-2 text-left text-sm">*******</td>
                        <td class="px-4 py-2 text-sm text-gray-600 flex gap-2 items-center">

                            <i class="fa-regular fa-eye text-lg text-blue-600"></i>
                            <i class="fa-regular fa-pen-to-square text-lg text-green-600"></i>
                            <i class="fa-regular fa-trash-can text-lg text-red-600"></i>
                        </td>
                    </tr>

                    <!-- Second Row of Dummy Data -->
                    <tr class="border-b border-gray-300">
                        <td class="px-4 py-2 text-sm text-gray-600">
                            <div class="w-8 h-8 rounded-full bg-gray-600">

                            </div>
                        </td>
                        <td class="px-4 py-2 text-left text-sm">Bob Smith</td>
                        <td class="px-4 py-2 text-left text-sm">Developer</td>
                        <td class="px-4 py-2 text-left text-sm">bobsmith</td>
                        <td class="px-4 py-2 text-left text-sm">**********</td>
                        <td class="px-4 py-2 text-sm text-gray-600 flex gap-2 items-center">

                            <i class="fa-regular fa-eye text-lg text-blue-600"></i>
                            <i class="fa-regular fa-pen-to-square text-lg text-green-600"></i>
                            <i class="fa-regular fa-trash-can text-lg text-red-600"></i>
                        </td>
                    </tr>

                    <!-- Third Row of Dummy Data -->
                    <tr class="border-b border-gray-300">
                        <td class="px-4 py-2 text-sm text-gray-600">
                            <div class="w-8 h-8 rounded-full bg-gray-600">

                            </div>
                        </td>
                        <td class="px-4 py-2 text-left text-sm">Charlie Davis</td>
                        <td class="px-4 py-2 text-left text-sm">Designer</td>
                        <td class="px-4 py-2 text-left text-sm">charlied</td>
                        <td class="px-4 py-2 text-left text-sm">*****</td>
                        <td class="px-4 py-2 text-sm text-gray-600 flex gap-2 items-center">

                            <i class="fa-regular fa-eye text-lg text-blue-600"></i>
                            <i class="fa-regular fa-pen-to-square text-lg text-green-600"></i>
                            <i class="fa-regular fa-trash-can text-lg text-red-600"></i>
                        </td>
                    </tr>

                    <!-- Fourth Row of Dummy Data -->
                    <tr class="border-b border-gray-300">
                        <td class="px-4 py-2 text-sm text-gray-600">
                            <div class="w-8 h-8 rounded-full bg-gray-600">

                            </div>
                        </td>
                        <td class="px-4 py-2 text-left text-sm">Diana Evans</td>
                        <td class="px-4 py-2 text-left text-sm">Tester</td>
                        <td class="px-4 py-2 text-left text-sm">dianae</td>
                        <td class="px-4 py-2 text-left text-sm">********</td>
                        <td class="px-4 py-2 text-sm text-gray-600 flex gap-2 items-center">
                            <i class="fa-regular fa-eye text-lg text-blue-600"></i>
                            <i class="fa-regular fa-pen-to-square text-lg text-green-600"></i>
                            <i class="fa-regular fa-trash-can text-lg text-red-600"></i>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
@endsection
