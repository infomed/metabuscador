<?php

  class InfoSourceEngine
  {
      private $name;
      private $description;
      private $search_engine_id;
      private $params;
      private $id;

      function __construct($name,$description,$search_engine_id,$params,$id)
      {
          $this->name = $name;
          $this->description = $description;
          $this->search_engine_id = $search_engine_id;
          $this->params = $params;
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

      public function getSearchEngineParams()
      {
          return $this->params;
      }

      public function setSearchEngineParams($value)
      {
          $this->params = $value;
      }

      public function getSearchEngineId()
      {
          return $this->search_engine_id;
      }

      public function setSearchEngineId($value)
      {
          $this->search_engine_id = $value;
      }
  }

  class InfoSourceEngineManager
  {
    private $dbHandle;
    private $queries = array(
                      'getAll' => 'SELECT * FROM infosources',
                      'getInfoSourceEngine' => 'SELECT * FROM infosources WHERE id=%d',
                      'delInfoSourceEngine' => 'DELETE FROM infosources WHERE id=%d',
                      'updInfoSourceEngine' => 'UPDATE infosources SET name=%s,description=%s,search_engine_id=%d,search_engine_params=%s where id=%d',
                      'addInfoSourceEngine' => 'INSERT INTO infosources (name,description,search_engine_id,search_engine_params) values (%s,%s,%d,%s)',
                      'getInfoSourceEngineName' => 'SELECT name FROM infosources',
                      'getInfoSourceEngineByName' => 'SELECT * FROM infosources WHERE name=%s;'

   );

    function __construct($mdb)
    {
      $this->dbHandle = $mdb;
    }

   //devuelve un objeto de tipo FI dado un Id de la misma
    public function get($id)
    {
          $data = $this->dbHandle->queryAll(sprintf($this->queries['getInfoSourceEngine'], $this->dbHandle->quote($id, 'integer')));

          if (count($data) > 0)
          {
             return new InfoSourceEngine($data[0]['name'], $data[0]['description'],$data[0]['search_engine_id'],$data[0]['search_engine_params'], $data[0]['id']);
          }

          else { return false; }
    }
    //devuelve todas las FI registradas en la BD
	public function getAll()
	{
	    $sources_engines = array();
	    $data = $this->dbHandle->queryAll($this->queries['getAll']);
	    foreach($data as $row)
	    {
               //array_push($sources_engines, new InfoSourceEngine($row['name'], $row['description'], $row['search_engine_id'], $row['search_engine_params'], $row['id']));
	        array_push($sources_engines, new InfoSourceEngine(utf8_encode($row['name']), utf8_encode($row['description']), $row['search_engine_id'], $row['search_engine_params'], $row['id']));
	    }
	    return $sources_engines;
	}
    //actualizarle los parametros de una FI
	public function update($source_engine,$data,$buscadorParam)
	{
	    $source_engine->setName($data['name']);//Aqui hay que lowercase
	    $source_engine->setDescription($data['description']);
	    $source_engine->setSearchEngineId($data['searchers']);
	    //actualizando los parametros
        $source_engine->setSearchEngineParams($buscadorParam);

	}
    //devuelve un arreglo de errores (posibles errores -> name vacio, name repetido o descripcion vacia)
	public function validate($source_engine)
	{
        $errors = array();
	    if (!$source_engine->getName())
	    {
	        $errors['name'] = 'You must provide a name';
	    }
	    else
	    {
	        $engines = $this->dbHandle->queryAll(sprintf($this->queries['getInfoSourceEngineByName'], $this->dbHandle->quote($source_engine->getName())));

	        if (count($engines))
	        {
	            if ($source_engine->getId())
	            {
	                if ($source_engine->getId() != $engines[0]['id'])
	                {
	                    $errors['name'] = 'An Info Source Engine already exists with that name';
	                }
	            }
	            else
	            {
	                $errors['name'] = 'An Info Source Engine already exists with that name';
	            }
	        }
	    }

	    if (!$source_engine->getDescription())
	    {
	        $errors['description'] = 'You must provide a description';
	    }

	    return $errors;
	}

    //para salvar los datos en la BD, ya sea añadir una nueva FI o actualizar los campos de un existente
	public function save($source_engine)
	{
	    $query = '';
	    //die(print_r($source_engine));
	    if ($source_engine->getId())
	    {
	        $query = sprintf($this->queries['updInfoSourceEngine'],$this->dbHandle->quote($source_engine->getName()),$this->dbHandle->quote($source_engine->getDescription()),$this->dbHandle->quote($source_engine->getSearchEngineId(),'integer'),$this->dbHandle->quote($source_engine->getSearchEngineParams()),$this->dbHandle->quote($source_engine->getId(),'integer'));
	    }
	    else
	    {
	        $query = sprintf($this->queries['addInfoSourceEngine'], $this->dbHandle->quote($source_engine->getName()), $this->dbHandle->quote($source_engine->getDescription()), $this->dbHandle->quote($source_engine->getSearchEngineId(),'integer'), $this->dbHandle->quote($source_engine->getSearchEngineParams()));

	    }

	    return $this->dbHandle->exec($query);
	}

    //para eliminar una FI de la BD
	public function delete($id)
    {
        return $this->dbHandle->exec(sprintf($this->queries['delInfoSourceEngine'], $this->dbHandle->quote($id, 'integer')));
    }
    //obtener los parametros y sus valores del buscador asociado a una FI (tabla Fuentes Innformacion)
    public function getSearchEngineParamsArray($id)
	{
		$fi_engine = $this->get($id);
		$parameters_valor_XML= $fi_engine->getSearchEngineParams();

		$xml= new XMLParamParser();

		return $xml->readXMLParamValor($parameters_valor_XML);//arreglo con todos los parametros y sus valores
	}

	//obtener los parametros y sus valores del buscador asociado a una FI (para una FI que se está creando o actualizando pero que aun no se ha salvado en la BD)
	public function getSearchEngineParamsArrayNew($fi_engine)
	{
	    $parameters_valor_XML= $fi_engine->getSearchEngineParams();
	    $xml= new XMLParamParser();

        return $xml->readXMLParamValor($parameters_valor_XML);//arreglo con todos los parametros y sus valores

	}
  }
?>