@extends('adminlte::page')


@section('title', 'detalle Usuario')

@section('content')
   
<div class="card">
    <div class="card-header">
      Detalle Usuario
    </div>
      
<div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        Nombre
                    </th>
                    <td>
                        {{ $user->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                       Correo
                    </th>
                    <td>
                        {{ $user->email }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Roles
                    </th>
                    <td>
                        @foreach($user->getRoleNames() as $id => $roles)
                            <span class="label label-info label-many">{{ $roles }}</span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>
                       Correos enviados
                    </th>
                    <td>
                        {{ $user->mails->count() }}
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>
 
@stop
