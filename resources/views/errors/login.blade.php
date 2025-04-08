@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-red-600 mb-4">Lỗi Truy Cập</h2>
            <p class="text-gray-600 mb-4">
                Bạn không có quyền truy cập vào trang quản trị.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('client.home') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Về Trang Chủ
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">
                        Đăng Xuất
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 