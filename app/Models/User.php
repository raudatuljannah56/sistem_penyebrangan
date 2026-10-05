<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements HasName, HasAvatar, FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'nama',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Nama user yang ditampilkan oleh Filament.
     */
    public function getFilamentName(): string
    {
        return $this->nama;
    }

    /**
     * Foto profil yang digunakan oleh avatar Filament.
     */
    public function getFilamentAvatarUrl(): ?string
    {
        if (! $this->foto) {
            return null;
        }

        if (! Storage::disk('public')->exists($this->foto)) {
            return null;
        }

        return Storage::disk('public')->url($this->foto);
    }

    /**
     * Mengecek apakah user adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Mengecek apakah user adalah petugas.
     */
    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    /**
     * Menentukan akses user ke panel Filament.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->role === 'admin',
            'petugas' => $this->role === 'petugas',
            default => false,
        };
    }

    /**
     * Satu user/petugas dapat memiliki banyak shift.
     */
    public function shifts(): HasMany
    {
        return $this->hasMany(
            Shift::class,
            'id_user',
            'id_user'
        );
    }
}