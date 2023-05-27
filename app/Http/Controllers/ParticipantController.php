<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeckStoreRequest;
use App\Models\Participant;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParticipantController extends Controller
{
    public function store(DeckStoreRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $participant = new Participant();
            $participant->fill($request->all());
            $participant->save();

            DB::commit();
            return response()->json(['message' => 'Registro salvo com sucesso', 'data' => $participant]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());//deverá haver tratamento de exception
        }
    }

    public function show(string $id)
    {
        //
        try {
            $participant = Participant::findOrFail($id);

            return response()->json(['message' => 'Registro: ', 'data' => $participant]);
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

            $participant = Participant::findOrFail($id);
            $participant->fill($request->all());
            $participant->save();    

            DB::commit();
            return response()->json(['message' => 'Registro alterado com sucesso', 'data' => $participant]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
