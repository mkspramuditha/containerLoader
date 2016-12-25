<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TyrePallet;
use AppBundle\Entity\Tyres;
use AppBundle\Packer\TestBox;
use AppBundle\Packer\TestItem;
use DVDoug\BoxPacker\ItemList;
use DVDoug\BoxPacker\Packer;
//use DVDoug\BoxPacker\TestBox;
//use DVDoug\BoxPacker\TestItem;
use DVDoug\BoxPacker\VolumePacker;
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
        $palletCount = $request->get('palletQuanity');
//        var_dump($palletCount);
//        exit;
        $country = $request->get('country');
        $palletValue = $request->get('palletValue');

        $containerSize = $request->get('container');



        if($orderItems != null){
            $packedBoxes = $this->packing($orderItems,$orderQuantities, $palletCount,$country,$palletValue) ;

            $test = clone $packedBoxes;
            $itemInContainer = [];
            foreach ($test as $row){
                $itemsInTheBox = $row->getItems();
                $countItems = [];
                foreach ($itemsInTheBox as $item) { // your own item object, in this case TestItem
                    $countItems[] = $item->getDescription();
                }
                $array = array_count_values($countItems);
                $temp = [];
                foreach ($array as $key=>$value){
                    $temp[$key] = $value;
                }
                $itemInContainer[] = $temp;
            }

//            $total = 0;
//            foreach($orderItems as $key=>$value) {
//                $total+= (float)$value * (float)$orderQuantities[$key];
//            }
//            $size = 0;
//            if($containerSize == '20'){
//                $size = 5.9*2.35*2.393*1000000000;
//            }
//            else if($containerSize == '40'){
//                $size = 12.036*2.350*2.392*1000000000;
//            }
//
//            $containerCount = ceil($total/(float)$size);

            return $this->render('default/result.html.twig',array(
               'packedBoxes'=>$packedBoxes,
                'items'=>$itemInContainer
            ));
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



    /**
     * @Route("/excel/pallet", name="uploadExcelPallet")
     */

    public function palletExcel(Request $request){
        $inputFileName = ($this->get('kernel')->getRootDir() .'/../web/upload/pallet.xlsx');;
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

            $tyre = $rowData[0][0];
            $description = $rowData[0][1];
            $standardSize = explode("x", $rowData[0][2]);
            if(count($standardSize) == 2){
                $standardLength = $standardSize[0];
                $standardWidth = $standardSize[1];
            }
            else{
                $standardLength = 0;
                $standardWidth = 0;
            }

            $standardQuantity = $rowData[0][3];
            $italySize = explode("x", $rowData[0][4]);
            if(count($italySize) == 2){
                $italyLength = $italySize[0];
                $italyWidth = $italySize[1];
            }
            else{
                $italyLength = 0;
                $italyWidth = 0;
            }

            $italyQuantity = $rowData[0][5];
            $usaSize = explode("x", $rowData[0][6]);
//            var_dump($usaSize);
//            $str = "12";
//            var_dump(explode("&",$str));
//            exit;
            if(count($usaSize) == 2){
                $usaLength = $usaSize[0];
                $usaWidth = $usaSize[1];
            }
            else{
                $usaLength = 0;
                $usaWidth = 0;
            }


            $usaQuantity = $rowData[0][7];
//            var_dump($name);
//            var_dump($od);
//            var_dump($width);
//            $tyre = new Tyres();
//            $tyre->setName($name);
//            $tyre->setOd($od);
//            $tyre->setWidth($width);
//            $tyre->setVolume($od*$od*$width);

            $tyrePallet = new TyrePallet();
            $tyrePallet->setTyre($tyre);
            $tyrePallet->setDescription($description);
            $tyrePallet->setStandardLength($standardLength);
            $tyrePallet->setStandardWidth($standardWidth);
            $tyrePallet->setStandardQuantity($standardQuantity);
            $tyrePallet->setItalyLength($italyLength);
            $tyrePallet->setItalyWidth($italyWidth);
            $tyrePallet->setItalyQuantity($italyQuantity);
            $tyrePallet->setUsaLength($usaLength);
            $tyrePallet->setUsaWidth($usaWidth);
            $tyrePallet->setUsaQuantity($usaQuantity);

            $em->persist($tyrePallet);

        }
        $em->flush();
        return new Response('Done Uploading');
    }

    /**
     * @Route("/test", name="test")
     */

    public function testAction(Request $request){
        /*
   * To figure out which boxes you need, and which items go into which box
   */
        $packer = new Packer();

        $packer->addBox(new TestBox('Le petite box', 300, 300, 10, 10, 296, 296, 8, 1000));
        $packer->addBox(new TestBox('Le grande box', 3000, 3000, 100, 100, 2960, 2960, 80, 10000));
        for($i = 0; $i<1000; $i++){
            $packer->addItem(new TestItem('item'.$i,250,250,2,200,true));
        }
//        $packer->addItem(new TestItem('Item 1', 250, 250, 2, 200, true));
//        $packer->addItem(new TestItem('Item 2', 250, 250, 2, 200, true));
//        $packer->addItem(new TestItem('Item 3', 250, 250, 2, 200, true));
        $packedBoxes = $packer->pack();
//
//        echo("These items fitted into " . count($packedBoxes) . " box(es)" . PHP_EOL);
//        foreach ($packedBoxes as $packedBox) {
//            $boxType = $packedBox->getBox(); // your own box object, in this case TestBox
//            echo("This box is a {$boxType->getReference()}, it is {$boxType->getOuterWidth()}mm wide, {$boxType->getOuterLength()}mm long and {$boxType->getOuterDepth()}mm high" . PHP_EOL);
//            echo("The combined weight of this box and the items inside it is {$packedBox->getWeight()}g" . PHP_EOL);
//
//            echo("The items in this box are:" . PHP_EOL);
//            $itemsInTheBox = $packedBox->getItems();
////            foreach ($itemsInTheBox as $item) { // your own item object, in this case TestItem
////                echo($item->getDescription() . PHP_EOL);
////            }
//
//            echo(PHP_EOL);
//        }



        /*
         * To just see if a selection of items will fit into one specific box
         */
//        $box = new TestBox('Le box', 300, 300, 10, 10, 296, 296, 8, 1000);
//
//        $items = new ItemList();
//        $items->insert(new TestItem('Item 1', 297, 296, 2, 200, true));
//        $items->insert(new TestItem('Item 2', 297, 296, 2, 500, true));
//        $items->insert(new TestItem('Item 3', 296, 296, 4, 290, true));
//
//        $volumePacker = new VolumePacker($box, $items);
//        $packedBox = $volumePacker->pack();
        /* $packedBox->getItems() contains the items that fit */

    }

    public function packing($items , $quantity, $palletCounts, $country, $palletValue){
//        var_dump($palletCounts);
        $objectArray = [];

        if($items!== null){
            foreach ($items as $key=>$value){
//                var_dump($value);
                $objectArray[] = $this->getRepository('Tyres')->findOneBy(array('name'=>$value));
            }

//            var_dump(count($objectArray));
//            var_dump($objectArray);

//            var_dump($objectArray[0]->getName());
//            exit;
            $packer = new Packer();

        $packer->addBox(new TestBox('40ft container', 2350, 12036, 2392, 0, 2350, 12036, 2392, 1));
//            $packer->addBox(new TestBox('Le grande box', 3000, 3000, 100, 100, 2960, 2960, 80, 10000));
//            for($i = 0; $i<1000; $i++){
//                $packer->addItem(new TestItem('item'.$i,250,250,2,200,true));
//            }

            foreach ($objectArray as $key=>$value){
                $palletObj = $this->getRepository('TyrePallet')->findOneBy(array('tyre'=>$value->getName()));
                $palletCount = $palletCounts[$key];
//                var_dump($palletCounts);
//                exit;
                $palletCountry = $country[$key];
                $length = 0;
                $width = 0;
                $height = 1000;
                $tyreCount = 0;
                if($palletObj !== null) {
                    if ($palletCountry == "std") {
                        $length = $palletObj->getStandardLength();
                        $width = $palletObj->getStandardWidth();
                        $tyreCount = $palletObj->getStandardQuantity();
                    } elseif ($palletCountry == "itl") {
                        $length = $palletObj->getItalyLength();
                        $width = $palletObj->getItalyWidth();
                        $tyreCount = $palletObj->getItalyQuantity();
                    } elseif ($palletCountry == "usa") {
                        $length = $palletObj->getUsaLength();
                        $width = $palletObj->getUsaWidth();
                        $tyreCount = $palletObj->getUsaQuantity();
                    }
//                var_dump($length);
//                var_dump($tyreCount);
//                var_dump($palletValue[$key]);
//                exit;
                    if ($palletValue[$key] == "1") {
                        if(count(explode("&", $tyreCount)) ==2) {
                            $tyreCount = (int)explode("&", $tyreCount)[1];
                        }
                        else{
                            $tyreCount = (int)explode("&", $tyreCount)[0];
                        }
                    } else {
                        $tyreCount = (int)explode("&", $tyreCount)[0];
                    }
//                var_dump($tyreCount);
                    if ($tyreCount !== 0) {
                        for ($j = 0; $j < (int)$palletCount; $j++) {
                            $packer->addItem(new TestItem($palletObj->getDescription() . " " . $value->getName(), $length, $width, $height, 0, true));
                        }
                    }
                }
                else{
                    $palletCount = 0;
                }

                for($i = 0;$i<((int)$quantity[$key]-((int)$palletCount*$tyreCount)) ;$i++)
                {
                    $packer->addItem(new TestItem($value->getName(),$value->getOd(),$value->getOd(),$value->getWidth(),0,true));

                }
            }

            $packedBoxes = $packer->pack();
//            $boxDetails = $packedBoxes;
//            var_dump(count($packedBoxes));
//            $test = $packer->pack();
            $itemInContainer = [];

//            echo("These items fitted into " . count($packedBoxes) . " box(es)" . PHP_EOL);
            /*
            foreach ($boxDetails as $packedBox) {
//                echo("<br>");
                $boxType = $packedBox->getBox(); // your own box object, in this case TestBox
//                echo("This box is a {$boxType->getReference()}, it is {$boxType->getOuterWidth()}mm wide, {$boxType->getOuterLength()}mm long and {$boxType->getOuterDepth()}mm high" . PHP_EOL);
//                echo("The combined weight of this box and the items inside it is {$packedBox->getWeight()}g" . PHP_EOL);
//
//                echo("The items in this box are:" . PHP_EOL);
//                echo("<br>");
                $itemsInTheBox = $packedBox->getItems();
//                var_dump(gettype($itemsInTheBox));
//                exit;
//                array_count_values($itemsInTheBox);
                $countItems = [];
            foreach ($itemsInTheBox as $item) { // your own item object, in this case TestItem
                $countItems[] = $item->getDescription();
            }
            $array = array_count_values($countItems);
            $temp = [];
            foreach ($array as $key=>$value){
                $temp[$key] = $value;
//                echo($key . " - " . $value);
//                echo("<br>");
            }
            $itemInContainer[] = $temp;
//
//                echo(PHP_EOL);
//                echo("<br>");
            } */

//            foreach ($boxDetails as $row){
//
//            }



//            var_dump(count($boxDetails));
            return $packedBoxes;
        }

    }
}
