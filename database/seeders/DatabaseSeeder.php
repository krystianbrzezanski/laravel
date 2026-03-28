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
        // Tworzy użytkownika (już bez błędu)
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // DODAJEMY KATEGORIĘ I PRODUKTY
        $category = \App\Models\Category::create([
            'name' => 'Elektronika',
            'slug' => 'elektronika'
        ]);

        \App\Models\Product::create([
            'name' => 'Laptop Gamingowy',
            'slug' => 'laptop-gamingowy',
            'description' => 'Super szybki laptop do gier.',
            'price' => 4500.00,
            'category_id' => $category->id,
            'stock' => 5
        ]);

        \App\Models\Product::create([
            'name' => 'Mysz Bezprzewodowa',
            'slug' => 'mysz-bezprzewodowa',
            'description' => 'Precyzyjna mysz do pracy.',
            'price' => 150.00,
            'category_id' => $category->id,
            'stock' => 20
        ]);
    }
}
