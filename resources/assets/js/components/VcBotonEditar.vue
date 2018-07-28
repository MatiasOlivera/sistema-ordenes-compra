<template lang="html">

    <button
        @click="click"
        type="button"
        name="editar"
        class="btn btn-sm btn-outline-primary"
        data-toggle="tooltip"
        data-placement="top"
        :title="tooltip"
    >
        <edit-icon class="icono"></edit-icon>
    </button>

</template>

<script>
/**
 * Mixins
 */
import TooltipMixin from '../mixins/tooltip_mixin.js';

/**
 * Componentes
 */
import { EditIcon } from 'vue-feather-icons';

export default {
    name: 'vc-boton-editar',
    mixins: [ TooltipMixin ],
    components: { EditIcon },
    data() {
        return {
            tooltip: 'Editar'
        }
    },
    static: {
        elemento: 'button[name="editar"]'
    },
    methods: {
        click() {
            this.$_TooltipMixin_ocultarTooltip();
            this.$emit('click');
        }
    }
}
</script>

<style lang="css">
</style>
