<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Gerenciamento de Schemas de Exame</title>
</head>

<body style="background-color: #BCB8B1">
    <?php
    include 'header.php';
    ?>
    <div style="width: 100%; display: flex; justify-content: center;">
        <div class="mt-3 mb-3 bg-light p-3 border rounded" style="width: 50%;">
            <div class="container">
                <form id="schemaForm">
                    <input type="hidden" id="schemaId">

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Schema</label>
                        <input type="text" class="form-control" id="nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <input type="text" class="form-control" id="descricao">
                    </div>

                    <div class="mb-3">
                        <label for="versao" class="form-label">Versão</label>
                        <input type="text" class="form-control" id="versao" value="1.0" required>
                    </div>

                    <div class="mb-3">
                        <label for="campos" class="form-label">Campos (em formato JSON)</label>
                        <textarea class="form-control" id="campos" rows="6" required></textarea>
                        <div class="form-text">
                            Exemplo:
                            <code>[{"nome":"Hemoglobina", "tipo":"number"}, {"nome":"Observação", "tipo":"text"}]</code>
                        </div>
                    </div>
                    <div class='w-100 d-flex justify-content-end'>
                        <div class='d-flex'>
                            <a href="./schemaList.php" class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-primary ms-2">Salvar</button>
                        </div>
                    </div>
                </form>
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
         * Busca um schema por ID e preenche o formulário para edição
         */
        async function editSchema() {
            try {
                const urlParams = new URLSearchParams(window.location.search);

                if (urlParams.get('edit')) {
                    const response = await fetch(`${API_URL}/schema/${urlParams.get('edit')}`);
                    if (!response.ok) throw new Error('Schema não encontrado.');

                    const schema = await response.json();

                    schemaIdInput.value = schema.id;
                    nomeInput.value = schema.nome;
                    descricaoInput.value = schema.descricao;
                    versaoInput.value = schema.versao;
                    // Formata o JSON para ser mais legível no textarea
                    camposInput.value = JSON.stringify(schema.campos, null, 2);

                    form.querySelector('button[type="submit"]').textContent = 'Atualizar';
                    window.scrollTo(0, 0); // Rola a página para o topo para focar no formulário
                }
            } catch (error) {
                console.error('Erro ao buscar schema para edição:', error);
                alert(error.message);
            }
        }

        // Reseta o formulário
        function resetForm() {
            form.reset();
            schemaIdInput.value = '';
            form.querySelector('button[type="submit"]').textContent = 'Salvar';
        }

        // Listener para o formulário (lida com Criar e Atualizar)
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            let camposData;
            try {
                camposData = JSON.parse(camposInput.value);
            } catch (e) {
                alert('O formato do texto no campo "Campos" não é um JSON válido.');
                return;
            }

            const schemaData = {
                nome: nomeInput.value,
                descricao: descricaoInput.value,
                versao: versaoInput.value,
                campos: camposData
            };

            const id = schemaIdInput.value;
            const method = id ? 'PUT' : 'POST';
            const url = id ? `${API_URL}/schema/${id}` : `${API_URL}/schema`;

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(schemaData)
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Ocorreu um erro ao salvar.');
                }

                // Redireciona para a página da lista após o sucesso
                 window.location.href = './schemaList.php';

            } catch (error) {
                console.error('Erro ao salvar schema:', error);
                 alert('Erro ao salvar: ' + error.message);
            }
        });

        // Carrega os dados iniciais quando a página é carregada
        document.addEventListener('DOMContentLoaded', editSchema);
    </script>
</body>

</html>