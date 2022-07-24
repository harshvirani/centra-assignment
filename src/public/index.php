<?php
require '../../vendor/autoload.php';

use KanbanBoard\Authentication;
use KanbanBoard\Application;
use KanbanBoard\Github;


$repositories = explode('|', Utilities::env('GH_REPOSITORIES'));
$authentication = new Authentication();
$token = $authentication->login();
$github = new Github($token, Utilities::env('GH_ACCOUNT'));
$board = new Application($github, $repositories, array('waiting-for-feedback'));
$data = $board->board();
$m = new Mustache_Engine(array(
	'loader' => new Mustache_Loader_FilesystemLoader('../views'),
));
echo $m->render('index', array('milestones' => $data));
