<?php
header("Content-Type: application/json;charset=utf-8");
header("Access-Control-Allow-Origin: ");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
require "config.php";
$rota = $_GET["rota"] ?? "";
$metodo = $_SERVER["REQUEST_METHOD"];
$corpo = json_decode(file_get_contents("php://input"), true) ?? [];
function teste(){
echo json_encode(["mensagem" => "API Instagram respondendo!"]);
exit;
}
function createUsuario($con, $dados){
$stmt = $con->prepare(
"INSERT INTO usuarios (nome, username, email, senha)
VALUES (?, ?, ?, ?)"
);
$senha = $dados["senha"];
$stmt->execute([
$dados["nome"],
$dados["username"],
$dados["email"],
$senha
]);
http_response_code(201);
echo json_encode([
"mensagem" => "Usuario criado com sucesso!",
"id" => $con->lastInsertId()
]);
}
function readUsuario($con){
$stmt = $con->query("SELECT * FROM usuarios");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
function updateUsuario($con, $id, $dados){
$stmt = $con->prepare(
"UPDATE usuarios
SET nome = ?, username = ?, email = ?, senha = ?
WHERE id_usuario = ?"
);
$stmt->execute([
$dados["nome"],
$dados["username"],
$dados["email"],
$dados["senha"],
$id
]);
echo json_encode([
"mensagem" => "Usuario atualizado com sucesso!"
]);
}
function deleteUsuario($con, $id){
$stmt = $con->prepare(
"DELETE FROM usuarios WHERE id_usuario = ?"
);
$stmt->execute([$id]);
echo json_encode([
"mensagem" => "Usuario removido com sucesso!"
]);
}
if ($rota == "usuarios"){
switch ($metodo){
case "GET":
readUsuario($con);
break;
case "POST":
createUsuario($con, $corpo);
break;
case "PUT":
updateUsuario($con, $_GET["id"], $corpo);
break;
case "DELETE":
deleteUsuario($con, $_GET["id"]);
break;
default:
teste();
}
exit;
}
function createPublicacao($con, $dados){
$stmt = $con->prepare(
"INSERT INTO publicacoes (id_usuario, legenda, imagem_url)
VALUES (?, ?, ?)"
);
$stmt->execute([
$dados["id_usuario"],
$dados["legenda"],
$dados["imagem_url"]
]);
http_response_code(201);
echo json_encode([
"mensagem" => "Publicacao criada com sucesso!",
"id" => $con->lastInsertId()
]);
}
function readPublicacao($con){
$stmt = $con->query("SELECT * FROM publicacoes");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
function updatePublicacao($con, $id, $dados){
$stmt = $con->prepare(
"UPDATE publicacoes
SET id_usuario = ?, legenda = ?, imagem_url = ?
WHERE id_publicacao = ?"
);
$stmt->execute([
$dados["id_usuario"],
$dados["legenda"],
$dados["imagem_url"],
$id
]);
echo json_encode([
"mensagem" => "Publicacao atualizada com sucesso!"
]);

function deletePublicacao($con, $id){
$stmt = $con->prepare(
"DELETE FROM publicacoes WHERE id_publicacao = ?"
);
$stmt->execute([$id]);
echo json_encode([
"mensagem" => "Publicacao removida com sucesso!"
]);
}
if ($rota == "publicacoes"){
switch ($metodo){
case "GET":
readPublicacao($con);
break;
case "POST":
createPublicacao($con, $corpo);
break;
case "PUT":
updatePublicacao($con, $_GET["id"], $corpo);
break;
case "DELETE":
deletePublicacao($con, $_GET["id"]);
break;
default:
teste();
}
exit;
}
function createCurtida($con, $dados){
$stmt = $con->prepare(
"INSERT INTO curtidas (id_usuario, id_publicacao)
VALUES (?, ?)"
);
$stmt->execute([
$dados["id_usuario"],
$dados["id_publicacao"]
]);
http_response_code(201);
echo json_encode([
"mensagem" => "Curtida criada com sucesso!",
"id" => $con->lastInsertId()
]);
}
function readCurtida($con){
$stmt = $con->query("SELECT * FROM curtidas");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
function updateCurtida($con, $id, $dados){
$stmt = $con->prepare(
"UPDATE curtidas
SET id_usuario = ?, id_publicacao = ?
WHERE id_curtida = ?"
);
$stmt->execute([
$dados["id_usuario"],
$dados["id_publicacao"],
$id
]);
echo json_encode([
"mensagem" => "Curtida atualizada com sucesso!"
]);
}
function deleteCurtida($con, $id){
$stmt = $con->prepare(
"DELETE FROM curtidas WHERE id_curtida = ?"
);
$stmt->execute([$id]);
echo json_encode([
"mensagem" => "Curtida removida com sucesso!"
]);
}
if ($rota == "curtidas"){
switch ($metodo){
case "GET":
readCurtida($con);
break;
case "POST":
createCurtida($con, $corpo);
break;
case "PUT":
updateCurtida($con, $_GET["id"], $corpo);
break;
case "DELETE":
deleteCurtida($con, $_GET["id"]);
break;
default:
teste();
}
exit;
}
?>