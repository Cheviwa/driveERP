<?php

include_once 'config.php';

$OrderId = $_POST['OrderId'];
$OrderId = 36;


//* Co-ordinates  ****************************************//
$itemlineHeight = 4;
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
$lastItemRow = 240;


/* * ****************************************************** */

require('fpdf.php');
$pdf = new FPDF('P', 'mm', 'A4');
newPage($pdf);
$pdf->SetDisplayMode(real, 'default');
$pdf->SetFont('Helvetica', 'B', 16);
$pdf->SetXY(40, 15);
$pdf->SetDrawColor(50, 60, 100);
$pdf->Write(5, 'THANK YOU FOR YOUR ORDER!');
$pdf->SetXY(72, 30);
$pdf->SetFontSize( 10); 
$pdf->Write(5, 'ORDER CONFIRMATION.');
$pdf->SetFont('Arial', 'I', 10);
$pdf->line( 12,245,190,245);
$pdf->line( 12,267,190,267);
$pdf->line( 8,65,190,65);
$pdf->line( 8,35,190,35);


$errFlg = 0;
$errMsg = "";

//$pdf->SetY(260);
//$pdf->Cell(0, 10, 'Page ' . $pdf->PageNo(), 0, 0, 'C');


//$pdf->Write(print_r($OrderId));




$sqlConnection = null;
$sqlConnection = connectToDatabase();
if ($sqlConnection != null) { {
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
                $pdf->Text(172, 300, 'Currency:');
                $pdf->Text(120, 260, $Currency);
                    if ($OrdrRow > $lastItemRow) {
                    newPage($pdf);
                }
             
            }
        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();
            $errFlg = 1;
        }

    
}

        $sqlQuery = "SELECT   OrderItems.OrderId, OrderItems.itemId, OrderItems.productId, OrderItems.quantity,Product.RRP, product.ProductCode, product.ProductDescShort,
OrderItems.quantity * Product.RRP as itemValue
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

                $price = $dataSet['RRP'];
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
      if ($currentRow > $lastItemRow) {
                    newPage($pdf);
                }
            }
        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();
            $errFlg = 1;
        }
        
        
        $pdf->Text(169, 250, 'Value:');
        $pdf->Text(181, 250, number_format($totalValue, 2));
        $pdf->Text(172, 258, 'Vat:');
        $pdf->Text(181, 258, number_format($Vat, 2));
        $pdf->Text(169, 266, 'Total:');
        $pdf->Text(181, 266, number_format($total, 2));
        
             
  
}



//$pdf->Write(5,(print_rs $productCode));
$pdf->Output();

function newPage($pdf) {
    //this starts a new page with the logo and order id
    global $OrderId, $currentRow, $itemRowStart;

    $currentRow = $itemRowStart;

    $pdf->Addpage();
    $pdf->SetFont('Helvetica', 'B', 16);
    $pdf->Image('blissLogo.png');
    $pdf->Text(20, 43, "OrderId:");
    $pdf->Text(43, 43, $OrderId);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->SetY(266.5);
    $pdf->Cell(0, 10, 'Page ' . $pdf->PageNo(), 0, 0, 'C');
    $pdf->line( 12,245,190,245);
$pdf->line( 12,267,190,267);

    
}


?>