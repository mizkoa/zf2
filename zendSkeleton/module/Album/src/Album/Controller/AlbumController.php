<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AlbumController extends AbstractActionController
{
    protected $albumTable ;  
    public function indexAction() //Album\Controller\AlbumController::indexAction
    {
//         The ViewModel object also allows us to change the view script that is used, but the default is to use {controller name}/{action name}
        return new ViewModel(array(
            'albums' => $this->getAlbumTable()->fetchAll(), //to set variables in the view, we return a ViewModel instance where the first parameter of the constructor is an array from the action containing data we need. 
        ));
    }

    public function addAction()
    {
        
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
    
     public function getAlbumTable()
    {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Album\Model\AlbumTable');
        }
        return $this->albumTable;
    }

}
?>
