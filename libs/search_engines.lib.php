<?php

  class SearchEngine
  {
      private $name;
      private $description;
      private $params;
      private $implementation;
      private $class_name;
      private $id;

      function __construct($name,$description,$params,$implementation,$class_name,$id)
      {
          $this->name = $name;
          $this->description = $description;
          $this->params = $params;
          $this->implementation = $implementation;
          $this->class_name = $class_name;
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

      public function getParams()
      {
          return $this->params;
      }

      public function setParams($value)
      {
          $this->params = $value;
      }

      public function getImplementation()
      {
          return $this->implementation;
      }

      public function setImplementation($value)
      {
          $this->implementation = $value;
      }

      public function getClassName()
      {
          return $this->class_name;
      }

      public function setClassName($value)
      {
          $this->class_name = $value;
      }

  }

  class SearchEngineManager
  {
      private $dbHandle;
      private $queries = array(
        'getAll' => 'SELECT * FROM searchengines;',
        'getSearchEngine' => 'SELECT * FROM searchengines WHERE id=%d;',
        'delSearchEngine' => 'DELETE FROM searchengines WHERE id=%d;',
        'updSearchEngine' => 'UPDATE searchengines SET name=%s, description=%s, params=%s, implementation=%s, class_name=%s WHERE id=%d',
        'addSearchEngine' => 'INSERT INTO searchengines (name, description, params, implementation,class_name) VALUES (%s, %s, %s, %s, %s);',
        'getSearchEngineByName' => 'SELECT * FROM searchengines WHERE name=%s;',
      );

      function __construct($mdb)
    {
        $this->dbHandle = $mdb;
    }

      public function get($id)
      {
          $data = $this->dbHandle->queryAll(sprintf($this->queries['getSearchEngine'], $this->dbHandle->quote($id, 'integer')));
          if (count($data) > 0)
          {
              return new SearchEngine($data[0]['name'], $data[0]['description'], $data[0]['params'], $data[0]['implementation'], $data[0]['class_name'], $data[0]['id']);
          }
          else { return false; }
      }

    public function getAll()
    {
        $search_engines = array();
        $data = $this->dbHandle->queryAll($this->queries['getAll']);
        foreach($data as $row)
        {
            array_push($search_engines, new SearchEngine(utf8_encode($row['name']), utf8_encode($row['description']), $row['params'], utf8_encode($row['implementation']), utf8_encode($row['class_name']), $row['id']));
        }
        return $search_engines;
    }

    public function update($engine, $data)
    {
        //Exceptuando implementation todos los otros datos hay que trimearlos

        $engine->setName($data['name']); //Aqui hay que lowercase
        $engine->setDescription($data['description']);
        $engine->setParams($data['params']);
        $engine->setImplementation($data['implementation']);
        $engine->setClassName($data['classname']);
    }

    public function validate($engine)
    {
        $errors = array();
        if (!$engine->getName())
        {
            $errors['name'] = 'You must provide a name';
        }
        else
        {
            $engines = $this->dbHandle->queryAll(sprintf($this->queries['getSearchEngineByName'], $this->dbHandle->quote($engine->getName())));
            if (count($engines))
            {
                if ($engine->getId())
                {
                    if ($engine->getId() != $engines[0]['id'])
                    {
                        $errors['name'] = 'A search engine already exists with that name';
                    }

                }
                else
                {
                    $errors['name'] = 'A search engine already exists with that name';
                }

            }

        }
        if (!$engine->getDescription())
        {
            $errors['description'] = 'You must provide a description';
        }
        return $errors;
    }

    public function save($engine)
    {
        $query = '';

        if ($engine->getId())
        {
            $query = sprintf($this->queries['updSearchEngine'], $this->dbHandle->quote($engine->getName()), $this->dbHandle->quote($engine->getDescription()), $this->dbHandle->quote($engine->getParams()), $this->dbHandle->quote($engine->getImplementation()),$this->dbHandle->quote($engine->getClassName()), $this->dbHandle->quote($engine->getId(), 'integer'));
        }
        else
        {
            $query = sprintf($this->queries['addSearchEngine'], $this->dbHandle->quote($engine->getName()), $this->dbHandle->quote($engine->getDescription()), $this->dbHandle->quote($engine->getParams()), $this->dbHandle->quote($engine->getImplementation()),$this->dbHandle->quote($engine->getClassName()));
        }

        return $this->dbHandle->exec($query);
    }

    public function delete($id)
    {
        return $this->dbHandle->exec(sprintf($this->queries['delSearchEngine'], $this->dbHandle->quote($id, integer)));
    }

    public function getParamsArray($id)
	{
		$search_engine = $this->get($id);
		$parameters_XML= $search_engine->getParams();

		$xml= new XMLParamParser();

		return $xml->readXMLParam($parameters_XML);//arreglo con todos los parametros
	}

	public function getFirstSearchEngine()
	{
		$searchers_array= $this->getAll();
        return $searchers_array[0];
	}

  }
?>
