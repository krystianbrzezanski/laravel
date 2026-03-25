<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            
            // Relacja do zamówienia (KLUCZ OBCY)
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            
            // Dane produktu (zapisujemy je na sztywno)
            $table->string('product_name'); 
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Cena jednostkowa w momencie zakupu
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};