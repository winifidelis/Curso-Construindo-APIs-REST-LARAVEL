<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Products;

class ProductController extends Controller
{
    private $product;
    
    public function __construct(Products $product) {
        $this->product = $product;
    }
    
    public function index(){
        $products = $this->product->all();
        return response()->json($products);
    }
    
    public function show($id){
        $product = $this->product->find($id);
        return response()->json($product);
    }
    
    public function save(Request $request){
        $data = $request->all();
        $product = $this->product->create($data);
        return response()->json($product);
    }
    
    public function update(Request $request){
        $data = $request->all();
        $product = $this->product->find($data['id']);
        $product->update($data);
        return response()->json($product);
    }
    
    public function delete($id){
        $product = $this->product->find($id);
        $product->delete();
        
        return response()->json(['data' => ['msg' => 'Produto removido com sucesso.']]);
    }
}
