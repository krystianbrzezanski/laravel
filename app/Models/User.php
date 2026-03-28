<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser; // Dodane
use Filament\Panel; // Dodane
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser // Zmienione: dodano implements
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Funkcja pozwalająca na dostęp do panelu Filament.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Tutaj wpisz swój prawdziwy adres e-mail admina
        return $this->email === 'admin@test.pl'; 
    }
}