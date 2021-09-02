@extends('adminlte::page')

@section('content')

 <div class="card">
      <div class="card-header">
          {{isset($data->id) ?  'Actualizacion' :'Registro'}} Mensaje Nuevo
          <a class=" float-right" data-toggle="tooltip" data-placement="right" title="Regresar listado" href="{{ route('mails.index') }}" ><i class="fas fa-undo-alt" aria-hidden="true"></i></a>
        </div>
        <div class="card-body">

             <form class="form-horizontal" role="form" method="POST" action="{{ route('mails.store') }}"  enctype="multipart/form-data">
                        @csrf
                            
                        <div class="form-group ">
                            <label for="email">Para: </label>
                            <input type="email" id="email" name="email" 
                            Placeholder="Correo electronico"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email', isset($data) ? $data->email : '') }}">
                            
                            @error('email')
                                    <em class="invalid-feedback">
                                        {{ $message }}
                                    </em>
                            @enderror
                            
                        </div>

                              
                        <div class="form-group ">
                            <label for="subject">Asunto: </label>
                            <input type="text" id="subject" name="subject" 
                           
                            Placeholder="Asunto"
                            class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject', isset($data) ? $data->subject : '') }}">
                            
                            @error('subject')
                                    <em class="invalid-feedback">
                                        {{ $message }}
                                    </em>
                            @enderror
                            
                        </div>


                      <div class="form-group">
                            <textarea
                             class="form-control @error('body') is-invalid @enderror" 
                             name="body" 
                             id="body" 
                             rows="3"
                             placeholder="Escriba un mensaje"
                             >{{old('body')}}</textarea>
                         
                          @error('body')
                          <span class="text-danger"> {{ $message }} </span>
                          @enderror
                         
                      </div>

                      <div class="custom-file">
                        <input type="file" name="file" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Adjuntar archivo</label>
                      </div>

                      <div class="mt-2">
                          <input class="btn btn-primary mt-1" type="submit" value=" {{isset($data->id) ?  'Actualizar' :'Guardar'}}">
                      </div>
                  </form>
              </div>
          </div>
@stop