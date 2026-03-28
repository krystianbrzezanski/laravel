<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tworzy użytkownika (korzystając z poprawionej fabryki powyżej)
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.pl',
        ]);

        // DODAJEMY KATEGORIĘ
        $category = \App\Models\Category::create([
            'name' => 'Elektronika',
            'slug' => 'elektronika'
        ]);

        // DODAJEMY PRODUKTY DO TEJ KATEGORII
        \App\Models\Product::create([
            'name' => 'Laptop Gamingowy',
            'slug' => 'laptop-gamingowy',
            'description' => 'Super szybki laptop.',
            'price' => 4500.00,
            'category_id' => $category->id,
            'stock' => 10
        ]);

        \App\Models\Product::create([
            'name' => 'Myszka',
            'slug' => 'myszka-usb',
            'description' => 'Myszka optyczna.',
            'price' => 50.00,
            'category_id' => $category->id,
            'stock' => 50
        ]);
    }
}
