let vue = new Vue({
    el: '#index',
    components: {

    },
    data: {
        url: $('#baseUrl').val(),
    },
    computed: {

    },
    created() {
        this.initList();
        console.log("Vue works")
    },
    methods: {
        switchResponseServer: function (switchAction, response){
            switch (switchAction){
                case 'initList':

                    break;
            }
        },
        initList: function(page = 1){

        },
    },
});
