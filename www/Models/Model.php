<?php
namespace Pa\Models;

use Pa\Exception\BDDException;

class Model {
    /**
     * @return array
     */
    public function __toArray(){
        $property = get_object_vars($this);
        return $property;
    }

    /**
     * Hydratation
     */
    public function hydrate(array $row)
    {
        try {
            $className = get_class($this);
            $articleObj = new $className();
            foreach ($row as $key => $value) {

                $method = 'set' . ucFirst($key);
                if (method_exists($articleObj, $method)) {
                    // Author = 4
                    if ($relation = $articleObj->getRelation($key)) {
                        // relation = User::class (App\Model\User)
                        $tmp = new $relation();
                        $tmp = $tmp->hydrate($row);
                        // Maintenant on récupère notre id qui est ... la valeur actuelle de notre objet
                        $tmp->setId($value);
                        $articleObj->$method($tmp);
                    } else {
                        $articleObj->$method($value);
                    }
                }
            }
            return $articleObj;
        } catch (BDDException $e) {
            throw new BDDException('Erreur d\'hydratation');
        }
    }

    /**
     * @param string $key
     * @return string|null
     * Recherche les relations entre les tables
     */
    public function getRelation(string $key): ?string
    {
        $relations = $this->initRelation();

        if(isset($relations[$key]))
            return $this->initRelation()[$key];

        return null;
    }

    /**
     * Indique la relation entre table
     */
    public function initRelation()
    {
        // clef etrangère vers classe
        return [];
    }

}