<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report History - Jaga Warga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
</head>

<body class="bg-gray-100">

    <x-navbar />

    <main>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">
                        Report History
                    </h2>
                    <a href="{{ route('profile.show') }}" class="text-sm text-custom-blue hover:underline">
                        &larr; Back to Profile
                    </a>
                </div>

                <div class="space-y-6">
                    @if($reports->isEmpty())
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">
                            Anda belum membuat laporan apapun.
                        </div>
                    </div>
                    @else
                    @foreach($reports as $report)
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 space-y-4">

                            <div class="flex flex-col sm:flex-row justify-between sm:items-center border-b pb-3">
                                <div class="mb-2 sm:mb-0">
                                    <h3 class="text-lg font-semibold text-custom-blue">
                                        {{ $report->incident_type }}
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        Dilaporkan pada: {{ $report->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                                <div>
                                    @php
                                    $status = strtolower($report->status);
                                    $statusClass = 'bg-gray-100 text-gray-800';
                                    if ($status == 'ditinjau') {
                                    $statusClass = 'bg-blue-100 text-blue-800';
                                    } elseif ($status == 'selesai') {
                                    $statusClass = 'bg-green-100 text-green-800';
                                    } elseif ($status == 'ditolak') {
                                    $statusClass = 'bg-red-100 text-red-800';
                                    }
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        Status: {{ $report->status ?? 'Terkirim' }}
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 md:items-start">

                                {{-- Kolom Kiri --}}
                                <div class="space-y-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Tanggal Insiden</h4>
                                        <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($report->incident_date)->format('d F Y') }} pukul {{ $report->incident_time }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Lokasi Insiden</h4>
                                        <p class="text-sm text-gray-900">{{ $report->incident_location }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">File Bukti</h4>
                                        @if($report->evidence_file_path)
                                            @php
                                                $extension = pathinfo($report->evidence_file_path, PATHINFO_EXTENSION);
                                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                $fileUrl = str_starts_with($report->evidence_file_path, 'http') 
                                                    ? $report->evidence_file_path 
                                                    : asset('storage/' . $report->evidence_file_path);
                                            @endphp

                                            <div class="mt-1">
                                                <a href="{{ $fileUrl }}" target="_blank" class="text-sm text-custom-blue hover:underline flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                    Lihat File Bukti
                                                </a>
                                                
                                                @if($isImage)
                                                    <a href="{{ $fileUrl }}" target="_blank" class="block mt-2 w-32 h-32 overflow-hidden rounded-lg border border-gray-200 hover:opacity-75 transition">
                                                        <img src="{{ $fileUrl }}" alt="Bukti Laporan" class="w-full h-full object-cover">
                                                    </a>
                                                @endif
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500 italic mt-1">Tidak ada file bukti yang diunggah.</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Kolom Kanan (Deskripsi) --}}
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Deskripsi Laporan</h4>
                                    
                                    {{-- FIX: Hapus spasi/enter di dalam div agar whitespace-pre-line tidak membuat margin aneh --}}
                                    <div class="text-sm text-gray-900 bg-gray-50 p-4 rounded-md border border-gray-200 break-words whitespace-pre-line leading-relaxed min-h-[100px]">@if(!empty($report->description)){{ trim($report->description) }}@else<span class="text-gray-400 italic">Tidak ada deskripsi.</span>@endif</div>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>

            </div>
        </div>
    </main>

</body>

</html>