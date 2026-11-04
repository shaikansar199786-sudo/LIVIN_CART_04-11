<?php
require_once __DIR__ . '/../demoark/api/config/Database.php';
require_once __DIR__ . '/../demoark/api/helpers/SimplePdfBuilder.php';
require_once __DIR__ . '/../demoark/api/controllers/QuoteController.php';

$db = (new Database())->getConnection();

// Let's find an existing quote to use as a base or test
$stmt = $db->query("SELECT * FROM quotes ORDER BY quote_id DESC LIMIT 1");
$baseQuote = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$baseQuote) {
    echo "No existing quotes found.\n";
    exit(1);
}

$quoteId = intval($baseQuote['quote_id']);
echo "Found base quote ID: $quoteId (" . ($baseQuote['quote_number'] ?? 'N/A') . ")\n";

// Let's prepare test quote data with ALL non-zero values:
// 1. Sections with items
$testSections = [
    [
        'section_id' => 101,
        'section_name' => 'Living Room & Foyer',
        'items' => [
            [
                'item_id' => 1001,
                'particulars' => 'TV Console & Feature Wall Panelling',
                'category' => 'Living Room',
                'brand' => 'HDMR / Acrylic Finish',
                'unit' => 'SFT',
                'quantity' => 120,
                'rate' => 1500,
                'amount' => 180000,
                'discount_percent' => 0,
                'gst_rate' => 18
            ],
            [
                'item_id' => 1002,
                'particulars' => 'Foyer Shoe Cabinet & Mirror Frame',
                'category' => 'Living Room',
                'brand' => 'BWP Plywood / Laminate',
                'unit' => 'SFT',
                'quantity' => 60,
                'rate' => 1250,
                'amount' => 75000,
                'discount_percent' => 0,
                'gst_rate' => 18
            ]
        ]
    ],
    [
        'section_id' => 102,
        'section_name' => 'Modular Kitchen',
        'items' => [
            [
                'item_id' => 1003,
                'particulars' => 'Base & Wall Cabinets with Tandem Drawers',
                'category' => 'Kitchen',
                'brand' => 'Merino Laminates / Hafele Soft Close',
                'unit' => 'SFT',
                'quantity' => 140,
                'rate' => 1750,
                'amount' => 245000,
                'discount_percent' => 0,
                'gst_rate' => 18
            ]
        ]
    ]
];

// Gross Total = 180,000 + 75,000 + 245,000 = 500,000.00
// Category Discount = 10% on Kitchen (245,000) = 24,500.00
// Flat Discount = 5,000.00
// Net before coupon = 500,000 - 24,500 - 5,000 = 470,500.00
// Coupon FESTIVE5 = 5% on 470,500 = 23,525.00
// Taxable subtotal = 446,975.00
// Additional charges = 15,250.35 (to ensure decimal round off)
// GST 18% on 446,975 = 80,455.50
// Unrounded = 446,975 + 15,250.35 + 80,455.50 = 542,680.85
// Round off adj = +0.15
// Final Total = 542,681.00

$extraData = [
    'category_discounts' => [
        'Kitchen' => ['value' => 10, 'type' => 'percent']
    ],
    'general_discount' => [
        'amount' => 5000,
        'type' => 'flat'
    ],
    'flat_discount' => 5000,
    'applied_coupon' => [
        'code' => 'FESTIVE5',
        'discountType' => 'percent',
        'discountValue' => 5
    ],
    'additional_charges' => [
        'amount' => 15250.35,
        'withGst' => false
    ],
    'overall_gst_enabled' => true,
    'overall_gst_line_hidden' => false,
    'overall_gst_rate' => 18,
    'round_off_enabled' => true,
    'hidden_fields' => []
];

// Assemble quoteData array
$testQuoteRow = [
    'quote_id' => $quoteId,
    'quote_number' => $baseQuote['quote_number'] ?? 'QTN-2026-TEST',
    'version' => 1,
    'subtitle' => 'Detailed Commercial Estimate Test',
    'client_name' => 'Dr. Ramesh Sharma',
    'total_amount' => 542681,
    'sections' => $testSections,
    'extra_data' => json_encode($extraData),
    'extra_data_parsed' => $extraData
];

echo "Generating test PDF with all values populated...\n";
$pdfBinary = SimplePdfBuilder::generateQuotePdfBinary($testQuoteRow);

if (!$pdfBinary || strlen($pdfBinary) < 1000) {
    echo "ERROR: Failed to generate PDF.\n";
    exit(1);
}

$outputDir = __DIR__ . '/../../../../Users/Shaik Ansar/.gemini/antigravity-ide/brain/91c581a2-b340-4403-af55-f4e3d0a202c7';
if (!is_dir($outputDir)) {
    @mkdir($outputDir, 0777, true);
}
$pdfPath = $outputDir . '/Quotation_Full_Pricing_Breakdown_Test.pdf';
file_put_contents($pdfPath, $pdfBinary);
echo "SUCCESS: Saved populated PDF to: $pdfPath (size: " . strlen($pdfBinary) . " bytes)\n";

// Also test the "Hide GST Line in PDF" toggle
$extraDataGstHidden = $extraData;
$extraDataGstHidden['overall_gst_line_hidden'] = true;
$testQuoteRowGstHidden = $testQuoteRow;
$testQuoteRowGstHidden['extra_data'] = json_encode($extraDataGstHidden);
$testQuoteRowGstHidden['extra_data_parsed'] = $extraDataGstHidden;

echo "Generating test PDF with GST Line HIDDEN toggle...\n";
$pdfBinaryGstHidden = SimplePdfBuilder::generateQuotePdfBinary($testQuoteRowGstHidden);
$pdfPathGstHidden = $outputDir . '/Quotation_GST_Hidden_Test.pdf';
file_put_contents($pdfPathGstHidden, $pdfBinaryGstHidden);
echo "SUCCESS: Saved GST hidden PDF to: $pdfPathGstHidden (size: " . strlen($pdfBinaryGstHidden) . " bytes)\n";
