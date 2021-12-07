@extends('layouts.app')

@section('content')
<div class="container" id="index">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <custom-card
                card-title="Usuarios">
                <h6 class="font-weight-light"><i class="fa fa-list"></i> Lista de usuarios</h6>
                <search-bar @search="search"></search-bar>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre del usuario</th>
                        <th>Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(user, index) in users">
                        <th>@{{ index + 1 }}.</th>
                        <td>@{{ user.name }}</td>
                        <td>

                        </td>
                    </tr>
                    </tbody>
                </table>
                <pagination
                    align="center"
                    :data="paginate"
                    @pagination-change-page="initList">
                </pagination>
            </custom-card>
        </div>
    </div>
</div>
@endsection
@section('inlineScript')
    <script src="{{asset('js/home/index.js')}}"></script>
@endsection
