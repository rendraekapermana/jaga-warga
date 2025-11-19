<x-guest-layout>
    {{-- Container Utama --}}
    <div class="min-h-screen flex flex-col justify-center items-center bg-white p-6">
        
        <div class="w-full max-w-md">
            
            {{-- HEADER: Logo & Judul --}}
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('image/logo-biru.png') }}" alt="Logo" class="h-12 w-auto">
                </div>
                <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Log in for JAGA WARGA</h2>
            </div>

            {{-- DIVIDER "OR" --}}
            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500"></span>
                </div>
            </div>

            {{-- FORM LOGIN --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-500 mb-1">Email address or user name</label>
                    <input type="email" name="email" id="email" :value="old('email')" required autofocus 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#222E85] focus:border-[#222E85] p-2.5 text-sm"
                           placeholder="">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password dengan Toggle Show/Hide (Alpine.js) --}}
                <div class="mb-4" x-data="{ show: false }">
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="block text-sm font-medium text-gray-500">Password</label>
                        {{-- Tombol Hide/Show --}}
                        <button type="button" @click="show = !show" class="text-xs text-gray-500 hover:text-gray-700 flex items-center">
                            <span x-show="!show" class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                Show
                            </span>
                            <span x-show="show" class="flex items-center" style="display: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                                Hide
                            </span>
                        </button>
                    </div>
                    <input :type="show ? 'text' : 'password'" name="password" id="password" required autocomplete="current-password"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#222E85] focus:border-[#222E85] p-2.5 text-sm">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Remember Me & Forgot Password --}}
                <div class="flex items-center justify-between mb-6">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#222E85] shadow-sm focus:ring-[#222E85]" name="remember">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-gray-500 hover:text-[#222E85] underline decoration-gray-400">
                            Forget your password
                        </a>
                    @endif
                </div>

                {{-- Tombol Login --}}
                <button type="submit" class="w-full bg-[#222E85] text-white py-3 rounded-full font-bold hover:bg-opacity-90 transition shadow-md text-sm">
                    Log in
                </button>
            </form>

            {{-- Link ke Register --}}
            <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                <p class="text-sm text-gray-600 font-medium mb-4">Don't have an account?</p>
                <a href="{{ route('register') }}" class="block w-full border border-gray-400 text-gray-700 py-2.5 rounded-full font-bold hover:bg-gray-50 transition text-sm">
                    Sign up
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>