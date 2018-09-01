class Ruta {
  constructor(urlBase) {
    this.base = urlBase;
    this.restaurar = 'restore';
  }

  especifica(id) {
    return `${this.base}/${id}`;
  }

  alta(id) {
    const BASE = this.especifica(id);
    return `${BASE}/${this.restaurar}`;
  }
}

export default Ruta;
