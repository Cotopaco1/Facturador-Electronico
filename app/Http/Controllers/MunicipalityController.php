<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

class MunicipalityController extends Controller
{
    //
    public static function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:255'
        ]);

        $query = $request->query('query');
        $searchResults = (new Search())
            ->registerModel(Municipality::class, 'name')
            ->limitAspectResults(20)
            ->search(request('query'));

        return response()->json([
            'municipalities' => $searchResults,
        ]);

    }
}
