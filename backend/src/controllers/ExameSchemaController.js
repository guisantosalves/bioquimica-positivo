import ExameSchemaService from "../services/ExameSchemaService.js";

export default class ExameSchemaController {
  static async createSchema(req, res) {
    try {
      const newSchema = await ExameSchemaService.createSchema(req.body);
      res.status(201).json(newSchema);
    } catch (error) {
      res.status(error.status || 500).json({ message: error.message || "Erro interno do servidor." });
    }
  }

  static async getAllSchemas(req, res) { 
    try {
      const schemas = await ExameSchemaService.getAllSchemas();
      res.status(200).json(schemas);
    } catch (error) {
      res.status(error.status || 500).json({ message: error.message || "Erro interno do servidor." });
    }
  }

  static async getSchemaById(req, res) {
    try {
      const schema = await ExameSchemaService.getSchemaById(req.params.id);
      res.status(200).json(schema);
    } catch (error) {
      res.status(error.status || 500).json({ message: error.message || "Erro interno do servidor." });
    }
  }

  static async updateSchema(req, res) {
    try {
      const updatedSchema = await ExameSchemaService.updateSchema(req.params.id, req.body);
      res.status(200).json(updatedSchema);
    } catch (error) {
      res.status(error.status || 500).json({ message: error.message || "Erro interno do servidor." });
    }
  }

  //Status 204 (No Content) - Não retornam conteúdo no corpo da resposta.
  static async deleteSchema(req, res) {
    try {
      await ExameSchemaService.deleteSchema(req.params.id);
      res.status(204).send(); 
    } catch (error) { 
      res.status(error.status || 500).json({ message: error.message || "Erro interno do servidor." });
    }
  }
}