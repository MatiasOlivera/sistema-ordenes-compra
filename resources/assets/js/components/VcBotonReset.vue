<template lang="html">
    
    <button
        type="reset"
        name="reset"
        class="btn btn-secondary btn-sm"
    >
        <delete-icon class="icono"></delete-icon> Deshacer todo
    </button>
    
</template>

<script>
/**
 * Componentes
 */
import { DeleteIcon } from 'vue-feather-icons';

export default {
    name: 'vc-boton-reset',
    components: { DeleteIcon }
}
</script>

<style lang="css">
</style>
