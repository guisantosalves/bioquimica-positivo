import ExameService from "../services/ExameService.js";
export default class ExameController {
  static getExames(req, res) {
    // some logic here
    ExameService.getExames(req, res);
  }
}
