export default class ExameService {
  static getExames(req, res) {
    res.status(200).json({ message: "get exames" });
  }
}
