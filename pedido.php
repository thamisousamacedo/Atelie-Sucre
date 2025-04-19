<?php
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $telefone = $_POST["telefone"];
    $pedido_itens = $_POST["pedido_itens"];
    $numero_whatsapp = $_POST["numero_whatsapp"];

    $sql = "SELECT nome, endereco FROM clientes WHERE telefone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $telefone);
    $stmt->execute();
    $result - $stmt->get_result();

    if ($result->num_rows > 0) {
        $cliente = $result->fetch_assoc();
        $nome_cliente = $cliente["nome"];
        $endereco_cliente = $cliente["endereco"];

        $mensagem = "Pedido de: " . $nome_cliente . "\n";
        $mensagem .= "Telefone: " . $telefone . "\n";
        $mensagem .= "Endereço de Entrega: " , $edereco_cliente . "\n\n";
        $mensagem .= "Itens do Pedido:\n";

        foreach ($pedido_itens as $item => $quantidade) {
            if ($quantidade > 0) {
                $mensagem .= ucfirst(str_replace("_", " ", $item)) . ": " . $quantidade . "\n";
            }
        }

        $mensagem_whatsapp = urelencode($mensagem);
        $link_whatsapp = "https://wa.me/" . $numero_whatsapp . "?text=" . $mensagem_whatsapp;

        echo json_encode(["success" => true, "whatsapp_link" => $link_whatsapp]);
    } else {
        echo json_encode(["success" => false, "message" => "Cliente não encontrado."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Método de requisição inválido."]);
}
?>
