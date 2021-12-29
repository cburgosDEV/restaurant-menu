@extends('layouts.app')

@section('content')
    <div class="container" id="update">
        <input id="id" hidden type="text" v-model="id" value="{{ $id }}">
        <div v-if="isLoaded" class="row justify-content-center">
            <div class="col-md-8">
                <custom-card
                    :card-title="viewModel.name">
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
                        <div class="col-md-12 mb-3">
                            <label for="address">Dirección:</label>
                            <input type="text" class="form-control" id="address" v-model="viewModel.address">
                            <span v-if="showError && validations.address !== undefined" class="text-danger font-weight-light">@{{validations.address[0]}}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone1">Teléfono 1:</label>
                            <input type="text" class="form-control" id="phone1" v-model="viewModel.phone1">
                            <span v-if="showError && validations.phone1 !== undefined" class="text-danger font-weight-light">@{{validations.phone1[0]}}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone2">Teléfono 2:</label>
                            <input type="text" class="form-control" id="phone2" v-model="viewModel.phone2">
                            <span v-if="showError && validations.phone2 !== undefined" class="text-danger font-weight-light">@{{validations.phone2[0]}}</span>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="address">Email:</label>
                            <input type="email" class="form-control" id="email" v-model="viewModel.email">
                            <span v-if="showError && validations.email !== undefined" class="text-danger font-weight-light">@{{validations.email[0]}}</span>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="web">Dirección Web:</label>
                            <input type="text" class="form-control" id="address" v-model="viewModel.web">
                            <span v-if="showError && validations.web !== undefined" class="text-danger font-weight-light">@{{validations.web[0]}}</span>
                        </div>
                    </div>
                </custom-card>
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="col-md-12 mb-3">
                            <label for="web">Seleccionar la categoría del restaurante (max. 3):</label>
                            <v-select
                                multiple
                                :options="restaurantCategoryDropdown"
                                label="text"
                                :reduce="item => item.value"
                                v-model="categories"
                                :selectable="() => categories.length < 3">
                            </v-select>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="col-md-12 mb-3">
                            <label for="web">Seleccionar las imágenes del restaurante (max. 3):</label>
                            <vue-upload-multiple-image
                                drag-text="Arrastrar imagen"
                                browse-text="Seleccionar imagen"
                                primary-text="Logo"
                                mark-is-primary-text="Marcar como imagen principal (logo)"
                                popup-text="Esta imagen es el logo del restaurant"
                                drop-text="Soltar aquí"
                                :data-images="images"
                                id-upload="myIdUpload"
                                :show-edit="showEdit"
                                @upload-success="uploadImageSuccess"
                                @mark-is-primary="markIsPrimary"
                                @before-remove="beforeRemove"
                                :disabled="isImageSelectorDisabled">
                            </vue-upload-multiple-image>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12 d-flex">
                        <a href="#" class="link-danger" v-on:click="softDelete">Eliminar Restaurante</a>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12 d-flex justify-content-center">
                        <button class="btn btn-primary mx-1" v-on:click="save"><i class="fa fa-save"></i> Guardar</button>
                        <a :href="'{{'../../homeUser'}}' + '/' + viewModel.idUser" class="btn btn-secondary mx-1"><i class="fa fa-arrow-left"></i> Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('inlineScript')
    <script src="{{asset('js/restaurant/update.js')}}"></script>
@endsection
