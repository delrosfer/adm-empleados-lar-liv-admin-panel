<div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Estados</h1>
    </div>
    <div class="row">
        <div class="card  mx-auto">
            <div>
                @if (session()->has('state-message'))
                    <div class="alert alert-success">
                        {{ session('state-message') }}
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
                                        placeholder="Buscar un estado">
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
                        <button wire:click="showStateModal" class="btn btn-primary">
                          Crear nuevo estado
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table border-separate border border-slate-400 table-hover table-auto bg-sky-100/100" wire:loading.remove>
                    <thead>
                        <tr>
                            <th class="font-bold" scope="col">Id</th>
                            <th scope="col">Pais</th>
                            <th scope="col">Descripción Estado</th>
                            <th scope="col">Administrar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($states as $state)
                            <tr>
                                <th scope="row">{{ $state->id }}</th>
                                <td>{{ $state->country->name}}</td>
                                <td>{{ $state->name }}</td>
                                <td>
                                    <button wire:click="showEditModal({{ $state->id }})" class="btn btn-success">Editar</button>
                                    <button wire:click="deleteState({{ $state->id }})" class="btn btn-danger">Eliminar</button>
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
                {{ $states->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="stateModal" tabindex="-1" aria-labelledby="stateModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                @if($editMode)
                    <h5 class="modal-title" id="stateModalLabel">Editar Estado</h5>
               
                    @else
                    <h5 class="modal-title" id="stateModalLabel">Crear Estado</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <label for="countryId"
                            class="col-md-4 col-form-label text-md-right">{{ __('Pais') }}</label>

                        <div class="col-md-6">
                            <select wire:model.defer="countryId" class="custom-select">
                                <option selected>Seleccione</option>
                                    @foreach (App\Models\Country::all() as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                            </select>
                            @error('countryId')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name"
                            class="col-md-4 col-form-label text-md-right">{{ __('Descripción Pais') }}</label>

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
                    <button type="button" class="btn btn-primary" wire:click="updateState">Actualizar Estado</button>
                @else
                    <button type="button" class="btn btn-primary" wire:click="storeState">Crear Estado</button>
                @endif
                
                
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
