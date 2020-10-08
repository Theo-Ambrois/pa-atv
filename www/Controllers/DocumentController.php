<?php
use Pa\Core\View;
use Pa\Models\Documents;
use Pa\Managers\DocumentManager;
use Pa\Core\helpers;

class DocumentController
{    
    public function listAction()
    {
      //Affiche la liste des documents uploadés

      $title = "Upload Document";
      $tabName = "DOCUMENTS";
      
      $dir = 'public/uploads/';
      $files = array_diff(scandir($dir), array('..', '.'));

      $allDocuments = (new DocumentManager)->getAll();
      $documents = [];
      foreach ($allDocuments as $d) {
        $documents[$d->getId()] = $d->getDocument_name();
      }
      $view = new View("document");
      $view->assign("title", $title);
      $view->assign("tabName", $tabName);
      $view->assign("documents", $documents);
    }


    public function uploadAction() {
        $documents = (new Documents())->getAll();
        $title = "Upload Document";
        $tabName = "DOCUMENTS";

        $name_file = basename( $_FILES["fileToUpload"]["name"]);
        $target_dir = "public/uploads/";
        $target_file = $target_dir . $name_file;
        $imageFileType = pathinfo($name_file, PATHINFO_EXTENSION);
        $uploadOk = 1;


        //Vérifie si le fichier existe ou non
        if (file_exists($target_file)) {
          echo "Le fichier existe déjà.";
          $uploadOk = 0;
        }

        //vérifie si le fichier est trop lourd
        if ($_FILES["fileToUpload"]["size"] > 2000000) {
          echo "Le fichier est trop lourd.";
          $uploadOk = 0;
        }

        //Vérifie si le fichier est d'un type autorisé
        if($imageFileType != "png" && $imageFileType != "jpg" && $imageFileType != "zip" && $imageFileType != "doc" && $imageFileType != "pdf" && $imageFileType != "gif" && $imageFileType != "docx") {
          echo "Le type de fichier n'est pas supporté.";
          $uploadOk = 0;
        }

        // erreur si 0
        if ($uploadOk == 0) {
          echo " Le fichier n'a pas été uploadé.";
        // upload si 1
        } else {
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              //echo "Le fichier ". $name_file. " a été uploadé.";
              $document = new Documents();
              $document->setDocument_name(helpers::specialChars($name_file));

              $documentManager = new DocumentManager();
              $documentManager->save($document);

              header("Location: " . helpers::getUrl("document", "list"));
            }
            
          } else {
            //echo "Il y a eu une erreur pendant l'upload.";
            header("Location: " . helpers::getUrl("document", "list"));
          }
        }
    }


    public function deleteAction()
    {
      //On spécifie le chemin jusqu'au fichier à supprimer
      $documentManager = new DocumentManager();
      $document = new Documents();
      $name_file = $document->getDocumentById($_GET['id'])["document_name"];
      $target_dir = 'public/uploads/';      

      if (isset($name_file)){
      //Suppression du fichier dans le dossier uploads 
        unlink($target_dir.$name_file);
        // Suppression du fichier par son id en base
      $documentManager->delete($_GET['id'], 'id_document');
      } else {
        die ("Le fichier n'a pas pu etre delete.");
      }

        // Redirection pour mettre à jour la liste
        header("Location: " . helpers::getUrl("document", "list"));
    }

    public function DownloadAction(){

      //On spécifie le chemin jusqu'au fichier à download
      $target_dir = 'public/uploads/';
      $document = new Documents();
      $name_file = $document->getDocumentById($_GET['id'])["document_name"];
      $file_url = $target_dir . $name_file;

      //Définit qu'il doit aller dans le dossier DL de l'utilisateur
      header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
      readfile($file_url);
      exit;

      //On retourne sur la liste des documents
      header("Location: " . helpers::getUrl("document", "list"));
    }
}