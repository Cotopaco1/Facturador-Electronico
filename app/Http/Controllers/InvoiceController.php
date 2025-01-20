<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceStoreRequest;
use App\Models\IdentificationDocument;
use App\Models\Municipality;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Services\RequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    //
    public static function create()
    {
        $products = Product::all()->map(function ($product) {
            $product->priceFormatted = number_format($product->price, 2, '.', ',');
            return $product;
        });

        return Inertia::render('Quotation/Create', [
            'products' => $products->toArray(),
            'identifications_documents' => IdentificationDocument::all()->toArray(),
            'payment_methods' => PaymentMethod::all()->toArray(),
        ]);
    }
    public static function store(InvoiceStoreRequest $request)
    {
        $data = $request->all();

        $numbering_range_id = 8; //Rango de numeracion de facturas parece ser fijo siempre.
        $document = '01'; //Corresponde al codigo de 'Factura electronica de venta'
        $reference_code = 'FACT_'. time(); //Codigo unico de referencia de la factura
        
        
        $data['numbering_range_id'] = $numbering_range_id;
        $data['document'] = $document;
        $data['reference_code'] = $reference_code;
        $data['payment_due_date'] = now()->addDay()->format('Y-m-d');

        Storage::disk('local')->put("invoice_with_reference_{$data['reference_code']}.json", json_encode($data, JSON_PRETTY_PRINT));
        
        $response = Http::withHeaders(RequestService::getHeadersApiFactus())
                    ->post(
                        env('FACTUS_BASE_URL') . '/v1/bills/validate',
                        $data, 
                    );
        if(!$response->successful()){
            return response()->json([
                'data' => $response->json(),
                'message' => 'Error al validar la factura con factus'
            ], 400);
        }
        return response()->json([
            'data' => $response->json(),
            'message' => 'Factura validada con exito',
            'status'    => 'ok'
        ]);

        dd([
            $response->json(),
            $data
        ]);

    }
    public static function index()
    {
        $response = Http::withHeaders(RequestService::getHeadersApiFactus())
                    ->get(
                        env('FACTUS_BASE_URL') . '/v1/bills',
                    );
        
        return Inertia::render('Quotation/Index', [
            'invoices' => $response->json()['data']
        ]);
    }
    public static function download($number)
    {
        $response = Http::withHeaders(RequestService::getHeadersApiFactus())
                    ->get(
                        env('FACTUS_BASE_URL') . '/v1/bills/download-pdf/' . $number,
                    );
        if(!$response->successful()){
            return response()->json([
                'data' => $response->json(),
                'message' => 'Error al descargar la factura'
            ], 400);
        }
        
        $data = $response->json()['data'];
        $file = base64_decode($data['pdf_base_64_encoded']);
        $filename = $data['file_name'];

        return response($file, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"'
        ]);
    }
}
