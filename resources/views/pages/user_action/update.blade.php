@extends('layout.app')

@section('title', 'Edit User')

@section('content')
    <div class="flex-1 grid place-items-center">

        <div class=" mx-auto p-6 bg-white rounded-lg">
            <h1 class="text-2xl font-bold mb-4 text-gray-600">Edit User</h1>

            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    @if ($user->profile)
                        <div class="flex items-center gap-5">
                            <img src="{{ asset('storage/' . $user->profile) }}" alt="Current Profile"
                                class="w-24 h-24 rounded-full object-cover mb-2">
                            <input type="file" name="profile" id="profile"
                                class="border border-gray-300 rounded p-2 w-52 bg-gray-50" />
                        </div>
                    @endif


                    @error('profile')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block mb-1 font-medium  text-sm">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="border border-gray-300 rounded p-2 w-full bg-gray-50" />
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role" class="block mb-1 font-medium  text-sm">Role</label>
                    <input type="text" name="role" id="role" value="{{ old('role', $user->role) }}" required
                        class="border border-gray-300 rounded p-2 w-full bg-gray-50" />
                    @error('role')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="username" class="block mb-1 font-medium  text-sm">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                        required class="border border-gray-300 rounded p-2 w-full bg-gray-50" />
                    @error('username')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block mb-1 font-medium  text-sm">Password (leave blank to keep
                        current)</label>
                    <input type="password" name="password" id="password"
                        class="border border-gray-300 rounded p-2 w-full bg-gray-50" />
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="w-1/2 cursor-pointer bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 text-sm mt-auto">
                        Update User
                    </button>

                    <button type="button" onclick="window.location='{{ route('users.index') }}'"
                        class="w-1/2 cursor-pointer px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 text-sm">
                        Cancel
                    </button>
                </div>

            </form>
        </div>

    </div>
@endsection
