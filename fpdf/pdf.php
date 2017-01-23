<?php

include_once 'config.php';
//* Co-ordinates  ****************************************//
$itemlineHeight = 5;
$itemRowStart = 100;
$currentRow = 0;
$codeXPos = 20;
$DescXPos = 50;
$HdrPriceXPos = 99;
$HdrDescXPos = 51;
$HdrQtyXPos = 110;
$HdrValueXPos = 180;
$headerX = 15;
$hderRow = 90;
$priceXPos = 100;
$quantityXPos = 120;
$itemValueXpos = 180;
$orderIdXpos = 20;
$orderIdX = 40;
$OrdrRow = 40;
$curncyRow = 260;
$curncyX = 80;
$curncyXpos = 40;
$valueX = 140;
$valueXpos = 120;
$vatX = 120;
$vatRow = 265;
$lastItemRow = 2;

/* * ****************************************************** */

require('fpdf.php');
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage('P');
$pdf->SetDisplayMode(real, 'default');
$pdf->SetFont('Helvetica', 'B', 16);
$pdf->Image('blissLogo.png');
$pdf->SetXY(40, 15);
$pdf->SetDrawColor(50, 60, 100);
$pdf->Write(5, 'THANK YOU FOR YOUR ORDER!');
$pdf->SetXY(72, 30);
$pdf->SetFontSize(10);
$pdf->Write(5, 'ORDER CONFIRMATION.');

$errFlg = 0;
$errMsg = "";
$OrderId = $_POST['OrderId'];
$OrderId = 36;
//$pdf->Write(print_r($OrderId));

if ($currentRow > $lastItemRow) {
    $pdf->SetAutoPageBreak(true, 0);
    $pdf->AddPage();
}

$pdf->SetXY($orderIdXpos, $OrdrRow);
$pdf->Write(5, 'OrderId:');
$pdf->SetXY($orderIdX, $OrdrRow);
$pdf->Write(5, $OrderId);

$sqlConnection = null;
$sqlConnection = connectToDatabase();
if ($sqlConnection != null) { {
        $sqlQuery = "SELECT   OrderItems.OrderId, OrderItems.itemId, OrderItems.productId, OrderItems.quantity, OrderItems.price, product.ProductCode, product.ProductDescShort,
OrderItems.quantity * OrderItems.price as itemValue
 FROM  OrderItems INNER JOIN
                         product ON OrderItems.productId = product.ProductId WHERE OrderId = $OrderId order by itemId ASC";


        try {
            $currentRow = $itemRowStart;
            $result = $sqlConnection->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();


            foreach ($rs as $dataSet) {

                $currentRow = $currentRow + $itemlineHeight;

                $productCode = $dataSet['ProductCode'];
                $pdf->SetXY($headerX, $hderRow);
                $pdf->Write(2, "Product Code");
                $pdf->SetXY($codeXPos, $currentRow);
                $pdf->Write(5, $productCode);

                $productDescShrt = $dataSet['ProductDescShort'];
                $pdf->SetXY($HdrDescXPos, $hderRow);
                $pdf->Write(2, "Description");
                $pdf->SetXY($DescXPos, $currentRow);
                $pdf->Write(5, $productDescShrt);

                $price = $dataSet['price'];
                $pdf->SetXY($HdrPriceXPos, $hderRow);
                $pdf->Write(2, "Price");
                $pdf->SetXY($priceXPos, $currentRow);
                $pdf->Write(5, $price);

                $quantity = $dataSet['quantity'];
                $pdf->SetXY($HdrQtyXPos, $hderRow);
                $pdf->Write(2, "Quantity");
                $pdf->SetXY($quantityXPos, $currentRow);
                $pdf->Write(5, $quantity);

                $itemValue = $dataSet['itemValue'];

                $pdf->SetXY($HdrValueXPos, $hderRow);
                $pdf->Write(2, "Value");
                $pdf->SetXY($itemValueXpos, $currentRow);
                $pdf->Write(5, $itemValue);

                $currentRow = $currentRow + $itemlineHeight;
                $totalValue += $itemValue;
                $Vat = 20 / 100 * $totalValue;
                $total = $Vat + $totalValue;
            }
        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();
            $errFlg = 1;
        }
        $pdf->Text(140, 260, 'Value:');
        $pdf->Text(152, 260, $totalValue);
        $pdf->Text(140, 265, 'Vat:');
        $pdf->Text(152, 265, $Vat);
        $pdf->Text(140, 270, 'Total:');
        $pdf->Text(152, 270, $total);

        $sqlQuery = "SELECT OrderId, Email, TelNo,Currency FROM OrderHeader WHERE OrderId = $OrderId";
        try {

            $result = $sqlConnection->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
            foreach ($rs as $dataSet) {
                $OrdrRow = $OrdrRow + 5;
                $email = $dataSet['Email'];
                $pdf->SetXY($orderIdXpos, $OrdrRow);
                $pdf->Write(5, 'Email:');
                $pdf->SetXY($orderIdX, $OrdrRow);
                $pdf->Write(5, $email);

                $OrdrRow = $OrdrRow + 5;
                $telNo = $dataSet['TelNo'];
                $pdf->SetXY($orderIdXpos, $OrdrRow);
                $pdf->Write(5, 'TelNo:');
                $pdf->SetXY($orderIdX, $OrdrRow);
                $pdf->Write(5, $telNo);
                $Currency = $dataSet['Currency'];
                $pdf->Text(140, 270, 'Total:');
                $pdf->Text(152, 270, $total);
            }
        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();
            $errFlg = 1;
        }
    }
}


//$pdf->Write(5,(print_rs $productCode));
$pdf->Output();
?>