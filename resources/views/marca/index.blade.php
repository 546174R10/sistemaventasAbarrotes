@extends ('template')

@section('title', 'Marcas')

@push('css')
<!-- Carga el CDN de SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush


@section('content')
<!-- inicio -->
@if(session('success'))
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<script>
    // Obtiene el mensaje de éxito de la sesión y lo convierte a formato JSON seguro para JS
    let message = "{{ session('success') }}";

    // Configura el toast de SweetAlert2
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    // Muestra el toast con el mensaje
    Toast.fire({
        icon: "success",
        title: message
    });
</script>

@endif

<!-- fin -->

<div class="container-fluid px-4"> <!--inicio contenido-->
    <h1 class="mt-4 text-center">Marcas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Marcas</li>
    </ol>
    <!-- Boton de nuevos registros -->
    <div class="mb-4">
        <a href="{{route('marcas.create')}}">
            <button type="button" class="btn btn-primary">Añadir nueva marca</button>
        </a>
    </div>

    <!-- inicio de tabla -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Marcas
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($marcas as $marca)
                    <tr>
                        <td>
                            {{$marca->caracteristica->nombre}}
                        </td>
                        <td>
                            {{$marca->caracteristica->descripcion}}
                        </td>

                        <td>
                            @if($marca->caracteristica->estado ==1)
                            <span class="fw-bolder p-1 rounded bg-success text-white">Activo</span>
                            @else
                            <span class="fw-bolder p-1 rounded bg-danger text-white">Eliminado</span>
                            @endif

                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">

                                <form action="{{ route('marcas.edit', ['marca' => $marca]) }}">

                                    <button type="sumit" class="btn btn-warning">Editar</button>
                                </form>
                                <!-- boton eliminar -->
                                @if($marca->caracteristica->estado == 1)
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#ConfirmModal-{{$marca->id}}">Eliminar</button>
<!-- fin boton eliminar -->
                                @else
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ConfirmModal-{{$marca->id}}">Restaurar</button>
                                @endif

                            </div>
                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="ConfirmModal-{{$marca->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de Confirmacion</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{$marca->caracteristica->estado ==1 ?'¿seguro que quieres eliminar la marca?'
                                        :'¿seguro que quieres restaurar la marca?'}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{route('marcas.destroy',['marca'=>$marca->id])}}" method="post">
                                        @method ('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Confirmar</button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- fin de Modal -->
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- fin de tabla -->

</div>
@endsection

@push('js')

@endpush()
