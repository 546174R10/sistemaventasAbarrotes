<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\marca;
use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use App\Models\Caracteristica;
use Exception;
use PhpParser\Node\Stmt\TryCatch;

class marcaController extends Controller
{

    public function index()
    {
        $marcas = Marca::with('caracteristica')->latest()->get();
        //    dd($marcas);
        return view('marca.index', ['marcas' => $marcas]);
    }

    public function create()
    {
        return view('marca.create');
    }



    public function store(StoreMarcaRequest $request)
    {
        try {
            DB::beginTransaction();

            // Crear la característica (nombre y descripción)
            $caracteristica = Caracteristica::create($request->validated());

            // Crear la marca relacionada, sin pasar caracteristica_id porque Laravel lo asigna automáticamente
            $caracteristica->marca()->create([
                'caracteristica_id' => $caracteristica->id
            ]);

            DB::commit();

            // dd('llego aqui');
            return redirect()->route('marcas.index')->with('success', 'Marca registrada');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al crear la marca: ' . $e->getMessage()]);
        }
    }
    public function show(string $id)
    {
        //
    }
    public function edit(marca $marca)
    {
        return view('marca.edit', ['marca' => $marca]);
    }

    public function update(UpdateMarcaRequest $request, Marca $marca)
    {
        // lógica para actualizar la marca
        Caracteristica::where('id', $marca->caracteristica->id)
            ->update($request->validated());
        return redirect()->route('marcas.index')->with('success', 'Marca editada');
    }

    public function destroy(string $id)
    {
        $message = '';
        $marca = Marca::find($id);
        if ($marca->caracteristica->estado == 1) {
            Caracteristica::where('id', $marca->caracteristica->id)
                ->update([
                    'estado' => 0
                ]);
            $message = 'Marca eliminada';
        } else{
            Caracteristica::where('id', $marca->caracteristica->id)
                ->update([
                    'estado' => 1
                ]);
        $message = 'Marca restaurada';
            }
        return redirect()->route('marcas.index')->with('success', $message);
    }
}
