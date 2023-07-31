<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Exception;

class AdminController extends Controller
{
    function getall(){
        try{    
            // $products = ProductCategory::with('products')->get();

            $users = Users::where('user_types_id', 2)->with('type')->get();
            return $this->customResponse($users);
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }
        //http://127.0.0.1:8000/api/product/all
    }

    function getCategory(){
        try{    
            // $products = ProductCategory::with('products')->get();

            $category = ProductCategory::all();
            return $this->customResponse($category);
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }
        //http://127.0.0.1:8000/api/admin/category/all
    }

    function getById(ProductCategory $category){
        try{
            return $this->customResponse($category);
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }
        //http://127.0.0.1:8000/api/admin/category/2
    }

    function store(Request $request_info){
        try{   
           $validated_data = $this->validate($request_info, [
                'category' => ['required','string', 'unique:product_categories'],
            ]); 
                $category = ProductCategory::create($validated_data);

            return $this->customResponse($category, 'Category Created Successfully');
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }
    }

    function destroy($id){
        try{

            $category = ProductCategory::find($id);
            $associatedProducts = $category->products;

            if ($associatedProducts->isNotEmpty()) {
                return $this->customResponse('Cannot delete category. It has associated products.', 'error', 400);
            }

            $category->delete();
            return $this->customResponse($category, 'Deleted Successfully');
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }
        //http://localhost:8000/api/admin/category/destroy/18
    }

    function update(Request $request_info){
        try{
            $category = ProductCategory::find($request_info->id);
            $category->category = $request_info->category;
            $category->save();

            return $this->customResponse($category, 'Updated Successfully');
        }catch(Exception $e){
            return self::customResponse($e->getMessage(),'error',500);
        }

        //http://localhost:8000/api/admin/category/update/17
    }

    function customResponse($data, $status = 'success', $code = 200){
        $response = ['status' => $status,'data' => $data];
        return response()->json($response,$code);
    }
}
