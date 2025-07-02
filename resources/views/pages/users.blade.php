@extends('layout.app')

@section('title', 'Users')

@section('content')


    <div class="w-full h-full flex flex-col gap-10 p-10">

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show"
                class="text-sm bg-green-200 border border-green-500 text-green-700 p-4 rounded-lg relative">
                <button @click="show = false"
                    class="text-2xl cursor-pointer absolute top-2 right-4 text-green-700 hover:text-green-900">
                    &times;
                </button>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show"
                class="text-sm p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg relative">
                <button @click="show = false"
                    class="text-2xl cursor-pointer absolute top-2 right-4 text-red-700 hover:text-red-900">
                    &times;
                </button>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-col h-full bg-white p-6 rounded-lg ">
            <h2 class="text-xl font-bold text-gray-700 mb-6">New User</h2>


            <form action="{{ route('users.register') }}" method="post" enctype="multipart/form-data">

                @csrf

                <small>Select Profile <span class="text-red-500">*</span></small>
                <input type="file" name="profile"
                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded-md cursor-pointer mb-2" required>

                <small>Name <span class="text-red-500">*</span></small>
                <input type="text" name="name"
                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded-md mb-2" required>

                <small>Role <span class="text-red-500">*</span></small>
                <input type="text" name="role"
                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded-md mb-2" required>

                <small>Username <span class="text-red-500">*</span></small>
                <input type="text" name="username"
                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded-md mb-2" required>

                <small>Password <span class="text-red-500">*</span></small>
                <input type="password" name="password"
                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded-md mb-2" required>

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
                    @foreach ($users as $user)
                        <tr class="border-b border-gray-300">
                            <td class="px-4 py-2 text-sm text-gray-600">
                                @if ($user->profile)
                                    <img src="{{ asset('storage/' . $user->profile) }}" alt="Profile"
                                        class="w-8 h-8 rounded-full object-cover" loading="lazy">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gray-600"></div>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-left text-sm">{{ $user->name }}</td>
                            <td class="px-4 py-2 text-left text-sm">{{ $user->role }}</td>
                            <td class="px-4 py-2 text-left text-sm">{{ $user->username }}</td>
                            <td class="px-4 py-2 text-left text-sm">{{ $user->password }}</td>
                            <td class="px-4 py-2 text-sm text-gray-600">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('users.show', $user->id) }}">
                                        <i class="fa-solid fa-eye text-lg text-blue-600"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}">
                                        <i class="fa-solid fa-user-pen text-lg text-green-600"></i>
                                    </a>
                                    <form id="delete-user-form-{{ $user->id }}"
                                        action="{{ route('users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button data-micromodal-trigger="modal-delete-user"
                                            data-user-delete-url="{{ route('users.destroy', $user->id) }}"
                                            class="text-red-400 hover:text-red-800 cursor-pointer p-0" type="button">
                                            <i class="fa-regular fa-trash-can text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal micromodal-slide" id="modal-delete-user" aria-hidden="true">
        <div class="modal__overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            tabindex="-1" data-micromodal-close>
            <div class="modal__container bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative" role="dialog"
                aria-modal="true" aria-labelledby="modal-delete-title">
                <header class="modal__header flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-600" id="modal-delete-title">Confirm Delete</h2>
                </header>
                <main class="modal__content text-sm">
                    Are you sure you want to delete this user? This action cannot be undone.
                </main>
                <footer class="modal__footer mt-4 flex justify-end gap-2">
                    <form id="deleteUserForm" method="POST" action="{{ route('users.destroy', $user->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-400 hover:bg-red-500 text-sm text-white px-4 py-2 rounded cursor-pointer">
                            Delete
                        </button>
                    </form>

                    <button class="bg-gray-300 hover:bg-gray-400  text-sm text-gray-700 px-4 py-2 rounded cursor-pointer"
                        data-micromodal-close>Cancel</button>

                </footer>
            </div>
        </div>
    </div>
@endsection
