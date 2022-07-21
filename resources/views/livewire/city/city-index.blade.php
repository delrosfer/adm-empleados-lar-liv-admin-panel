<div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ciudades</h1>
    </div>
    <div class="row">
        <div class="card  mx-auto">
            <div>
                @if (session()->has('city-message'))
                    <div class="alert alert-success">
                        {{ session('city-message') }}
                    </div>
                @endif
            </div>
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <form>
                            <div class="form-row align-items-center">
                                <div class="col">
                                    <input type="search" wire:model="search" name="search" class="form-control mb-2" id="inlineFormInput"
                                        placeholder="Buscar una ciudad">
                                </div>
                                <div class="col" wire:loading>
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Buscando...</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div>
                        <!-- Button trigger modal -->
                        <button wire:click="showCityModal" class="btn btn-primary">
                          Crear nueva ciudad
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="border-separate border border-slate-400 table table-hover table-auto bg-sky-100/100" wire:loading.remove>
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Descripción Ciudad</th>
                            <th scope="col">Administrar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cities as $city)
                            <tr>
                                <th scope="row">{{ $city->id }}</th>
                                <td>{{ $city->state->name}}</td>
                                <td>{{ $city->name }}</td>
                                <td>
                                    <button wire:click="showEditModal({{ $city->id }})" class="btn btn-success">Editar</button>
                                    <button wire:click="deleteCity({{ $city->id }})" class="btn btn-danger">Eliminar</button>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <th>No se encontraron resultados</th>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div>
                {{ $cities->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="cityModal" tabindex="-1" aria-labelledby="cityModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                @if($editMode)
                    <h5 class="modal-title" id="cityModalLabel">Editar Ciudad</h5>
               
                    @else
                    <h5 class="modal-title" id="cityModalLabel">Crear Ciudad</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <label for="stateId"
                            class="col-md-4 col-form-label text-md-right">{{ __('Ciudad') }}</label>

                        <div class="col-md-6">
                            <select wire:model.defer="stateId" class="custom-select">
                                <option selected>Seleccione</option>
                                    @foreach (App\Models\State::all() as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                            </select>
                            @error('stateId')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name"
                            class="col-md-4 col-form-label text-md-right">{{ __('Descripción Ciudad') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text"
                                class="form-control @error('name') is-invalid @enderror" wire:model.defer="name">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModal">Cerrar</button>
                @if($editMode)
                    <button type="button" class="btn btn-primary" wire:click="updateCity">Actualizar Ciudad</button>
                @else
                    <button type="button" class="btn btn-primary" wire:click="storeCity">Crear Ciudad</button>
                @endif
                
                
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
