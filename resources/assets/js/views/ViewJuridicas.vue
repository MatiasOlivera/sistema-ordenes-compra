<template lang="html">

  <base-crud
    :titulo="titulo"
    :boton-nuevo="botonNuevo"
  >

    <template
      slot="perfil"
      slot-scope="{ mostrarForm, ocultarPerfil }"
    >
      <vc-perfil-juridica
        @mostrar-form="mostrarForm(false)"
        @cerrar="ocultarPerfil"
      />
    </template>

    <template
      slot="formulario"
      slot-scope="{ ocultarForm }"
    >
      <vc-form-juridica @cerrar="ocultarForm"/>
    </template>

    <template
      slot="tabla"
      slot-scope="{ mostrarPerfil, mostrarForm }"
    >
      <vc-tabla-juridicas
        @mostrar-perfil="mostrarPerfil"
        @mostrar-form="mostrarForm(true)"
      />
    </template>

  </base-crud>

</template>

<script>
import BaseCrud from './BaseCrud.vue';
import VcPerfilJuridica from '../components/persona_juridica/VcPerfilJuridica.vue';
import VcFormJuridica from '../components/persona_juridica/VcFormJuridica.vue';
import VcTablaJuridicas from '../components/persona_juridica/VcTablaJuridicas.vue';

export default {
  components: {
    BaseCrud,
    VcPerfilJuridica,
    VcFormJuridica,
    VcTablaJuridicas
  },

  data() {
    return {
      titulo: 'Personas Jurídicas',
      botonNuevo: 'Nueva'
    };
  }
};
</script>

<style lang="css">
</style>
