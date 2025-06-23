import ExameService from "../services/ExameService.js";

export default class ExameController {
  static async getExames(req, res) {
    await ExameService.getExames(req, res);
  }

  static async createExame(req, res) {
    await ExameService.createExame(req, res);
  }

  static async getExameById(req, res) {
    await ExameService.getExameById(req, res);
  }

  static async updateExame(req, res) {
    await ExameService.updateExame(req, res);
  }

  static async deleteExame(req, res) {
    await ExameService.deleteExame(req, res);
  }

  static async downloadExame(req, res) {
    await ExameService.donwload(req, res);
  }
}
