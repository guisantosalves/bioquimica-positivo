<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Tabela de esquemas de exame</title>
</head>

<body style="background-color: #BCB8B1">
    <?php include './header.php' ?>
    <div style="width: 100%; display: flex; justify-content: center;">
        <div class="mt-3 mb-3 bg-light p-3 border rounded" style="width: 50%;">
            <div class="container">
                <div class="w-100 d-flex justify-content-between align-items-center">
                    <p class="h1">Esquema de exames</p>
                    <a style="cursor: pointer;" href="./schemaManagement.php">
                        <svg fill="#000000" height="40px" width="40px" version="1.1" id="Capa_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 490.2 490.2" xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <g>
                                        <path
                                            d="M418.5,418.5c95.6-95.6,95.6-251.2,0-346.8s-251.2-95.6-346.8,0s-95.6,251.2,0,346.8S322.9,514.1,418.5,418.5z M89,89 c86.1-86.1,226.1-86.1,312.2,0s86.1,226.1,0,312.2s-226.1,86.1-312.2,0S3,175.1,89,89z">
                                        </path>
                                        <path
                                            d="M245.1,336.9c3.4,0,6.4-1.4,8.7-3.6c2.2-2.2,3.6-5.3,3.6-8.7v-67.3h67.3c3.4,0,6.4-1.4,8.7-3.6c2.2-2.2,3.6-5.3,3.6-8.7 c0-6.8-5.5-12.3-12.2-12.2h-67.3v-67.3c0-6.8-5.5-12.3-12.2-12.2c-6.8,0-12.3,5.5-12.2,12.2v67.3h-67.3c-6.8,0-12.3,5.5-12.2,12.2 c0,6.8,5.5,12.3,12.2,12.2h67.3v67.3C232.8,331.4,238.3,336.9,245.1,336.9z">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </a>
                </div>
                <!-- table -->
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Versão</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="schemaTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>

                </div>
            </div>
        </div>
    </div>

    <script>
        // URL base da sua API em Node.js
        const API_URL = 'http://localhost:3000';

        // Elementos do DOM
        const form = document.getElementById('schemaForm');
        const schemaIdInput = document.getElementById('schemaId');
        const nomeInput = document.getElementById('nome');
        const descricaoInput = document.getElementById('descricao');
        const versaoInput = document.getElementById('versao');
        const camposInput = document.getElementById('campos');
        const tableBody = document.getElementById('schemaTableBody');

        /**
         * Busca todos os schemas na API e preenche a tabela
         */
        async function fetchSchemas() {
            try {
                const response = await fetch(`${API_URL}/schema`);
                console.log(response);
                if (!response.ok) throw new Error('Falha na resposta da API');

                const schemas = await response.json();

                tableBody.innerHTML = ''; // Limpa a tabela antes de preencher
                schemas.forEach(schema => {
                    const row = `
                        <tr>
                            <td>${schema.id}</td>
                            <td>${schema.nome}</td>
                            <td>${schema.versao}</td>
                            <td class="text-center">
                                <a href="./schemaManagement.php?edit=${schema.id}" class="btn btn-sm btn-warning me-2" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button class="btn btn-sm btn-danger" onclick="deleteSchema(${schema.id})" title="Excluir">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            } catch (error) {
                console.error('Erro ao buscar schemas:', error);
                tableBody.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Falha ao carregar dados da API. Verifique se o servidor Node.js está rodando.</td></tr>';
            }
        }

        /**
         * Deleta um schema após confirmação
         */
        async function deleteSchema(id) {
            if (!confirm(`Tem certeza que deseja excluir o Schema com ID ${id}?`)) {
                return;
            }

            try {
            const response = await fetch(`${API_URL}/schema/${id}`, { method: 'DELETE' });

            // Se a resposta NÃO for de sucesso (ex: 409, 404, etc.)
            if (!response.ok) {
                //Tenta ler o corpo da resposta para pegar a mensagem específica do Node.js
                const errorData = await response.json().catch(() => null);

                //Lança um erro usando a MENSAGEM DO BACK-END
                throw new Error(errorData?.message || `Ocorreu um erro. Status: ${response.status}`);
            }

            // Se a resposta foi de sucesso, simplesmente atualiza a lista
            fetchSchemas();

            } catch (error) {
                console.error('Erro ao deletar schema:', error);
                //Eexibir a mensagem vinda diretamente do Node.js!
                alert(error.message);
            }
}

        // Carrega os dados iniciais quando a página é carregada
        document.addEventListener('DOMContentLoaded', fetchSchemas);
    </script>
</body>

</html>