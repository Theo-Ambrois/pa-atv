<?php
namespace Pa\Managers;

use Pa\Core\Manager;
use Pa\Core\QueryBuilder;
use Pa\Models\Documents;

/**
 * Class DocumentManager
 * @package Pa\Managers
 */
class DocumentManager extends Manager
{
	/**
     * DocumentManager constructor.
     * Appelle le constructeur parent
     */
    public function __construct()
    {
        parent::__construct(Documents::class, 'documents');
    }

    public function getDocument() {
        $document = $this->findBy(["id"=>$id]);
        return ($document);
    }

    /**
     * @param $id
     * @return mixed
     * Récupère les infos d'un document
     */
    public function getDocumentInfo($id)
    {
        $document = $this->findBy(['id_document'=>$id]);
        return $document[0];
    }

    /**
     * @return array
     * Récupère tous les documents
     */
    public function getAll()
    {
        return $this->findAll();
    }
}