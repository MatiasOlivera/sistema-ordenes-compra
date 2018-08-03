<template lang="html">
    
    <base-crud
        :titulo="titulo"
        :botonNuevo="botonNuevo"
    >
    
        <template slot="perfil" slot-scope="{ mostrarForm, ocultarPerfil }">
            <vc-perfil-actividad
                @mostrar-form="mostrarForm(false)"
                @cerrar="ocultarPerfil"
            >
            </vc-perfil-actividad>
        </template>
        
        <template slot="formulario" slot-scope="{ ocultarForm }">
            <vc-form-actividad @cerrar="ocultarForm">
            </vc-form-actividad>
        </template>
        
        <template slot="tabla" slot-scope="{ mostrarPerfil, mostrarForm }">
            <vc-tabla-actividades
                @mostrar-perfil="mostrarPerfil"
                @mostrar-form="mostrarForm(true)"
            >
            </vc-tabla-actividades>
        </template>
    
    </base-crud>
    
</template>

<script>
import BaseCrud           from '../views/BaseCrud.vue';
import VcPerfilActividad  from '../components/actividad_economica/VcPerfilActividad.vue';
import VcFormActividad    from '../components/actividad_economica/VcFormActividad.vue';
import VcTablaActividades from '../components/actividad_economica/VcTablaActividades.vue';

export default {
    components: {
        BaseCrud,
        VcPerfilActividad,
        VcFormActividad,
        VcTablaActividades
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
