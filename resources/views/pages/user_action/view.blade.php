@extends('layout.app')

@section('title', 'View User')

@section('content')
    <div class="flex-1 grid place-items-center">
        <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg">
            <div class="flex flex-col items-center justify-center mb-6">
                <div>
                    @if ($user->profile)
                        <img src="{{ asset('storage/' . $user->profile) }}" alt="{{ $user->name }} Profile Picture"
                            class="w-48 h-48 rounded-full object-cover mt-5" loading="lazy">
                    @else
                        <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                            No Image
                        </div>
                    @endif
                </div>
                <div>
                    <h2 class="text-xl font-black text-gray-600 uppercase mt-5 mb-2">{{ $user->name }}</h2>
                    <div class="flex text-sm">
                        <span class="font-semibold mr-auto inline-block text-gray-500">Role:</span>
                        <span>{{ $user->role }}</span>
                    </div>
                    <div class="flex text-sm">
                        <span class="font-semibold mr-auto inline-block text-gray-500">Username:</span>
                        <span>{{ $user->username }}</span>
                    </div>

                </div>
            </div>

            <a href="{{ route('users.index') }}"
                class="block text-center rounded-md bg-gray-500 text-white px-4 py-2 hover:bg-gray-600 text-sm ml-auto mt-2">
                Back to List
            </a>


        </div>
    </div>
@endsection
