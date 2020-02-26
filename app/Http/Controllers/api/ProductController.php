<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Product;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $product = '';
        try{
            DB::beginTransaction();
            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'price' => $request->price,
            ]);

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            dd($e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }


        return response()->json($product, 201);
    }
}
