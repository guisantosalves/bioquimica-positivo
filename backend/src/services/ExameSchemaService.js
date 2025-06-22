import prisma from '../prisma/client.js';

export default class ExameSchemaService {
  static async createSchema(data) {
    const { nome, descricao, campos, versao } = data;

    if (!nome || !campos || !Array.isArray(campos)) {
      throw { status: 400, message: 'Nome e campos (sendo um array) são obrigatórios.' };
    }

    for (const campo of campos) {
      if (!campo.nome || !campo.tipo) {
        throw { status: 400, message: 'Cada item em "campos" deve ter as propriedades "nome" e "tipo".' };
      }
    }

    try {
      const newExameSchema = await prisma.exameSchema.create({
        data: {
          nome,
          descricao: descricao || null,
          campos,
          versao: versao || '1.0',
        },
      });
      return newExameSchema;
    } catch (error) {
      console.error("Erro ao criar o schema no serviço:", error);
      throw { status: 500, message: 'Erro ao criar o schema do exame.' };
    }
  }

  static async getAllSchemas() { 
    try {
      const schemas = await prisma.exameSchema.findMany();
      return schemas;
    } catch (error) {
      console.error("Erro ao buscar todos os schemas no serviço:", error);
      throw { status: 500, message: 'Erro ao buscar os schemas dos exames.' };
    }
  }

  static async getSchemaById(id) {
    //Converte o ID (que vem da URL como string) para um número inteiro
    const schemaId = parseInt(id);
    //Valida se o ID é um número válido.
    if (isNaN(schemaId)) {
      throw { status: 400, message: 'ID inválido.' };
    }

    try {
      const schema = await prisma.exameSchema.findUnique({
        where: { id: schemaId },
      });
      if (!schema) {
        throw { status: 404, message: 'Schema de exame não encontrado.' };
      }
      return schema;
    } catch (error) {
      console.error(`Erro ao buscar o schema pelo ID ${id} no serviço:`, error);
      if (error.status) throw error; 
      throw { status: 500, message: 'Erro ao buscar o schema do exame.' };
    }
  }

  static async updateSchema(id, data) {
    const schemaId = parseInt(id);
    if (isNaN(schemaId)) {
      throw { status: 400, message: 'ID inválido para atualização.' };
    }

    const { nome, descricao, campos, versao } = data;

    
    if (campos && !Array.isArray(campos)) {
        throw { status: 400, message: '"campos" deve ser um array.' };
    }
    if (campos) {
      for (const campo of campos) {
        if (!campo.nome || !campo.tipo) {
          throw { status: 400, message: 'Cada item em "campos" deve ter as propriedades "nome" e "tipo".' };
        }
      }
    }
    
    try {
      //O 'where' encontra o registro, e 'data' define os novos valores.
      const updatedSchema = await prisma.exameSchema.update({
        where: { id: schemaId },
        data: {
          nome,
          descricao,
          campos,
          versao,
        },
      });
      return updatedSchema;
    } catch (error) {
      console.error(`Erro ao atualizar o schema com ID ${id} no serviço:`, error);
      
      if (error.code === 'P2025') {
        throw { status: 404, message: 'Schema de exame não encontrado para atualização.' };
      }
      throw { status: 500, message: 'Erro ao atualizar o schema do exame.' };
    }
  }

  static async deleteSchema(id) {
    const schemaId = parseInt(id);
    if (isNaN(schemaId)) {
      throw { status: 400, message: 'ID inválido para exclusão.' };
    }

    try {
      await prisma.exameSchema.delete({
        where: { id: schemaId },
      });
      
    } catch (error) {
      console.error(`Error deleting schema ID ${id} in service:`, error);
      //Trata o erro de violação de chave estrangeira
      if (error.code === 'P2003') {
        throw { status: 409, message: 'Não é possível excluir este schema, pois ele já está sendo utilizado por um ou mais exames.' };
      }
      if (error.code === 'P2025') {
        throw { status: 404, message: 'Schema de exame não encontrado para exclusão.' };
      }
      throw { status: 500, message: 'Erro ao excluir o schema do exame.' };
    }
  }
}