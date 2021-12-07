@extends('layouts.app')

@section('content')
    <div class="container" id="index">
        <div v-if="isLoaded" class="row justify-content-center">
            <div class="col-md-8">
                <custom-card
                    card-title="Mis Restaurantes">
                    <div v-if="restaurants.length>0">
                        <h6 class="font-weight-light"><i class="fa fa-list"></i> Lista de restaurantes</h6>
                        <search-bar @search="search"></search-bar>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre del restaurante</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in restaurants">
                                <th>@{{ index + 1 }}.</th>
                                <td>@{{ item.name }}</td>
                                <td>
                                    <a :href="'{{'restaurant/update'}}' + '/' + item.id" class="btn btn-outline-success btn-sm"><i class="fa fa-eye"></i> Ver</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <pagination
                            align="center"
                            :data="paginate"
                            @pagination-change-page="initList">
                        </pagination>
                    </div>
                    <div v-else>
                        <div class="alert alert-danger" role="alert">
                            *No tiene restaurantes registrados
                            <a href="{{'restaurant/create'}}" class="link-secondary">Click aquí para registrar uno.</a>
                        </div>
                    </div>
                </custom-card>
            </div>
        </div>
    </div>
@endsection
@section('inlineScript')
    <script src="{{asset('js/homeUser/index.js')}}"></script>
@endsection
