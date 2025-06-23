<?php
require_once 'ICrudData.php';
require_once 'ConnectionFactory.php';
require_once __DIR__ . '/../utils/ManageUuid.php';
require_once __DIR__ . '/../model/Paciente.php';
class PacienteDao implements ICrudData
{
    private $apiBaseUrl;

    public function __construct(string $apiBaseUrl)
    {
        $this->apiBaseUrl = rtrim($apiBaseUrl, '/');
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

    public function inserir($paciente)
    {
        $data = [
            'id' => generateUUIDv4(),
            'nome' => $paciente->getNome(),
            'cpf' => $paciente->getCpf(),
            'dataNascimento' => $paciente->getDataNascimento()->format('Y-m-d'),
            'sexo' => $paciente->getSexo(),
            'telefone' => $paciente->getTelefone(),
            'email' => $paciente->getEmail(),
            'endereco' => $paciente->getEndereco(),
            'RGM' => $paciente->getRGM(),
        ];

        try {
            $res = $this->request('POST', $this->apiBaseUrl . '/paciente', $data);
            return $res['status'] === 201;
        } catch (Exception $e) {
            echo "<p>Erro ao inserir paciente via API: {$e->getMessage()}</p>";
            return false;
        }
    }

    public function update(string $id, $paciente)
    {
        $data = [
            'nome' => $paciente->getNome(),
            'cpf' => $paciente->getCpf(),
            'dataNascimento' => $paciente->getDataNascimento()->format('Y-m-d\TH:i:s'),
            'sexo' => $paciente->getSexo(),
            'telefone' => $paciente->getTelefone(),
            'email' => $paciente->getEmail(),
            'endereco' => $paciente->getEndereco(),
            'RGM' => $paciente->getRGM(),
        ];

        try {
            $res = $this->request('PUT', $this->apiBaseUrl . "/paciente/{$id}", $data);
            return $res['status'] === 200;
        } catch (Exception $e) {
            echo "<p>Erro ao atualizar paciente via API: {$e->getMessage()}</p>";
            return false;
        }
    }

    public function delete(string $id)
    {
        try {
            $res = $this->request('DELETE', $this->apiBaseUrl . "/paciente/{$id}");
            return $res['status'] === 204;
        } catch (Exception $e) {
            echo "<p>Erro ao excluir paciente via API: {$e->getMessage()}</p>";
            return false;
        }
    }

    public function read()
    {
        try {
            $res = $this->request('GET', $this->apiBaseUrl . '/paciente');
            if ($res['status'] === 200 && is_array($res['body'])) {
                $pacientes = [];
                foreach ($res['body'] as $item) {
                    $pacientes[] = $this->mapPaciente($item);
                }
                return $pacientes;
            }
            return [];
        } catch (Exception $e) {
            echo "<p>Erro ao buscar pacientes via API: {$e->getMessage()}</p>";
            return [];
        }
    }

    public function readById($id)
    {
        try {
            $res = $this->request('GET', $this->apiBaseUrl . "/paciente/{$id}");
            if ($res['status'] === 200 && $res['body']) {
                return $this->mapPaciente($res['body']);
            }
            return null;
        } catch (Exception $e) {
            echo "<p>Erro ao buscar paciente por ID via API: {$e->getMessage()}</p>";
            return null;
        }
    }

    private function mapPaciente($data)
    {
        $paciente = new Paciente();
        $paciente->setId($data['id']);
        $paciente->setNome($data['nome']);
        $paciente->setCpf($data['cpf']);
        $paciente->setDataNascimento(new DateTime($data['dataNascimento']));
        $paciente->setSexo($data['sexo']);
        $paciente->setTelefone($data['telefone']);
        $paciente->setEmail($data['email']);
        $paciente->setEndereco($data['endereco']);
        $paciente->setRGM($data['RGM']);
        return $paciente;
    }
}


?>