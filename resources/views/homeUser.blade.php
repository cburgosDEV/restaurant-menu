@extends('layouts.app')

@section('content')
    <div class="container" id="index">
        <input type="hidden" id="idUser" name="idUser" value="{{$idUser}}">
        <div v-if="isLoaded" class="row justify-content-center">
            <div class="col-md-8">
                <custom-card
                    @role("super") card-title="Usuario ({{$userName}})"
                    @else card-title="Mis Restaurantes"
                    @endrole
                button-title="Crear"
                button-icon="plus"
                @button-action="createRestaurant">
                    <div v-if="restaurants.length > 0">
                        <h6 class="font-weight-light"><i class="fa fa-list"></i> Lista de restaurantes</h6>
                        <search-bar @search="search"></search-bar>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre del restaurante</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in restaurants">
                                <th>@{{ item.id }}.</th>
                                <td>@{{ item.name }}</td>
                                <td>
                                    <a :href="'{{'../restaurant/update'}}' + '/' + item.id" class="btn btn-outline-success btn-sm"><i class="fa fa-eye"></i> Ver</a>
                                    <a :href="'{{'../plate'}}' + '/' + item.id" class="btn btn-outline-secondary btn-sm"><i class="fa fa-list"></i> Platos</a>
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
                            *No tiene restaurantes registrados, crear uno para continuar.
                            <a href="{{'restaurant/create'}}" class="link-secondary">Click aquí para crear uno.</a>
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
