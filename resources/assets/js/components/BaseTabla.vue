<template lang="html">

  <v-server-table
    :ref="nombre"
    :name="nombre"
    :url="url"
    :columns="todasColumnas"
    :options="todasOpciones"
  >
    <template slot="afterFilter">
      <div class="custom-control custom-checkbox ml-3">
        <input
          id="eliminados"
          v-model="soloEliminados"
          type="checkbox"
          class="custom-control-input"
        >
        <label
          class="custom-control-label"
          for="eliminados"
        >
          Solo eliminados
        </label>
      </div>

      <slot name="filtros"/>
    </template>

    <template
      slot="acciones"
      slot-scope="{ row: fila, row: {id} }"
    >
      <vc-boton-info
        @click="verPerfil(id)"
      />

      <vc-boton-editar
        @click="editar(id)"
      />

      <vc-boton-alta
        v-if="soloEliminados"
        :nombre="fila[campoNombre]"
        @confirmado="darDeAlta(fila.id)"
      />

      <vc-boton-baja
        v-else
        :nombre="fila[campoNombre]"
        @confirmado="darDeBaja(fila.id)"
      />
    </template>
  </v-server-table>

</template>

<script>
import VcBotonInfo from './VcBotonInfo.vue';
import VcBotonEditar from './VcBotonEditar.vue';
import VcBotonBaja from './VcBotonBaja.vue';
import VcBotonAlta from './VcBotonAlta.vue';

export default {
  components: {
    VcBotonInfo,
    VcBotonEditar,
    VcBotonBaja,
    VcBotonAlta
  },

  props: {
    nombre: {
      type: String,
      required: true
    },

    url: {
      type: String,
      required: true
    },

    columnas: {
      type: Array,
      required: true
    },

    opciones: {
      type: Object,
      required: true
    },

    obtenerTabla: {
      type: Boolean,
      default: false
    },

    campoNombre: {
      type: String,
      required: true
    }
  },

  data() {
    return {
      soloEliminados: false
    };
  },

  computed: {
    todasColumnas() {
      const especificas = this.columnas;
      const porDefecto = ['acciones'];
      return especificas.concat(porDefecto);
    },

    todasOpciones() {
      const OPCIONES_POR_DEFECTO = {
        requestAdapter: (data) => {
          let datos = data;
          const BINARIO = this.soloEliminados ? 1 : 0;
          datos.soloEliminados = BINARIO;

          return datos;
        }
      };

      return { ...OPCIONES_POR_DEFECTO, ...this.opciones };
    }
  },

  watch: {
    obtenerTabla(estado) {
      if (estado) this.obtenerModelos();
    },

    soloEliminados() {
      this.obtenerModelos();
    }
  },

  methods: {
    verPerfil(id) {
      this.$emit('ver-perfil', id);
    },

    editar(id) {
      this.$emit('editar', id);
    },

    darDeBaja(id) {
      this.$emit('dar-de-baja', id);
    },

    darDeAlta(id) {
      this.$emit('dar-de-alta', id);
    },

    obtenerModelos() {
      this.$refs[this.nombre].getData();
    }
  }
};
</script>

<style lang="css">
</style>
