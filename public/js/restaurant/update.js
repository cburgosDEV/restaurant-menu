/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************************************!*\
  !*** ./resources/js/project_scripts/restaurant/update.js ***!
  \***********************************************************/
var vue = new Vue({
  el: '#update',
  components: {},
  data: {
    url: $('#baseUrl').val() + 'restaurant',
    id: $('#id').val(),
    viewModel: [],
    validations: {},
    showError: false,
    isLoaded: false
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
          this.isLoaded = true;
          break;

        case 'store':
          if (response) {
            showToast('success', 'Operación realizada correctamente');
            window.location.href = this.url;
          } else {
            showToast('error', 'Ocurrió un error al guardar el registro');
          }

          break;
      }
    },
    initForm: function initForm() {
      var _this = this;

      loading(true);
      var url = this.url + "/jsonUpdate/" + this.id;
      window.axios.get(url).then(function (response) {
        _this.switchResponseServer("initForm", response.data);
      })["catch"](function (error) {})["finally"](function (response) {
        loading(false);
      });
    },
    save: function save() {
      var _this2 = this;

      loading(true);
      var url = this.url + "/store";
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