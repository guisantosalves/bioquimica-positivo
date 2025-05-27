import PacienteService from "../services/PacienteService.js";
export default class PacienteController {
  static getPacientes(req, res) {
    // some logic here
    PacienteService.getPaciente(req, res);
  }

  static postPaciente(req, res) {
    PacienteService.createPaciente(req, res);
  }
}
