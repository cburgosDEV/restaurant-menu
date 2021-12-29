import VueUploadMultipleImage from 'vue-upload-multiple-image';

let vue = new Vue({
    el: '#index',
    components: {
        VueUploadMultipleImage
    },
    data: {
        url: $('#baseUrl').val() + 'profile',
        filterText: '',
        viewModel: {},
        validations : {},
        showError: false,
        isEditForm: false,
        //IMAGE
        image: [],
        imagePath: [],
        showEdit: false,
        isMultiple: false,
        //PASSWORD
        isEditFormPassword: false,
        password: '',
        rePassword: '',
        showErrorsChangePassword: false,
        validationsChangePassword: {},
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
                    this.viewModel = response;
                    break;
                case 'store':
                    if(response){
                        showToast('success', 'Operación realizada correctamente');
                        this.clearData();
                        this.initList();
                    } else {
                        showToast('error', 'Ocurrió un error al guardar el registro');
                    }
                    break;
                case 'jsonDetail':
                    this.viewModel = response;
                    break;
            }
        },
        initList: function(){
            loading(true);
            let url = this.url + "/jsonIndex";
            window.axios.get(url).then((response) => {
                this.switchResponseServer("initList", response.data);
            }).catch((error) => {

            }).finally((response) => {
                this.setImageToShow(this.viewModel.avatar);
                loading(false);
            });
        },
        save: function () {
            let url = this.url + "/store";
            if(this.imagePath.length>0)this.viewModel.image = this.imagePath[0].path;
            loading(true);
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
        clearData: function () {
            this.isEditForm = false;
            this.showError = false;
            this.validations = {};
            this.image = [];
            this.imagePath = [];
            this.initList();
        },
        uploadImageSuccess(formData, index, fileList) {
            this.imagePath = fileList;
        },
        beforeRemove (index, done, fileList) {
            let r = true;
            if (r) {
                this.viewModel.isImageDeleted = true;
                done();
            }
        },
        setImageToShow: function (image){
            this.image.push(
                {
                    path: 'storage/'+image,
                    default: 1,
                    highlight: 1,
                    caption: 'Profile'
                }
            );
        },
        changePassword: function () {
            let url = this.url + "/changePassword";
            let data = {
                id: this.viewModel.id,
                password: this.password,
                rePassword: this.rePassword,
            };
            this.$swal({
                confirmButtonText: 'Si, cambiar contraseña',
                icon: 'warning',
            }).then((result) => {
                if(result.value) {
                    loading(true);
                    window.axios.post(url, data).then((response) => {
                        if (response.data) {
                            showToast('success', 'Operación realizada correctamente');
                            this.clearDataChangePassword();
                            $('#UserPasswordModal').modal('hide');
                        }
                    }).catch((error) => {
                        if(error.response.status === 422){
                            this.showErrorsChangePassword = true;
                            this.validationsChangePassword = error.response.data.errors;
                            showToast("warning", "Revisar los datos ingresados");
                        }
                    }).finally((response) => {
                        loading(false);
                    });
                }
            });
        },
        clearDataChangePassword: function (){
            this.isEditFormPassword = false;
            this.password = '';
            this.rePassword = '';
            this.showErrorsChangePassword = false;
            this.validationsChangePassword = {};
        }
    },
});


