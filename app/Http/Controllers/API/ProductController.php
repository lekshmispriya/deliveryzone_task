<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use DataTables;
use file;
use ApiResponseHelpers;
use Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
class ProductController extends BaseController
{

   
    public function getproduct($id)
    {
        $product = Product::find($id);
  
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        else{
            $product = Product::where('id',$id)->get(); 
        }
   
        return $this->sendResponse($product, 'Product retrieved successfully.');
    }
    
    
    public function saveProduct(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'sku' => 'required',
            'price' => 'required',
            'status' => 'required',
            'image' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $product         = new Product;
        $product->name   = $request->name;
        $product->sku    = $request->sku;
        $product->price  = $request->price;
        $product->status = $request->status;

       // $product->image=$request->image;

        if($request->hasFile('image')) {
            $file = $request->image;
            //getting timestamp
            $timestamp = str_replace([' ', ':'], '-', time());

            $name = $timestamp. '-' .$file->getClientOriginalName();

            $product->image = $name;

            $file->move(public_path().'/images/', $name);
        }
        
        $product ->save();
        $products = Product::where('id',$product->id)->get(); 
        return $this->sendResponse($products, 'Product created successfully.');
    } 
    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        unset($input['id']);
        $validator = Validator::make($input, [
            'name' => 'required',
            'sku' => 'required',
            'price' => 'required',
            'status' => 'required',
            'id' => 'id'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $product = Product::find($request->id);
  
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        if($request->hasFile('image')) {
            $file = $request->image;
            //getting timestamp
            $timestamp = str_replace([' ', ':'], '-', time());

            $name = $timestamp. '-' .$file->getClientOriginalName();

            $input['image'] = $name;

            $file->move(public_path().'/images/', $name);
        }
        
        Product::where('id',$request->id)->update($input);
        $product = Product::where('id',$request->id)->get();
        return $this->sendResponse($product, 'Product updated successfully.');
    }

    public function destroy($productId)
    {
        $product = Product::find($productId);
  
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        Product::where('id',$productId)->delete();
   
        return $this->sendResponse([], 'Product deleted successfully.');
    }

    public function ajaxForm(Request $request)
    {
       if ($request->ajax()) {
            $data = Product::latest()->get(); 
            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('image',function($row){
                $img_url=url('public/images/'.$row->image);
                return $image ="<img style='
                height: 20px;
                width: 20px;
            ' src='".$img_url."'/>";
            })
            ->addColumn('Actions',function($row){
                $btn = '<a href="'.url("/editView/".$row->id).'" data-toggle="tooltip" data-id="'.$row->id.'" title="Edit" class=" btn btn-primary btn-sm ">Edit</a>';
                 $btn = $btn.' <button data-toggle="tooltip" data-id="'.$row->id.'" title="Delete" class="btn btn-danger btn-sm delete">Delete</button>';
                return $btn;
                
            })
            ->rawColumns(['Actions','image'])
            ->make(true);
        }

    }

    public function createView()
    {
        return view('add_product');
    }

    public function addProduct_Web(Request $request)
    {
       if(isset($request))
       {
       // print_r($request->file);die;
        if(isset($request->id))
        {
            $input = $request->all();
            unset($input['id']);
            unset($input['_token']); 
            if($request->hasFile('image')) {
                $file = $request->image;
                //getting timestamp
                $timestamp = str_replace([' ', ':'], '-', time());
    
                $name = $timestamp. '-' .$file->getClientOriginalName();
    
                $input['image'] = $name;
    
                $file->move(public_path().'/images/', $name);
            }
           // print_r($input);die;
            Product::where('id',$request->id)->update($input);
            $response = array("status"=>true,"msg"=>"Product updated successfully");
        }else{
            

            $product         = new Product;
            $product->name   = $request->name;
            $product->sku    = $request->sku;
            $product->price  = $request->price;
            $product->status = $request->status;
    
           // $product->image=$request->image;
    
            if($request->hasFile('image')) {
                $file = $request->image;
                //getting timestamp
                $timestamp = str_replace([' ', ':'], '-', time());
    
                $name = $timestamp. '-' .$file->getClientOriginalName();
    
                $product->image = $name;
    
                $file->move(public_path().'/images/', $name);
            }
            
            $product ->save();
            $response = array("status"=>true,"msg"=>"Product created successfully");
        }
       
        
       } 
       else{
        $response = array("status"=>false,"msg"=>"error");
       }

       return json_encode($response);
    }

    public function editView($id)
    {
        $product = Product::where('id',$id)->get();
        return view('add_product',compact('product'));
    }

    public function getProduct_Web($id)
    {
        return view('add_product');
    }

    public function deleteProduct_Web(Request $request)
    {
        $productId = $request->id;
        $product = Product::find($productId);
  
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        Product::where('id',$productId)->delete();
   
        return $this->sendResponse([], 'Product deleted successfully.');
    }

}
