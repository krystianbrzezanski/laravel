<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Powiązanie z kategorią (MVP: Katalog produktów i drzewo kategorii)
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique()->nullable(); // SKU (MVP: Zarządzanie produktami)
            $table->text('description')->nullable();
            
            $table->decimal('price', 10, 2);              // Cena netto
            $table->decimal('vat_rate', 5, 2)->default(23.00); // VAT (MVP: Podatki)
            $table->integer('stock')->default(0);         // Magazyn (MVP: Stany magazynowe)
            
            $table->string('image')->nullable();          // Zdjęcie (zgodnie z wcześniejszym krokiem)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};