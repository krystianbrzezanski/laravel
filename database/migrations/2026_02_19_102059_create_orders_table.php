<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Dane klienta (Punkt 2.3 MVP)
            $table->string('customer_name');
            $table->string('email');
            $table->string('address');
            $table->string('city');
            $table->string('zip_code');
            
            // Finanse
            $table->decimal('total_brutto', 10, 2);
            
            // Status (Punkt 7 planu - "nowe", "opłacone", "wysłane")
            $table->string('status')->default('nowe');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};