<?php

namespace App\Service;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpKernel\KernelInterface;

class ExcelService
{
    /**
     * @var KernelInterface
     */
    private $appKernel;

    public function __construct(KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel;
    }

    function getExcel ($users){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $column = 1;
        $row = 1;
        foreach ($users as $user){
            $sheet->setCellValueByColumnAndRow($column++,$row, $user->getId());
            $sheet->setCellValueByColumnAndRow($column++,$row, $user->getFullName());
            $sheet->setCellValueByColumnAndRow($column++,$row, $user->getUsername());
            $sheet->setCellValueByColumnAndRow($column++,$row, $user->getEmail());
            $sheet->setCellValueByColumnAndRow($column++,$row, $user->getPassword());
            $sheet->setCellValueByColumnAndRow($column++,$row, implode(",", $user->getRoles()));
            $row++;
            $column = 1;
        }
        $sheet->setTitle("users");
        $writer = new Xlsx($spreadsheet);
        $publicDirectory = $this->appKernel->getProjectDir() . '/public';
        $rand = rand(1, 1000);
        $filename ='excel'.$rand.'.xlsx';
        $excelFilepath =  $publicDirectory . '/'.$filename;
        $writer->save($excelFilepath);
        return $excelFilepath;
    }

}