<?php

require '../entities/Personnage.php';
require '../model/PersonnagesManager.php';

$perso = new Personnage([
  'nom' => 'Victor',
  'forcePerso' => 5,
  'degats' => 0,
  'niveau' => 1,
  'experience' => 1
]);

$db = new PDO('mysql:host=localhost;dbname=mini_jeu_combat', 'root', 'Strawberry591peaches', [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING]);
$manager = new PersonnagesManager($db);

$manager->add($perso);

include "../views/indexVue.php";

 ?>
