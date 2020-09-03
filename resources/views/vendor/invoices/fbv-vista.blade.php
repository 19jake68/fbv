<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Invoice #{{ $invoice->number }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link href="{{ asset('la-assets/css/bootstrap.v-3.3.7.min.css') }}" rel="stylesheet" type="text/css" />
        <style>
            html, body {
                font-family: sans-serif;
                font-size: 12px;
                line-height: 1.2;
                letter-spacing: 1px;
            }

            body {
                width: 98%;
                margin: auto;
            }

            .wrapper {
                outline: 1px solid black;
            }

            table {
                width: 100%;
                text-align: left;
            }

            td {
                padding: 5px;
                border: 1px solid #888;
            }

            .font-weight-bold {
                font-weight: bold
            }

        </style>
    </head>
    <body>
        <div class="wrapper">
            <table class="text-center">
                <tr>
                    <td colspan="4" class="font-weight-bold">JOB ORDER RECEIPT</td>
                    <td class="font-weight-bold">Invoice No: {{ $invoice->id }}</td>
                </tr>
                <tr>
                    <td colspan="5" class="font-weight-bold text-uppercase">{{ $invoice->business_details['name'] }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Meter #</td>
                    <td>{{ $invoice->number }}</td>
                    <td></td>
                    <td class="font-weight-bold">Date</td>
                    <td>{{ $invoice->dateDone }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Area</td>
                    <td>{{ $invoice->area }}</td>
                    <td></td>
                    <td class="font-weight-bold">Block</td>
                    <td>{{ $invoice->block }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Subdivision</td>
                    <td>{{ $invoice->subdivision }}</td>
                    <td></td>
                    <td class="font-weight-bold">Lot</td>
                    <td>{{ $invoice->lot }}</td>
                </tr>
            </table>
            <table style="margin-top:10px">
                <tr class="text-center">
                    <td style="width:10%" class="font-weight-bold">Qty</td>
                    <td style="width:10%" class="font-weight-bold">Unit</td>
                    <td style="width:40%" class="font-weight-bold">Activity (Items)</td>
                    <td style="width:15%" class="font-weight-bold">Amount</td>
                    <td style="width:25%" class="font-weight-bold">Remarks</td>
                </tr>

                @foreach ($invoice->groupedItems as $activity => $items)
                    <tr class="text-center">
                        <td colspan="5">{{ $activity }}</td>
                    </tr>
                    @foreach ($items as $item)
                    <tr class="text-center">
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->totalPrice }}</td>
                        <td>{{ $item->remarks }}</td>
                    </tr>
                    @endforeach
                @endforeach
                @if (!$invoice->miscs->isEmpty())
                <tr class="text-center">
                    <td colspan="5">Other Charges</td>
                </tr>
                @foreach ($invoice->miscs as $loop => $item)
                    <tr class="text-center">
                        <td>{{ $item->get('quantity') }}</td>
                        <td>{{ $item->get('unit') }}</td>
                        <td>{{ $item->get('activity') }}</td>
                        <td>{{ $invoice->currency }}{{ $item->get('amount') }}</td>
                        <td>{{ $item->get('remarks') }}</td>
                    </tr>
                @endforeach
                @endif
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>

                @if ($invoice->hasTax || $invoice->hasOTMultiplier)
                    <tr>
                        <td colspan="3" class="text-right">Subtotal</td>
                        <td class="text-center">{{ $invoice->currency }}{{ $invoice->subTotalPriceFormatted() }}</td>
                        <td></td>
                    </tr>

                    @if ($invoice->hasOTMultiplier)
                        <tr>
                            <td colspan="3" class="text-right">{{ $invoice->otMultiplierText }} OT</td>
                            <td class="text-center">{{ $invoice->currency }}{{ $invoice->otMultiAmountFormatted() }}</td>
                            <td></td>
                        </tr>
                    @endif


                    @if ($invoice->hasTax)
                        <tr>
                            <td colspan="3" class="text-right">Tax</td>
                            <td class="text-center">{{ $invoice->currency }}{{ $invoice->taxPriceFormatted() }}</td>
                            <td></td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="3" class="text-right font-weight-bold">Total Invoice</td>
                        <td class="text-center font-weight-bold">{{ $invoice->currency }}{{ $invoice->totalPriceFormatted() }}</td>
                        <td></td>
                    </tr>
                @else
                    <tr>
                        <td colspan="3" class="text-right font-weight-bold">Total Invoice</td>
                        <td class="text-center font-weight-bold">{{ $invoice->currency }}{{ $invoice->subTotalPriceFormatted() }}</td>
                        <td></td>
                    </tr>
                @endif
            <table>
            <table class="text-center">
                <tr>
                    <td class="font-weight-bold">J.O. Type</td>
                    <td>{{ $invoice->orderType }}
                    <td class="font-weight-bold">Billed by</td>
                    <td>{{ $invoice->biller_details['name'] }}</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>
                        <div style="min-height:100px">
                        Remarks: {{ $invoice->notes }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
