/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************************!*\
  !*** ./resources/js/project_scripts/homeUser/index.js ***!
  \********************************************************/
var vue = new Vue({
  el: '#index',
  components: {},
  data: {
    url: $('#baseUrl').val(),
    idUser: $('#idUser').val(),
    filterText: '',
    restaurants: [],
    paginate: {},
    isLoaded: false
  },
  computed: {},
  created: function created() {
    this.initList();
  },
  methods: {
    switchResponseServer: function switchResponseServer(switchAction, response) {
      switch (switchAction) {
        case 'initList':
          this.restaurants = response.model;
          this.paginate = response.paginate;
          this.isLoaded = true;
          break;
      }
    },
    initList: function initList() {
      var _this = this;

      var page = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
      loading(true);
      var url = this.url + "homeUser/jsonIndex/" + this.idUser + (this.filterText === '' ? '' : '/') + this.filterText + '?page=' + page;
      window.axios.get(url).then(function (response) {
        _this.switchResponseServer("initList", response.data);
      })["catch"](function (error) {})["finally"](function (response) {
        loading(false);
      });
    },
    search: function search(filterText) {
      this.filterText = filterText;
      this.initList();
    },
    createRestaurant: function createRestaurant() {
      window.location.href = this.url + 'restaurant/create/' + this.idUser;
    }
  }
});
/******/ })()
;