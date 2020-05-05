<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Products;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Repository\ProductRepository;

class ProductController extends Controller
{
    private $product;

    public function __construct(Products $product)
    {
        $this->product = $product;
    }

    public function index(Request $request)
    {
        //http://localhost:8000/api/products?fields=name,slug,price&conditions=name:=:produto editado;price:=:39.99
        //http://localhost:8000/api/products?fields=name,slug,price&conditions=name:like:%pr%
        //http://localhost:8000/api/products?fields=name,slug,price&conditions=price:>:9

        $products = $this->product;
        //a linha acima eu comentei pq estou criando o productrepository

        $productRepository = new ProductRepository($products);

        
        //conditions=name:Nanderson;price=X
        if($request->has('conditions')){
            /*
            $expressions = explode(';', $request->get('conditions'));
            foreach ($expressions as $e){
                $exp = explode(':', $e);
                $products = $products->where($exp[0], $exp[1], $exp[2]);
            }
            */
            //return response()->json($condition);
            $products = $productRepository->selectConditions($request->get('conditions'));
        }
        
        if ($request->has('fields')) {
            $products = $productRepository->selectFilter($request->get('fields'));
        }

        /*
        if($request->has('fields')){
            $fields = $request->get('fields');
            //return response()->json($fields);
            //$products = $products->select('name', 'price');
            $products = $products->selectRaw($fields);
        }
        */

        //$products = $this->product->all();
        //$products = $this->product->paginate(10);
        //return response()->json($products);

        //return new ProductCollection($products->paginate(10));
        //apos as modificações feitas no productRepository tenho  linha abaixo
        return new ProductCollection($productRepository->getResult()->paginate(10));
    }

    public function show($id)
    {
        $product = $this->product->find($id);
        //return response()->json($product);
        return new ProductResource($product);
    }

    public function save(ProductRequest $request)
    {
        $data = $request->all();
        $product = $this->product->create($data);
        return response()->json($product);
    }

    public function update(ProductRequest $request)
    {
        $data = $request->all();
        $product = $this->product->find($data['id']);
        $product->update($data);
        return response()->json($product);
    }

    public function delete($id)
    {
        $product = $this->product->find($id);
        $product->delete();

        return response()->json(['data' => ['msg' => 'Produto removido com sucesso.']]);
    }
}
