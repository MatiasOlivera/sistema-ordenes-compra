<template lang="html">
    
    <base-crud
        :titulo="titulo"
        :botonNuevo="botonNuevo"
    >
    
        <template slot="perfil" slot-scope="{ mostrarForm, ocultarPerfil }">
            <vc-perfil-rubro
                @mostrar-form="mostrarForm(false)"
                @cerrar="ocultarPerfil"
            >
            </vc-perfil-rubro>
        </template>
        
        <template slot="formulario" slot-scope="{ ocultarForm }">
            <vc-form-rubro @cerrar="ocultarForm">
            </vc-form-rubro>
        </template>
        
        <template slot="tabla" slot-scope="{ mostrarPerfil, mostrarForm }">
            <vc-tabla-rubros
                @mostrar-perfil="mostrarPerfil"
                @mostrar-form="mostrarForm(true)"
            >
            </vc-tabla-rubros>
        </template>
    
    </base-crud>
    
</template>

<script>
import BaseCrud      from '../views/BaseCrud.vue';
import VcPerfilRubro from '../components/rubro/VcPerfilRubro.vue';
import VcFormRubro   from '../components/rubro/VcFormRubro';
import VcTablaRubros from '../components/rubro/VcTablaRubros.vue';

export default {
    components: {
        BaseCrud,
        VcPerfilRubro,
        VcFormRubro,
        VcTablaRubros
    },
    data() {
        return {
            titulo: 'Rubros',
            botonNuevo: 'Nuevo'
        }
    }
}
</script>

<style lang="css">
</style>
