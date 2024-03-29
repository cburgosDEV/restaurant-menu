let vue = new Vue({
    el: '#create',
    components: {

    },
    data: {
        url: $('#baseUrl').val(),
        idUser: $('#idUser').val(),
        viewModel : {},
        validations : {},
        showError: false,
    },
    computed: {

    },
    created() {
        this.initForm();
    },
    methods: {
        switchResponseServer: function (switchAction, response){
            switch (switchAction){
                case 'initForm':
                    this.viewModel = response;
                    break;
                case 'store':
                    if(response.id>0){
                        showToast('success', 'Operación realizada correctamente');
                        window.location.href = this.url + 'restaurant/update/' + response.id;
                    } else {
                        showToast('error', 'Ocurrió un error al guardar el registro');
                    }
                    break;
            }
        },
        initForm: function(){
            loading(true);
            let url = this.url + "restaurant/jsonCreate";
            window.axios.get(url).then((response) => {
                this.switchResponseServer("initForm", response.data);
            }).catch((error) => {

            }).finally((response) => {
                loading(false);
            });
        },
        save: function () {
            loading(true);
            this.viewModel.idUser = this.idUser;
            let url = this.url + "restaurant/store";
            window.axios.post(url, this.viewModel).then((response) => {
                this.switchResponseServer("store", response.data);
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
    },
});
