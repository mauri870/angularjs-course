<?php

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app['debug'] = true;

$app['db'] = function() {
    return new \PDO('mysql:host=localhost;dbname=angular','root','root');
};

$app->get('/', function() use ($app) {
    return new Response(file_get_contents('pessoas/templates/template.html'), 200);
});

$app->post('/pessoas', function(Request $request) use ($app) {

    $data = $request->getContent();
    parse_str($data, $out);

    $stmt = $app['db']->prepare("insert into pessoas(nome,email) value(:nome, :email)");
    $stmt->bindParam('nome', $out['nome']);
    $stmt->bindParam('email', $out['email']);
    $stmt->execute();

    return $app->json(array('success'=>true));
});

$app->get('/pessoas', function() use ($app) {

    $stmt = $app['db']->query("Select * from pessoas");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $app->json($result);

});

$app->get('/pessoas/{id}', function($id) use ($app) {

    $stmt = $app['db']->prepare("Select * from pessoas where id=:id");
    $stmt->bindParam('id',$id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $app->json($result);

});

$app->put('/pessoas/{id}', function(Request $request, $id) use ($app) {

    $data = $request->getContent();
    parse_str($data, $out);

    $stmt = $app['db']->prepare("update pessoas set nome=:nome, email=:email where id=:id");
    $stmt->bindParam('id',$id);
    $stmt->bindParam('nome', $out['nome']);
    $stmt->bindParam('email', $out['email']);
    $stmt->execute();

    return $app->json(array('success'=>true));
});


$app->delete('/pessoas/{id}', function($id) use ($app) {

    $stmt = $app['db']->prepare("delete from pessoas where id=:id");
    $stmt->bindParam('id',$id);
    $stmt->execute();

    return $app->json(array('success'=>true));

});


$app->run();
