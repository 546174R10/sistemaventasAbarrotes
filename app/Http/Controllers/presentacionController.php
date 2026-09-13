<?php

namespace App\Http\Controllers;
//  use App\Http\Requests\UpdatePresentaconRequest;
use App\Http\Requests\StorePresentacionRequest;
use App\Http\Requests\UpdatePresentaconRequest;
use App\Models\Caracteristica;
use App\Models\Presentacione;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class presentacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presentaciones = Presentacione::with('caracteristica')->latest()->latest()->get();
    //   dd($presentaciones);

        return view('presentacion.index',['presentaciones'=> $presentaciones]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('presentacion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePresentacionRequest $request)
    {

    //   dd($request);

      try {
      DB::beginTransaction();
      // Crear la característica (nombre y descripción)
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->presentacione()->create([
                'caracteristica_id'=>$caracteristica->id
            ]);
            DB::commit();
} catch (Exception $e) {
    DB::rollBack();
    //throw $th;
      }
      return redirect()->route('presentaciones.index')->with('success','Presentacion registrada');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presentacione $presentacione)
    {
        // dd($presentacione);
return view('presentacion.edit',['presentacione'=>$presentacione]);
        }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePresentaconRequest $request, Presentacione $presentacione)
    {
        // lógica para actualizar la presentacion
        Caracteristica::where('id', $presentacione->caracteristica->id)
            ->update($request->validated());
        return redirect()->route('presentaciones.index')->with('success', 'Presentación editada');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($id);

        $presentacion = Presentacione::find($id);
      if($presentacion->caracteristica->estado==1){
        //busqueda  en tabla caracteristicas y actualizacion de estado a 0
           Caracteristica::where ('id' ,$presentacion->caracteristica->id)
       ->update([
        'estado' => 0
        ]);
        $message = 'Presentación eliminada';
      }else{
           Caracteristica::where ('id' ,$presentacion->caracteristica->id)
       ->update([
        'estado' => 1
        ]);
        $message = 'Presentación restaurada';
      }
        return redirect()->route('presentaciones.index')->with('success', $message);
    }
}
