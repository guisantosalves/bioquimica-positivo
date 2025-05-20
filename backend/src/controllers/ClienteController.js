import ClienteService from "../services/ClienteService.js";
export default class ClienteController {
  static getClientes(req, res) {
    // some logic here
    ClienteService.getClientes(req, res);
  }

  static postCliente(req, res) {
    ClienteService.createCliente(req, res);
  }
}
