<?php

class Character {

  private $_id;
  private $_name;
  private $_damages;

  const ITS_MYSELF = 1;
  const KILLED_CHAR = 2;
  const HIT_CHAR = 3;
  
//Constructor

  public function __construct(array $data)
  {
    $this->hydrate($data);
  }

//Hydrate

  public function hydrate(array $data){
    foreach ($data as $key => $value)
    {
      // On récupère le nom du setter correspondant à l'attribut.
      $method = 'set'.ucfirst($key);
        
      // Si le setter correspondant existe.
      if (method_exists($this, $method))
      {
      // On appelle le setter.
      $this->$method($value);
      }
    }
  }


//Methods

  public function validName(){
    return !empty($this->_name);
  }

  public function hit(Character $character){
    if ($character->getId() == $this->_id)
    {
      return self::ITS_MYSELF;
    }

    return $character->takeDamages();

  }

  public function takeDamages(){

    $this->_damages += 5;
    
    // If 100 damages taken or more, character is killed
    if ($this->_damages >= 100)
    {
      return self::KILLED_CHAR;
    }
    
    // Else, chara has been hitted
    return self::HIT_CHAR;
  }

//Getters list

  public function getId(){
    return $this->_id;
  }

  public function getName()
  {
    return $this->_name;
  }
  
  public function getDamages()
  {
    return $this->_damages;
  }
  

//Setters list

  public function setId($id)
  {
    $id = (int)$id;

    if ($id > 0) {
        $this->_id = $id;
    }
  }

  public function setName($name)
  {
    if (is_string($name))
    {
      $this->_name = $name;
    }
  }
  
  
  public function setDamages($damages)
  {
    $damages = (int) $damages;
    
    if ($damages >= 0 && $damages <= 100)
    {
      $this->_damages = $damages;
    }
  }
}

?>