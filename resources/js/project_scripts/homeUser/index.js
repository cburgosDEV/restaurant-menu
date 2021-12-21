let vue = new Vue({
    el: '#index',
    components: {

    },
    data: {
        url: $('#baseUrl').val(),
        idUser: $('#idUser').val(),
        filterText: '',
        restaurants : [],
        paginate: {},
        isLoaded: false,
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
                    this.restaurants = response.model;
                    this.paginate = response.paginate;
                    this.isLoaded = true;
                    break;
            }
        },
        initList: function(page = 1){
            loading(true);
            let url = this.url + "homeUser/jsonIndex/" + this.idUser + '/' + this.filterText + '?page=' + page;
            window.axios.get(url).then((response) => {
                this.switchResponseServer("initList", response.data);
            }).catch((error) => {

            }).finally((response) => {
                loading(false);
            });
        },
        search: function (filterText){
            this.filterText = filterText;
            this.initList();
        },
        createRestaurant: function (){
            window.location.href = this.url + 'restaurant/create/' + this.idUser;
        }
    },
});
