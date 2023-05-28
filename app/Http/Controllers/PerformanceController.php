<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerformanceStoreRequest;
use App\Models\Performance;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerformanceController extends Controller
{
    public function store(PerformanceStoreRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $performance = new Performance();
            $performance->fill($request->all());
            $performance->save();

            DB::commit();
            return response()->json(['message' => 'Registro salvo com sucesso', 'data' => $performance]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());//deverá haver tratamento de exception
        }
    }

    public function show(string $id)
    {
        //
        try {
            $performance = Performance::findOrFail($id);

            return response()->json(['message' => 'Registro: ', 'data' => $performance]);
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

            $performance = Performance::findOrFail($id);
            $performance->fill($request->all());
            $performance->save();    

            DB::commit();
            return response()->json(['message' => 'Registro alterado com sucesso', 'data' => $performance]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
