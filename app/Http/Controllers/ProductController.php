<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStore;
use App\Models\Product;
use App\Models\Tribute;
use App\Models\UnitMeasure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    //
    public static function create()
    {
        return Inertia::render('Products/Create', [
            'tributes' => Tribute::all(),
            'units_measures' => UnitMeasure::all()
        ]);
    }
    public static function store(ProductStore $request)
    {
        $validated = $request->validated();

        $prefix = 'COTO-';
        $lastProduct = Product::latest()->first();
        $lastId = $lastProduct ? $lastProduct->id : 0;
        $code_reference = $prefix . ( $lastId + 1);
        $standard_code_id = 1; /* Estandar de adopcion del contribuyende, es el mas usado.  */

        $validated['code_reference'] = $code_reference;
        $validated['standard_code_id'] = $standard_code_id;

        $result = Product::create($validated);

        return response()->json([
            'message' => 'Producto creado correctamente',
            'product' => $result
        ]);
        
    }
}
