<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TyrePallet;
use AppBundle\Entity\Tyres;
use AppBundle\Form\TyrePalletType;
use AppBundle\Form\TyreType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class CustomController extends DefaultController
{

    /**
     * @Route("/tyre/add", name="tyreAdd")
     */

    public function tyreAddAction(Request $request)
    {
        $tyre = new Tyres();
        $form = $this->createForm(TyreType::class, $tyre);
        $form->handleRequest($request);
        if ($form->isSubmitted() & $form->isValid()) {
            $data = $form->getData();
            $volume = $data->getOd()*$data->getOd()*$data->getWidth();
            $tyre->setVolume($volume);
            $this->insert($tyre);

            return $this->redirectToRoute('homepage');
        }
        return $this->render('default/tyreAdd.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/pallet/add", name="palletAdd")
     */

    public function palletAddAction(Request $request)
    {
        $pallet = new TyrePallet();
        $form = $this->createForm(TyrePalletType::class, $pallet);
        $form->handleRequest($request);
        if ($form->isSubmitted() & $form->isValid()) {
            $this->insert($pallet);

            return $this->redirectToRoute('homepage');
        }
        return $this->render('default/tyrePalletAdd.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
