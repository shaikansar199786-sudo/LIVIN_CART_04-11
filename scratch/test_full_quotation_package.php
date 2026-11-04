<?php
require_once __DIR__ . '/../demoark/api/libs/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$css = '
@page {
  margin: 12mm 15mm 12mm 15mm;
}
body {
  font-family: DejaVu Sans, sans-serif;
  font-size: 9pt;
  color: #0f172a;
  margin: 0;
  padding: 0;
}
.page-break, #pdf-page-1, #pdf-page-2, #pdf-page-3, #pdf-page-4, [style*="page-break-after: always"] {
  page-break-after: always !important;
  break-after: page !important;
  clear: both !important;
}
.agreements-contract-wrapper, [style*="page-break-before: always"] {
  page-break-before: always !important;
  break-before: page !important;
  clear: both !important;
}
table { width: 100%; border-collapse: collapse; }
';

$html = '
<!DOCTYPE html>
<html>
<head>
<style>' . $css . '</style>
</head>
<body>
  <div class="merged-package-wrapper">
    <!-- PAGE 1: COVER PAGE -->
    <div id="pdf-page-1" style="page-break-after: always;">
      <div style="font-size: 20pt; font-weight: bold; color: #ea580c; text-align: center; margin-top: 200px;">
        OFFICIAL QUOTATION &amp; PROJECT ESTIMATE
      </div>
      <div style="text-align: center; margin-top: 20px; font-size: 14pt;">
        Quote No: QTN-PR_1001 | Date: 05/09/2026
      </div>
    </div>

    <!-- PAGE 2: PROJECT INFORMATION -->
    <div id="pdf-page-2" style="page-break-after: always;">
      <h2 style="font-size: 18pt; color: #0f172a; border-bottom: 2px solid #ea580c; padding-bottom: 8px;">
        PROJECT INFORMATION
      </h2>
      <div style="border: 2px dashed #cbd5e1; padding: 20px; border-radius: 10px; margin-top: 20px;">
        <p><strong>Client Name:</strong> John Doe</p>
        <p><strong>Project ID:</strong> PR_1001</p>
        <p><strong>Proposal Date:</strong> 05/09/2026</p>
        <p><strong>Scope of Work:</strong> Complete Interior Design &amp; Custom Modular Execution</p>
        <p><strong>Production &amp; Installation Timeline:</strong> 75 Business Days</p>
        <p><strong>Designer Details:</strong> Livincart Team</p>
      </div>
    </div>

    <!-- PAGE 3: MODULES SUMMARY -->
    <div id="pdf-page-3" style="page-break-after: always;">
      <h2 style="font-size: 18pt; color: #0f172a; border-bottom: 2px solid #ea580c; padding-bottom: 8px;">
        MODULES SUMMARY
      </h2>
      <table style="border: 1px solid #cbd5e1; margin-top: 20px;">
        <tr style="background-color: #ea580c; color: white;">
          <th style="padding: 10px;">#</th>
          <th style="padding: 10px;">Module Name</th>
          <th style="padding: 10px; text-align: center;">Total Items</th>
          <th style="padding: 10px; text-align: right;">Amount (₹)</th>
        </tr>
        <tr>
          <td style="padding: 8px;">1</td>
          <td style="padding: 8px;">False Ceiling</td>
          <td style="padding: 8px; text-align: center;">4</td>
          <td style="padding: 8px; text-align: right;">₹ 85,000</td>
        </tr>
        <tr>
          <td style="padding: 8px;">2</td>
          <td style="padding: 8px;">Woodwork</td>
          <td style="padding: 8px; text-align: center;">12</td>
          <td style="padding: 8px; text-align: right;">₹ 4,50,000</td>
        </tr>
        <tr style="background-color: #fff1f2; font-weight: bold;">
          <td colspan="3" style="padding: 10px; text-align: right;">Net Payable Total</td>
          <td style="padding: 10px; text-align: right; color: #16a34a;">₹ 5,35,000</td>
        </tr>
      </table>
    </div>

    <!-- PAGE 4+: DETAILED BOQ BREAKDOWN -->
    <div id="pdf-page-4" style="page-break-after: always;">
      <h2 style="font-size: 18pt; color: #0f172a; border-bottom: 2px solid #ea580c; padding-bottom: 8px;">
        DETAILED BOQ BREAKDOWN
      </h2>
      <h3>Module 1: False Ceiling</h3>
      <table style="border: 1px solid #cbd5e1;">
        <tr style="background-color: #ea580c; color: white;">
          <th style="padding: 8px;">Particulars</th>
          <th style="padding: 8px;">Unit</th>
          <th style="padding: 8px;">Qty</th>
          <th style="padding: 8px;">Rate</th>
          <th style="padding: 8px;">Amount</th>
        </tr>
        <tr>
          <td style="padding: 8px;">Gypsum Board Ceiling</td>
          <td style="padding: 8px;">SFT</td>
          <td style="padding: 8px;">500</td>
          <td style="padding: 8px;">₹120</td>
          <td style="padding: 8px;">₹60,000</td>
        </tr>
      </table>
    </div>

    <!-- WORKS CONTRACT AGREEMENT -->
    <div class="agreements-contract-wrapper">
      <h2 style="font-size: 18pt; color: #0f172a; border-bottom: 2px solid #ea580c; padding-bottom: 8px;">
        WORKS CONTRACT AGREEMENT
      </h2>
      <p>This Agreement is entered into by and between Livincart Private Limited and Client...</p>
    </div>
  </div>
</body>
</html>
';

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$canvas = $dompdf->getCanvas();
$pageCount = $canvas->get_page_count();

echo "Full Package Generated Total Pages: " . $pageCount . "\n";
file_put_contents(__DIR__ . '/verified_full_package.pdf', $dompdf->output());
echo "Saved to verified_full_package.pdf\n";
