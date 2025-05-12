import ExameSchemaService from "../services/ExameSchemaService.js";
export default class ExameSchemaController {
  static getSchemas(req, res) {
    // some logic here
    ExameSchemaService.getSchemas(req, res);
  }
}
