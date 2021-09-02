@extends('adminlte::page')

@section('content')

 <div class="card">
      <div class="card-header">
          {{isset($data->id) ?  'Actualizacion' :'Registro'}} Usuario
          <a class=" float-right" data-toggle="tooltip" data-placement="right" title="Regresar listado" href="{{ route('admin.users.index') }}" ><i class="fas fa-undo-alt" aria-hidden="true"></i></a>
        </div>
        <div class="card-body">

             <form class="form-horizontal" role="form" method="POST" action="{{ isset($data) ? route('admin.users.update', $data->id) : route('admin.users.store') }}"  enctype="multipart/form-data">
                        @csrf

                        @if(isset($data))

                        @method('PUT')
                        @endif

                        <div class="row">

                            <div class="col-6">

                                <div class="form-group ">
                                    <label for="name">Nombre*</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', isset($data) ? $data->name : '') }}">
                                    
                                    @error('email')
                                            <em class="invalid-feedback">
                                                {{ $message }}
                                            </em>
                                    @enderror
                                
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="identification">Cedula*</label>
                                    <input id="identification"  maxlength="11" name="identification" 
                                    {{ isset($data->identification) ? 'readonly' : ''}}
                                    class="form-control @error('identification') is-invalid @enderror" value="{{ old('identification', isset($data) ? $data->identification : '') }}">
                                   
                                    @error('identification')
                                          <em class="invalid-feedback">
                                              {{ $message }}
                                          </em>
                                    @enderror
                                   
                                </div>
            
                                
                            </div>
                        </div>
                            
                        <div class="form-group ">
                            <label for="email">Correo electronico*</label>
                            <input type="email" id="email" name="email" 
                            {{ isset($data->email) ? 'readonly' : ''}}
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email', isset($data) ? $data->email : '') }}">
                            
                            @error('email')
                                    <em class="invalid-feedback">
                                        {{ $message }}
                                    </em>
                            @enderror
                            
                        </div>

                    
                    <div class="row">

                        <div class="col-4">

                            <div class="form-group ">
                                <label for="cell_phone">Numero de telefono*</label>
                                <input type="text" maxlength="10" id="cell_phone" name="cell_phone" 
                                class="form-control @error('cell_phone') is-invalid @enderror" value="{{ old('cell_phone', isset($data) ? $data->cell_phone : '') }}" >
                               
                                @error('cell_phone')
                                       <span class="text-danger"> {{ $message }} </span>
                                @enderror
                               
                            </div>

                        </div>

                        <div class="col-4">

                            <div class="form-group ">
                                <label for="birth_date">Fecha de nacimiento*</label>
                                <input type="date" id="birth_date" name="birth_date" 
                                class="form-control @error('birth_date') is-invalid @enderror"
                                value='{{(isset($data)) && strtotime($data->birth_date) != false  ? date("Y-m-d", strtotime($data->birth_date)) : date("Y-m-d") }}' max="{{date("Y-m-d")}}" required >
                               
                            </div>
                            @error('birth_date')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror

                        </div>
                        
                        <div class="col-4">

                            <div class="form-group ">
                                <label for="city_code">Codigo ciudad*</label>
                                <input type="number" id="city_code" name="city_code" max="999999"
                                class="form-control @error('city_code') is-invalid @enderror"
                                value="{{ old('city_code', isset($data) ? $data->city_code : '') }}" required=""
                                 >
                               
                                @error('city_code')
                                       <span class="text-danger"> {{ $message }} </span>
                                @enderror
                               
                            </div>

                        </div>
                    </div>


                      <div class="form-group">
                          <label for="password">Contraseña</label>
                          <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">

                          @error('password')
                            <span class="text-danger"> {{ $message }} </span>
                          @enderror

                         
                      </div>
                      <div class="form-group">
                          <label for="roles">Roles*
                              
                          <select name="roles" id="roles" class="custom-select custom-select-lg select2  @error('roles') is-invalid @enderror">
                              @foreach($roles as $id => $roles)
                                  <option value="{{ $id }}" {{ (old('roles') || isset($data) && $data->roles->contains($id)) ? 'selected' : '' }}>
                                    
                                      {{ $roles }}
                                  </option>
                              @endforeach
                          </select>
                         
                          @error('roles')
                          <span class="text-danger"> {{ $message }} </span>
                          @enderror
                         
                      </div>
                      <div>
                          <input class="btn btn-primary mt-1" type="submit" value=" {{isset($data->id) ?  'Actualizar' :'Guardar'}}">
                      </div>
                  </form>
              </div>
          </div>
@stop