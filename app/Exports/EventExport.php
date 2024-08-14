<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing;


class EventExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    use Exportable;

    protected $events;

    public function __construct($events)
    {
        $this->events = $events;
    }

    public function collection()
    {
        return $this->events;
    }

    public function headings(): array
    {
        return [
            [
                hasRole('admin') ? user()->federation()?->name : 'Etkinlikler'
            ],
            [
                'Kullanıcı',
                'Başlık',
                'Açıklama',
                'Yer',
                'Başlangıç',
                'Bitiş',
                'Uluslar Arası',
                'Durum',
                'Kafile',
                'Not',
            ]
        ];
    }

    public function map($row): array
    {
        $groups = 'Hayır, Yok';
        if ($row->groups()->count()) {
            $peoples = [];
            foreach ($row->groups as $group) {
                $peoples[] = sprintf('(%s) %s', $group->people?->type?->title(), $group->people?->fullname);
            }

            $groups = implode(', ', $peoples);
        }

        return [
            $row->user?->username . ' ' . $row->user?->name,
            $row->title,
            $row->content,
            $row->location,
            $row->start_date,
            $row->end_date,
            $row->is_national ? 'Evet' : 'Hayır',
            $row->status,
            $groups,
            $row->end_notes,
        ];
    }

    public function drawings()
    {
        $drawing = new HeaderFooterDrawing();

        if ($federation = user()?->federation()) {
            $drawing->setName($federation->name);

            if (file_exists(public_path($federation->logo))) {
                $logo = public_path($federation->logo);
            } else {
                $logo = public_path('uploads/no-img.png');
            }

            $drawing->setPath($logo);
            $drawing->setHeight(100);
            $drawing->setCoordinates('A1');
        }

        return $drawing;
    }
}
