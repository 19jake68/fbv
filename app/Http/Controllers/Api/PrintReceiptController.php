<?php

namespace App\Http\Controllers\Api;

use Smalot\Cups\Builder\Builder;
use Smalot\Cups\Manager\PrinterManager;
use Smalot\Cups\Transport\Client;
use Smalot\Cups\Transport\ResponseParser;
use Smalot\Cups\Manager\JobManager;
use Smalot\Cups\Model\Job;
use App\Http\Controllers\Controller;
use App\Models\Order;

class PrintReceiptController extends Controller 
{
    public function index(Order $order)
    {
        $receipt = $this->createReceipt([
            'invoice_number' => $order->id,
            'company_name' => $order->company,
            'job_order_number' => $order->job_number,
            'area' => $order->area->name,
            'account_name' => $order->account_name,
        ]);

        $this->print($receipt);
    }

    private function createReceipt($dictionary = [])
    {
        $template = "Job Order Receipt----------------------------------------
-----------------                                                                        
INVOICE NO: :invoice_number:
:company_name:
JOB ORDER NO: :job_order_number:
AREA: :area:

ADDRESSED TO: :account_name:
";

        foreach($dictionary as $search => $replace) {
            $search = ":{$search}:";

            $template = str_replace($search, $replace, $template);
        }

        return $template;
    }

    private function print($text)
    {
        $client = new Client('laquisumbing', 'apple');
        $builder = new Builder();
        $responseParser = new ResponseParser();

        $printerManager = new PrinterManager($builder, $client, $responseParser);
        $printer = $printerManager->findByUri('ipp://localhost:631/printers/Printer_58_USB_Printing_Support');

        $jobManager = new JobManager($builder, $client, $responseParser);

        $job = new Job();
        $job->setName('asdfsadfsadfsdafsadfas');
        $job->setUsername('laquisumbing');
        // $job->addAttribute('size', '12');
        // $job->setCopies(1);
        $job->setPageRanges('1');
        $job->addText($text);
        // $job->addAttribute('media', 'Custom.58x500mm');
        // $job->addAttribute('fit-to-page', true);
        // $job->addAttribute('cpi', 2);
        $result = $jobManager->send($printer, $job);
    }
}