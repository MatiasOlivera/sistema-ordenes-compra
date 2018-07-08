<template lang="html">
    
    <div class="row border-bottom border-gray mb-4">
        <div class="col-auto">
            <h3 class="h6">{{ titulo }}</h3>
        </div>

        <div class="col-auto ml-auto">
            <a
                @click.prevent="cerrar"
                href="#"
                class="text-muted"
            >
                <x-icon class="icono"></x-icon> Cerrar
            </a>
        </div>
    </div>
    
</template>

<script>
import { XIcon } from 'vue-feather-icons';

export default {
    name: 'base-cabecera',
    components: {
        XIcon
    },
    props: {
        titulo: {
            type: String,
            required: true
        }
    },
    methods: {
        cerrar() {
            this.$emit('cerrar');
        }
    }
}
</script>

<style lang="css">
</style>
