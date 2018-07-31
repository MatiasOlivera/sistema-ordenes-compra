<template lang="html">
    
    <base-form-simple
        @guardar="guardar"
    >
        
        <fieldset class="form-group">
            <label for="vc-select-juridica">Persona jurídica</label>
            
            <vc-select-juridica
                :juridicas="juridicas"
                @buscar="selectJuridicaBuscar"
                @input="selectJuridicaInput"
            >
            </vc-select-juridica>
        </fieldset>
        
    </base-form-simple>
    
</template>

<script>
/**
 * Componentes
 */
import BaseFormSimple   from '../../components/BaseFormSimple.vue';
import VcSelectJuridica from './VcSelectJuridica.vue';


export default {
    name: 'vc-form-asociar-juridica',
    components: {
        BaseFormSimple,
        VcSelectJuridica
    },
    props: {
        juridicas: {
            type: Array,
            default: []
        }
    },
    data() {
        return {
            relacion: []
        }
    },
    methods: {
        selectJuridicaBuscar(valorBuscado) {
            this.$emit('buscar', valorBuscado);
        },
        
        selectJuridicaInput(juridica) {
            this.relacion = juridica;
        },
        
        guardar() {
            this.$emit('guardar', this.relacion);
        }
    }
}
</script>

<style lang="css">
</style>
