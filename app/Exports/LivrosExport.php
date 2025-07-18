<?php

namespace App\Exports;

use App\Models\Livro;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LivrosExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithColumnWidths, WithStyles
{
    protected $ids;

    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        if (!empty($this->ids)) {
            return Livro::with('editora', 'autores')->whereIn('id', $this->ids)->get();
        }
        return Livro::with('editora', 'autores')->get();
    }

    public function headings(): array
    {
        return ['ISBN', 'Nome do Livro', 'Editora', 'Autores', 'Preço', 'Bibliografia'];
    }

    public function map($livro): array
    {
        return [
            "'" . $livro->isbn,
            $livro->nome,
            $livro->editora->nome,
            $livro->autores->pluck('nome')->join(', '),
            (float) $livro->preco,
            $livro->bibliografia,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'E' => '€#,##0.00',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 18.29, 'B' => 53.14, 'C' => 14.71,
            'D' => 20.71, 'E' => 8.43,  'F' => 55.43,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // 1. Estilo para a linha do cabeçalho
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getRowDimension('1')->setRowHeight(30.00);

        // 2. Estilo padrão para todas as células
        $styleArray = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];
        $sheet->getStyle($sheet->calculateWorksheetDataDimension())->applyFromArray($styleArray);

        // ================================================================
        // NOVA ADIÇÃO: DEFINIR A ALTURA DAS LINHAS DE DADOS
        // ================================================================
        // Itera sobre todas as linhas a partir da linha 2 (após o cabeçalho)
        foreach ($sheet->getRowIterator(2) as $row) {
            $sheet->getRowDimension($row->getRowIndex())->setRowHeight(53.00);
        }
    }
}