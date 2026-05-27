<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Mahasiswa;

class MahasiswaPolicy
{
    /**
     * Only admin dan dosen can view all
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'dosen']);
    }

    public function view(User $user, Mahasiswa $mahasiswa): bool
    {
        return $user->role === 'admin' || $user->isMahasiswa();
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Mahasiswa $mahasiswa): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Mahasiswa $mahasiswa): bool
    {
        return $user->role === 'admin';
    }
}
