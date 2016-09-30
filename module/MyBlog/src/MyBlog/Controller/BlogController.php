<?php

namespace MyBlog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use MyBlog\Entity;

class BlogController extends AbstractActionController{

    public function indexAction()
    {
        return new ViewModel();
    }

}