@extends('layout.ClientLayout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Đổi mật khẩu</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('client.change-password') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu hiện tại</label>
                <input type="password" name="current_password" id="current_password" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('current_password') border-red-500 @enderror">
                @error('current_password')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="new_password" class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu mới</label>
                <input type="password" name="new_password" id="new_password" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('new_password') border-red-500 @enderror">
                @error('new_password')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="new_password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Xác nhận mật khẩu mới</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('new_password_confirmation') border-red-500 @enderror">
                @error('new_password_confirmation')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Đổi mật khẩu
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 