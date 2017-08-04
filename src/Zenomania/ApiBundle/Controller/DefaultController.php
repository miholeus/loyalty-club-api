<?php

namespace Zenomania\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ZenomaniaApiBundle:Default:index.html.twig');
    }
}
