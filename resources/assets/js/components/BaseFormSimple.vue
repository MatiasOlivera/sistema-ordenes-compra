<template lang="html">
    
    <form @submit.prevent="guardar">        
        <!-- Campos -->
        <slot></slot>
        
        <!-- Botones -->
        <div class="row mt-4">
            <div class="col">
                <button type="submit" name="submit" class="btn btn-primary btn-sm">
                    <save-icon class="icono"></save-icon> Guardar
                </button>
            </div>
        </div>
    </form>
    
</template>

<script>
/**
 * Componentes
 */
import { SaveIcon } from 'vue-feather-icons';


export default {
    name: 'base-form-simple',
    components: {
        SaveIcon
    },
    methods: {
        guardar() {
            this.$emit('guardar');
        }
    }
}
</script>

<style lang="css">
</style>
