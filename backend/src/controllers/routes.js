import express from "express";
import PacienteController from "./PacienteController.js";
import ExameController from "./ExameController.js";
import ExameSchemaController from "./ExameSchemaController.js";

const routes = express.Router();

// cliente (paciente/estudante)
routes
  .route("/paciente")
  .get(PacienteController.getPacientes)
  .post(PacienteController.postPaciente);

// exame schema
routes.route("/schema").get(ExameSchemaController.getSchemas);

// exame
routes.route("/exame").get(ExameController.getExames);

export default routes;
