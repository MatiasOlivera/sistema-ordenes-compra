<template lang="html">

    <button
        @click="$_TooltipMixin_ocultarTooltip"
        type="button"
        name="info"
        class="btn btn-sm btn-outline-info"
        data-toggle="tooltip"
        data-placement="top"
        :title="tooltip"
    >
        <info-icon class="icono"></info-icon>
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
import { InfoIcon } from 'vue-feather-icons';

export default {
    name: 'vc-boton-info',
    mixins: [ TooltipMixin ],
    components: { InfoIcon },
    props: {
        tooltip: {
            type: String,
            default: 'Perfil'
        }
    },
    static: {
        elemento: 'button[name="info"]'
    }
}
</script>

<style lang="css">
</style>
