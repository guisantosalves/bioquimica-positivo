<?php
require_once 'ICrudData.php';
require_once 'ConnectionFactory.php';
require_once 'PacienteDao.php';
require_once 'ExameSchemaDao.php';
class ExameDao implements ICrudData
{
    private $apiBaseUrl;
    private $pacienteDao;
    private $schemaDao;

    public function __construct(string $apiBaseUrl)
    {
        $this->apiBaseUrl = rtrim($apiBaseUrl, '/');
        $this->pacienteDao = new PacienteDao($apiBaseUrl);
        $this->schemaDao = new ExameSchemaDao($apiBaseUrl);
    }

    private function request(string $method, string $url, $data = null)
    {
        $curl = curl_init();

        $headers = ['Content-Type: application/json'];

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
        ]);

        if ($data !== null) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            throw new Exception('Request Error: ' . curl_error($curl));
        }

        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return ['status' => $statusCode, 'body' => json_decode($response, true)];
    }

    public function inserir($exame)
    {
        $data = [
            'id' => generateUUIDv4(),
            'idPaciente' => $exame->getIdPaciente(),
            'idSchema' => $exame->getIdSchema(),
            'dataRealizacao' => $exame->getDataRealizacao()->format(DateTime::ATOM),
            'dadosPreenchidos' => $exame->getDadosPreenchidos(),
            'responsavel' => $exame->getResponsavel(),
            'observacoes' => $exame->getObservacoes(),
        ];

        try {
            $res = $this->request('POST', $this->apiBaseUrl . '/exame', $data);
            return $res['status'] === 201;
        } catch (Exception $e) {
            echo "<p>Erro ao inserir exame via API: {$e->getMessage()}</p>";
            return false;
        }
    }
    public function update(string $id, $exame)
    {
        $data = [
            'idPaciente' => $exame->getIdPaciente(),
            'idSchema' => $exame->getIdSchema(),
            'dataRealizacao' => $exame->getDataRealizacao()->format(DateTime::ATOM),
            'dadosPreenchidos' => json_encode($exame->getDadosPreenchidos()),
            'responsavel' => $exame->getResponsavel(),
            'observacoes' => $exame->getObservacoes(),
        ];

        try {
            $res = $this->request('PUT', $this->apiBaseUrl . "/exame/{$id}", $data);
            return $res['status'] === 200;
        } catch (Exception $e) {
            echo "<p>Erro ao atualizar exame via API: {$e->getMessage()}</p>";
            return false;
        }
    }
    public function delete(string $id)
    {
        try {
            $res = $this->request('DELETE', $this->apiBaseUrl . "/exame/{$id}");
            return $res['status'] === 204;
        } catch (Exception $e) {
            echo "<p>Erro ao excluir exame via API: {$e->getMessage()}</p>";
            return false;
        }
    }
    public function read()
    {
        try {
            $res = $this->request('GET', $this->apiBaseUrl . '/exame');
            if ($res['status'] === 200 && is_array($res['body'])) {
                $exames = [];
                foreach ($res['body'] as $item) {
                    $exames[] = $this->mapExame($item);
                }
                return $exames;
            }
            return [];
        } catch (Exception $e) {
            echo "<p>Erro ao buscar exames via API: {$e->getMessage()}</p>";
            return [];
        }
    }
    public function readById(string $id)
    {
        try {
            $res = $this->request('GET', $this->apiBaseUrl . "/exame/{$id}");
            if ($res['status'] === 200 && $res['body']) {
                return $this->mapExame($res['body']);
            }
            return null;
        } catch (Exception $e) {
            echo "<p>Erro ao buscar exame por ID via API: {$e->getMessage()}</p>";
            return null;
        }
    }

    public function downloadExame(string $id)
    {
        try {
            $res = $this->request('GET', $this->apiBaseUrl . "/exame/download/{$id}");
            return $res["status"] === 200;
        } catch (Exception $e) {
            echo "<p>Erro ao buscar download por ID via API: {$e->getMessage()}</p>";
            return null;
        }
    }

    private function mapExame($data)
    {

        $paciente = $this->pacienteDao->readById($data['idPaciente']);
        $schema = $this->schemaDao->readById($data['idSchema']);

        return new Exame(
            $data['id'],
            $data['idPaciente'],
            $data['idSchema'],
            new DateTime($data['dataRealizacao']),
            $data['dadosPreenchidos'],
            $data['responsavel'],
            $data['observacoes'],
            $paciente,
            $schema
        );
    }

}

?>