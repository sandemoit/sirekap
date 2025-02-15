<?php

namespace App\Traits;

trait HasRoles
{
    public function isAdmin(): bool
    {
        return $this->HasRole('admin');
    }

    public function isGuru(): bool
    {
        return $this->HasRole('guru');
    }

    public function isKepsek(): bool
    {
        return $this->HasRole('kepala_sekolah');
    }

    public function isStaf(): bool
    {
        return $this->HasRole('staff_administrasi');
    }

    public function HasRole(string $role): bool
    {
        return $this->role === $role;
    }
}
