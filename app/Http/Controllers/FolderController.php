<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeckStoreRequest;
use App\Http\Requests\FolderStoreRequest;
use App\Models\Folder;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FolderController extends Controller
{
    public function store(FolderStoreRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $folder = new Folder();
            $folder->fill($request->all());
            $folder->save();

            DB::commit();
            return response()->json(['message' => 'Registro salvo com sucesso', 'data' => $folder]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());//deverá haver tratamento de exception
        }
    }

    public function show(string $id)
    {
        //
        try {
            $folder = Folder::findOrFail($id);

            return response()->json(['message' => 'Registro: ', 'data' => $folder]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        //
        try {
            DB::beginTransaction();

            $folder = Folder::findOrFail($id);
            $folder->fill($request->all());
            $folder->save();    

            DB::commit();
            return response()->json(['message' => 'Registro alterado com sucesso', 'data' => $folder]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
