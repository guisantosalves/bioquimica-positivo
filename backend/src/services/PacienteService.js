import pkg from "@prisma/client";
const { PrismaClient } = pkg;

export default class PacienteService {
  static getPaciente(req, res) {
    res.status(200).json({ message: "get Paciente" });
  }

  static async createPaciente(req, res) {
    const prisma = new PrismaClient();

    const newPaciente = await prisma.Paciente.create({
      data: {
        nome: "Mariana Silva",
        cpf: "321.654.987-00",
        dataNascimento: "1990-03-22T00:00:00.000Z",
        sexo: "F",
        telefone: "(21) 99876-5432",
        email: "mariana.silva@example.com",
        endereco: "Av. Central, 456 - Copacabana, Rio de Janeiro - RJ",
        senha: "marianaSenha2025!",
        RGM: "2025123456",
      },
    });

    res.status(201).json(newPaciente);
  }
}
