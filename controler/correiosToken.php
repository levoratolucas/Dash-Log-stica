<?php 
$usuario = "47673531000109";
$codigo_acesso = "miMGGU7NyrawqBZdqVMNDqKZaTzZHmxbgUNVvhVi";
$numero_cartao_postagem = "0077563182";
function obterToken($usuario, $codigo_acesso, $numero_cartao_postagem) {
    $api_url = "https://api.correios.com.br/token/v1/autentica/cartaopostagem";

    $payload = [
        "usuario" => $usuario,
        "codigo_acesso" => $codigo_acesso,
        "numero_cartao_postagem" => $numero_cartao_postagem
    ];

    $headers = [
        'Accept: application/json',
        'Content-Type: application/json',  // Adicionando o cabeçalho Content-Type
        'Authorization: Basic ' . base64_encode($payload["usuario"] . ':' . $payload["codigo_acesso"])
    ];

    $json_payload = [
        "numero" => $payload["numero_cartao_postagem"]
    ];

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json_payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);

    $response = curl_exec($ch);

    if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 201) {
        $token_info = json_decode($response, true);
        return $token_info["token"];
    } else {
        return handleAuthErrors($ch, $response);
    }
}


function handleAuthErrors($ch, $response) {
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode == 400) {
        echo "Falha na autenticação. Erro 400 - Validação necessária:\n";
        echo $response;
        throw new Exception("Falha na autenticação. Erro 400 - Validação necessária");
    } elseif ($httpCode == 500) {
        echo "Falha na autenticação. Erro 500 - Erro interno do servidor:\n";
        echo $response;
        throw new Exception("Falha na autenticação. Erro 500 - Erro interno do servidor");
    } else {
        echo "Falha na autenticação. Código de status: $httpCode\n";
        echo $response;
        throw new Exception("Falha na autenticação. Código de status: $httpCode");
    }
}
function rastrearObjetoApi($token, $codigoObjeto)
    {
        try {
            $api_url = "https://api.correios.com.br/srorastro/v1/objetos?codigosObjetos={$codigoObjeto}&resultado=T";
            $headers = [
                'Accept: application/json',
                'Authorization: Bearer ' . $token
            ];

            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);

            if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200) {
                $rastreio_info = json_decode($response, true);
                $objetos = $rastreio_info["objetos"];

                if ($objetos) {
                    return $objetos;
                } else {
                    return "Nenhum objeto encontrado.";
                }
            } else {
                return "Falha ao rastrear objeto. Detalhes do erro:\nCódigo de status: " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n" . $response;
            }
        } catch (Exception $e) {
            return "Erro ao rastrear objeto: " . $e->getMessage();
        }
    }

    function rastrearObjeto($codigoObjeto)
    {
        global $usuario, $codigo_acesso, $numero_cartao_postagem;

        $codigoObjeto; // Aplica trim para remover espaços em branco

        if ($codigoObjeto) {
            $token = obterToken($usuario, $codigo_acesso, $numero_cartao_postagem);
            $objetos = rastrearObjetoApi($token, $codigoObjeto);

            foreach ($objetos as $objeto) {
                echo "Objeto: {$objeto['codObjeto']}\n";
                $eventos = $objeto['eventos'] ?? [];

                if ($eventos) {
                    foreach ($eventos as $evento) {
                        $data_hora = new DateTime($evento['dtHrCriado'] ?? '');
                        $date = $data_hora->format('d/m/Y');
                        $descricao = $evento['descricao'] ?? '';
                        $detalhe = $evento['detalhe'] ?? '';
                        $cidade = $evento['unidade']['endereco']['cidade'] ?? '';
                        $estado = $evento['unidade']['endereco']['uf'] ?? '';

                        echo "<br><br>";
                        $formatted_event = "$date<br> $descricao<br>$cidade - $estado<br>$detalhe";
                        echo $formatted_event;
                    }
                } else {
                    echo "<br>Nenhum evento encontrado.\n";
                }

                echo "\n";
            }
        } else {
            echo "Digite um código de rastreamento.";
        }
    }

?>