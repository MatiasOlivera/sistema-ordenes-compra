<template lang="html">

  <form
    class="form-signin"
    @submit.prevent="autenticar"
  >
    <h1 class="h3 mb-3">Gestión de ordenes</h1>

    <label
      for="username"
      class="sr-only"
    >
      DNI
    </label>
    <input
      id="username"
      v-model="user.username"
      :class="{'is-invalid' : errores.username}"
      class="form-control"
      type="text"
      name="username"
      aria-describedby="username"
      placeholder="DNI"
    >

    <label
      for="password"
      class="sr-only"
    >
      Contraseña
    </label>
    <input
      id="password"
      v-model="user.password"
      :class="{'is-invalid' : errores.password}"
      class="form-control"
      type="password"
      name="password"
      aria-describedby="password"
      placeholder="Contraseña"
    >

    <vc-form-error
      v-for="(error, clave) in errores"
      :error="error"
      :key="clave"
    />

    <button
      type="submit"
      name="submit"
      class="btn btn-lg btn-primary btn-block"
    >
      Iniciar sesión
    </button>
  </form>

</template>

<script>
import VcFormError from '../components/VcFormError.vue';

export default {
  components: {
    VcFormError
  },

  data() {
    return {
      user: {
        username: null,
        password: null
      },

      errores: {}
    };
  },

  methods: {
    autenticar() {
      axios
        .post('/login', this.user)
        .then(() => {
          window.location.replace('/inicio');
        })
        .catch((error) => {
          if (error.response) {
            const { status: STATUS } = error.response;

            switch (STATUS) {
              case 422:
              case 429:
                this.errores = error.response.data.errors;
                break;
              default:
                this.porDefecto();
                break;
            }
          } else if (error.request) {
            this.peticion();
          } else {
            this.config();
          }
        });
    }
  },
  notifications: {
    porDefecto: {
      title: 'Solicitud',
      message: '¡Oops! Hubo un problema al procesar la solicitud',
      type: 'error'
    },
    peticion: {
      title: 'Petición',
      message: `No estás en la misma red que el servidor o este
                podría estar caído`,
      type: 'error'
    },
    config: {
      title: 'Configuración',
      message: '¡Oops! Hubo un problema al configurar la solicitud',
      type: 'error'
    }
  }
};
</script>

<style lang="css">
html,
body,
#main {
  height: 100%;
}

#main {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
}

.form-signin {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}

.form-signin .form-control {
  position: relative;
  box-sizing: border-box;
  height: auto;
  padding: 10px;
  font-size: 16px;
}

.form-signin .form-control:focus {
  z-index: 2;
}

.form-signin input[type='text'] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.form-signin input[type='password'] {
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

.form-signin button {
  margin-top: 10px;
}
</style>
