<?php

namespace App\Exports;

use App\Models\Autor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths; // Para larguras
use Maatwebsite\Excel\Concerns\WithStyles;         // Para estilos
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;   // Para manipular a folha
use PhpOffice\PhpSpreadsheet\Style\Alignment;     // Para alinhamento

class AutoresExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithColumnWidths, WithStyles
{
    protected $ids;

    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        if (!empty($this->ids)) {
            return Autor::whereIn('id', $this->ids)->orderBy('nome')->get();
        }
        return Autor::orderBy('nome')->get();
    }

    public function headings(): array
    {
        return [
            'Nome do Autor',
            'Data de Inserção',
            'Modificado em',
        ];
    }

    public function map($autor): array
    {
        return [
            $autor->nome,
            $autor->created_at,
            $autor->updated_at,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => 'dd/mm/yyyy hh:mm:ss',
            'C' => 'dd/mm/yyyy hh:mm:ss',
        ];
    }

    /**
     * Define a largura de cada coluna.
     */
    public function columnWidths(): array
    {
        return [
            'A' => 22.30,
            'B' => 22.30,
            'C' => 22.30,
        ];
    }

    /**
     * Aplica estilos à folha de cálculo.
     */
    public function styles(Worksheet $sheet)
    {
        // 1. Estilo para a linha do cabeçalho (Linha 1)
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('1')->getFill()
              ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
              ->getStartColor()->setARGB('E2E8F0'); // Cor de fundo cinzento claro

        // 2. Estilo para todo o conteúdo da tabela
        $styleArray = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true, // Permite que a altura da linha aumente
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'DDDDDD'],
                ],
            ],
        ];

        // Aplica o estilo a todas as células com dados
        $sheet->getStyle($sheet->calculateWorksheetDataDimension())->applyFromArray($styleArray);
    }
}