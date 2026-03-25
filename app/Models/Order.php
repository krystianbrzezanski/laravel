<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    // Te pola pozwalają na zapisywanie danych z formularza do bazy
    protected $fillable = [
        'customer_name', 
        'email', 
        'address', 
        'city', 
        'zip_code', 
        'total_brutto', 
        'status'
    ];

    /**
     * Relacja: Jedno zamówienie ma wiele produktów (OrderItem)
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}