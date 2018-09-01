<template lang="html">

  <base-tarjeta
    :titulo="titulo"
    :boton-nuevo-visible="!form.visible"
    :boton-izq-visible="form.visible"
    @nuevo="mostrarForm"
    @cerrar="ocultarForm"
  >

    <template v-if="form.visible">
      <vc-form-asociar-empresa
        :empresas="empresasNoAsociadas"
        @buscar="buscar"
        @guardar="darDeAlta"
      />
      <hr>
    </template>

    <template v-if="hayEmpresas">
      <div class="row">
        <div class="col-10">
          <h6>Nombre de fantasía</h6>
        </div>
        <div class="col-2"/>
      </div>

      <vc-tarjeta-empresas-item
        v-for="empresa in empresas"
        :key="empresa.id"
        :id="empresa.id"
        :nombre="empresa.nombre_fantasia"
        @dar-de-alta="darDeAlta"
        @dar-de-baja="darDeBaja"
      />
    </template>

    <template v-else>
      <p>{{ mensaje }}</p>
    </template>

  </base-tarjeta>

</template>

<script>
/**
 * Componentes
 */
import BaseTarjeta from '../BaseTarjeta.vue';
import VcTarjetaEmpresasItem from './VcTarjetaEmpresasItem.vue';
import VcFormAsociarEmpresa from './VcFormAsociarEmpresa.vue';

export default {
  name: 'VcTarjetaEmpresas',

  components: {
    BaseTarjeta,
    VcTarjetaEmpresasItem,
    VcFormAsociarEmpresa
  },

  props: {
    empresasNoAsociadas: {
      type: Array,
      default: function() {
        return [];
      }
    },

    empresas: {
      type: Array,
      required: true
    },

    mensaje: {
      type: String,
      required: true
    }
  },

  data() {
    return {
      titulo: 'Empresas',
      form: {
        visible: false
      }
    };
  },

  computed: {
    hayEmpresas() {
      return !_.isEmpty(this.empresas);
    }
  },

  methods: {
    buscar(valorBuscado) {
      this.$emit('buscar', valorBuscado);
    },

    darDeAlta({ id }) {
      this.ocultarForm();
      this.$emit('dar-de-alta', id);
    },

    darDeBaja(id) {
      this.$emit('dar-de-baja', id);
    },

    mostrarForm() {
      this.form.visible = true;
    },

    ocultarForm() {
      this.form.visible = false;
    }
  }
};
</script>

<style lang="css">
</style>
