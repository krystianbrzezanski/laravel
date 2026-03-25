<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', // Dodajemy powiązanie z kategorią
        'name',
        'slug',
        'price',       // Cena netto (zgodnie z MVP)
        'vat_rate',    // Stawka VAT (np. 23)
        'description',
        'image',
        'stock',       // Zarządzanie stanem magazynowym z MVP
        'sku',         // Unikalny identyfikator produktu
    ];

    /**
     * Relacja: Produkt należy do jednej kategorii.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Pomocnik: Oblicza cenę brutto na podstawie stawki VAT.
     */
    public function getPriceBruttoAttribute()
    {
        return $this->price * (1 + ($this->vat_rate / 100));
    }
}