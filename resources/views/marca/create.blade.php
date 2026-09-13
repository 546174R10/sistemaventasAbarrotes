@extends('template')

@section('title','Crear Marca')

@push('css')
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<style>
    #descripcion{
        resize: none;
    }
    </style>
@enpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear Marcas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('marcas.index')}}">Marcas</a></li>
        <li class="breadcrumb-item active">Crear Marca</li>
    </ol>

     <div class="container w-100 border border-3 border-primary rounder p-4 mt-3">
        <form action="{{route('marcas.store')}}" method="post">
            <!--csrf Nos ayuda para la pagina expirada al guardar cambios-->
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
                </div><!-- fin -->
            </div>
        </form>
    </div>

</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
