<?php

namespace Tests\Unit;

use App\Models\Nilai;
use PHPUnit\Framework\TestCase;

class NilaiTest extends TestCase
{
    public function test_grade_conversion_uses_extended_scale_with_plus_minus(): void
    {
        $this->assertSame('A', Nilai::nilaiKeGrade(95));
        $this->assertSame('A-', Nilai::nilaiKeGrade(83));
        $this->assertSame('B+', Nilai::nilaiKeGrade(78));
        $this->assertSame('B', Nilai::nilaiKeGrade(72));
        $this->assertSame('B-', Nilai::nilaiKeGrade(67));
        $this->assertSame('C+', Nilai::nilaiKeGrade(62));
        $this->assertSame('C', Nilai::nilaiKeGrade(58));
        $this->assertSame('D', Nilai::nilaiKeGrade(50));
        $this->assertSame('E', Nilai::nilaiKeGrade(40));
    }

    public function test_grade_to_indeks_matches_new_bobot_values(): void
    {
        $this->assertSame(4.00, Nilai::gradeToIndeks('A'));
        $this->assertSame(3.70, Nilai::gradeToIndeks('A-'));
        $this->assertSame(3.30, Nilai::gradeToIndeks('B+'));
        $this->assertSame(3.00, Nilai::gradeToIndeks('B'));
        $this->assertSame(2.70, Nilai::gradeToIndeks('B-'));
        $this->assertSame(2.30, Nilai::gradeToIndeks('C+'));
        $this->assertSame(2.00, Nilai::gradeToIndeks('C'));
        $this->assertSame(1.00, Nilai::gradeToIndeks('D'));
        $this->assertSame(0.00, Nilai::gradeToIndeks('E'));
    }
}
