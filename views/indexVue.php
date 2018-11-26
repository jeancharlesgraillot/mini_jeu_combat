<?php
  include("template/header.php");
?>

    <p>Nombre de personnages créés : <?php echo $characterManager->count() ?></p>

<?php

if (isset($message)){
  echo '<p>', $message, '</p>';
} 
  
if (isset($character)) // Si on utilise un personnage (nouveau ou pas).
{
?>
    <p><a href="?deconnexion=1">Déconnexion</a></p>
    
    <fieldset>
      <legend>Mes informations</legend>
      <p>
        Nom : <?php echo htmlspecialchars($character->getName()) ?><br />
        Dégâts : <?php echo $character->getDamages() ?>
      </p>
    </fieldset>
    
    <fieldset>
      <legend>Qui frapper ?</legend>
      
      <p>
<?php
      $characters = $characterManager->getList($character->getName());

if (empty($characters))
{
  echo 'Personne à frapper !';
}

else
{
  foreach ($characters as $character)
    echo '<a href="?hit=', $character->getId(), '">', htmlspecialchars($character->getName()), '</a> (dégâts : ', $character->getDamages(), ')<br />';
}
?>
      </p>
    </fieldset>
<?php
}
else
{
?>
    <form action="" method="post">
      <p>
        Nom : <input type="text" name="name" maxlength="50" /><br>
        <input type="submit" value="Create character" name="create" />
        <input type="submit" value="Use character" name="use" />
      </p>
    </form>
<?php
}
?>

<?php

   include("template/footer.php");
?>


