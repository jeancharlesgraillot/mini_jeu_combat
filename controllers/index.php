<?php

require '../entities/Character.php';

//Autoloader

function loadModel($modelname){
  require '../model/'. $modelname . '.php';
}

spl_autoload_register('loadModel');


session_start(); // Call of session_start after autoload registration

if (isset($_GET['deconnexion']))
{
  session_destroy();
  header('Location: .');
  exit();
}

if (isset($_SESSION['character'])) // Si la session perso existe, on restaure l'objet.
{
  $character = $_SESSION['character'];
}


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

elseif (isset($_POST['use']) && isset($_POST['name']))
{
  if ($characterManager->exists($_POST['name']))
  {
    $character = $characterManager->getCharacter($_POST['name']);
  }
  else
  {
    $message = 'Ce personnage n\'existe pas !';
  }
}

elseif (isset($_GET['hit']))
{
   
  if (!isset($character))
  {
    $message = 'Merci de créer un personnage ou de vous identifier.';
  }
  
  else
  {
    if (!$characterManager->exists((int) $_GET['hit']))
    {
      $message = 'Le personnage que vous voulez frapper n\'existe pas !';
    }
    
    else
    {
      $target = $characterManager->getCharacter((int) $_GET['hit']);
      
      $callback = $character->hit($target);
      
      switch ($callback)
      {
        case Character::ITS_MYSELF :
          $message = 'Je suis suicidaire là !';
          break;
        
        case Character::HIT_CHAR :
          $message = 'Le personnage a bien été frappé !';
          
          $characterManager->updateCharacter($character);
          $characterManager->updateCharacter($target);
          
          break;
        
        case Character::KILLED_CHAR :
          $message = 'Vous avez tué ce personnage !';
          
          $manager->update($perso);
          $manager->delete($target);
          
          break;
      }
    }
  }
}

?>

<?php

include "../views/indexVue.php";

?>
