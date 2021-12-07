<template>
    <div class="modal fade" :id="idModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">{{modalTitle}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
                <div class="modal-footer">
                    <button v-if="buttonTitle!==undefined" type="button" class="btn btn-primary" v-on:click="buttonAction">{{buttonTitle}}</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CustomModal",
    props: {
        idModal: {
            type: String,
            required: true,
        },
        modalTitle: {
            type: String,
            required: true,
        },
        buttonTitle: String
    },
    methods: {
        buttonAction: function () {
            this.$emit('button-action');
        }
    },
}
</script>

<style>

</style>
