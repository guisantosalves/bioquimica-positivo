import pkg from "@prisma/client";
const { PrismaClient } = pkg;

export default class ClienteService {
  static getClientes(req, res) {
    res.status(200).json({ message: "get clientes" });
  }

  static async createCliente(req, res) {
    const prisma = new PrismaClient();

    const newCliente = await prisma.Cliente.create({
      data: {
        nome: "Maria Souza",
        cpf: "12345678900",
        dataNascimento: new Date("1990-04-25"),
        sexo: "F",
        telefone: "(43) 99999-8888",
        email: "maria.souza@example.com",
        endereco: "Rua das Flores, 123 - Centro, Londrina/PR",
        senha: "senhaSegura123",
        Paciente: true,
        RGM: "20250001",
      },
    });

    res.status(201).json(newCliente);
  }
}
