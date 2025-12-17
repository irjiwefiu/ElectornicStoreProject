@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen">
    <form method="POST" action="{{ route('login') }}"
          class="bg-white p-6 rounded-xl shadow w-96">
        @csrf

        <h2 class="text-xl font-bold mb-4 text-center">🔐 Login</h2>

        {{-- ❌ LOGIN FAILED ALERT --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 px-4 py-2 rounded text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <input type="email" name="email" placeholder="Email"
               value="{{ old('email') }}"
               class="w-full mb-3 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
               required>

        <input type="password" name="password" placeholder="Password"
               class="w-full mb-4 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
               required>

        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
            Login
        </button>

        {{-- 🔗 REGISTER LINK --}}
        <div class="mt-4 text-center text-sm">
            Don’t have an account?
            <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">
                Register
            </a>
        </div>
    </form>
</div>
@endsection
