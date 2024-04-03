<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{
  public function index(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function alunnoId(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni");
    $id = $args['id'];
    $res = $mysqli_connection->query("SELECT * FROM alunni WHERE id = $id ");
    $re = $res->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($re));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);

  }

  public function create(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni");

    $body = $request->getBody()->getContents();
    $parseBody = json_decode($body, true);

    $nome = $parseBody['nome'];
    $cognome = $parseBody['cognome'];

    $invia = $mysqli_connection->query("INSERT INTO alunni (nome, cognome) VALUES ('$nome', '$cognome')");

    $response->getBody()->write(json_encode($invia));  
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);




  } 

}
