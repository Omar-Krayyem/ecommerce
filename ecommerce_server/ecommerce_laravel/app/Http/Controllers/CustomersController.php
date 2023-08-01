<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\ProductCategory;
use Exception;

class CustomersController extends Controller
{
    function getFavorites($id){
        try{
            $favoriteProductIds = Favorite::where('user_id', $id)->pluck('product_id');

            // Get the actual product details using the product ids
            $favoriteProducts = Product::whereIn('id', $favoriteProductIds)->get();

            return $this->customResponse($favoriteProducts);            
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }
    }

    function addFavorite(Request $request_info){
        try{
            $validated_data = $this->validate($request_info, [
                'product_id' => ['required','exists:products,id'],
                'user_id' => ['required','exists:users,id'],
            ]); 

            $favorite = Favorite::create($validated_data);

            return $this->customResponse($favorite, 'Favorite Added Successfully');
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }
        //http://127.0.0.1:8000/api/client/favorite/add
    }

    function destroy($id){
        try{

            $favoritte = Favorite::find($id)->delete();

            return $this->customResponse($favoritte, 'Deleted Successfully');
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }
        //http://localhost:8000/api/admin/category/destroy/18
    }

    function customResponse($data, $status = 'success', $code = 200){
        $response = ['status' => $status,'data' => $data];
        return response()->json($response,$code);
    }
}
