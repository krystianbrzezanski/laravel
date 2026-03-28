<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // To usunie starą wersję tabeli, która nie ma kolumny user_id
        Schema::dropIfExists('orders');

        // To stworzy ją poprawnie od zera
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('customer_name');
            $table->string('email');
            $table->string('address');
            $table->string('city');
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('nowe');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};