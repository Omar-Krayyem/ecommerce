<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

    function destroy(Request $request_info){
        try{
            $validated_data = $this->validate($request_info, [
                'product_id' => ['required','exists:products,id'],
                'user_id' => ['required','exists:users,id'],
            ]); 

            $user_id = $request_info->user_id;
            $product_id = $request_info->product_id;

            $favorite = Favorite::where('user_id', $user_id)
                    ->where('product_id', $product_id)
                    ->delete();

            return $this->customResponse($favorite, 'Deleted Successfully');
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }
        //http://localhost:8000/api/admin/category/destroy/18
    }

    function getCart(User $user){
        try{
            $cart_items = $user->cart->items->load('product'); 

            if(!$cart_items) return self::customResponse([], "No cart items", 200);
            
            return self::customResponse($cart_items, 'sucess', 200);
          
            
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }
        //http://127.0.0.1:8000/api/client/cart/2
    }

    function addCartItem(Request $request_info){
        try{
            $validated_data = $this->validate($request_info, [
                'user_id' => ['required','numeric'],
     -           'product_id' => ['required','numeric'],
                
            ]);
    
            $user_id = $request_info->user_id;
            $product_id = $request_info->product_id;
    
            // echo $user_id . ' ' . $product_id;
            $cart = Cart::where('users_id', $user_id)->first();
            
            if(!$cart) {
                $cart = new Cart();
                $cart->users_id = $user_id;
                $cart->save();
    
                $cart_id = $cart->id;
            }

            $cart_item = CartItem::where('carts_id', $cart->id)->where('products_id', $product_id)->first();
            if($cart_item){
                return $this->customResponse($cart_item, 'Allready exist');
            }

            $cart_item = new CartItem();
            $cart_item->carts_id = $cart->id;
            $cart_item->products_id = $product_id;

            $cart_item->save();

            return $this->customResponse($cart_item, 'Added Successfully');
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }
        //http://127.0.0.1:8000/api/client/cart/add/
    }

    function deleteItem(CartItem $item){
        try{
            $item->delete();
            return $this->customResponse([], 'Deleted Successfully');

        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }
    }

    function customResponse($data, $status = 'success', $code = 200){
        $response = ['status' => $status,'data' => $data];
        return response()->json($response,$code);
    }
}
