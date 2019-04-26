<?php
/* Change to the correct path if you copy this example! */
require __DIR__ . '/../../autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;

try {
    //$connector = new CupsPrintConnector("EPSON_TM-T20");
    $connector = new CupsPrintConnector("EPSON_UB-E03");
    
    /* Print a "Hello world" receipt" */
    $printer = new Printer($connector);
    $printer -> text("1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890\n");
    $printer -> cut();
    
    /* Close printer */
    $printer -> close();
} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}
