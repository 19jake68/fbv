<?php

namespace App\Helpers\FBV;

use Carbon\Carbon;
use App\Helpers\FBV\Setters;
use Illuminate\Support\Collection;
use Storage;

/**
 * This is the Invoice class.
 */
class Invoice
{
    use Setters;

    /**
     * Invoice ID.
     * 
     * @var integer
     */
    public $id;

    /**
     * Order Type
     * 
     * @var string
     */
    public $orderType;

    /**
     * Invoice name.
     *
     * @var string
     */
    public $name;

    /**
     * Invoice item collection.
     *
     * @var Illuminate\Support\Collection
     */
    public $items;

    /**
     * Invoice grouped item collection
     */
    public $groupedItems;

    /**
     * Invoice misc collection.
     *
     * @var Illuminate\Support\Collection
     */
    public $miscs;

    /**
     * Invoice currency.
     *
     * @var string
     */
    public $currency;

    /**
     * Invoice has tax.
     * 
     * @var boolean
     */
    public $hasTax;

    /**
     * Display tax
     */
    public $displayTax;

    /**
     * Invoice tax.
     *
     * @var int
     */
    public $tax;

    /**
     * Invoice tax type.
     *
     * @var string
     */
    public $tax_type;

    /**
     * Invoice Tax Amount
     */
    public $taxAmount;

    /**
     * Invoice subtotal (total - tax amount)
     */
    public $subtotal;

    /**
     * Invoice number.
     *
     * @var int
     */
    public $number = null;

    /**
     * Area name
     * 
     * @var string
     */
    public $area = null;

    /**
     * Invoice decimal precision.
     *
     * @var int
     */
    public $decimals;

    /**
     * Invoice logo.
     *
     * @var string
     */
    public $logo;

    /**
     * Invoice Logo Height.
     *
     * @var int
     */
    public $logo_height;

    /**
     * Invoice Date.
     *
     * @var Carbon\Carbon
     */
    public $date;

    /**
     * Invoice Notes.
     *
     * @var string
     */
    public $notes;

    /**
     * Invoice Business Details.
     *
     * @var array
     */
    public $business_details;

    /**
     * Invoice Customer Details.
     *
     * @var array
     */
    public $customer_details;

    /**
     * Invoice biller
     * 
     * @var array
     */
    public $biller_details;

    /**
     * Invoice Footnote.
     *
     * @var array
     */
    public $footnote;

    /**
     * Invoice Template
     * 
     * @var string
     */
    public $template = 'default';

    /**
     * Date done
     * 
     * @var Date
     */
    public $dateDone;

    /**
     * timeStart
     * 
     * @var Date
     */
    public $timeStart;

    /**
     * timeEnd
     * 
     * @var Date
     */
    public $timeEnd;

    /**
     * totalInvoice
     * 
     * @var Integer
     */
    public $totalInvoice;

    /**
     * Stores the PDF object.
     *
     * @var Dompdf\Dompdf
     */
    private $pdf;

    /**
     * Create a new invoice instance.
     *
     * @method __construct
     *
     * @param string $name
     */
    public function __construct($name = 'Invoice')
    {
        $this->name = $name;
        $this->items = Collection::make([]);
        $this->miscs = Collection::make([]);
        $this->currency = config('invoices.currency');
        $this->tax = config('invoices.tax');
        $this->tax_type = config('invoices.tax_type');
        $this->decimals = config('invoices.decimals');
        $this->logo = config('invoices.logo');
        $this->logo_height = config('invoices.logo_height');
        $this->business_details = Collection::make(config('invoices.business_details'));
        $this->customer_details = Collection::make([]);
        $this->biller_details = Collection::make([]);
        $this->footnote = config('invoices.footnote');
        $this->totalInvoice = 0;
    }

    /**
     * Return a new instance of Invoice.
     *
     * @method make
     *
     * @param string $name
     *
     * @return App\Helpers\FBV\Invoice
     */
    public static function make($name = 'Invoice')
    {
        return new self($name);
    }

    /**
     * Adds an item to the invoice.
     *
     * @method addItem
     *
     * @param string $name
     * @param int    $price
     * @param int    $ammount
     * @param string $id
     *
     * @return self
     */
    public function addItem($name, $price, $ammount = 1, $id = '-', $measurement = '', $unit = '')
    {
        $this->items->push(Collection::make([
            'name'        => $name,
            'price'       => $price,
            'ammount'     => $ammount,
            'totalPrice'  => number_format(bcmul($price, $ammount, $this->decimals), $this->decimals),
            'id'          => $id,
            'measurement' => $measurement,
            'unit'        => $unit
        ]));

        return $this;
    }

