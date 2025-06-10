import prisma from "../prisma/client.js";

export default class PacienteService {
  static async getPaciente(req, res) {
    try {
      const pacientes = await prisma.paciente.findMany();
      console.log("pacientes");
      res.status(200).json(pacientes);
    } catch (error) {
      res
        .status(500)
        .json({ error: "Erro ao buscar pacientes", details: error.message });
    }
  }

  static async getPacienteById(req, res) {
    try {
      const { id } = req.params;
      const paciente = await prisma.paciente.findUnique({
        where: { id: id },
      });

      if (!paciente) {
        return res.status(404).json({ error: "Paciente não encontrado" });
      }

      res.status(200).json(paciente);
    } catch (error) {
      res
        .status(500)
        .json({ error: "Erro ao buscar paciente", details: error.message });
    }
  }

  static async createPaciente(req, res) {
    try {
      const data = req.body;

      const novoPaciente = await prisma.paciente.create({ data });
      res.status(201).json(novoPaciente);
    } catch (error) {
      res
        .status(500)
        .json({ error: "Erro ao criar paciente", details: error.message });
    }
  }

  static async updatePaciente(req, res) {
    try {
      const { id } = req.params;
      let { nome, cpf, dataNascimento, sexo, telefone, email, endereco, RGM } =
        req.body;

      if (dataNascimento && dataNascimento != null)
        dataNascimento = new Date(dataNascimento).toISOString();

      const pacienteAtualizado = await prisma.paciente.update({
        where: { id: id },
        data: {
          nome,
          cpf,
          dataNascimento,
          sexo,
          telefone,
          email,
          endereco,
          RGM,
        },
      });

      res.status(200).json(pacienteAtualizado);
    } catch (error) {
      res
        .status(500)
        .json({ error: "Erro ao atualizar paciente", details: error.message });
    }
  }

  static async deletePaciente(req, res) {
    try {
      const { id } = req.params;

      await prisma.paciente.delete({
        where: { id: id },
      });

      res.status(204).send();
    } catch (error) {
      res
        .status(500)
        .json({ error: "Erro ao deletar paciente", details: error.message });
    }
  }
}
