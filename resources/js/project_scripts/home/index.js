let vue = new Vue({
    el: '#index',
    components: {

    },
    data: {
        url: $('#baseUrl').val() + '',
        filterText: '',
        users: [],
        paginate: {},
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
                    this.users = response.model;
                    this.paginate = response.paginate;
                    break;
            }
        },
        initList: function(page = 1){
            console.log($('#baseUrl').val());
            console.log(this.url);
            loading(true);
            let url = this.url + "jsonIndex/" + this.filterText + '?page=' + page;
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
    },
});
