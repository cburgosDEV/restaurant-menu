@extends('layouts.app')

@section('content')
    <div id="index" class="container">
        <div class="d-flex align-items-start row">
            <div class="nav flex-column nav-pills me-3 col-md-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="true">Perfil</button>
                <button class="nav-link" id="v-pills-password-tab" data-bs-toggle="pill" data-bs-target="#v-pills-password" type="button" role="tab" aria-controls="v-pills-password" aria-selected="false">Contraseña</button>
            </div>
            <div class="tab-content col-md-8 mt-4" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <custom-card
                        card-title="Perfil"
                        :button-title="!isEditForm?'Editar Datos':undefined"
                        button-icon="pen"
                        @button-action="isEditForm=true">
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
                                    :show-delete="isEditForm"
                                    :multiple="isMultiple"
                                    @upload-success="uploadImageSuccess"
                                    @before-remove="beforeRemove">
                                </vue-upload-multiple-image>
                            </div>
                            <div class="col-md-12 col-lg-8 col-xl-8 mt-2">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="name">Nombre del usuario:</label>
                                        <input type="text" class="form-control" id="name" placeholder="Nombre del usuario" v-model="viewModel.name" :disabled="!isEditForm">
                                        <span v-if="showError && validations.name !== undefined" class="text-danger font-weight-light">@{{validations.name[0]}}</span>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" id="email" placeholder="Email" v-model="viewModel.email" :disabled="!isEditForm">
                                        <span v-if="showError && validations.email !== undefined" class="text-danger font-weight-light">@{{validations.email[0]}}</span>
                                    </div>
                                    <div v-if="isEditForm" class="col-md-12 mb-3 d-flex justify-content-center">
                                        <button class="btn btn-primary mx-1" v-on:click="save"><i class="fa fa-save"></i> Guardar</button>
                                        <button class="btn btn-secondary mx-1" v-on:click="clearData"><i class="fa fa-times"></i> Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </custom-card>
                </div>
                <div class="tab-pane fade" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab">
                    <custom-card
                        card-title="Contraseña"
                        :button-title="!isEditFormPassword?'Cambiar contraseña':undefined"
                        button-icon="pen"
                        @button-action="isEditFormPassword=true">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-xl-12 mt-2">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="password">Nueva contraseña:</label>
                                        <input type="password" class="form-control" id="password" v-model="password" :disabled="!isEditFormPassword">
                                        <span v-if="showErrorsChangePassword && validationsChangePassword.password !== undefined" class="text-danger">@{{validationsChangePassword.password[0]}}</span>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="rePassword">Repetir contraseña:</label>
                                        <input type="password" class="form-control" id="rePassword" v-model="rePassword" :disabled="!isEditFormPassword">
                                        <span v-if="showErrorsChangePassword && validationsChangePassword.rePassword !== undefined" class="text-danger">@{{validationsChangePassword.rePassword[0]}}</span>
                                    </div>
                                    <div v-if="isEditFormPassword" class="col-md-12 mb-3 d-flex justify-content-center">
                                        <button class="btn btn-primary mx-1" v-on:click="changePassword"><i class="fa fa-save"></i> Guardar</button>
                                        <button class="btn btn-secondary mx-1" v-on:click="clearDataChangePassword"><i class="fa fa-times"></i> Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </custom-card>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('inlineScript')
    <script src="{{asset('js/profile/index.js')}}"></script>
@endsection
