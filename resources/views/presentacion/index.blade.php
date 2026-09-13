@extends('template')

@section('title','Presentaciones')

@push('css')
<!-- Carga el CDN de SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')

<!-- inicio sweetalert -->
@if(session('success'))
<script>
    let message = "{{ session('success') }}";

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

    Toast.fire({
        icon: "success",
        title: message
    });
</script>
@endif
<!-- fin sweetalert -->

<div class="container-fluid px-4"> <!--inicio contenido-->
    <h1 class="mt-4 text-center">Presentaciones</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Presentaciones</li>
    </ol>

    <!-- Boton de nuevos registros -->
    <div class="mb-4">
        <a href="{{route('presentaciones.create')}}">
            <button type="button" class="btn btn-primary">Añadir nueva presentacion</button>
        </a>
    </div>

    <!-- inicio de tabla -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            DataTable Example
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- la variable definida es presentacion -->
                    @foreach($presentaciones as $presentacion)
                    <tr>
                        <td>{{$presentacion->caracteristica->nombre}}</td>

                        <td>{{$presentacion->caracteristica->descripcion}}</td>

                        <td>
                            @if($presentacion->caracteristica->estado == 1)
                                <span class="fw-bolder p-1 rounded bg-success text-white">Activo</span>
                            @else
                                <span class="fw-bolder p-1 rounded bg-danger text-white">Eliminado</span>
                            @endif
                        </td>

                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">

                                <a href="{{ route('presentaciones.edit', ['presentacione' => $presentacion]) }}"
                                   class="btn btn-warning">
                                    Editar
                                </a>

                              @if($presentacion->caracteristica->estado == 1)
    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
            data-bs-target="#confirmModal{{ $presentacion->id }}">
        Eliminar
    </button>
@else

  <button type="button" class="btn btn-success" data-bs-toggle="modal"
            data-bs-target="#confirmModal{{ $presentacion->id }}">
        Restaurar
    </button>
@endif

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- fin de tabla -->

    <!-- Modales: van FUERA de la tabla, uno por cada presentacion -->
    @foreach($presentaciones as $presentacion)
    <div class="modal fade" id="confirmModal{{ $presentacion->id }}" tabindex="-1"
         aria-labelledby="exampleModalLabel{{ $presentacion->id }}" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel{{ $presentacion->id }}">
                Mensaje de Confirmacion
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
           {{$presentacion->caracteristica->estado==1?'¿Seguro que quieres eliminar la':'¿Seguro que quieres restaurar la'}} presentacion?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

            <!-- utilizacion de presentacion -->
            <form action="{{ route('presentaciones.destroy', ['presentacione' => $presentacion]) }}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger">Confirmar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endforeach

</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
