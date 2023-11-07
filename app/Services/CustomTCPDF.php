<?php

namespace App\Services;

use TCPDF;

class CustomTCPDF extends TCPDF
{

    public function Header() {
        // Image on the left
        $image_file_left = public_path('img/PBIB Logo.png'); // Replace with the path to your left image
        $this->Image($image_file_left, 10, 5, 50, '', 'PNG', 'https://pbibins.com', 'T', false, 300, '', false, false, 0, false, false, false);

        // Image on the right
        $image_file_right = public_path('img/getaquote400x90.png'); // Replace with the path to your right image
        $this->Image($image_file_right, $this->getPageWidth() - 60, 10, 50, '', 'PNG', 'https://quote.pbibins.com/?utm_source=InsuranceSurveyEmail&utm_medium=Pdf&utm_campaign=InsuranceSurveyEmail&utm_content=InsuranceSurveyPdf', 'T', false, 300, '', false, false, 0, false, false, false);
    }

    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-25);

        // Set the fill color (RGB)
        $this->SetFillColor(6, 67, 103);

        // Draw a filled rectangle with specific x, y, width, and height
        // x = left margin, y = top position, width = page width minus left and right margins, height = desired height
        $this->Rect(10, $this->GetY(), $this->GetPageWidth() - 20, 20, 'F');

        // Set font and text color
        $this->SetFont('helvetica', 'B', 11);
        $this->SetTextColor(255, 255, 255);

        // Add the text over the filled rectangle, aligned to center
        $this->Cell(0, 10, 'Pascal Burke Insurance Brokerage, Inc.', 0, false, 'C', 0, '', 0, false, 'T', 'M');

        // Move to the next line
        $this->Ln(4); // Adjust the line height as needed

        // Set font and text color
        $this->SetFont('helvetica', '', 9);

        // Add the second line of text without fill
        $this->Cell(0, 12, '2102 Business Center Drive Suite 280 Irvine, CA 92612 | Tel.877-893-7629 | Fax 949-340-8412 | info@pbibinc.com | Lic. # 0L98468', 0, false, 'C', 0, '', 0, false, 'T', 'M');

        // Move to the next line
        $this->Ln(4); // Adjust the line height as needed

        $this->SetFont('helvetica', 'B', 9);

        // Get the current page number
        $pageNumber = $this->PageNo();

        // You can position this text wherever you like
        $this->Cell(0, 14, 'Page ' . $pageNumber, 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }


}


?>