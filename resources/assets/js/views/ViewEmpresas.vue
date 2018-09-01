<template lang="html">

  <base-crud
    :titulo="titulo"
    :boton-nuevo="botonNuevo"
  >

    <template
      slot="perfil"
      slot-scope="{ mostrarForm, ocultarPerfil }"
    >
      <vc-perfil-empresa
        @mostrar-form="mostrarForm(false)"
        @cerrar="ocultarPerfil"
      />
    </template>

    <template
      slot="formulario"
      slot-scope="{ ocultarForm }"
    >
      <vc-form-empresa @cerrar="ocultarForm"/>
    </template>

    <template
      slot="tabla"
      slot-scope="{ mostrarPerfil, mostrarForm }"
    >
      <vc-tabla-empresas
        @mostrar-perfil="mostrarPerfil"
        @mostrar-form="mostrarForm(true)"
      />
    </template>

  </base-crud>

</template>

<script>
import BaseCrud from './BaseCrud.vue';
import VcPerfilEmpresa from '../components/empresa/VcPerfilEmpresa.vue';
import VcFormEmpresa from '../components/empresa/VcFormEmpresa.vue';
import VcTablaEmpresas from '../components/empresa/VcTablaEmpresas.vue';

export default {
  components: {
    BaseCrud,
    VcPerfilEmpresa,
    VcFormEmpresa,
    VcTablaEmpresas
  },

  data() {
    return {
      titulo: 'Empresas',
      botonNuevo: 'Nueva'
    };
  }
};
</script>

<style lang="css">
</style>
