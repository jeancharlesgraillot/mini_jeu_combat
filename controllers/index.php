<?php

require '../entities/Character.php';

//Autoloader

function loadModel($modelname){
  require '../model/'. $modelname . '.php';
}

spl_autoload_register('loadModel');


$db = Database::Db();
$characterManager = new CharacterManager ($db);



if (isset($_POST['create']) && isset($_POST['name'])) // If we wanna create a character
{
  $character = new Character(['name' => $_POST['name']]); // We create a new character
  
  if (!$character->validName())
  {
    $message = 'Le nom choisi est invalide.';
    unset($character);
  }
  elseif ($characterManager->exists($character->getName()))
  {
    $message = 'Le nom du personnage est déjà pris.';
    unset($character);
  }
  else
  {
    $characterManager->addCharacter($character);
  }
}

elseif (isset($_POST['use']) && isset($_POST['name'])) // Si on a voulu utiliser un personnage.
{
  if ($characterManager->exists($_POST['name'])) // Si celui-ci existe.
  {
    $character = $CharacterManager->getCharacter($_POST['name']);
  }
  else
  {
    $message = 'Ce personnage n\'existe pas !'; // S'il n'existe pas, on affichera ce message.
  }
}

?>

<?php

include "../views/indexVue.php";

?>
