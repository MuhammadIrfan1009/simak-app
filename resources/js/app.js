// Auto-calculate nilai akhir
document.addEventListener('DOMContentLoaded', function() {
    const nilaiTugas = document.getElementById('nilai_tugas');
    const nilaiUts = document.getElementById('nilai_uts');
    const nilaiUas = document.getElementById('nilai_uas');
    const nilaiAkhirDisplay = document.getElementById('nilai_akhir_display');

    function hitungNilaiAkhir() {
        if (nilaiTugas && nilaiUts && nilaiUas && nilaiAkhirDisplay) {
            const tugas = parseFloat(nilaiTugas.value) || 0;
            const uts = parseFloat(nilaiUts.value) || 0;
            const uas = parseFloat(nilaiUas.value) || 0;

            const nilaiAkhir = (0.20 * tugas) + (0.30 * uts) + (0.50 * uas);
            nilaiAkhirDisplay.textContent = nilaiAkhir.toFixed(2);

            // Hitung grade
            let grade = 'E';
            if (nilaiAkhir >= 80) grade = 'A';
            else if (nilaiAkhir >= 70) grade = 'B';
            else if (nilaiAkhir >= 60) grade = 'C';
            else if (nilaiAkhir >= 50) grade = 'D';

            const gradeDisplay = document.getElementById('grade_display');
            if (gradeDisplay) {
                gradeDisplay.textContent = grade;
            }
        }
    }

    if (nilaiTugas) nilaiTugas.addEventListener('input', hitungNilaiAkhir);
    if (nilaiUts) nilaiUts.addEventListener('input', hitungNilaiAkhir);
    if (nilaiUas) nilaiUas.addEventListener('input', hitungNilaiAkhir);
});

// Konfirmasi delete
document.querySelectorAll('form[data-confirm]').forEach(form => {
    form.addEventListener('submit', function(e) {
        if (!confirm(this.dataset.confirm)) {
            e.preventDefault();
        }
    });
});

// Toast notification
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 p-4 rounded-lg text-white ${
        type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'
    }`;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}
