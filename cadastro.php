<?php
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] =="POST") {
    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];
    $endereco = $_POST["endereço"];
    $email = $_POST["email"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO clientes (nome. telefone. endereço. email, senha)
    VALUES (?,?,?,?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nome, $telefone, $endereco, $email, $senha);

    if ($stmt->execute()){
        echo json_encode(["sucess" => true, "message" => "Cadastro realizado com sucesso!"]);
    } else {
        echo json_encode(["sucess" => false, "message" => "Erro ao cadastrar: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["sucess" => false, "message" => "Método de requisição inválido."]); 
}
?>

