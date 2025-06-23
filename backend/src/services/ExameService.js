import prisma from "../prisma/client.js";
import pdf from "html-pdf";

export default class ExameService {
  static async getExames(req, res) {
    console.log("[ExameService] Buscando todos os exames");
    try {
      const exames = await prisma.exame.findMany({
        include: {
          paciente: true,
          schema: true,
        },
      });
      console.log(`[ExameService] ${exames.length} exames encontrados`);
      res.status(200).json(exames);
    } catch (error) {
      console.error("[ExameService] Erro ao buscar exames:", error);
      res.status(500).json({ message: "Erro ao buscar exames." });
    }
  }

  static async createExame(req, res) {
    console.log("[ExameService] Criando novo exame", {
      idPaciente: req.body.idPaciente,
      idSchema: req.body.idSchema,
    });
    try {
      const {
        idPaciente,
        idSchema,
        dataRealizacao,
        dadosPreenchidos,
        responsavel,
        observacoes,
      } = req.body;

      if (!idPaciente || !idSchema || !dataRealizacao) {
        console.log("[ExameService] Dados incompletos para criar exame");
        return res.status(400).json({
          message:
            "ID do Paciente, ID do Schema e Data de Realização são obrigatórios.",
        });
      }

      const exame = await prisma.exame.create({
        data: {
          idPaciente,
          idSchema,
          dataRealizacao,
          dadosPreenchidos,
          responsavel,
          observacoes,
        },
      });

      console.log(`[ExameService] Exame criado com sucesso, ID: ${exame.id}`);
      res.status(201).json(exame);
    } catch (error) {
      console.error("[ExameService] Erro ao criar exame:", error);
      return res.status(500).json({ message: "Erro ao criar exame." });
    }
  }

  static async getExameById(req, res) {
    const { id } = req.params;
    console.log(`[ExameService] Buscando exame com ID: ${id}`);
    try {
      if (!id) {
        console.log("[ExameService] ID do exame não fornecido");
        return res.status(400).json({ message: "ID do exame é obrigatório." });
      }

      const exame = await prisma.exame.findUnique({
        where: { id: parseInt(id) },
      });

      if (!exame) {
        console.log(`[ExameService] Exame com ID ${id} não encontrado`);
        return res.status(404).json({ message: "Exame não encontrado." });
      }

      console.log(`[ExameService] Exame com ID ${id} encontrado`);
      res.status(200).json(exame);
    } catch (error) {
      console.error(`[ExameService] Erro ao buscar exame com ID ${id}:`, error);
      return res.status(500).json({ message: "Erro ao buscar exame por ID." });
    }
  }

  static async updateExame(req, res) {
    try {
      const { id } = req.params;
      const {
        idPaciente,
        idSchema,
        dataRealizacao,
        dadosPreenchidos,
        responsavel,
        observacoes,
      } = req.body;

      if (!id || !idPaciente || !idSchema || !dataRealizacao) {
        return res.status(400).json({
          message:
            "Os campos ID, ID do Paciente, ID do Schema e Data de Realização são obrigatórios.",
        });
      }

      const convertingDataDadosPreenchindos = JSON.parse(dadosPreenchidos);

      const exame = await prisma.exame.update({
        where: { id: parseInt(id) },
        data: {
          dataRealizacao,
          dadosPreenchidos: convertingDataDadosPreenchindos,
          responsavel,
          observacoes,
          paciente: {
            connect: { id: idPaciente },
          },
          schema: {
            connect: { id: idSchema },
          },
        },
      });

      res.status(200).json(exame);
    } catch (error) {
      console.error("Erro ao atualizar exame:", error);
      return res.status(500).json({ message: "Erro ao atualizar exame." });
    }
  }

  static async deleteExame(req, res) {
    try {
      const { id } = req.params;

      if (!id) {
        return res.status(400).json({ message: "ID do exame é obrigatório." });
      }

      await prisma.exame.delete({
        where: { id: parseInt(id) },
      });

      res.status(204).send();
    } catch (error) {
      console.error("Erro ao deletar exame:", error);
      return res.status(500).json({ message: "Erro ao deletar exame." });
    }
  }

  static async donwload(req, res) {
    try {
      const { id } = req.params;

      const exame = await prisma.exame.findUnique({
        where: { id: Number(id) },
        include: {
          paciente: true,
          schema: true,
        },
      });

      if (!exame) {
        return res.status(404).json({ error: "Exame não encontrado." });
      }

      // Exemplo de HTML para o PDF (você pode estilizar melhor depois)
      const htmlContent = `
        <h1>Laudo do Exame</h1>
        <p><strong>ID:</strong> ${exame.id}</p>
        <p><strong>Paciente:</strong> ${exame.paciente.nome}</p>
        <p><strong>Schema:</strong> ${exame.schema.nome}</p>
        <p><strong>Data de Realização:</strong> ${new Date(
          exame.dataRealizacao
        ).toLocaleString()}</p>
        <h3>Dados Preenchidos:</h3>
        <ul>
          ${Object.entries(exame.dadosPreenchidos)
            .map(([key, value]) => {
              const currCampos = exame.schema.campos.find(
                (item) => item.nome === key
              );
              return `<li><strong>${key}:</strong> Valores absolutos: ${value} ${
              currCampos.valor_referencia
                ? `| Valores de Referência: ${currCampos.valor_referencia}`
                : ""
            } ${
              currCampos.unidade ? `| Unidade: ${currCampos.unidade}` : ""
            }</li>`;
            })
            .join("")}
        </ul>
        <p><strong>Responsável:</strong> ${exame.responsavel}</p>
        <p><strong>Observações:</strong> ${exame.observacoes}</p>
      `;

      // Gerando o PDF
      pdf.create(htmlContent).toBuffer((err, buffer) => {
        if (err) {
          console.error("Erro ao gerar PDF:", err);
          return res.status(500).json({ error: "Erro ao gerar PDF." });
        }

        res.setHeader("Content-Type", "application/pdf");
        res.setHeader(
          "Content-Disposition",
          `attachment; filename=exame_${exame.id}.pdf`
        );
        res.send(buffer);
      });
    } catch (error) {
      console.log(error);
      console.error("Erro no downloadExame:", error);
      res.status(500).json({ error: "Erro interno ao gerar o download." });
    }
  }
}