    /**
     * Add Grouped Items to the invoice
     */
    public function addGroupedItems($groupedItems)
    {
        $this->groupedItems = Collection::make($groupedItems);
    }

    /**
     * Adds other chargers to the invoice.
     *
     * @method addMisc
     *
     * @param string $activity
     * @param int    $quantity
     * @param string $unit
     * @param int    $amount
     * @param string $id
     *
     * @return self
     */
    public function addMisc($activity, $quantity, $unit, $amount, $remarks, $hasTax, $tax)
    {
        $this->miscs->push(Collection::make([
            'activity'    => $activity,
            'quantity'    => $quantity,
            'unit'        => $unit,
            'amount'      => number_format($hasTax ? $this->_calcTax($amount, $tax) : $amount, $this->decimals),
            'remarks'     => $remarks
        ]));

        return $this;
    }

    /**
     * Pop the last invoice item.
     *
     * @method popItem
     *
     * @return self
     */
    public function popItem()
    {
        $this->items->pop();

        return $this;
    }

    /**
     * Pop the last invoice misc.
     *
     * @method popMisc
     *
     * @return self
     */
    public function popMisc()
    {
        $this->miscs->pop();

        return $this;
    }

    /**
     * Return the currency object.
     *
     * @method formatCurrency
     *
     * @return stdClass
     */
    public function formatCurrency()
    {
        $currencies = json_decode(file_get_contents(__DIR__.'/../Currencies.json'));
        $currency = $this->currency;

        return $currencies->$currency;
    }

    /**
     * Return the subtotal invoice price.
     *
     * @method subTotalPrice
     *
     * @return int
     */
    private function subTotalPrice()
    {
        return $this->subtotal;
        // return preg_replace("/([^0-9\\.])/i", "", $this->totalInvoice);
        // return $this->items->sum(function ($item) {
        //     return bcmul($item['price'], $item['ammount'], $this->decimals);
        // });
    }

    /**
     * Return formatted sub total price.
     *
     * @method subTotalPriceFormatted
     *
     * @return int
     */
    public function subTotalPriceFormatted()
    {
        return number_format($this->subTotalPrice(), $this->decimals);
    }

    /**
     * Return the total invoce price after aplying the tax.
     *
     * @method totalPrice
     *
     * @return int
     */
    private function totalPrice()
    {
        return $this->subtotalPrice() + $this->taxPrice();
        // return bcadd($this->subTotalPrice(), $this->taxPrice(), $this->decimals);
    }

    /**
     * Total Invoice
     * 
     * @method totalInvoice
     * 
     * @return self
     */
    public function totalInvoice($totalInvoice) {
        $this->totalInvoice = number_format($totalInvoice, $this->decimals);

        return $this;
    }

    /**
     * Return formatted total price.
     *
     * @method totalPriceFormatted
     *
     * @return int
     */
    public function totalPriceFormatted()
    {
        return number_format($this->totalPrice(), $this->decimals);
    }

    /**
     * taxPrice.
     *
     * @method taxPrice
     *
     * @return float
     */
    private function taxPrice()
    {
        return $this->taxAmount;
        // if ($this->tax_type == 'percentage') {
            // return $this->subTotalPrice() * ($this->tax / 100);
            // return bcdiv(bcmul($this->tax, $this->subTotalPrice(), $this->decimals), 100, $this->decimals);
        // }

        // return $this->tax;
    }

    /**
     * Return formatted tax.
     *
     * @method taxPriceFormatted
     *
     * @return int
     */
    public function taxPriceFormatted()
    {
        return number_format($this->taxPrice(), $this->decimals);
    }

    /**
     * Generate the PDF.
     *
     * @method generate
     *
     * @return self
     */
    private function generate()
    {
        $this->pdf = PDF::generate($this, $this->template);

        return $this;
    }

    /**
     * Downloads the generated PDF.
     *
     * @method download
     *
     * @param string $name
     *
     * @return response
     */
    public function download($name = 'invoice')
    {
        $this->generate();

        return $this->pdf->stream($name);
    }

    /**
     * Save the generated PDF.
     *
     * @method save
     *
     * @param string $name
     *
     */
    public function save($name = 'invoice.pdf')
    {
        $invoice = $this->generate();

        Storage::put($name, $invoice->pdf->output());
    }

    /**
     * Show the PDF in the browser.
     *
     * @method show
     *
     * @param string $name
     *
     * @return response
     */
    public function show($name = 'invoice')
    {
        $this->generate();

        return $this->pdf->stream($name, ['Attachment' => false]);
    }

    /**
   * Calculate Tax
   */
  private function _calcTax($amount, $tax)
  {
    return ($amount * ($tax + 100)) / 100;
  }
}
