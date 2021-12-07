/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************************!*\
  !*** ./resources/js/project_scripts/home/index.js ***!
  \****************************************************/
var vue = new Vue({
  el: '#index',
  components: {},
  data: {
    url: $('#baseUrl').val()
  },
  computed: {},
  created: function created() {
    this.initList();
    console.log("Vue works");
  },
  methods: {
    switchResponseServer: function switchResponseServer(switchAction, response) {
      switch (switchAction) {
        case 'initList':
          break;
      }
    },
    initList: function initList() {
      var page = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
    }
  }
});
/******/ })()
;