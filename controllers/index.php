<?php

require '../entities/Personnage.php';
require '../model/PersonnagesManager.php';

$character = new Character([
  'name' => 'Victor',
  'damages' => 0,
]);

$db = new PDO('mysql:host=localhost;dbname=mini_jeu_combat', 'root', 'Strawberry591peaches', [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING]);
$manager = new CharacterManager($db);

$manager->add($character);

include "../views/indexVue.php";

 ?>
