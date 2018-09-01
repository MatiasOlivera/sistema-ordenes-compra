<template lang="html">

  <base-tarjeta
    :titulo="titulo"
    :boton-izq-visible="tarjeta.botonIzq.visible"
    :boton-izq-tipo="tarjeta.botonIzq.tipo"
    @cerrar="cerrar"
  >
    <!-- Botones -->
    <div class="mb-3">
      <vc-boton-editar
        v-if="!eliminado"
        @click="editar"
      />

      <slot name="acciones"/>

      <vc-boton-alta
        v-if="eliminado"
        :nombre="nombreInstancia"
        @confirmado="darDeAlta"
      />
      <vc-boton-baja
        v-else
        :nombre="nombreInstancia"
        @confirmado="darDeBaja"
      />
    </div>


    <!-- Datos -->
    <slot/>
  </base-tarjeta>

</template>

<script>
/**
 * Componentes
 */
import BaseTarjeta from './BaseTarjeta.vue';
import VcBotonEditar from './VcBotonEditar.vue';
import VcBotonBaja from './VcBotonBaja.vue';
import VcBotonAlta from './VcBotonAlta.vue';

export default {
  name: 'BasePerfil',

  components: {
    BaseTarjeta,
    VcBotonEditar,
    VcBotonBaja,
    VcBotonAlta
  },

  props: {
    titulo: {
      type: String,
      required: true
    },

    nombreInstancia: {
      type: String,
      required: true
    },

    eliminado: {
      type: Boolean,
      required: true,
      default: false
    }
  },

  data() {
    return {
      tarjeta: {
        botonIzq: {
          visible: true,
          tipo: 'cerrar'
        }
      }
    };
  },

  methods: {
    editar() {
      this.$emit('editar');
    },

    darDeBaja() {
      this.$emit('dar-de-baja');
    },

    darDeAlta() {
      this.$emit('dar-de-alta');
    },

    cerrar() {
      this.$emit('cerrar');
    }
  }
};
</script>

<style lang="css">
</style>
