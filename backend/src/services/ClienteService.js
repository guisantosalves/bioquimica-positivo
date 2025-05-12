export default class ClienteService {
  static getClientes(req, res) {
    res.status(200).json({ message: "get clientes" });
  }
}
