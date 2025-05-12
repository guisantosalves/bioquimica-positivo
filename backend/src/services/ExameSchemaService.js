export default class ExameSchemaService {
  static getSchemas(req, res) {
    res.status(200).json({ message: "get schemas" });
  }
}
