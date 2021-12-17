/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************************************!*\
  !*** ./resources/js/project_scripts/plate/index.js ***!
  \*****************************************************/
var vue = new Vue({
  el: '#index',
  components: {},
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
    validations: {},
    showError: false,
    modalTitle: '',
    buttonModalTitle: ''
  },
  computed: {},
  created: function created() {
    this.initList();
  },
  methods: {
    switchResponseServer: function switchResponseServer(switchAction, response) {
      switch (switchAction) {
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
          if (response) {
            showToast('success', 'Operación realizada correctamente');
            this.initList();
            $('#CategoryModal').modal('hide');
          } else {
            showToast('error', 'Ocurrió un error al guardar el registro');
          }

          break;

        case 'storePlate':
          if (response) {
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
    initList: function initList() {
      var _this = this;

      loading(true);
      var url = this.url + "/jsonIndex/" + this.idRestaurant + "/" + this.filterTextCategory;
      window.axios.get(url).then(function (response) {
        _this.switchResponseServer("initList", response.data);
      })["catch"](function (error) {})["finally"](function (response) {
        loading(false);
      });
    },
    showModalCategory: function showModalCategory() {
      var idCategory = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
      this.clearDataCategory();

      if (idCategory === 0) {
        this.modalTitle = 'Crear nueva categoría';
        this.buttonModalTitle = 'Guardar';
        this.initFormCreateCategory();
      } else {
        this.modalTitle = 'Detalle';
        this.buttonModalTitle = 'Actualizar';
        this.isEditFormCategory = true;
        this.initFormDetailCategory(idCategory);
      }

      $('#CategoryModal').modal('show');
    },
    initFormCreateCategory: function initFormCreateCategory() {
      var _this2 = this;

      loading(true);
      var url = this.url + "/jsonCreateCategory/" + this.discriminator;
      window.axios.get(url).then(function (response) {
        _this2.switchResponseServer("jsonCreate", response.data);
      })["catch"](function (error) {})["finally"](function (response) {
        loading(false);
      });
    },
    initFormDetailCategory: function initFormDetailCategory(idCategory, callback) {
      var _this3 = this;

      loading(true);
      var url = this.url + "/jsonDetailCategory/" + idCategory;
      window.axios.get(url).then(function (response) {
        _this3.switchResponseServer("jsonDetail", response.data);
      })["catch"](function (error) {})["finally"](function (response) {
        loading(false);

        if (callback) {
          callback();
        }
      });
    },
    saveCategory: function saveCategory() {
      var _this4 = this;

      var url = this.url + "/storeCategory";
      this.viewModel.idRestaurant = this.idRestaurant;
      loading(true);
      window.axios.post(url, this.viewModel).then(function (response) {
        _this4.switchResponseServer("storeCategory", response.data);
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this4.showError = true;
          _this4.validations = error.response.data.errors;
        }

        showToast('error', 'Revisar los datos ingresados');
      })["finally"](function (response) {
        loading(false);
      });
    },
    softDeleteCategory: function softDeleteCategory(idCategory) {
      var _this5 = this;

      this.$swal({
        icon: 'warning'
      }).then(function (result) {
        if (result.value) {
          var context = _this5;

          _this5.initFormDetailCategory(idCategory, function () {
            context.viewModel.state = false;
            context.saveCategory();
          });
        }
      });
    },
    clearDataCategory: function clearDataCategory() {
      this.isEditFormCategory = false;
      this.showError = false;
      this.validations = {};
      this.viewModel = {};
      this.modalTitle = '';
      this.buttonModalTitle = '';
    },
    //PLATE
    initListPlate: function initListPlate(idCategory) {
      var _this6 = this;

      this.idCategory = idCategory;
      loading(true);
      var url = this.url + "/jsonIndexPlate/" + idCategory + "/" + this.filterTextPlate;
      window.axios.get(url).then(function (response) {
        _this6.switchResponseServer("initListPlate", response.data);
      })["catch"](function (error) {})["finally"](function (response) {
        loading(false);
      });
    },
    showModalPlate: function showModalPlate() {
      var idPlate = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
      this.clearDataPlate();

      if (idPlate === 0) {
        this.modalTitle = 'Crear nuevo plato';
        this.buttonModalTitle = 'Guardar';
        this.initFormCreatePlate();
      } else {
        this.modalTitle = 'Detalle';
        this.buttonModalTitle = 'Actualizar';
        this.isEditFormPlate = true;
        this.initFormDetailPlate(idPlate);
      }

      $('#PlateModal').modal('show');
    },
    initFormCreatePlate: function initFormCreatePlate() {
      var _this7 = this;

      loading(true);
      var url = this.url + "/jsonCreate";
      window.axios.get(url).then(function (response) {
        _this7.switchResponseServer("jsonCreate", response.data);
      })["catch"](function (error) {})["finally"](function (response) {
        loading(false);
      });
    },
    initFormDetailPlate: function initFormDetailPlate(idPlate, callback) {
      var _this8 = this;

      loading(true);
      var url = this.url + "/jsonDetail/" + idPlate;
      window.axios.get(url).then(function (response) {
        _this8.switchResponseServer("jsonDetail", response.data);
      })["catch"](function (error) {})["finally"](function (response) {
        loading(false);

        if (callback) {
          callback();
        }
      });
    },
    savePlate: function savePlate() {
      var _this9 = this;

      var url = this.url + "/store";
      this.viewModel.idCategory = this.idCategory;
      loading(true);
      window.axios.post(url, this.viewModel).then(function (response) {
        _this9.switchResponseServer("storePlate", response.data);
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this9.showError = true;
          _this9.validations = error.response.data.errors;
        }

        showToast('error', 'Revisar los datos ingresados');
      })["finally"](function (response) {
        loading(false);
      });
    },
    searchPlate: function searchPlate(filterTextPlate) {
      this.filterTextPlate = filterTextPlate;
      this.initList();
    },
    softDeletePlate: function softDeletePlate(idPlate) {
      var _this10 = this;

      this.$swal({
        icon: 'warning'
      }).then(function (result) {
        if (result.value) {
          var context = _this10;

          _this10.initFormDetailPlate(idPlate, function () {
            context.viewModel.state = false;
            context.savePlate();
          });
        }
      });
    },
    clearDataPlate: function clearDataPlate() {
      this.isEditFormPlate = false;
      this.showError = false;
      this.validations = {};
      this.viewModel = {};
      this.modalTitle = '';
      this.buttonModalTitle = '';
    }
  }
});
/******/ })()
;