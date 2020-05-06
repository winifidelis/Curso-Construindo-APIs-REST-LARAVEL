<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\RealStateRequest;
use App\RealState;

class RealStateController extends Controller
{
    private $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }

    public function index()
    {
        //dd(auth('api')->user());
        $realStates = auth('api')->user()->real_state();
        //$realState = $this->realState->paginate('10');
        return response()->json($realStates->paginate(10), 200);
    }

    public function show($id)
    {
        try {

            //$realState = $this->realState->with('photos')->findOrFail($id);
            $realState = auth('api')->user()->real_state()->with('photos')->findOrFail($id);

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel exibido com sucesso!',
                    'data' => $realState,
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function store(RealStateRequest $request)
    {
        $data = $request->all();

        $images = $request->file('images');

        try {

            $data['user_id'] = auth('api')->user()->id;

            $realState = $this->realState->create($data); //Adicionando dados em massa

            if (isset($data['categories']) && count($data['categories'])) {
                //sync faz a sincronização 
                $realState->categories()->sync($data['categories']);
            }

            if ($images) {
                $imagesUploaded = [];
                foreach ($images as $image) {
                    $path = $image->store('images', 'public');
                    $imagesUploaded[] = ['photo' => $path, 'is_thumb' => false];
                }

                $realState->photos()->createMany($imagesUploaded);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel cadastrado com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function update($id, RealStateRequest $request)
    {
        $data = $request->all();
        $images = $request->file('images');

        try {
            //$realState = $this->realState->findOrFail($id);
            $realState = auth('api')->user()->realState()->findOrFail($id);
            $realState->update($data);

            if (isset($data['categories']) && count($data['categories'])) {
                //sync faz a sincronização 
                $realState->categories()->sync($data['categories']);
            }

            if ($images) {
                $imagesUploaded = [];
                foreach ($images as $image) {
                    $path = $image->store('images', 'public');
                    $imagesUploaded[] = ['photo' => $path, 'is_thumb' => false];
                }

                $realState->photos()->createMany($imagesUploaded);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel atualizado com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function destroy($id)
    {
        try {
            //$realState = $this->realState->findOrFail($id);
            $realState = auth('api')->user()->realState()->findOrFail($id);
            $realState->delete();
            return response()->json([
                'data' => [
                    'msg' => 'Imóvel excluido com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
