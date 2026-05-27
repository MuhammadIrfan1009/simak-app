<!DOCTYPE html>
<html>
<head>
    <title>Rekap Nilai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #0D9488;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            color: #0D9488;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #0D9488;
            color: white;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        .summary {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REKAP NILAI AKADEMIK</h1>
        <p>Universitas Sriwijaya</p>
    </div>

    <div class="info">
        <p><strong>Nama Mahasiswa:</strong> {{ $mahasiswa->nama }}</p>
        <p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
        <p><strong>Jurusan:</strong> {{ $mahasiswa->jurusan }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode MK</th>
                <th>Nama Mata Kuliah</th>
                <th>SKS</th>
                <th>Tugas</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Nilai Akhir</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @forelse($nilais as $index => $nilai)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $nilai->mataKuliah->kode_mk }}</td>
                    <td>{{ $nilai->mataKuliah->nama_mk }}</td>
                    <td>{{ $nilai->mataKuliah->sks }}</td>
                    <td>{{ number_format($nilai->nilai_tugas, 2) }}</td>
                    <td>{{ number_format($nilai->nilai_uts, 2) }}</td>
                    <td>{{ number_format($nilai->nilai_uas, 2) }}</td>
                    <td><strong>{{ number_format($nilai->nilai_akhir, 2) }}</strong></td>
                    <td>{{ $nilai->grade }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center;">Belum ada data nilai</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <p><strong>Rata-rata Nilai:</strong> {{ number_format($rataRata, 2) }}</p>
        <p><strong>Total SKS:</strong> {{ $nilais->sum(fn($n) => $n->mataKuliah->sks) }}</p>
    </div>

    <div style="margin-top: 40px; text-align: right;">
        <p>Diterbitkan oleh Sistem SIMAK<br>{{ now()->format('d F Y') }}</p>
    </div>
</body>
</html>
