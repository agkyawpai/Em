<?php

namespace App\Logics;

use Carbon\Carbon;
use Mpdf\Mpdf;

class PdfGenerator
{
    /**
     * Generate PDF for the employee list.
     * @author AungKyawPaing
     * @create 22/06/2023
     * This method generates a PDF containing the employee list.
     *
     * @param  array  $employees  The array of employees
     * @return void
     */
    public static function generateEmployeeListPDF($employees, $emp_programming)
    {
        $pdf = new Mpdf(['format' => 'A2']);
        // Generate the PDF content
        $content = self::generatePDFContent($employees, $emp_programming);

        // Write the content to the PDF
        $pdf->WriteHTML($content);

        // Output the PDF for download or save it to a file
        $pdf->Output(uniqid() . 'employee_list.pdf', 'D');
    }

    private static function generatePDFContent($employees, $emp_programming)
    {
        // Generate the content of the PDF using the provided data
        $content = '<h1>Employee List</h1>';
        $content .= '<style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            color: blue;
        }
        p {
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>';
        $content .= '<table>';
        $content .= '<tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>NRC</th>
                        <th>Email</th>
                        <th>Date of Birth</th>
                        <th>Address</th>
                        <th>Programming Languages</th>
                        <th>Language</th>
                        <th>Career</th>
                        <th>Level</th>
                    </tr>';

        // Add table rows with employee data
        foreach ($employees as $employee) {
            $content .= '<tr>';
            $content .= '<td style = "text-align: center">' . $employee->employee_id . '</td>';
            $content .= '<td style = "text-align: center">' . $employee->name . '</td>';
            $content .= '<td style = "text-align: center">' . $employee->phone . '</td>';
            $content .= '<td style = "text-align: center">' . $employee->nrc . '</td>';
            $content .= '<td style = "text-align: center">' . $employee->email . '</td>';
            $content .= '<td style = "text-align: center">' . Carbon::parse($employee->date_of_birth)->format('d/m/Y') . '</td>';
            $content .= '<td style = "text-align: center">' . $employee->address . '</td>';
            $content .= '<td style = "text-align: center">' . EmployeeLogic::getProgrammingLanguages($emp_programming, $employee->id) . '</td>';
            $content .= '<td style = "text-align: center">' . EmployeeLogic::getLanguagesName($employee->language) . '</td>';
            $content .= '<td style = "text-align: center">' . EmployeeLogic::getCareerName($employee->career_path) . '</td>';
            $content .= '<td style = "text-align: center">' . EmployeeLogic::getLevelName($employee->level) . '</td>';
            $content .= '</tr>';
        }

        $content .= '</table>';

        return $content;
    }
}
