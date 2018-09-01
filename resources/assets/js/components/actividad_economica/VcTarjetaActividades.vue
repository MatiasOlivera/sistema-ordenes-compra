<template lang="html">

  <base-tarjeta
    :titulo="$options.static.tarjeta.titulo"
    :boton-nuevo-visible="!form.visible"
    :boton-izq-visible="form.visible"
    @nuevo="mostrarForm"
    @cerrar="ocultarForm"
  >

    <template v-if="form.visible">
      <vc-form-asociar-actividad
        :actividades="actividadesNoAsociadas"
        @buscar="buscar"
        @guardar="darDeAlta"
      />
      <hr>
    </template>

    <template v-if="hayActividades">
      <div class="row">
        <div class="col-10">
          <h6>Descripción</h6>
        </div>
        <div class="col-2"/>
      </div>

      <vc-tarjeta-actividades-item
        v-for="actividad in actividades"
        :key="actividad.id"
        :id="actividad.id"
        :actividad="actividad.descripcion"
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
import VcTarjetaActividadesItem from './VcTarjetaActividadesItem.vue';
import VcFormAsociarActividad from './VcFormAsociarActividad.vue';

export default {
  name: 'VcTarjetaActividades',
  components: {
    BaseTarjeta,
    VcTarjetaActividadesItem,
    VcFormAsociarActividad
  },
  props: {
    actividadesNoAsociadas: {
      type: Array,
      default: function() {
        return [];
      }
    },
    actividades: {
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
    hayActividades() {
      return !_.isEmpty(this.actividades);
    }
  },
  static: {
    tarjeta: {
      titulo: 'Rubros'
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
