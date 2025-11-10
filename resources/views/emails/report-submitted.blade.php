<!DOCTYPE html>
<html>

<head>
    <title>Laporan Baru Telah Masuk</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        .container {
            padding: 20px;
        }

        .field {
            margin-bottom: 12px;
        }

        .field strong {
            display: block;
            color: #333;
            font-size: 14px;
        }

        .field span,
        .field p {
            font-size: 16px;
            color: #555;
            margin-top: 4px;
        }

        h3 {
            border-bottom: 2px solid #eee;
            padding-bottom: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Laporan Baru Telah Masuk: {{ $reportData['incident_type'] }}</h2>

        <hr>

        @if($reportData['is_anonymous'] == 'yes')
        <h3>Data Diri Pelapor</h3>
        <p style="font-size: 16px; color: #555; font-style: italic;">
            Pelapor memilih untuk tetap anonim.
        </p>
        @else
        <h3>Data Diri Pelapor</h3>
        <div class="field">
            <strong>Nama Lengkap:</strong>
            <span>{{ $reportData['first_name'] }} {{ $reportData['last_name'] }}</span>
        </div>
        <div class="field">
            <strong>Email:</strong>
            <span>{{ $reportData['email'] }}</span>
        </div>
        <div class="field">
            <strong>Nomor Telepon:</strong>
            <span>{{ $reportData['phone_number'] }}</span>
        </div>
        <div class="field">
            <strong>Tempat/Tanggal Lahir:</strong>
            <span>{{ $reportData['place_of_birth'] }}, {{ \Carbon\Carbon::parse($reportData['date_of_birth'])->format('d F Y') }}</span>
        </div>
        <div class="field">
            <strong>Alamat Rumah:</strong>
            <p>{{ $reportData['home_address'] }}</p>
        </div>
        @endif

        <h3>Detail Laporan Kejadian</h3>
        <div class="field">
            <strong>Tipe Insiden:</strong>
            <span>{{ $reportData['incident_type'] }}</span>
        </div>
        <div class="field">
            <strong>Waktu Kejadian:</strong>
            <span>{{ \Carbon\Carbon::parse($reportData['incident_date'])->format('d F Y') }}, Pukul {{ $reportData['incident_time'] }}</span>
        </div>
        <div class="field">
            <strong>Lokasi Insiden:</strong>
            <span>{{ $reportData['incident_location'] }}</span>
        </div>
        <div class="field">
            <strong>Deskripsi:</strong>
            <p>{!! nl2br(e($reportData['description'])) !!}</p>
        </div>
        <div class="field">
            <strong>Bukti Terlampir:</strong>
            @if(isset($reportData['evidence_file_name']))
            <span>Ya (File: {{ $reportData['evidence_file_name'] }})</span>
            @else
            <span>Tidak ada.</span>
            @endif
        </div>

    </div>
</body>

</html>