<?php
require_once 'ICrudData.php';
require_once 'ConnectionFactory.php';
require_once __DIR__ . '/../model/ExameSchema.php';
class ExameSchemaDao implements ICrudData
{
    private $apiBaseUrl;
    public function __construct(string $apiBaseUrl)
    {
        $this->apiBaseUrl = rtrim($apiBaseUrl, '/');
    }

    public function inserir($exameSchema)
    {
    }
    public function update(string $id, $exameSchema)
    {
    }
    public function delete(string $id)
    {
    }
    public function read()
    {
        try {
            $res = $this->request('GET', $this->apiBaseUrl . '/schema');
            if ($res['status'] === 200 && is_array($res['body'])) {
                $exames = [];
                foreach ($res['body'] as $item) {
                    $exames[] = $this->mapExameSchema($item);
                }
                return $exames;
            }
            return [];
        } catch (Exception $e) {
            echo "<p>Erro ao buscar schemas via API: {$e->getMessage()}</p>";
            return [];
        }
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

    public function readById($id)
    {
        try {
            $res = $this->request('GET', $this->apiBaseUrl . "/schema/{$id}");

            if ($res['status'] === 200 && $res['body']) {
                return $this->mapExameSchema($res['body']);
            }

            return null;
        } catch (Exception $e) {
            echo "<p>Erro ao buscar ExameSchema por ID via API: {$e->getMessage()}</p>";
            return null;
        }
    }

    private function mapExameSchema($data)
    {
        return new ExameSchema(
            $data['id'],
            $data['nome'],
            $data['descricao'],
            $data['campos'],
            $data['versao'],
            [] // Não carrego os exames aqui, para evitar loop infinito ou carga desnecessária
        );
    }
}

?>