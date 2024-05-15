<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();
    $db = getDatabaseConnection();

    $address = $_POST['adress'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $postalCode = $_POST['postal-code'];


    if ($address === "" || $city === "" || $country === "" || $postalCode === "") {
        $addressInfo = User::getAdressInfo($db, $session->getUserId());
        $address = $addressInfo[0];
        $city = $addressInfo[1];
        $country = $addressInfo[2];
        $postalCode = $addressInfo[3];
    }

    $cardNumber = $_POST['card-number'];
    $expirationDate = $_POST['expiration-date'];
    $cvv = $_POST['cvv'];

    require_once __DIR__ . '/../tcpdf/tcpdf.php';
   
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Shipping Form');
    $pdf->SetSubject('Shipping Form');
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    $pdf->AddPage();
    $html = '<h1>Shipping Form</h1>';
    $html .= "<p>Address: $address</p>";
    $html .= "<p>City: $city</p>";
    $html .= "<p>Country: $country</p>";
    $html .= "<p>Postal Code: $postalCode</p>";
    $pdf->writeHTML($html, true, false, true, false, '');

    $pdfPath = __DIR__ . "/../docs/invoices/shipping_form_" . $session->getUserId() . ".pdf";
    $pdf->Output($pdfPath, 'F');

    header("Location: ../docs/invoices/shipping_form_" . $session->getUserId() . ".pdf");
    exit();
?>
