@extends('adminlte::page')


@section('title', 'Usuarios')

@section('content')
<section class="content">
  

    <div class="card mt-3">
        <div class="card-header">
        
        Listado Usuarios
        @can('users.create')
        <a  href="{{ route('admin.users.create') }}"  class="d-sm-inline-block btn btn-sm btn-success shadow-sm float-right ml-2"><i class="fas fa-plus fa-lg text-white-50"></i> Nuevo </a>
        @endcan
        </div>
                
        <div class="card-body">
            <div class="table-responsive">
                <table id="table" class=" table table-bordered table-striped table-hover datatable">
                    <thead>
                    <tr class="text-center">
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Correo </th>
                        <th>Fecha Registro</th>
                        <th>Rol</th>
                        <th>&nbsp; </th>
                    </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
</section>
   

@stop

@section('css')
  
@stop

@section('js')
    
<script>

    $(document).ready(function() {

        $('#table').DataTable({
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Busqueda por cada columna"
                },
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                        "url":  '{{ route("admin.users.table") }}',
                        "type": "get"
                        },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'role', name: 'role'},
                    {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%", "class": "text-center" },
                ]
            }).on('search.dt', function() {
              var input = $('.dataTables_filter input')[0];
                // $('#tx').val(input.value);
              //console.log(input.value)
            });

    });  


</script>
@stop
