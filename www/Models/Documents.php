<?php
namespace Pa\Models;

use Pa\Core\helpers;
use Pa\Managers\DocumentManager;

class Documents extends Model
{
    protected $id_document;
    protected $document_name;

    //GETTER AND SETTER

    public function setId_document($id)
    {
        $this->id_document = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id_document;
    }

    public function setDocument_name($document_name)
    {
        $this->document_name = $document_name;
        return $this;
    }

    public function getDocument_name()
    {
        return $this->document_name;
    }


    //Récupère tous les noms de documents

    public function getAll()
    {
        $allDocuments = (new DocumentManager())->getAll();
        $documents = [];
        foreach ($allDocuments as $d) {
            $documents[$d->getId()] = $d->getDocument_name();
        }
        return $documents;
    }

    /**
     * @param $id
     * @return mixed
     * Recupère un document en bdd depuis son id
     */
    public function getDocumentById($id)
    {
        $document = (new DocumentManager())->findBy(['id_document'=>$id]);
       return $document[0];
    }

}