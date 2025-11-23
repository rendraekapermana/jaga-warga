<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultasi Psikolog - Jaga Warga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'custom-blue': '#222E85'
                    }
                }
            }
        }
    </script>
    <!-- Penting: Load app.js untuk Realtime Chat (Echo) -->
    @vite(['resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans antialiased">

    <x-navbar />

    <main>
        <div class="py-12 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <!-- Hero Section Kecil -->
                <div class="bg-custom-blue rounded-2xl p-8 mb-8 text-white shadow-lg flex justify-between items-center relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-3xl font-bold mb-2">Butuh Teman Cerita?</h3>
                        <p class="text-blue-100 max-w-xl">
                            Jaga Warga menyediakan layanan konsultasi aman dan rahasia. 
                            Pilih psikolog atau konselor di bawah ini untuk memulai percakapan realtime.
                        </p>
                    </div>
                    <!-- Dekorasi -->
                    <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-blue-500 to-transparent opacity-30"></div>
                    <div class="hidden md:block text-6xl">🩺</div>
                </div>

                <!-- Grid List User (Psikolog Sementara) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($users as $user)
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden border border-gray-100">
                            <div class="p-6 flex flex-col items-center text-center">
                                <!-- Avatar -->
                                <div class="w-20 h-20 rounded-full bg-blue-100 text-custom-blue flex items-center justify-center text-2xl font-bold mb-4">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                
                                <!-- Info -->
                                <h4 class="text-lg font-bold text-gray-800">{{ $user->name }}</h4>
                                <p class="text-sm text-gray-500 mb-1">Psikolog Klinis</p> <!-- Placeholder Role -->
                                <div class="flex items-center gap-2 text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full mb-6">
                                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> Tersedia
                                </div>

                                <!-- Action Button -->
                                <a href="{{ route('chat.show', $user->id) }}" 
                                   class="w-full py-2 px-4 bg-custom-blue hover:bg-blue-900 text-white rounded-lg font-medium transition duration-200 flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    Chat Sekarang
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
                            <p class="text-gray-500">Belum ada psikolog yang tersedia saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <x-footer/>

</body>
</html>