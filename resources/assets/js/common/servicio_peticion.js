import axios from 'axios';

export function get(url, parametros = {}) {
  if (parametros) return axios.get(url, { params: parametros });
  return axios.get(url);
}

export function post(url, datos = {}) {
  if (datos) return axios.post(url, datos);
  return axios.post(url);
}

export function put(url, datos) {
  return axios.put(url, datos);
}

export function destroy(url) {
  return axios.delete(url);
}

export function patch(url) {
  return axios.patch(url);
}

export default {
  get,
  post,
  put,
  destroy,
  patch
};
