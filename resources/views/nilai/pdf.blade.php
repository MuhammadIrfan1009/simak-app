<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Nilai — {{ $mahasiswa->nama }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #1a1a1a; }

        .header {
            text-align: center;
            border-bottom: 3px solid #0D9488;
            padding-bottom: 14px;
            margin-bottom: 24px;
        }
        .header h1 { font-size: 16px; color: #0D9488; margin-bottom: 4px; }
        .header p  { font-size: 11px; color: #555; }

        .info { margin-bottom: 20px; }
        .info p { margin: 4px 0; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 7px 8px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #0D9488; color: #fff; font-size: 11px; }
        td { font-size: 11px; }
        td.center { text-align: center; }

        .summary {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 12px 16px;
            margin-bottom: 32px;
        }
        .summary p { margin: 4px 0; }

        .footer { text-align: right; font-size: 11px; color: #555; }
    </style>
</head>
<body>

    <div class="header">
        <h1>REKAP NILAI AKADEMIK</h1>
        <p>Universitas Sriwijaya</p>
    </div>

    <div class="info">
        <p><strong>Nama Mahasiswa :</strong> {{ $mahasiswa->nama }}</p>
        <p><strong>NIM             :</strong> {{ $mahasiswa->nim }}</p>
        <p><strong>Jurusan         :</strong> {{ $mahasiswa->jurusan }}</p>
        <p><strong>Tanggal Cetak   :</strong> {{ now()->translatedFormat('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode MK</th>
                <th>Nama Mata Kuliah</th>
                <th>SKS</th>
                <th>Indeks</th>
                <th>Tugas</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Nilai Akhir</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($nilais as $i => $nilai)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $nilai->mataKuliah->kode_mk }}</td>
                    <td>{{ $nilai->mataKuliah->nama_mk }}</td>
                    <td class="center">{{ $nilai->mataKuliah->sks }}</td>
                    <td class="center">{{ number_format($nilai->indeks ?? 0, 2) }}</td>
                    <td class="center">{{ number_format($nilai->nilai_tugas, 2) }}</td>
                    <td class="center">{{ number_format($nilai->nilai_uts, 2) }}</td>
                    <td class="center">{{ number_format($nilai->nilai_uas, 2) }}</td>
                    <td class="center"><strong>{{ number_format($nilai->nilai_akhir, 2) }}</strong></td>
                    <td class="center">{{ $nilai->grade }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" style="text-align:center;padding:16px;">Belum ada data nilai.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <p><strong>IP Semester  :</strong> {{ number_format($ip ?? 0, 2) }}</p>
        <p><strong>Total SKS    :</strong> {{ $totalSks ?? $nilais->sum(fn ($n) => $n->mataKuliah->sks) }}</p>
    </div>

    <div class="footer">
        <p>Diterbitkan oleh Sistem SIMAK &mdash; {{ now()->translatedFormat('d F Y') }}</p>
    </div>

</body>
</html>
