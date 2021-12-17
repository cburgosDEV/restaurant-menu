let vue = new Vue({
    el: '#index',
    components: {

    },
    data: {
        url: $('#baseUrl').val() + 'plate',
        idRestaurant: $('#idRestaurant').val(),
        idCategory: 0,
        discriminator: "PLATE",

        //CATEGORY
        filterTextCategory: '',
        categories: [],
        isEditFormCategory: false,

        //PLATE
        filterTextPlate: '',
        plates: [],
        isEditFormPlate: false,

        //BOTH
        viewModel: {},
        validations : {},
        showError: false,
        modalTitle: '',
        buttonModalTitle: '',
    },
    computed: {

    },
    created() {
        this.initList();
    },
    methods: {
        switchResponseServer: function (switchAction, response){
            switch (switchAction){
                case 'initList':
                    this.categories = response;
                    break;
                case 'initListPlate':
                    this.plates = response;
                    break;
                case 'jsonCreate':
                    this.viewModel = response;
                    break;
                case 'jsonDetail':
                    this.viewModel = response;
                    break;
                case 'storeCategory':
                    if(response){
                        showToast('success', 'Operación realizada correctamente');
                        this.initList();
                        $('#CategoryModal').modal('hide');
                    } else {
                        showToast('error', 'Ocurrió un error al guardar el registro');
                    }
                    break;
                case 'storePlate':
                    if(response){
                        showToast('success', 'Operación realizada correctamente');
                        this.initList();
                        $('#PlateModal').modal('hide');
                    } else {
                        showToast('error', 'Ocurrió un error al guardar el registro');
                    }
                    break;
            }
        },
        //CATEGORY
        initList: function(){
            loading(true);
            let url = this.url + "/jsonIndex/" + this.idRestaurant + "/" + this.filterTextCategory;
            window.axios.get(url).then((response) => {
                this.switchResponseServer("initList", response.data);
            }).catch((error) => {

            }).finally((response) => {
                loading(false);
            });
        },
        showModalCategory: function (idCategory = 0) {
            this.clearDataCategory();
            if (idCategory === 0){
                this.modalTitle = 'Crear nueva categoría'
                this.buttonModalTitle = 'Guardar';
                this.initFormCreateCategory();
            } else {
                this.modalTitle = 'Detalle'
                this.buttonModalTitle = 'Actualizar';
                this.isEditFormCategory = true;
                this.initFormDetailCategory(idCategory);

            }
            $('#CategoryModal').modal('show');
        },
        initFormCreateCategory: function (){
            loading(true);
            let url = this.url + "/jsonCreateCategory/" + this.discriminator;
            window.axios.get(url).then((response) => {
                this.switchResponseServer("jsonCreate", response.data);
            }).catch((error) => {

            }).finally((response) => {
                loading(false);
            });
        },
        initFormDetailCategory: function (idCategory, callback){
            loading(true);
            let url = this.url + "/jsonDetailCategory/" + idCategory;
            window.axios.get(url).then((response) => {
                this.switchResponseServer("jsonDetail", response.data);
            }).catch((error) => {

            }).finally((response) => {
                loading(false);
                if(callback){
                    callback();
                }
            });
        },
        saveCategory: function () {
            let url = this.url + "/storeCategory";
            this.viewModel.idRestaurant = this.idRestaurant;
            loading(true);
            window.axios.post(url, this.viewModel).then((response) => {
                this.switchResponseServer("storeCategory", response.data);
            }).catch((error) => {
                if(error.response.status === 422){
                    this.showError = true;
                    this.validations = error.response.data.errors;
                }
                showToast('error', 'Revisar los datos ingresados');
            }).finally((response) => {
                loading(false);
            });
        },
        softDeleteCategory: function (idCategory) {
            this.$swal({
                icon: 'warning',
            }).then((result) => {
                if(result.value) {
                    let context = this;
                    this.initFormDetailCategory(idCategory, function (){
                        context.viewModel.state = false;
                        context.saveCategory();
                    });
                }
            });
        },
        clearDataCategory: function () {
            this.isEditFormCategory = false;
            this.showError = false;
            this.validations = {};
            this.viewModel = {};
            this.modalTitle = '';
            this.buttonModalTitle = '';
        },
        //PLATE
        initListPlate: function(idCategory){
            this.idCategory = idCategory;
            loading(true);
            let url = this.url + "/jsonIndexPlate/" + idCategory + "/" + this.filterTextPlate;
            window.axios.get(url).then((response) => {
                this.switchResponseServer("initListPlate", response.data);
            }).catch((error) => {

            }).finally((response) => {
                loading(false);
            });
        },
        showModalPlate: function (idPlate = 0) {
            this.clearDataPlate();
            if (idPlate === 0){
                this.modalTitle = 'Crear nuevo plato'
                this.buttonModalTitle = 'Guardar';
                this.initFormCreatePlate();
            } else {
                this.modalTitle = 'Detalle'
                this.buttonModalTitle = 'Actualizar';
                this.isEditFormPlate = true;
                this.initFormDetailPlate(idPlate);

            }
            $('#PlateModal').modal('show');
        },
        initFormCreatePlate: function (){
            loading(true);
            let url = this.url + "/jsonCreate";
            window.axios.get(url).then((response) => {
                this.switchResponseServer("jsonCreate", response.data);
            }).catch((error) => {

            }).finally((response) => {
                loading(false);
            });
        },
        initFormDetailPlate: function (idPlate, callback){
            loading(true);
            let url = this.url + "/jsonDetail/" + idPlate;
            window.axios.get(url).then((response) => {
                this.switchResponseServer("jsonDetail", response.data);
            }).catch((error) => {

            }).finally((response) => {
                loading(false);
                if(callback){
                    callback();
                }
            });
        },
        savePlate: function () {
            let url = this.url + "/store";
            this.viewModel.idCategory = this.idCategory;
            loading(true);
            window.axios.post(url, this.viewModel).then((response) => {
                this.switchResponseServer("storePlate", response.data);
            }).catch((error) => {
                if(error.response.status === 422){
                    this.showError = true;
                    this.validations = error.response.data.errors;
                }
                showToast('error', 'Revisar los datos ingresados');
            }).finally((response) => {
                loading(false);
            });
        },
        searchPlate: function (filterTextPlate){
            this.filterTextPlate = filterTextPlate;
            this.initList();
        },
        softDeletePlate: function (idPlate) {
            this.$swal({
                icon: 'warning',
            }).then((result) => {
                if(result.value) {
                    let context = this;
                    this.initFormDetailPlate(idPlate, function (){
                        context.viewModel.state = false;
                        context.savePlate();
                    });
                }
            });
        },
        clearDataPlate: function () {
            this.isEditFormPlate = false;
            this.showError = false;
            this.validations = {};
            this.viewModel = {};
            this.modalTitle = '';
            this.buttonModalTitle = '';
        },
    },
});


