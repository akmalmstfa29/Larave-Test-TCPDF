<?php

namespace App\Http\Controllers;

use DllumDnate\Http\Request;
use PDF;

class PrintController extends Controller
{
    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
    }

    public function index()
    {
        $this->pdf::setFooterCallback(function($pdfFooter){
            $pdfFooter->SetY(-20);
            $pdfFooter->SetX(-35);

            $img = $pdfFooter->ImageSVG(public_path('/img/AbstractSwimmer.svg'), 170, $pdfFooter->GetY()+2, 35);

            $pdfFooter->Cell(0, 10, $img, 0, false, 'C', 0, '', 0, false, 'T', 'M');
        });
        $this->pdf::SetTitle("TCPDF Test");
        $this->pdf::AddPage();

        //second page
        $view = \View::make('second-page');
        $html_content = $view->render();
        $this->pdf::AddPage();
        $this->pdf::SetPrintFooter(false);
        $this->pdf::writeHTML($html_content, true, false, true, false, '');
        $this->pdf::Output('tcpdf.pdf', 'I');  
    }
}
