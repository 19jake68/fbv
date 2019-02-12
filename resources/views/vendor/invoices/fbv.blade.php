<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{{ $invoice->name }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style>
            h1,h2,h3,h4,p,span,div { font-family: DejaVu Sans; sans-serif; }

            .wrapper {
                outline: 1px solid black;
            }

            table {
                width: 100%;
                text-align: center;
            }

            td {
                padding-bottom: 2px;
                border: 1px solid #888;
            }

            .font-weight-bold {
                font-weight: bold
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <table>
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
                    <td class="font-weight-bold">Date Done</td>
                    <td>{{ $invoice->dateDone }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Account Name</td>
                    <td>{{ $invoice->customer_details['name'] }}</td>
                    <td></td>
                    <td class="font-weight-bold">Time Started</td>
                    <td>{{ $invoice->timeStart }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Area</td>
                    <td>{{ $invoice->area }}</td>
                    <td></td>
                    <td class="font-weight-bold">Time Ended</td>
                    <td>{{ $invoice->timeEnd }}</td>
                </tr>
            </table>
            <table style="margin-top:10px">
                <tr>
                    <td class="font-weight-bold">Qty</td>
                    <td class="font-weight-bold">Unit</td>
                    <td class="font-weight-bold">Activity</td>
                    <td class="font-weight-bold">Amount</td>
                </tr>
                @foreach ($invoice->items as $loop => $item)
                    <tr>
                        <td>{{ $item->get('ammount') }}</td>
                        <td>{{ $item->get('unit') }}</td>
                        <td>{{ $item->get('name') }}</td>
                        <td>{{ $invoice->currency }}{{ $item->get('totalPrice') }}</td>
                    </tr>
                @endforeach
                @if (!$invoice->miscs->isEmpty())
                <tr>
                    <td colspan="4" style="text-align:left;padding-left:5px">Other Charges:</td>
                </tr>
                @foreach ($invoice->miscs as $loop => $item)
                    <tr>
                        <td>{{ $item->get('quantity') }}</td>
                        <td>{{ $item->get('unit') }}</td>
                        <td>{{ $item->get('activity') }}</td>
                        <td>{{ $invoice->currency }}{{ $item->get('amount') }}</td>
                    </tr>
                @endforeach
                @endif
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right" style="padding-right:5px">Total Invoice</td>
                    <td>{{ $invoice->currency }}{{ $invoice->totalInvoice }}</td>
                </tr>
            <table>
            <table>
                <tr>
                    <td>J.O. Type</td>
                    <td>{{ $invoice->orderType }}
                    <td>Billed by</td>
                    <td>{{ $invoice->biller_details['name'] }}<br>{{ $invoice->biller_details['email'] }}</td>
                </tr>
            </table>
        </div>
    </body>
</html>
