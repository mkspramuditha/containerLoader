<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class SiteController extends DefaultController
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $items = $this->getRepository('Tyres')->findAll();
        return $this->render('default/index.html.twig',array(
            'items'=>$items
        ));
    }
}
