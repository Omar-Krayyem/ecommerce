<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
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

    function getCart($id){
        try{
            $users_id = $id;
            $cart = Cart::where('users_id', $users_id)->first();

            if($cart){
                $cart_id = $cart->id;

                $cart_items = CartItem::where('carts_id', $cart_id)->get();
                foreach ($cart_items as $cart_item) {
                    $name = Product::find($cart_item->products_id)->name;
                    $description = Product::find($cart_item->products_id)->description;
                    $price = Product::find($cart_item->products_id)->price;
    
                    $cart_item->name = $name;
                    $cart_item->description = $description;
                    $cart_item->price = $price;
                }
                return self::customResponse($cart_items, 'sucess', 200);
            }
            else{
                $cart = new Cart();
                $cart->users_id = $users_id;
                $cart->total = 0;
                $cart->save();

                $cart_id = $cart->id;
                return self::customResponse($cart_id, 'created new cart with 0 item', 200);
            }
            
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }
        //http://127.0.0.1:8000/api/client/cart/2
    }

    function addCartItem(Request $request_info){
        try{
            $validated_data = $this->validate($request_info, [
                'user_id' => ['required','numeric'],
                'product_id' => ['required','numeric'],
                
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

    function deleteItem($product_id){
        try{
            $user_id = auth()->user()->id;
            // $user_id = 3;
            $cart_id = Cart::where('users_id', $user_id)->first()->id;
            
            $cart_item = CartItem::where('carts_id', $cart_id)->where('products_id', $product_id)->first();
            
            if ($cart_item) {
                $cart_item->delete();
                return $this->customResponse(null, 'Deleted Successfully');
            } 
            else {
                return $this->customResponse(null, 'CartItem not found', 404);
            }

            return $this->customResponse($cart_item, 'Deleted Successfully');
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }
    }

    function customResponse($data, $status = 'success', $code = 200){
        $response = ['status' => $status,'data' => $data];
        return response()->json($response,$code);
    }
}
