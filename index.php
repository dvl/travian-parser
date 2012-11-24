<?php
require 'libs/Slim/Slim.php';
require 'libs/parser.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->config(array(
    'debug' => true,
    'templates.path' => 'views'
));

$app->get('/', function () use ($app) {
	$app->render('base.tpl', array('inner' => 'form.tpl'));   
});

$app->post('/', function () use ($app) {
	$parser = new Parser($_POST['server']);
	$parser->login($_POST['name'],$_POST['password']);
	$parser->populate();
	$result = $parser->build_html('views/template.html', $_POST['info']);

	$app->render('base.tpl', array('inner' => 'post.tpl', 'content' => $result));   
});

$app->run();

?>