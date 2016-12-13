<?php

namespace AppBundle\Controller;

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

        for ($row = 2; $row <= $highestRow; $row++){

            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            foreach ($rowData as $row){
                var_dump($row."  ");
            }
            var_dump("\n");

        }

        return new Response('Hi');

    }
}
