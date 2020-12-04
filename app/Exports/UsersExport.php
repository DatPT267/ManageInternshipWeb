<?php

namespace App\Exports;

use App\User;
use DateTime;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class UsersExport implements
    ShouldAutoSize,
    WithMapping,
    WithHeadings,
    // WithEvents
    FromQuery
    // WithDrawings,
    // WithCustomStartCell
    // WithTitle
{
    use Exportable;

    private $id;

   

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function query()
    {
        return  User::query()->where('class_id', $this->id);
        // return  User::where('class_id', $this->id)->get();
       
    }

    public function map($user): array
    {   
        
        return [
            $user->id,
            $user->name,
            $user->account,
            $user->email,
            $user->phone,
            $user->address,
          
        ];
    }

    public function headings(): array
    {
        return [
            'Id',
            'Name',
            'Account',
            'Email',
            'Phone',
            'Address',
        ];
    }

    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {
    //             $event->sheet->getStyle('A8:D8')->applyFromArray([
    //                 'font' => [
    //                     'bold' => true
    //                 ]
    //             ]);
    //         }
    //     ];
    // }

    // public function drawings()
    // {
    //     $drawing = new Drawing();
    //     $drawing->setName('Logo');
    //     $drawing->setDescription('This is my logo');
    //     $drawing->setPath(public_path('image/logo.png'));
    //     $drawing->setHeight(90);
    //     $drawing->setCoordinates('B2');

    //     return $drawing;
    // }

    // public function startCell(): string
    // {
    //     return 'A8';
    // }

    // public function title(): string
    // {
    //     return DateTime::createFromFormat('!m', $this->month)->format('F');
    // }
}