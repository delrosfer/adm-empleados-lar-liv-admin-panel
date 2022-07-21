<div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Empleados</h1>
    </div>
    <div class="row">
        <div class="card  mx-auto">
            <div>
                @if (session()->has('employee-message'))
                    <div class="alert alert-success">
                        {{ session('employee-message') }}
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
                                        placeholder="Buscar un empleado">
                                </div>
                                <div class="col">
                                    <select wire:model="selectedDepartmentId" class="form-control mb-2">
                                            <option selected>Selecciona un departamento</option>
                                        @foreach(App\Models\Department::all() as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
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
                        <button wire:click="showEmployeeModal" class="btn btn-primary">
                          Crear nuevo empleado
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table border-separate border border-slate-400 table-hover table-auto bg-sky-100/100" wire:loading.remove>
                    <thead class="font-bold">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido Paterno</th>
                            <th scope="col">Departamento</th>
                            <th scope="col">Pais</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Ciudad</th>
                            <th scope="col">Fecha de Contratación</th>
                            <th scope="col">Administrar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $employee)
                            <tr>
                                <th scope="row">{{ $employee->id }}</th>
                                <td>{{ $employee->first_name }}</td>
                                <td>{{ $employee->middle_name }}</td>
                                <td>{{ $employee->department->name}}</td>
                                <td>{{ $employee->country->name}}</td>
                                <td>{{ $employee->state->name}}</td>
                                <td>{{ $employee->city->name}}</td>
                                <td>{{ $employee->date_hired }}</td>
                                <td>
                                    <button wire:click="showEditModal({{ $employee->id }})" class="btn btn-success">Editar</button>
                                    <button wire:click="deleteEmployee({{ $employee->id }})" class="btn btn-danger">Eliminar</button>
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
                {{ $employees->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                @if($editMode)
                    <h5 class="modal-title" id="employeeModalLabel">Editar Empleado</h5>
               
                    @else
                    <h5 class="modal-title" id="employeeModalLabel">Crear Empleado</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <label for="firstName"
                            class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                        <div class="col-md-6">
                            <input id="firstName" type="text"
                                class="form-control @error('firstName') is-invalid @enderror" wire:model.defer="firstName">

                            @error('firstName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="middleName"
                            class="col-md-4 col-form-label text-md-right">{{ __('Apellido Paterno') }}</label>

                        <div class="col-md-6">
                            <input id="middleName" type="text"
                                class="form-control @error('middleName') is-invalid @enderror" wire:model.defer="middleName">

                            @error('middleName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lastName"
                            class="col-md-4 col-form-label text-md-right">{{ __('Apellido Materno') }}</label>

                        <div class="col-md-6">
                            <input id="lastName" type="text"
                                class="form-control @error('lastName') is-invalid @enderror" wire:model.defer="lastName">

                            @error('lastName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address"
                            class="col-md-4 col-form-label text-md-right">{{ __('Domicilio') }}</label>

                        <div class="col-md-6">
                            <input id="address" type="text"
                                class="form-control @error('address') is-invalid @enderror" wire:model.defer="address">

                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

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
                        <label for="stateId"
                            class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>

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
                        <label for="cityId"
                            class="col-md-4 col-form-label text-md-right">{{ __('Ciudad') }}</label>

                        <div class="col-md-6">
                            <select wire:model.defer="cityId" class="custom-select">
                                <option selected>Seleccione</option>
                                    @foreach (App\Models\City::all() as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                            </select>
                            @error('cityId')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="departmentId"
                            class="col-md-4 col-form-label text-md-right">{{ __('Departamento') }}</label>

                        <div class="col-md-6">
                            <select wire:model.defer="departmentId" class="custom-select">
                                <option selected>Seleccione</option>
                                    @foreach (App\Models\Department::all() as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                            </select>
                            @error('departmentId')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="zipCode"
                            class="col-md-4 col-form-label text-md-right">{{ __('Código Postal') }}</label>

                        <div class="col-md-6">
                            <input id="zipCode" type="text"
                                class="form-control @error('zipCode') is-invalid @enderror" wire:model.defer="zipCode">

                            @error('zipCode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="birthDate"
                            class="col-md-4 col-form-label text-md-right">{{ __('Fecha de Nacimiento') }}</label>

                        <div class="col-md-6">
                            <input id="birthDate" type="text"
                                class="form-control @error('birthDate') is-invalid @enderror" wire:model.defer="birthDate">

                            @error('birthDate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="dateHired"
                            class="col-md-4 col-form-label text-md-right">{{ __('Fecha de Contratación') }}</label>

                        <div class="col-md-6">
                            <input id="dateHired" type="text"
                                class="form-control @error('dateHired') is-invalid @enderror" wire:model.defer="dateHired">

                            @error('dateHired')
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
                    <button type="button" class="btn btn-primary" wire:click="updateEmployee">Actualizar Empleado</button>
                @else
                    <button type="button" class="btn btn-primary" wire:click="storeEmployee">Crear Empleado</button>
                @endif
                
                
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
