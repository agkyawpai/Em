<?php

namespace App\Exports;

use App\Logics\EmployeeLogic;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeeExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithTitle
{
    protected $employees;
    protected $emp_programming;

    public function __construct($employees, $emp_programming)
    {
        $this->employees = $employees;
        $this->emp_programming = $emp_programming;
    }

    public function title(): string
    {
        return 'Employee List';
    }

    /**
     * Define the data to be exported.
     * @author AungKyawPaing
     * @create 22/06/2023
     * @return \Illuminate\Support\Collection  The collection of employee data
     */
    public function collection()
    {
        $genders = [
            1 => 'Male',
            2 => 'Female'
        ];

        $languages = [
            1 => 'English',
            2 => 'Japanese'
        ];

        $careerPaths = [
            1 => 'Front End',
            2 => 'Back End',
            3 => 'Full Stack',
            4 => 'Mobile',
        ];

        $levels = [
            1 => 'Beginner',
            2 => 'Junior Engineer',
            3 => 'Engineer',
            4 => 'Senior Engineer',
        ];

        // Map the employee data and format it according to the defined mappings to show it in excel data.
        $employees = $this->employees->map(function ($employee) use ($genders, $languages, $careerPaths, $levels) {
            $employeeLanguages = explode(',', $employee->language);
            $languageNames = [];
            foreach ($employeeLanguages as $lang) {
                $languageNames[] = $languages[$lang] ?? '';
            }
            return [
                'Employee ID' => $employee->employee_id,
                'Name' => $employee->name,
                'NRC' => $employee->nrc,
                'Phone' => $employee->phone,
                'Email' => $employee->email,
                'Gender' => $genders[$employee->gender] ?? '',
                'Date of Birth' => Carbon::parse($employee->date_of_birth)->format('d/m/Y'),
                'Address' => $employee->address,
                'Programming Languages' => EmployeeLogic::getProgrammingLanguages($this->emp_programming, $employee->id),
                'Language' => implode(', ', $languageNames),
                'Career Path' => $careerPaths[$employee->career_path] ?? '',
                'Level' => $levels[$employee->level] ?? '',
            ];
        });

        return collect($employees);
    }

    /**
     * Define the headings for the exported data.
     * @author AungKyawPaing
     * @create 22/06/2023
     * @return array  The array of headings
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'NRC',
            'Phone',
            'Email',
            'Gender',
            'Date of Birth',
            'Address',
            'Programming Languages',
            'Language',
            'Career',
            'Level',
        ];
    }

    /**
     * Apply styles to the sheet.
     *
     * @param Worksheet $sheet
     *
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:L1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 14 //set font size and bold to the heading row
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '6495ED', // set the background color of the heading row
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ]

        ]);
        // Get the last row index
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A2:L'.$lastRow)->applyFromArray([
            'font' => [
                'size' => 10, // Set the font size of the data rows to 12
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'FFFFFF', // set the background color of the heading row
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ]
        ]);

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
