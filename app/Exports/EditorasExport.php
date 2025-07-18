<?php

namespace App\Exports;

use App\Models\Editora; // Mudança aqui
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class EditorasExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithColumnWidths, WithStyles
{
    protected $ids;

    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        // Lógica de busca adaptada para Editora
        if (!empty($this->ids)) {
            return Editora::whereIn('id', $this->ids)->orderBy('nome')->get();
        }
        return Editora::orderBy('nome')->get();
    }

    public function headings(): array
    {
        // Cabeçalhos adaptados para Editora
        return [
            'Nome da Editora',
            'Data de Inserção',
            'Modificado em',
        ];
    }

    public function map($editora): array
    {
        // Mapeamento adaptado para Editora
        return [
            $editora->nome,
            $editora->created_at,
            $editora->updated_at,
        ];
    }

    public function columnFormats(): array
    {
        // A formatação de data é a mesma
        return [
            'B' => 'dd/mm/yyyy hh:mm:ss',
            'C' => 'dd/mm/yyyy hh:mm:ss',
        ];
    }

    public function columnWidths(): array
    {
        // A largura das colunas é a mesma
        return [
            'A' => 22.30,
            'B' => 22.30,
            'C' => 22.30,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // A lógica de estilo é idêntica
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('1')->getFill()
              ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
              ->getStartColor()->setARGB('E2E8F0');

        $styleArray = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'DDDDDD'],
                ],
            ],
        ];

        $sheet->getStyle($sheet->calculateWorksheetDataDimension())->applyFromArray($styleArray);
    }
}