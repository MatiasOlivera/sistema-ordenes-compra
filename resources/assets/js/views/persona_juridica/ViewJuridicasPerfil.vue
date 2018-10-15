<template>

  <div class="row justify-content-center">
    <div class="col-xl-6">
      <router-view/>

      <!-- Empresas -->
      <vc-tarjeta-empresas
        :empresas-no-asociadas="empresas.listado"
        :empresas="juridica.empresas"
        :mensaje="empresas.mensaje"
        @buscar="buscarEmpresa"
        @dar-de-alta="darDeAltaEmpresa"
        @dar-de-baja="darDeBajaEmpresa"
      />
    </div>
  </div>

</template>

<script>
import { mapState, mapActions } from 'vuex';
import store from '../../store';
import {
  OBTENER_JURIDICA,
  ASOCIAR_JURIDICA_EMPRESA,
  DESASOCIAR_JURIDICA_EMPRESA
} from '../../store/tipos_acciones';
import { MODULO_JURIDICAS } from '../../store/tipos_modulos';
import { manejadorNotificacion } from '../../store/modules/modulo_notificaciones';
import { obtenerEmpresas } from '../../api/empresa';
import VcTarjetaEmpresas from '../../components/empresa/VcTarjetaEmpresas.vue';

export default {
  name: 'ViewJuridicasPerfil',

  components: { VcTarjetaEmpresas },

  async beforeRouteEnter(hacia, desde, siguiente) {
    await store.dispatch(
      `${MODULO_JURIDICAS}/${OBTENER_JURIDICA}`,
      hacia.params.id
    );
    return siguiente();
  },

  async beforeRouteUpdate(hacia, desde, siguiente) {
    if (desde.params.id !== hacia.params.id) {
      await store.dispatch(
        `${MODULO_JURIDICAS}/${OBTENER_JURIDICA}`,
        hacia.params.id
      );
    }
    return siguiente();
  },

  data() {
    return {
      empresas: {
        listado: [],
        mensaje: 'No existen empresas asociadas a esta persona jurídica'
      }
    };
  },

  computed: {
    ...mapState(MODULO_JURIDICAS, ['juridica'])
  },

  methods: {
    ...mapActions(MODULO_JURIDICAS, {
      asociarJuridicaConEmpresa: ASOCIAR_JURIDICA_EMPRESA,
      desasociarJuridicaConEmpresa: DESASOCIAR_JURIDICA_EMPRESA
    }),

    buscarEmpresa(valorBuscado) {
      obtenerEmpresas({
        busqueda: valorBuscado,
        juridicaId: this.juridica.id
      })
        .then(({ data }) => {
          this.empresas.listado = data.data;
        })
        .catch(manejadorNotificacion);
    },

    darDeAltaEmpresa(id) {
      this.asociarJuridicaConEmpresa({
        idJuridica: this.juridica.id,
        idEmpresa: id
      });
    },

    darDeBajaEmpresa(id) {
      this.desasociarJuridicaConEmpresa({
        idJuridica: this.juridica.id,
        idEmpresa: id
      });
    }
  }
};
</script>

<style scoped>
</style>
