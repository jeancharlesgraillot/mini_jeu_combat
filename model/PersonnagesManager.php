<?php
class CharacterManager
{
  private $_db; // Instance de PDO

  public function __construct($db)
  {
    $this->setDb($db);
  }

  public function add(Character $character)
  {
    $q = $this->_db->prepare('INSERT INTO characters(name, damages) VALUES(:name, :damages)');

    $q->bindValue(':name', $character->getName());
    $q->bindValue(':damages', $character->getDamages(), PDO::PARAM_INT);

    $q->execute();
  }

  public function delete(Character $character)
  {
    $this->_db->exec('DELETE FROM characters WHERE id = '.$character->id());
  }

  public function get($id)
  {
    $id = (int) $id;

    $q = $this->_db->query('SELECT id, name, damages FROM characters WHERE id = '.$id);
    $data = $q->fetch(PDO::FETCH_ASSOC);

    return new Character($data);
  }

  public function getList()
  {
    $characters = [];

    $q = $this->_db->query('SELECT id, name, damages FROM characters ORDER BY name');

    while ($data = $q->fetch(PDO::FETCH_ASSOC))
    {
      $characters[] = new Character($data);
    }

    return $characters;
  }

  public function update(Character $character)
  {
    $q = $this->_db->prepare('UPDATE characters SET damages = :damages WHERE id = :id');

    $q->bindValue(':damages', $character->getDamages(), PDO::PARAM_INT);
    $q->bindValue(':id', $character->getId(), PDO::PARAM_INT);

    $q->execute();
  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}