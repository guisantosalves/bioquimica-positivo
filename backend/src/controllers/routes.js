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

routes
  .route("/paciente/:id")
  .get(PacienteController.getPacienteById)
  .put(PacienteController.updatePaciente)
  .delete(PacienteController.deletePaciente);

// exame schema
routes
  .route("/schema")
  .post(ExameSchemaController.createSchema)
  .get(ExameSchemaController.getAllSchemas);

routes
  .route("/schema/:id")
  .get(ExameSchemaController.getSchemaById)
  .put(ExameSchemaController.updateSchema)
  .delete(ExameSchemaController.deleteSchema);

// exame
routes
  .route("/exame")
  .get(ExameController.getExames)
  .post(ExameController.createExame);

routes
  .route("/exame/:id")
  .get(ExameController.getExameById)
  .put(ExameController.updateExame)
  .delete(ExameController.deleteExame);

routes.route("/exame/download/:id").get(ExameController.downloadExame);

export default routes;
