-- CreateTable
CREATE TABLE "Cliente" (
    "id" TEXT NOT NULL,
    "nome" TEXT NOT NULL,
    "cpf" TEXT NOT NULL,
    "dataNascimento" TIMESTAMP(3) NOT NULL,
    "sexo" CHAR(1) NOT NULL,
    "telefone" TEXT NOT NULL,
    "email" TEXT NOT NULL,
    "endereco" TEXT NOT NULL,
    "senha" TEXT NOT NULL,
    "Paciente" BOOLEAN NOT NULL,
    "RGM" TEXT,

    CONSTRAINT "Cliente_pkey" PRIMARY KEY ("id")
);

-- CreateTable
CREATE TABLE "Exame" (
    "id" SERIAL NOT NULL,
    "idPaciente" TEXT NOT NULL,
    "idSchema" INTEGER NOT NULL,
    "dataRealizacao" TIMESTAMP(3) NOT NULL,
    "dadosPreenchidos" JSONB NOT NULL,
    "responsavel" TEXT NOT NULL,
    "observacoes" TEXT NOT NULL,

    CONSTRAINT "Exame_pkey" PRIMARY KEY ("id")
);

-- CreateTable
CREATE TABLE "ExameSchema" (
    "id" SERIAL NOT NULL,
    "nome" TEXT NOT NULL,
    "descricao" TEXT NOT NULL,
    "campos" JSONB NOT NULL,
    "versao" TEXT NOT NULL,

    CONSTRAINT "ExameSchema_pkey" PRIMARY KEY ("id")
);

-- CreateIndex
CREATE UNIQUE INDEX "Cliente_cpf_key" ON "Cliente"("cpf");

-- CreateIndex
CREATE UNIQUE INDEX "Cliente_email_key" ON "Cliente"("email");

-- AddForeignKey
ALTER TABLE "Exame" ADD CONSTRAINT "Exame_idPaciente_fkey" FOREIGN KEY ("idPaciente") REFERENCES "Cliente"("id") ON DELETE RESTRICT ON UPDATE CASCADE;

-- AddForeignKey
ALTER TABLE "Exame" ADD CONSTRAINT "Exame_idSchema_fkey" FOREIGN KEY ("idSchema") REFERENCES "ExameSchema"("id") ON DELETE RESTRICT ON UPDATE CASCADE;
