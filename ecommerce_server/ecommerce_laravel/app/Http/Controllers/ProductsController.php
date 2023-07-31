<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    function getAll(){
        try{    
            // $products = ProductCategory::with('products')->get();

            $products = Product::with('category')->get();
            return $this->customResponse($products);
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }
        //http://127.0.0.1:8000/api/admin/product/all
    }

    function getById(Product $product){
        try{
          
            return $this->customResponse($product->load('category'));
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }
        //http://127.0.0.1:8000/api/admin/product/2
    }

    function store(Request $request_info){
        try{   
           $validated_data = $this->validate($request_info, [
                'name' => ['required','string', 'unique:products'],
                'description' => ['string'],
                'price' => ['required','numeric'],
                'product_categories_id' => ['required','exists:product_categories,id']
            ]); 

            $product = Product::create($validated_data);

            return $this->customResponse($product, 'Product Created Successfully');
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }
        //http://localhost:8000/api/admin/product/store
    }

    function destroy($id){
        try{
            $product = Product::find($id)->delete();
            return $this->customResponse($product, 'Deleted Successfully');
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }
        //http://localhost:8000/api/admin/product/destroy/12
    }

    function update(Request $request_info){
        try{
            $product = Product::find($request_info->id);
            $product->name = $request_info->name;
            $product->description = $request_info->description;
            $product->price = $request_info->price;
            $product->product_categories_id = $request_info->product_categories_id;
            $product->save();

            return $this->customResponse($product, 'Updated Successfully');
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }

        //http://localhost:8000/api/admin/product/update/
    }

    function customResponse($data, $status = 'success', $code = 200){
        $response = ['status' => $status,'data' => $data];
        return response()->json($response,$code);
    }
}
