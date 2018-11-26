<?php
class CharacterManager
{
  private $_db; // PDO instance

  public function __construct($db)
  {
    $this->setDb($db);
  }

  public function addCharacter(Character $character)
  {
    $q = $this->_db->prepare('INSERT INTO characters(name, damages) VALUES(:name, :damages)');
    $q->bindValue(':name', $character->getName());
    $q->bindValue(':damages', 0);
    $q->execute();

  }

  public function deleteCharacter(Character $character)
  {
    $this->_db->exec('DELETE FROM characters WHERE id = '.$character->id());
  }


  public function getCharacter($info)
  {
    if (is_int($info))
    {
      $q = $this->_db->query('SELECT id, name, damages FROM characters WHERE id = '.$info);
      $data = $q->fetch(PDO::FETCH_ASSOC);
      
      return new Character($data);
    }
    else
    {
      $q = $this->_db->prepare('SELECT id, name, damages FROM characters WHERE name = :name');
      $q->execute([':name' => $info]);
    
      return new Character($q->fetch(PDO::FETCH_ASSOC));
    }
  }

  public function getList()
  {
    $characters = [];

    $q = $this->_db->query('SELECT id, name, damages FROM characters ORDER BY id DESC LIMIT 1, 99999999');

    while ($data = $q->fetch(PDO::FETCH_ASSOC))
    {
      $characters[] = new Character($data);
    }

    return $characters;
  }

  public function updateCharacter(Character $character)
  {
    $q = $this->_db->prepare('UPDATE characters SET damages = :damages WHERE id = :id');

    $q->bindValue(':damages', $character->getDamages(), PDO::PARAM_INT);
    $q->bindValue(':id', $character->getId(), PDO::PARAM_INT);

    $q->execute();
  }

  public function count(){
    return $this->_db->query('SELECT COUNT(*) FROM characters')->fetchColumn();
  }

  public function exists($info)
  {
    if (is_int($info)) // We check if character with $info id exists
    {
      return (bool) $this->_db->query('SELECT COUNT(*) FROM characters WHERE id = '.$info)->fetchColumn();
    }
    
    // Else, we wanna check if name exists or not
    
    $q = $this->_db->prepare('SELECT COUNT(*) FROM characters WHERE name = :name');
    $q->execute([':name' => $info]);
    
    return (bool) $q->fetchColumn();
  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}