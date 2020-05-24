<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{{ $invoice->name }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- <link href="{{ asset('la-assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css" /> -->
        <style>
            body { font-size: 10px }
            h1,h2,h3,h4,p,span,div { font-family: DejaVu Sans; sans-serif; }

            .wrapper {
                outline: 1px solid black;
            }

            table {
                width: 100%;
                text-align: left;
            }

            td {
                padding: auto 5px;
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
                    <td class="font-weight-bold">J.O. #</td>
                    <td>{{ $invoice->number }}</td>
                    <td></td>
                    <td class="font-weight-bold">Date</td>
                    <td>{{ $invoice->dateDone }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Account Name</td>
                    <td>{{ $invoice->customer_details['name'] }}</td>
                    <td></td>
                    <td class="font-weight-bold">Started</td>
                    <td>{{ $invoice->timeStart }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Area</td>
                    <td>{{ $invoice->area }}</td>
                    <td></td>
                    <td class="font-weight-bold">Ended</td>
                    <td>{{ $invoice->timeEnd }}</td>
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

                @if ($invoice->hasTax)
                    @if ($invoice->displayTax)
                        <tr>
                            <td colspan="3" class="text-right">Subtotal</td>
                            <td class="text-center">{{ $invoice->currency }}{{ $invoice->subTotalPriceFormatted() }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right">Tax ({{ $invoice->tax }}%)</td>
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
            <table>
                <tr>
                    <td class="font-weight-bold">J.O. Type</td>
                    <td>{{ $invoice->orderType }}
                    <td class="font-weight-bold">Billed by</td>
                    <td>{{ $invoice->biller_details['name'] }}<br>{{ $invoice->biller_details['email'] }}</td>
                </tr>
            </table>
            <div style="min-height:500px;display:block;font-size:10px;margin:5px;">Remarks: {{ $invoice->notes }}</div>
        </div>
    </body>
</html>
