<?php

  class AdaptorEngine
  {
      private $name;
      private $description;
      private $file;
      private $class;
      private $search_engine_id;
      private $id;

      function __construct($name,$description,$file,$class,$search_engine_id,$id)
      {
          $this->name = $name;
          $this->description = $description;
          $this->file = $file;
          $this->class = $class;
          $this->search_engine_id = $search_engine_id;
          $this->id= $id;
      }

      public function getId()
      {
          return $this->id;
      }

      public function getName()
      {
          return $this->name;
      }

      public function setName($value)
      {
          $this->name = $value;
      }

      public function getDescription()
      {
          return $this->description;
      }

      public function setDescription($value)
      {
          $this->description = $value;
      }

      public function getImplementation()
      {
          return $this->file;
      }

      public function setImplementation($value)
      {
          $this->file = $value;
      }

      public function getClassName()
      {
          return $this->class;
      }

      public function setClassName($value)
      {
          $this->class = $value;
      }

      public function getBrowserId()
      {
          return $this->search_engine_id;
      }

      public function setBrowserId($value)
      {
          $this->search_engine_id = $value;
      }
  }

  class AdaptorEngineManager
  {
    private $dbHandle;
    private $queries = array(
                      'getAll' => 'SELECT * FROM adaptors',
                      'getAdaptorEngine' => 'SELECT * FROM adaptors WHERE id=%d',
                      'delAdaptorEngine' => 'DELETE FROM adaptors WHERE id=%d',
                      'updAdaptorEngine' => 'UPDATE adaptors SET name=%s,description=%s,file=%s,class_name=%s,search_engine_id=%d where id=%d',
                      'addAdaptorEngine' => 'INSERT INTO adaptors (name,description,file,class_name,search_engine_id) values (%s,%s,%s,%s,%d)',
                      'getAdaptorEngineName' => 'SELECT name FROM adaptors',
                      'getAdaptorEngineByName' => 'SELECT * FROM adaptors WHERE name=%s;' ,
                      'getAdaptorEngineSearchEngine' => 'SELECT * FROM adaptors WHERE search_engine_id=%d;'
   );

    function __construct($mdb)
    {
      $this->dbHandle = $mdb;
    }

   //devuelve un objeto de tipo Adaptador dado un Id del mismo
    public function get($id)
    {
          $data = $this->dbHandle->queryAll(sprintf($this->queries['getAdaptorEngine'], $this->dbHandle->quote($id, 'integer')));

          if (count($data) > 0)
          {
             return new AdaptorEngine($data[0]['name'], $data[0]['description'],$data[0]['file'], $data[0]['class_name'], $data[0]['search_engine_id'], $data[0]['id']);
          }

          else { return false; }
    }
    //devuelve todos los Adaptadores registrados en la BD
	public function getAll()
	{
	    $adaptors_engines = array();
	    $data = $this->dbHandle->queryAll($this->queries['getAll']);
	    foreach($data as $row)
	    {
	        array_push($adaptors_engines, new AdaptorEngine(utf8_encode($row['name']), utf8_encode($row['description']),$row['file'],$row['class_name'],$row['search_engine_id'],$row['id']));
	    }
	    return $adaptors_engines;
	}
	//devuelve los adaptadores para un search engine id dado
	public function getByEngineId($sEng_id)
	{
	    $adaptors_engines = array();
	    $data = $this->dbHandle->queryAll(sprintf($this->queries[ 'getAdaptorEngineSearchEngine'], $this->dbHandle->quote($sEng_id, 'integer')));

	    foreach($data as $row)
	    {
	        array_push($adaptors_engines, new AdaptorEngine(utf8_encode($row['name']), utf8_encode($row['description']),$row['file'],$row['class_name'],$row['search_engine_id'],$row['id']));
	    }
	    return $adaptors_engines;
	}

    //actualizarle los parametros de un Adaptador
	public function update($adaptor_engine,$data)
	{
	    $adaptor_engine->setName($data['name']);//Aqui hay que lowercase
	    $adaptor_engine->setDescription($data['description']);
	    $adaptor_engine->setImplementation($data['files']);
	    $adaptor_engine->setClassName($data['class']);
	    $adaptor_engine->setBrowserId($data['searchers']);

	}
    //devuelve un arreglo de errores (posibles errores -> name vacio, name repetido o descripcion vacia)
	public function validate($adaptor_engine)
	{
        $errors = array();
	    if (!$adaptor_engine->getName())
	    {
	        $errors['name'] = 'You must provide a name';
	    }
	    else
	    {
	        $engines = $this->dbHandle->queryAll(sprintf($this->queries['getAdaptorEngineByName'], $this->dbHandle->quote($adaptor_engine->getName())));

	        if (count($engines))
	        {
	            if ($adaptor_engine->getId())
	            {
	                if ($adaptor_engine->getId() != $engines[0]['id'])
	                {
	                    $errors['name'] = 'An Adaptor Engine already exists with that name';
	                }
	            }
	            else
	            {
	                $errors['name'] = 'An Adaptor Engine already exists with that name';
	            }
	        }
	    }

	    if (!$adaptor_engine->getDescription())
	    {
	        $errors['description'] = 'You must provide a description';
	    }
	    if (!$adaptor_engine->getClassName())
	    {
	        $errors['class'] = 'You must provide a class name';
	    }

	    return $errors;
	}
    //para salvar los datos en la BD, ya sea añadir un nuevo Adaptador o actualizar los campos de uno ya existente
	public function save($adaptor_engine)
	{
	    $query = '';

	    if ($adaptor_engine->getId())
	    {
	        $query = sprintf($this->queries['updAdaptorEngine'],$this->dbHandle->quote($adaptor_engine->getName()),$this->dbHandle->quote($adaptor_engine->getDescription()),$this->dbHandle->quote($adaptor_engine->getImplementation()),$this->dbHandle->quote($adaptor_engine->getClassName()),$this->dbHandle->quote($adaptor_engine->getBrowserId(),'integer'),$this->dbHandle->quote($adaptor_engine->getId(),'integer'));
	    }
	    else
	    {
	        $query = sprintf($this->queries['addAdaptorEngine'], $this->dbHandle->quote($adaptor_engine->getName()), $this->dbHandle->quote($adaptor_engine->getDescription()), $this->dbHandle->quote($adaptor_engine->getImplementation()),$this->dbHandle->quote($adaptor_engine->getClassName()),$this->dbHandle->quote($adaptor_engine->getBrowserId(),'integer'));

	    }
	    return $this->dbHandle->exec($query);
	}

    //para eliminar un Adaptador de la BD
	public function delete($id)
    {
        return $this->dbHandle->exec(sprintf($this->queries['delAdaptorEngine'], $this->dbHandle->quote($id, 'integer')));
    }



  }

?>
