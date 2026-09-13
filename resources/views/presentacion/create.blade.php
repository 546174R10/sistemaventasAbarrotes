@extends('template')

@section('title','Crear presentacion')

@push('css')
<style>
    #descripcion{
        resize: none;
    }
    </style>
@endpush

@section('content')
<div class="container-fluid px-4"> <!--inicio contenido-->
    <h1 class="mt-4 text-center">Crear Presentacion</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('presentaciones.index')}}">Presentacion</a></li>
       <li class="breadcrumb-item active">Crear Presentacion</li>
    </ol>
    <!-- formulario -->

     <div class="container w-100 border border-3 border-primary rounder p-4 mt-3">
        <form action="{{route('presentaciones.store')}}" method="post">
            <!--csrf Nos ayuda para la pagina expirada al guardar cambios-->
   @method('PATCH')
            @csrf
            <div class="row g-3">
                <!--inicio div de nombre -->
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre')}}">
                    @error('nombre')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                <!--fin-->

                <!-- inicio Descripcion -->
                <div class="col-md-12">
                    <label for="descripcion" class="form-label">Descripcion:</label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="form-control">{{old('descripcion')}}</textarea>
                    @error('descripcion')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div> <!--fin-->
                <!--inicio boton  -->
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="submit" class="btn btn-secondary">Cancelar</button>
                </div><!-- fin -->
            </div>
        </form>
    </div>
    </div>
@endsection

@push('js')

@endpush
