<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);

$bdd= new PDO('mysql:host=localhost; dbname=snort','root','virtuel',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
// $requet= $bdd->prepare('UPDATE snort SET vu = 1');
$bdd->exec('UPDATE event SET vu = 1');

return 'true';

?>