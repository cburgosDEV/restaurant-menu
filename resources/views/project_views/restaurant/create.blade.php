@extends('layouts.app')

@section('content')
    <div class="container" id="create">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <custom-card
                    card-title="Crear Nuevo Restaurante">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name">Nombre del restaurante:</label>
                            <input type="text" class="form-control" id="name" v-model="viewModel.name">
                            <span v-if="showError && validations.name !== undefined" class="text-danger font-weight-light">@{{validations.name[0]}}</span>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description">Descripción:</label>
                            <textarea type="text" class="form-control" id="description" rows="3" v-model="viewModel.description"></textarea>
                            <span v-if="showError && validations.description !== undefined" class="text-danger font-weight-light">@{{validations.description[0]}}</span>
                        </div>
                    </div>
                </custom-card>
                <div class="row mt-4">
                    <div class="col-md-12 d-flex justify-content-center">
                        <button class="btn btn-primary mx-1" v-on:click="save"><i class="fa fa-save"></i> Guardar</button>
                        <a href="{{'../homeUser'}}" class="btn btn-secondary mx-1"><i class="fa fa-arrow-left"></i> Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('inlineScript')
    <script src="{{asset('js/restaurant/create.js')}}"></script>
@endsection
