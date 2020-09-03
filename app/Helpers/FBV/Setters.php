<?php

namespace App\Helpers\FBV;

use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * This is the Setters trait.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
trait Setters
{
    /**
     * Set the invoice id
     *
     * @method id
     *
     * @param integer $id
     *
     * @return self
     */
    public function id($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set the invoice name.
     *
     * @method name
     *
     * @param string $name
     *
     * @return self
     */
    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the invoice number.
     *
     * @method number
     *
     * @param int $number
     *
     * @return self
     */
    public function number($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Set the invoice decimal precision.
     *
     * @method decimals
     *
     * @param int $decimals
     *
     * @return self
     */
    public function decimals($decimals)
    {
        $this->decimals = $decimals;

        return $this;
    }

    /**
     * Set the invoice tax.
     *
     * @method tax
     *
     * @param float $tax
     *
     * @return self
     */
    public function tax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Set the invoice tax type.
     *
     * @method taxType
     *
     * @param string $tax_type
     *
     * @return self
     */
    public function taxType($tax_type)
    {
        $this->tax_type = $tax_type;

        return $this;
    }

    /**
     * Set the invoice logo URL.
     *
     * @method logo
     *
     * @param string $logo_url
     *
     * @return self
     */
    public function logo($logo_url)
    {
        $this->logo = $logo_url;

        return $this;
    }

    /**
     * Set the invoice date.
     *
     * @method date
     *
     * @param Carbon $date
     *
     * @return self
     */
    public function date(Carbon $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Set the invoice notes.
     *
     * @method notes
     *
     * @param string $notes
     *
     * @return self
     */
    public function notes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Set the invoice business details.
     *
     * @method business
     *
     * @param array $details
     *
     * @return self
     */
    public function business($details)
    {
        $this->business_details = Collection::make($details);

        return $this;
    }

    /**
     * Set the invoice biller details
     *
     * @method biller
     *
     * @param array $details
     *
     * @return self
     */
    public function biller($details)
    {
        $this->biller_details = Collection::make($details);

        return $this;
    }

    /**
     * Set the invoice customer details.
     *
     * @method customer
     *
     * @param array $details
     *
     * @return self
     */
    public function customer($details)
    {
        $this->customer_details = Collection::make($details);

        return $this;
    }

    /**
     * Set the invoice currency.
     *
     * @method currency
     *
     * @param string $currency
     *
     * @return self
     */
    public function currency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Set the invoice footnote.
     *
     * @method footnote
     *
     * @param string $footnote
     *
     * @return self
     */
    public function footnote($footnote)
    {
        $this->footnote = $footnote;

        return $this;
    }

    /**
     * Set template
     *
     * @method setTemplate
     *
     * @param string $template
     *
     * @return self
     */
    public function template($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Set area
     *
     * @method area
     *
     * @return self
     */
    public function area($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Set date done
     *
     * @method datedone
     *
     * @return self
     */
    public function dateDone($dateDone)
    {
        $this->dateDone = $dateDone;

        return $this;
    }

    /**
     * Set time start
     *
     * @method timeStart
     *
     * @return self
     */
    public function timeStart($timeStart)
    {
        $this->timeStart = $timeStart;

        return $this;
    }

    /**
     * Set area
     *
     * @method timeEnd
     *
     * @return self
     */
    public function timeEnd($timeEnd)
    {
        $this->timeEnd = $timeEnd;

        return $this;
    }

    /**
     * Set Order Type
     *
     * @method orderType
     *
     * @return self
     */
    public function orderType($orderType)
    {
        $this->orderType = $orderType;

        return $this;
    }

    /**
     * Set Has Tax
     *
     * @method hasTax
     *
     * @param array $hasTax
     *
     * @return self
     */
    public function hasTax($hasTax)
    {
        $this->hasTax = $hasTax;
        return $this;
    }

    /**
     * Set tax display
     *
     * @method displayTax
     *
     * @param array $displayTax
     *
     * @return self
     */
    public function displayTax($displayTax)
    {
        $this->displayTax = $displayTax;
        return $this;
    }

    /**
     * Set Subtotal (Total - Tax Amount)
     *
     * @method subtotal
     *
     * @param array $subtotal
     *
     * @return self
     */
    public function subtotal($subtotal)
    {
        $this->subtotal = $subtotal;
        return $this;
    }

    /**
     * Set Tax Amount
     *
     * @method taxAmount
     *
     * @param array $taxAmount
     *
     * @return self
     */
    public function taxAmount($taxAmount)
    {
        $this->taxAmount = $taxAmount;
        return $this;
    }

    /**
     * Set OT Multipler checker
     *
     * @method hasOTMultiplier
     *
     * @param array $hasOTMultiplier
     *
     * @return self
     */
    public function hasOTMultiplier($hasOTMultiplier)
    {
        $this->hasOTMultiplier = $hasOTMultiplier;
        return $this;
    }

    /**
     * Set OT Multiplier Text
     *
     * @method otMultiplierText
     *
     * @param array $otMultiplierText
     *
     * @return self
     */
    public function otMultiplierText($otMultiplierText)
    {
        $this->otMultiplierText = $otMultiplierText;
        return $this;
    }

    /**
     * Set OT Multiplier Amount
     *
     * @method otMultiplierAmount
     *
     * @param array $otMultiplierAmount
     *
     * @return self
     */
    public function otMultiplierAmount($otMultiplierAmount)
    {
        $this->otMultiplierAmount = $otMultiplierAmount;
        return $this;
    }

    /**
     * Set OT Multiplier Tax Amount
     *
     * @method otMultiplierTax
     *
     * @param array $otMultiplierTax
     *
     * @return self
     */
    public function otMultiplierTax($otMultiplierTax)
    {
        $this->otMultiplierTax = $otMultiplierTax;
        return $this;
    }

    /**
     * Vista - Subdivision
     *
     * @method subdivision
     *
     * @param array $subdivision
     *
     * @return self
     */
    public function subdivision($subdivision)
    {
        $this->subdivision = $subdivision;
        return $this;
    }

    /**
     * Vista - Block
     *
     * @method block
     *
     * @param array $block
     *
     * @return self
     */
    public function block($block)
    {
        $this->block = $block;
        return $this;
    }

    /**
     * Vista - Lot
     *
     * @method lot
     *
     * @param array $lot
     *
     * @return self
     */
    public function lot($lot)
    {
        $this->lot = $lot;
        return $this;
    }
}
