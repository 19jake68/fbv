<?php

namespace App\Helpers\FBV;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;

/**
 * This is the PDF class.
 */
class PDF
{
    /**
     * Generate the PDF.
     *
     * @method generate
     *
     * @param App\Helpers\FBV\Invoice  $invoice
     * @param string                          $template
     *
     * @return Dompdf\Dompdf
     */
    public static function generate(Invoice $invoice, $template = 'default')
    {
        $template = strtolower($template);

        $options = new Options();

        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        // $options->set('dpi', 300);
        $options->set('defaultFont', 'sans-serif');

        $pdf = new Dompdf($options);
        // $pdf->setPaper('A6');

        $context = stream_context_create([
            'ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false,
                'allow_self_signed'=> true,
            ],
        ]);

        $pdf->setHttpContext($context);

        $pdf->loadHtml(View::make('invoices::'.$template, ['invoice' => $invoice]));
        $pdf->render();

        return $pdf;
    }
}
