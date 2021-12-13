import VueUploadMultipleImage from 'vue-upload-multiple-image';

let vue = new Vue({
    el: '#update',
    components: {
        VueUploadMultipleImage
    },
    data: {
        url: $('#baseUrl').val(),
        id: $('#id').val(),
        viewModel : [],
        validations : {},
        showError: false,
        isLoaded: false,
        //section restaurant categories
        restaurantCategoryDropdown: [],
        categories: [],
        //section restaurant images
        images: [],
        listImagePath: [],
        listImageDelete: null,
        showEdit: false,
        isImageSelectorDisabled: false,
    },
    computed: {

    },
    created() {
        this.initForm();
    },
    watch: {
        listImagePath: function (){
            this.isImageSelectorDisabled = this.listImagePath.length===3;
        },
    },
    methods: {
        switchResponseServer: function (switchAction, response){
            switch (switchAction){
                case 'initForm':
                    this.viewModel = response.viewModel;
                    this.restaurantCategoryDropdown = response.restaurantCategoryDropdown;
                    this.isLoaded = true;
                    break;
                case 'store':
                    if(response){
                        showToast('success', 'Operación realizada correctamente');
                        window.location.href = this.url;
                    } else {
                        showToast('error', 'Ocurrió un error al guardar el registro');
                    }
                    break;
            }
        },
        initForm: function(){
            loading(true);
            let url = this.url + "restaurant/jsonUpdate/" + this.id;
            window.axios.get(url).then((response) => {
                this.switchResponseServer("initForm", response.data);
            }).catch((error) => {

            }).finally((response) => {
                this.setImages(this.viewModel.images);
                this.setCategories(this.viewModel.categories);
                loading(false);
            });
        },
        save: function () {
            let listImageFile = [];
            let listCategoryDelete = [];
            this.listImagePath.forEach((item)=>{
                listImageFile.push({
                    'id':item.id??0,
                    'default':item.default,
                    'highlight':item.highlight,
                    'file': item.path
                });
            });
            if(this.viewModel.categories.length!==0){
                listCategoryDelete = this.viewModel.categories.filter(
                    item => !this.categories.includes(item.idCategory)
                );
            }
            this.viewModel.listImageDelete = this.listImageDelete;
            this.viewModel.listImage = listImageFile;

            this.viewModel.listCategory = this.categories;
            this.viewModel.listCategoryDelete = listCategoryDelete;
            loading(true);
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
        softDelete: function (){
            this.$swal({
                icon: 'warning',
                confirmButtonText: 'Si, eliminar restaurante',
            }).then((result) => {
                if(result.value) {
                    let context = this;
                    context.viewModel.state = false;
                    loading(true);
                    let url = this.url + "restaurant/softDelete";
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
                }
            });
        },
        uploadImageSuccess(formData, index, fileList) {
            this.listImagePath = fileList;
            if(this.listImagePath.length>3){
                this.images = [];
                this.setImages(this.viewModel.images);
                this.listImagePath = [];
                showToast('error', 'Solo se permiten agregar 3 imágenes');
            }
        },
        beforeRemove (index, done, fileList) {
            let r = true;
            if (r) {
                this.listImageDelete = fileList;
                done();
                if(fileList.length===2){
                    this.isImageSelectorDisabled = false;
                }
            }
        },
        markIsPrimary: function (index, fileList) {
            this.listImagePath = fileList;
        },
        setImages: function (images){
            images.forEach((item)=>{
                if(!item.state)return;
                this.images.push(
                    {
                        id: item.id,
                        path: '../../storage/'+item.url,
                        default: item.isPrincipal??0,
                        highlight: item.isPrincipal??0,
                        caption: 'Producto'
                    }
                );
            });
            this.isImageSelectorDisabled = this.images.length===3;
        },
        setCategories: function (categories) {
            categories.forEach((item)=>{
                if(!item.state)return;
                this.categories.push(item.idCategory);
            });
        },
    },
});
