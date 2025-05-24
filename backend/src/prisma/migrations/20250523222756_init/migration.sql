-- CreateTable
CREATE TABLE `Cliente` (
    `id` VARCHAR(191) NOT NULL,
    `nome` VARCHAR(191) NOT NULL,
    `cpf` VARCHAR(191) NOT NULL,
    `dataNascimento` DATETIME(3) NOT NULL,
    `sexo` CHAR(1) NOT NULL,
    `telefone` VARCHAR(191) NOT NULL,
    `email` VARCHAR(191) NOT NULL,
    `endereco` VARCHAR(191) NOT NULL,
    `senha` VARCHAR(191) NOT NULL,
    `Paciente` BOOLEAN NOT NULL,
    `RGM` VARCHAR(191) NULL,

    UNIQUE INDEX `Cliente_cpf_key`(`cpf`),
    UNIQUE INDEX `Cliente_email_key`(`email`),
    PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `Exame` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `idPaciente` VARCHAR(191) NOT NULL,
    `idSchema` INTEGER NOT NULL,
    `dataRealizacao` DATETIME(3) NOT NULL,
    `dadosPreenchidos` JSON NOT NULL,
    `responsavel` VARCHAR(191) NOT NULL,
    `observacoes` VARCHAR(191) NOT NULL,

    PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `ExameSchema` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(191) NOT NULL,
    `descricao` VARCHAR(191) NOT NULL,
    `campos` JSON NOT NULL,
    `versao` VARCHAR(191) NOT NULL,

    PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- AddForeignKey
ALTER TABLE `Exame` ADD CONSTRAINT `Exame_idPaciente_fkey` FOREIGN KEY (`idPaciente`) REFERENCES `Cliente`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

-- AddForeignKey
ALTER TABLE `Exame` ADD CONSTRAINT `Exame_idSchema_fkey` FOREIGN KEY (`idSchema`) REFERENCES `ExameSchema`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
