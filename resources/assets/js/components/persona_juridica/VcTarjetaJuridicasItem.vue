<template lang="html">

    <div class="row">
        <div class="col-5">
            <p>{{ denominacion }}</p>
        </div>
        <div class="col-5">
            <p>{{ cuit | formatoCuit }}</p>
        </div>
        <div class="col-2">
            <vc-boton-baja
                :tooltip="$options.static.tooltip"
                :nombre="denominacion"
                @confirmado="darDeBaja"
            >
            </vc-boton-baja>
        </div>
    </div>

</template>

<script>
/**
 * Mixins
 */
import FiltroCuitMixin from '../../mixins/persona_juridica/filtro_cuit_mixin.js';

/**
 * Componentes
 */
import VcBotonBaja from '../../components/VcBotonBaja.vue';


export default {
    name: 'vc-tarjeta-juridicas-item',
    mixins: [ FiltroCuitMixin ],
    components: { VcBotonBaja },
    props: {
        id: {
            type: Number,
            required: true
        },
        denominacion: {
            type: String,
            required: true
        },
        cuit: {
            type: Number,
            required: true
        }
    },
    static: {
        tooltip: 'Eliminar relación'
    },
    methods: {
        darDeBaja() {
            this.$emit('dar-de-baja', this.id);
        }
    }
}
</script>

<style lang="css">
</style>
