{{--
    Partial: nilai/_grade-script.blade.php
    Dipakai di create.blade.php dan edit.blade.php.
    Ekspos fungsi updateGradePreview() secara global.
--}}
<script>
const GRADE_TABLE = [
    { min: 86, grade: 'A',  indeks: 4.00 },
    { min: 80, grade: 'A-', indeks: 3.70 },
    { min: 75, grade: 'B+', indeks: 3.30 },
    { min: 70, grade: 'B',  indeks: 3.00 },
    { min: 65, grade: 'B-', indeks: 2.70 },
    { min: 60, grade: 'C+', indeks: 2.30 },
    { min: 56, grade: 'C',  indeks: 2.00 },
    { min: 41, grade: 'D',  indeks: 1.00 },
    { min:  0, grade: 'E',  indeks: 0.00 },
];

function getGradeInfo(nilai) {
    return GRADE_TABLE.find(g => nilai >= g.min) ?? GRADE_TABLE.at(-1);
}

function updateGradePreview() {
    const tugas = parseFloat(document.getElementById('nilaiTugas')?.value) || 0;
    const uts   = parseFloat(document.getElementById('nilaiUts')?.value)   || 0;
    const uas   = parseFloat(document.getElementById('nilaiUas')?.value)   || 0;

    const nilaiAkhir = (0.20 * tugas) + (0.30 * uts) + (0.50 * uas);
    const { grade, indeks } = getGradeInfo(nilaiAkhir);

    document.getElementById('nilaiAkhir').textContent  = nilaiAkhir.toFixed(2);
    document.getElementById('gradePreview').textContent = grade;
    document.getElementById('indeksPreview').textContent = indeks.toFixed(2);
}

['nilaiTugas', 'nilaiUts', 'nilaiUas'].forEach(id => {
    document.getElementById(id)?.addEventListener('input', updateGradePreview);
});
</script>
