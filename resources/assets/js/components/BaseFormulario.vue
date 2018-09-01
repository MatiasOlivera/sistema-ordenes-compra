<template lang="html">

  <form @submit.prevent="guardar">

    <base-tarjeta
      :titulo="titulo"
      :boton-izq-visible="tarjeta.botonIzq.visible"
      :boton-izq-tipo="botonIzqTipo"
      @volver="cerrar"
      @cerrar="cerrar"
    >
      <!-- Campos -->
      <slot/>

      <!-- Botones -->
      <div class="row mt-4">
        <div class="col-auto">
          <button
            type="submit"
            name="submit"
            class="btn btn-primary"
          >
            <save-icon class="icono"/> Guardar
          </button>
        </div>

        <div class="col-auto ml-auto">
          <button
            v-if="id === null"
            type="reset"
            name="reset"
            class="btn btn-secondary"
            @click.prevent="limpiar"
          >
            <delete-icon class="icono"/> Limpiar
          </button>

          <button
            v-else
            type="button"
            name="deshacer"
            class="btn btn-secondary"
            @click="deshacer"
          >
            <rotate-ccw-icon class="icono"/> Deshacer
          </button>
        </div>
      </div>
    </base-tarjeta>

  </form>

</template>

<script>
import { SaveIcon, DeleteIcon, RotateCcwIcon } from 'vue-feather-icons';

/**
 * Mixins
 */
import ObtenerInstanciaMixin from '../mixins/obtener_instancia_mixin';

/**
 * Componentes
 */
import BaseTarjeta from './BaseTarjeta.vue';

export default {
  name: 'BaseFormulario',

  components: {
    BaseTarjeta,
    SaveIcon,
    DeleteIcon,
    RotateCcwIcon
  },

  mixins: [ObtenerInstanciaMixin],

  props: {
    titulos: {
      type: Object,
      required: true,
      default: function() {
        return {
          crear: 'Nuevo modelo',
          editar: 'Editar modelo'
        };
      }
    },

    url: {
      type: String,
      required: true
    },

    modelo: {
      type: Object,
      required: true
    },

    modeloPorDefecto: {
      type: Object,
      required: true
    },

    id: {
      type: Number,
      default: null
    },

    mensajes: {
      type: Object,
      required: true,
      default: function() {
        return {
          obtener: {
            error: {
              noEncontrado: {
                titulo: '',
                mensaje: ''
              },
              porDefecto: {
                titulo: '',
                mensaje: ''
              }
            }
          },
          enviar: {
            error: {
              porDefecto: {
                titulo: '',
                mensaje: ''
              }
            }
          }
        };
      }
    }
  },

  data() {
    return {
      modeloObtenido: {},
      tarjeta: {
        botonIzq: {
          visible: true
        }
      }
    };
  },

  computed: {
    urlEspecifica() {
      return `${this.url}/${this.id}`;
    },

    titulo() {
      return this.id ? this.titulos.editar : this.titulos.crear;
    },

    botonIzqTipo() {
      return this.id ? 'volver' : 'cerrar';
    }
  },

  watch: {
    id: function(id) {
      if (id !== null) this.obtener();
    }
  },

  methods: {
    obtener() {
      this.$_obtenerInstanciaMixin_obtener(this.urlEspecifica, (response) => {
        const MODELO = response.data;
        // Crear un nuevo objeto para evitar la reactividad
        this.modeloObtenido = { ...MODELO };
        this.$emit('obtenido', MODELO);
      });
    },

    guardar() {
      let url = '';
      let metodo = '';

      if (!this.modelo.id) {
        url = this.url;
        metodo = 'POST';
      } else {
        url = this.urlEspecifica;
        metodo = 'PUT';
      }

      this.enviar(metodo, url);
    },

    enviar(metodo, url) {
      axios({
        method: metodo,
        url,
        data: this.modelo
      })
        .then((response) => {
          let status = response.status;
          let notificacion = {
            title: '',
            message: response.data.mensaje
          };

          switch (status) {
            case 200:
              notificacion.title = 'Actualizado';
              break;
            case 201:
              notificacion.title = 'Guardado';
              break;
            default:
              break;
          }

          this.exito(notificacion);

          let id = null;

          if (response.data.hasOwnProperty('data')) {
            id = response.data.data.id;
          }

          this.$emit('guardado', id);
        })
        .catch((error) => {
          let status = error.response.status;
          let porDefecto = this.mensajes.enviar.error.porDefecto;

          switch (status) {
            case 422:
              let mensajes = error.response.data.errors;
              this.$emit('validado', mensajes);
              break;
            case 400:
              var error = error.response.data.mensaje;

              if (error) {
                this.error({
                  title: 'Error',
                  message: error
                });
              }
              break;
            default:
              this.error({
                title: porDefecto.titulo,
                message: porDefecto.mensaje
              });
          }
        });
    },

    limpiar() {
      this.$emit('limpiar');
    },

    deshacer() {
      // Crear un nuevo objeto para evitar la reactividad
      let modelo = { ...this.modeloObtenido };
      this.$emit('deshacer', modelo);
    },

    emitirCerrar() {
      this.$emit('cerrar');
    },

    cerrar() {
      let iguales = false;

      if (!this.modelo.id) {
        iguales = _.isEqual(this.modeloPorDefecto, this.modelo);
      } else {
        iguales = _.isEqual(this.modeloObtenido, this.modelo);
      }

      if (!iguales) {
        function ocultarNotificacion(instancia, notificacion) {
          instancia.hide(
            {
              transitionOut: 'fadeOut'
            },
            notificacion,
            'button'
          );
        }

        this.pregunta({
          title: 'Cerrar formulario',
          message:
            'Se perderán todos los cambios de que no se hayan guardado. ¿Estás seguro?',
          timeout: false,
          buttons: [
            [
              '<button>Si</button>',
              (instance, toast) => {
                ocultarNotificacion(instance, toast);
                this.emitirCerrar();
              },
              true
            ],
            [
              '<button>No</button>',
              (instance, toast) => {
                ocultarNotificacion(instance, toast);
              }
            ]
          ]
        });
      } else {
        this.emitirCerrar();
      }
    }
  },

  notifications: {
    exito: {
      title: 'Exito',
      message: '',
      type: 'success'
    },
    error: {
      title: 'Error',
      message: '',
      type: 'error'
    },
    pregunta: {
      title: 'Pregunta',
      message: '',
      type: 'question'
    }
  }
};
</script>

<style lang="css">
</style>
