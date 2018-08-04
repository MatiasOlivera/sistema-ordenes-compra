<template lang="html">
    
    <base-form-simple
        @guardar="guardar"
    >
        
        <fieldset class="form-group">
            <label for="vc-select-empresas">Empresas</label>
            
            <vc-select-empresa
                :empresas="empresas"
                @buscar="selectEmpresaBuscar"
                @input="selectEmpresaInput"
            >
            </vc-select-empresa>
        </fieldset>
        
    </base-form-simple>
    
</template>

<script>
/**
 * Componentes
 */
import BaseFormSimple  from '../../components/BaseFormSimple.vue';
import VcSelectEmpresa from './VcSelectEmpresa.vue';


export default {
    name: 'vc-form-asociar-empresa',
    components: {
        BaseFormSimple,
        VcSelectEmpresa
    },
    props: {
        empresas: {
            type: Array,
            default: function() {
                return [];
            }
        }
    },
    data() {
        return {
            relacion: []
        }
    },
    methods: {
        selectEmpresaBuscar(valorBuscado) {
            this.$emit('buscar', valorBuscado);
        },
        
        selectEmpresaInput(empresa) {
            this.relacion = empresa;
        },
        
        guardar() {
            this.$emit('guardar', this.relacion);
        }
    }
}
</script>

<style lang="css">
</style>
