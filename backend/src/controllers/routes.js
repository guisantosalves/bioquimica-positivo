import express from "express";
import ClienteController from "./ClienteController.js";
import ExameController from "./ExameController.js";
import ExameSchemaController from "./ExameSchemaController.js";

const routes = express.Router();

// cliente (paciente/estudante)
routes
  .route("/cliente")
  .get(ClienteController.getClientes)
  .post(ClienteController.postCliente);

// exame schema
routes.route("/schema").get(ExameSchemaController.getSchemas);

// exame
routes.route("/exame").get(ExameController.getExames);

export default routes;
