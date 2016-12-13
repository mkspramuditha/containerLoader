<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tyres;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PHPExcel_IOFactory;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class SiteController extends DefaultController
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $orderItems = $request->get('items');
        $orderQuantities = $request->get('quantity');
        if($orderItems != null){
            var_dump($orderItems);
            var_dump($orderQuantities);
            exit;
        }

        $items = $this->getRepository('Tyres')->findAll();
        return $this->render('default/index.html.twig',array(
            'items'=>$items
        ));
    }

    /**
     * @Route("/excel", name="uploadExcel")
     */
    public function excelRead(Request $request){
        $inputFileName = ($this->get('kernel')->getRootDir() .'/../web/upload/dimension.xlsx');;
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch(Exception $e) {
            die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $em = $this->getDoctrine()->getManager();


        for ($row = 2; $row <= $highestRow; $row++){

            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

            $name = $rowData[0][0];
            $od = $rowData[0][1];
            $width = $rowData[0][2];
//            var_dump($name);
//            var_dump($od);
//            var_dump($width);
            $tyre = new Tyres();
            $tyre->setName($name);
            $tyre->setOd($od);
            $tyre->setWidth($width);
            $tyre->setVolume($od*$od*$width);

            $em->persist($tyre);

        }
        $em->flush();
        return new Response('Hi');

    }
}
