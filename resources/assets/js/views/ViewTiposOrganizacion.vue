<template lang="html">

  <base-crud
    :titulo="titulo"
    :boton-nuevo="botonNuevo"
  >

    <template
      slot="perfil"
      slot-scope="{ mostrarForm, ocultarPerfil }"
    >
      <vc-perfil-tipo-org
        @mostrar-form="mostrarForm(false)"
        @cerrar="ocultarPerfil"
      />
    </template>

    <template
      slot="formulario"
      slot-scope="{ ocultarForm }"
    >
      <vc-form-tipo-org @cerrar="ocultarForm"/>
    </template>

    <template
      slot="tabla"
      slot-scope="{ mostrarPerfil, mostrarForm }"
    >
      <vc-tabla-tipo-org
        @mostrar-perfil="mostrarPerfil"
        @mostrar-form="mostrarForm(true)"
      />
    </template>

  </base-crud>

</template>

<script>
import BaseCrud from './BaseCrud.vue';
import VcPerfilTipoOrg from '../components/tipo_organizacion/VcPerfilTipoOrg.vue';
import VcFormTipoOrg from '../components/tipo_organizacion/VcFormTipoOrg.vue';
import VcTablaTipoOrg from '../components/tipo_organizacion/VcTablaTipoOrg.vue';

export default {
  components: {
    BaseCrud,
    VcPerfilTipoOrg,
    VcFormTipoOrg,
    VcTablaTipoOrg
  },

  data() {
    return {
      titulo: 'Tipos de organización',
      botonNuevo: 'Nuevo'
    };
  }
};
</script>

<style lang="css">
</style>
