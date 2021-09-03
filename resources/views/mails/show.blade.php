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
                        Para
                    </th>
                    <td>
                        @foreach ($mail->mailAddress as $item)
                            {{ $item->email }}
                        @endforeach
                        
                    </td>
                </tr>
                <tr>
                    <th>
                        Asunto
                    </th>
                    <td>
                        {{ $mail->subject }}
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        {{ $mail->body }}
                    </td>
                </tr>
              
                <tr>
                    <th>
                       Correos enviados
                    </th>
                    <td>
                        {{ $mail->created_at->diffForHumans() }}
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>
 
@stop
