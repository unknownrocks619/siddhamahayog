<?php

namespace App\Classes\Helpers\ExcelExport;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportFromView implements FromView, WithStyles, ShouldAutoSize, WithTitle
{
    protected string $view;
    protected array $params = [];
    protected string $title;
    public function __construct($view,$params=[], $title='') {
        $this->view = $view;
        $this->params = $params;
        $this->title = $title;
    }
    public function view() : View {
        return view($this->view,$this->params);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:Z1000')->applyFromArray([
            'font'  => [
                'size'  => '20'
            ],
        ]);
        $sheet->getStyle('3')->applyFromArray([
            'height' => 25,
            'font' => [
                        'color' => [
                                        'rgb' => 'ffffff'
                                    ]
                        ],
            'fill' => [
                'fillType'  => 'solid',
                'startColor'    => [
                    'rgb'   => '0b0b0b'
                ]
            ]
        ]);
        $sheet->getStyle('1')->applyFromArray([
            'alignment' => [
                  'horizontal' => Alignment::HORIZONTAL_CENTER,
                  'vertical' => Alignment::VERTICAL_CENTER,
                  'wrapText' => true,
              ],
            'height'    => '30',
            'font'  => [
                'size'  => '25'
            ]
        ]);
    }

    public function title(): string
    {
        return $this->title;
    }
}
