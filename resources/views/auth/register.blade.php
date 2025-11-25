<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-white p-6 py-10">
        
        <div class="w-full max-w-md">
            
            {{-- HEADER --}}
            <div class="text-center mb-6">
                <div class="flex justify-center mb-4">
                    <img src="https://muabtceunyjvfxfkclzs.supabase.co/storage/v1/object/public/images/logo-biru.png" alt="Logo" class="h-12 w-auto">
                </div>
                <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Sign up for JAGA WARGA</h2>
            </div>

            {{-- DIVIDER --}}
            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500"></span>
                </div>
            </div>

            <div class="text-center mb-6">
                <p class="text-sm font-medium text-gray-600">Sign up with your email address</p>
            </div>

            {{-- FORM REGISTER --}}
            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Profile Name --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Profile name</label>
                    <input type="text" name="name" :value="old('name')" required autofocus
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#222E85] focus:border-[#222E85] p-2.5 text-sm placeholder-gray-400"
                           placeholder="Enter your profile name">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                    <input type="email" name="email" :value="old('email')" required
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#222E85] focus:border-[#222E85] p-2.5 text-sm placeholder-gray-400"
                           placeholder="Enter your email address">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div class="mb-4" x-data="{ show: false }">
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-sm font-medium text-gray-500">Password</label>
                        <button type="button" @click="show = !show" class="text-xs text-gray-400 hover:text-gray-600 flex items-center font-medium">
                            <span x-show="!show" class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                Hide
                            </span>
                            <span x-show="show" class="flex items-center" style="display: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                                Show
                            </span>
                        </button>
                    </div>
                    <input :type="show ? 'text' : 'password'" name="password" required
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#222E85] focus:border-[#222E85] p-2.5 text-sm placeholder-gray-400"
                           placeholder="Enter your password">
                    <p class="text-xs text-gray-400 mt-1">Use 8 or more characters with a mix of letters, numbers & symbols</p>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Hidden Password Confirmation (Auto-fill) --}}
                <input type="hidden" name="password_confirmation" id="password_confirmation">
                <script>
                    document.querySelector('input[name="password"]').addEventListener('input', function(e) {
                        document.getElementById('password_confirmation').value = e.target.value;
                    });
                </script>

                {{-- Gender (Optional) --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">What's your gender? <span class="text-gray-400 font-normal">(optional)</span></label>
                    <div class="flex space-x-6">
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio text-[#222E85] focus:ring-[#222E85]" name="gender" value="female">
                            <span class="ml-2 text-sm text-gray-600">Female</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio text-[#222E85] focus:ring-[#222E85]" name="gender" value="male">
                            <span class="ml-2 text-sm text-gray-600">Male</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio text-[#222E85] focus:ring-[#222E85]" name="gender" value="non-binary">
                            <span class="ml-2 text-sm text-gray-600">Non-binary</span>
                        </label>
                    </div>
                </div>

                {{-- Date of Birth --}}
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-2">What's your date of birth?</label>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="text-xs text-gray-500 block mb-1">Month</label>
                            <select name="dob_month" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#222E85] focus:border-[#222E85] text-sm py-2.5 text-gray-600">
                                <option value="" disabled selected></option>
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 block mb-1">Date</label>
                            <select name="dob_day" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#222E85] focus:border-[#222E85] text-sm py-2.5 text-gray-600">
                                <option value="" disabled selected></option>
                                @foreach(range(1, 31) as $d)
                                    <option value="{{ $d }}">{{ $d }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 block mb-1">Year</label>
                            <select name="dob_year" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#222E85] focus:border-[#222E85] text-sm py-2.5 text-gray-600">
                                <option value="" disabled selected></option>
                                @foreach(range(date('Y'), 1950) as $y)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Tombol Sign Up (Abu-abu) --}}
                <button type="submit" class="w-full bg-gray-400 hover:bg-gray-500 text-white py-3 rounded-full font-bold transition shadow-sm text-sm">
                    Sign up
                </button>

                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">Already have an account? 
                        <a href="{{ route('login') }}" class="text-gray-800 font-bold hover:underline decoration-2">Log in</a>
                    </p>
                </div>
            </form>

        </div>
    </div>
</x-guest-layout>