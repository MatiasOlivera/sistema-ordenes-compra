const servicioPeticion = {
  obtener(url, parametros = {}) {
    if (parametros) return axios.get(url, { params: parametros });
    return axios.get(url);
  },

  guardar(url, datos = {}) {
    if (datos) return axios.post(url, datos);
    return axios.post(url);
  },

  actualizar(url, datos) {
    return axios.put(url, datos);
  },

  eliminar(url) {
    return axios.delete(url);
  },

  restaurar(url) {
    return axios.patch(url);
  }
};

export default servicioPeticion;
