<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
// Styles
// Table Head
$headStyle = new PHPExcel_Style();
$headStyle->applyFromArray(
    [
        'alignment' => [
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ],
        'fill'      => [
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
        ],
        'borders'   => [
            'bottom' => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
            'right'  => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
            'top'    => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
            'left'   => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ]
);
// Table Sub
// Table Input
$inputStyle = new PHPExcel_Style();
$inputStyle->applyFromArray(
    [
        'fill'    => [
            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => ['argb' => 'FFA9FFB9'],
        ],
        'borders' => [
            'bottom' => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FFD1D1D1'],
            ],
            'right'  => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FFD1D1D1'],
            ],
            'top'    => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FFD1D1D1'],
            ],
            'left'   => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FFD1D1D1'],
            ],
        ],
    ]
);
// Colored1
$colored1Style = new PHPExcel_Style();
$colored1Style->applyFromArray(
    [
        'fill'    => [
            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => ['argb' => 'FFFFFF00'],
        ],
        'borders' => [
            'bottom' => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FFD1D1D1'],
            ],
            'right'  => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FFD1D1D1'],
            ],
            'top'    => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FFD1D1D1'],
            ],
            'left'   => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FFD1D1D1'],
            ],
        ],
    ]
);
// Variable but don't change
$fixedStyle = new PHPExcel_Style();
$fixedStyle->applyFromArray(
    [
        'fill'    => [
            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => ['argb' => 'FFDADADA'],
        ],
        'borders' => [
            'bottom' => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FFD1D1D1'],
            ],
            'right'  => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FFD1D1D1'],
            ],
            'top'    => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FFD1D1D1'],
            ],
            'left'   => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FFD1D1D1'],
            ],
        ],
    ]
);
// Table Total
$totalStyle = new PHPExcel_Style();
$totalStyle->applyFromArray(
    [
        'font'    => [
            'bold' => true,
        ],
        'fill'    => [
            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => ['argb' => 'FF97C8FF'],
        ],
        'borders' => [
            'bottom' => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
            'right'  => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
            'top'    => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
            'left'   => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ]
);
// Table Cell
// Table Outer
$outerStyle = new PHPExcel_Style();
$outerStyle->applyFromArray(
    [
        'borders' => [
            'outline' => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ]
);

// Negativ value
$badBudget = new PHPExcel_Style_Conditional();
$badBudget->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS);
$badBudget->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN);
$badBudget->addCondition('0');
$badBudget->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
$badBudget->getStyle()->getFont()->setBold(true);
