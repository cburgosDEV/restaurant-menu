@extends('layouts.app')

@section('content')
    <div id="index" class="container">
        <input type="hidden" name="idRestaurant" id="idRestaurant" value="{{$idRestaurant}}">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-primary" role="alert">
                    <h5>Restaurante: <strong>@{{restaurantName}}</strong></h5>
                </div>
            </div>
            <div class="col-md-5">
                <custom-card
                    card-title="Mis Categorías"
                    button-title="Crear"
                    button-icon="plus"
                    @button-action="showModalCategory">
                    <div v-if="categories.length > 0">
                        <h6 class="font-weight-light"><i class="fa fa-list"></i> Lista de categorías</h6>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre de la categoría</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(category, index) in categories" :class="[category.id===idCategory?'table-primary':'']">
                                <th>@{{ category.id }}.</th>
                                <td>@{{ category.name }}</td>
                                <td>
                                    <button class="btn btn-outline-success btn-sm" v-on:click="showModalCategory(category.id)"><i class="fa fa-eye"></i> Ver</button>
                                    <button class="btn btn-outline-secondary btn-sm" v-on:click="initListPlate(category.id)"><i class="fa fa-list"></i> Platos</button>
                                    <button class="btn btn-outline-danger btn-sm" v-on:click="softDeleteCategory(category.id)"><i class="fa fa-trash"></i> Eliminar</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else>
                        <div class="alert alert-danger" role="alert">
                            *No tiene categorías registradas, crear una para continuar.
                            <a v-on:click="showModalCategory(0)" class="link-secondary" style="cursor: pointer">Click aquí para crear una.</a>
                        </div>
                    </div>
                </custom-card>
            </div>
            <div v-if="idCategory>0" class="col-md-7">
                <custom-card
                    card-title="Mis Platos"
                    button-title="Crear"
                    button-icon="plus"
                    @button-action="showModalPlate">
                    <div v-if="plates.length > 0">
                        <h6 class="font-weight-light"><i class="fa fa-list"></i> Lista de platos</h6>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre del plato</th>
                                <th>Precio</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(plate, index) in plates">
                                <th>@{{ plate.id }}.</th>
                                <td>@{{ plate.name }}</td>
                                <td>@{{ plate.price }}</td>
                                <td>
                                    <button class="btn btn-outline-success btn-sm" v-on:click="showModalPlate(plate.id)"><i class="fa fa-eye"></i> Ver</button>
                                    <button class="btn btn-outline-danger btn-sm" v-on:click="softDeletePlate(plate.id)"><i class="fa fa-trash"></i> Eliminar</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else>
                        <div class="alert alert-danger" role="alert">
                            *No tiene platos registrados, crear uno para continuar.
                            <a v-on:click="showModalPlate(0)" class="link-secondary" style="cursor: pointer">Click aquí para crear uno.</a>
                        </div>
                    </div>
                </custom-card>
            </div>
        </div>
        <custom-modal
            id-modal="CategoryModal"
            :modal-title="modalTitle"
            :button-title="buttonModalTitle"
            @button-action="saveCategory">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xl-12 mt-2">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name">Nombre de la categoría:</label>
                            <input type="text" class="form-control" id="name" placeholder="Nombre de la categoría" v-model="viewModel.name">
                            <span v-if="showError && validations.name !== undefined" class="text-danger font-weight-light">@{{validations.name[0]}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </custom-modal>
        <custom-modal
            id-modal="PlateModal"
            :modal-title="modalTitle"
            :button-title="buttonModalTitle"
            @button-action="savePlate">
            <div class="row">
                <div class="col-md-12 col-lg-4 col-xl-4 d-flex justify-content-center">
                    <vue-upload-multiple-image
                        drag-text="Arrastrar imagen"
                        browse-text="Seleccionar imagen"
                        primary-text="Imagen principal"
                        popup-text="Esta imagen se mostrará en el perfil del usuario"
                        drop-text="Soltar aquí"
                        :data-images="image"
                        :show-edit="showEdit"
                        :multiple="isMultiple"
                        @upload-success="uploadImageSuccess"
                        @before-remove="beforeRemove">
                    </vue-upload-multiple-image>
                </div>
                <div class="col-md-12 col-lg-8 col-xl-8 mt-2">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name">Nombre del plato:</label>
                            <input type="text" class="form-control" id="name" placeholder="Nombre del plato" v-model="viewModel.name">
                            <span v-if="showError && validations.name !== undefined" class="text-danger font-weight-light">@{{validations.name[0]}}</span>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description">Descripción:</label>
                            <textarea class="form-control" id="description" placeholder="Descripción" v-model="viewModel.description" rows="3"></textarea>
                            <span v-if="showError && validations.description !== undefined" class="text-danger font-weight-light">@{{validations.description[0]}}</span>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="price">Precio (S/.):</label>
                            <input type="number" class="form-control" id="price" placeholder="0" v-model="viewModel.price">
                            <span v-if="showError && validations.price !== undefined" class="text-danger font-weight-light">@{{validations.price[0]}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </custom-modal>
    </div>
@endsection

@section('inlineScript')
    <script src="{{asset('js/plate/index.js')}}"></script>
@endsection
