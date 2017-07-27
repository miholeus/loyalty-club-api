<?php

namespace Zenomania\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ZenomaniaCoreBundle:Default:index.html.twig');
    }
}
