<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Gerenciamento de Schemas de Exame</title>
</head>

<body>
    <?php
    include 'header.php';
    ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-5 col-md-12 mb-4">
                <h3>Criar / Editar Schema</h3>
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
                            Exemplo: <code>[{"campo":"Hemoglobina", "tipo":"number"}, {"campo":"Observação", "tipo":"text"}]</code>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn btn-secondary" id="cancelButton" style="display: none;">Cancelar Edição</button>
                </form>
            </div>
            <div class="col-lg-7 col-md-12">
                <h3>Schemas Cadastrados</h3>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
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
        const cancelButton = document.getElementById('cancelButton');

        /**
         * Busca todos os schemas na API e preenche a tabela
         */
        async function fetchSchemas() {
            try {
                const response = await fetch(`${API_URL}/schema`);
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
                                <button class="btn btn-sm btn-warning me-2" onclick="editSchema(${schema.id})" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
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
         * Busca um schema por ID e preenche o formulário para edição
         */
        async function editSchema(id) {
            try {
                const response = await fetch(`${API_URL}/schema/${id}`);
                if (!response.ok) throw new Error('Schema não encontrado.');

                const schema = await response.json();

                schemaIdInput.value = schema.id;
                nomeInput.value = schema.nome;
                descricaoInput.value = schema.descricao;
                versaoInput.value = schema.versao;
                // Formata o JSON para ser mais legível no textarea
                camposInput.value = JSON.stringify(schema.campos, null, 2); 

                cancelButton.style.display = 'inline-block';
                form.querySelector('button[type="submit"]').textContent = 'Atualizar';
                window.scrollTo(0, 0); // Rola a página para o topo para focar no formulário
            } catch (error) {
                console.error('Erro ao buscar schema para edição:', error);
                alert(error.message);
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
                if (response.status !== 204) throw new Error('Erro ao deletar.');
                
                fetchSchemas(); // Recarrega a lista
            } catch (error) {
                console.error('Erro ao deletar schema:', error);
                alert(error.message);
            }
        }

        // Reseta o formulário
        function resetForm() {
            form.reset();
            schemaIdInput.value = '';
            cancelButton.style.display = 'none';
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
                
                resetForm();
                fetchSchemas();

            } catch (error) {
                console.error('Erro ao salvar schema:', error);
                alert('Erro ao salvar: ' + error.message);
            }
        });
        
        cancelButton.addEventListener('click', resetForm);

        // Carrega os dados iniciais quando a página é carregada
        document.addEventListener('DOMContentLoaded', fetchSchemas);
    </script>
</body>
</html>