<template lang="html">

  <base-tarjeta
    :titulo="$options.static.tarjeta.titulo"
    :boton-nuevo-visible="!form.visible"
    :boton-izq-visible="form.visible"
    @nuevo="mostrarForm"
    @cerrar="ocultarForm"
  >

    <template v-if="form.visible">
      <vc-form-asociar-juridica
        :juridicas="juridicasNoAsociadas"
        @buscar="buscar"
        @guardar="darDeAlta"
      />
      <hr>
    </template>

    <template v-if="hayJuridicas">
      <div class="row">
        <div class="col-5">
          <h6>Denominación</h6>
        </div>
        <div class="col-5">
          <h6>CUIT</h6>
        </div>
        <div class="col-2"/>
      </div>

      <vc-tarjeta-juridicas-item
        v-for="juridica in juridicas"
        :key="juridica.id"
        :id="juridica.id"
        :denominacion="juridica.denominacion"
        :cuit="juridica.cuit"
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
import VcTarjetaJuridicasItem from './VcTarjetaJuridicasItem.vue';
import VcFormAsociarJuridica from './VcFormAsociarJuridica.vue';

export default {
  name: 'VcTarjetaJuridicas',

  components: {
    BaseTarjeta,
    VcTarjetaJuridicasItem,
    VcFormAsociarJuridica
  },

  props: {
    juridicasNoAsociadas: {
      type: Array,
      default: function() {
        return [];
      }
    },

    juridicas: {
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
      form: {
        visible: false
      }
    };
  },

  computed: {
    hayJuridicas() {
      return !_.isEmpty(this.juridicas);
    }
  },

  static: {
    tarjeta: {
      titulo: 'Personas jurídicas'
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
