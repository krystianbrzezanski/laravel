<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // 1. Pobieramy kategorie do menu głównego
        $categories = Category::whereNull('parent_id')->with('children')->get();

        // 2. Rozpoczynamy zapytanie o produkty z relacją kategorii
        $query = Product::with('category');

        // 3. FILTRACJA: Po kategorii, jeśli została wybrana
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 4. SORTOWANIE: Obsługa logiki z widoku
        switch ($request->get('sort')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest(); // Domyślnie pokazuj najnowsze
                break;
        }

        $products = $query->get();
        
        return view('welcome', compact('products', 'categories'));
    }
}