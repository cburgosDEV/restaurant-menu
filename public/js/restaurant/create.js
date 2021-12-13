/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************************************!*\
  !*** ./resources/js/project_scripts/restaurant/create.js ***!
  \***********************************************************/
var vue = new Vue({
  el: '#create',
  components: {},
  data: {
    url: $('#baseUrl').val(),
    viewModel: {},
    validations: {},
    showError: false
  },
  computed: {},
  created: function created() {
    this.initForm();
  },
  methods: {
    switchResponseServer: function switchResponseServer(switchAction, response) {
      switch (switchAction) {
        case 'initForm':
          this.viewModel = response;
          break;

        case 'store':
          if (response.id > 0) {
            showToast('success', 'Operación realizada correctamente');
            window.location.href = this.url + '/update/' + response.id;
          } else {
            showToast('error', 'Ocurrió un error al guardar el registro');
          }

          break;
      }
    },
    initForm: function initForm() {
      var _this = this;

      loading(true);
      var url = this.url + "restaurant/jsonCreate";
      window.axios.get(url).then(function (response) {
        _this.switchResponseServer("initForm", response.data);
      })["catch"](function (error) {})["finally"](function (response) {
        loading(false);
      });
    },
    save: function save() {
      var _this2 = this;

      loading(true);
      var url = this.url + "restaurant/store";
      window.axios.post(url, this.viewModel).then(function (response) {
        _this2.switchResponseServer("store", response.data);
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this2.showError = true;
          _this2.validations = error.response.data.errors;
        }

        showToast('error', 'Revisar los datos ingresados');
      })["finally"](function (response) {
        loading(false);
      });
    }
  }
});
/******/ })()
;