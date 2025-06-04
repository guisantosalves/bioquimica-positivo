import PacienteService from "../services/PacienteService.js";

export default class PacienteController {

  static getPacientes(req, res) {
    PacienteService.getPaciente(req, res);
  }


  static getPacienteById(req, res) {
    PacienteService.getPacienteById(req, res);
  }


  static postPaciente(req, res) {
    PacienteService.createPaciente(req, res);
  }

  
  static updatePaciente(req, res) {
    PacienteService.updatePaciente(req, res);
  }

  
  static deletePaciente(req, res) {
    PacienteService.deletePaciente(req, res);
  }
}
