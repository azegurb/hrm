

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>{{    $payment->userIdLastName. ' '
                .$payment->userIdFirstName.' '.
                 $payment->userIdPatronymic     }}</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 1.9em;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.item.last td {
            padding-top: 20px;
        }

        .invoice-box table tr.item.sum {
            font-weight: 900;
            font-size: 1.1em;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

    </style>
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title">
                            PORT OF BAKU
                        </td>
                        <td>
                            {{ getMonth($payment->userPaymentsIdMonth) }}, {{ $payment->userPaymentsIdYear }}<br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td>
                            "Test" QSC<br>
                            Ba?? direktor: DD<br>
                            Maliyy?? departamentinin m??diri: ZZZ
                        </td>

                        <td>
                            <b>
                                {{   $payment->userIdLastName. ' '
                                    .$payment->userIdFirstName.' '.
                                     $payment->userIdPatronymic    }}
                            </b>
                            <br>
                            {{ $position->structureIdName or '' }}<br>
                            {{ $position->posNameIdName or '' }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td>
                ???? g??nl??ri v?? saatlar??
            </td>

            <td>

            </td>
        </tr>

        <tr class="item">
            <td>
                ??mumi i?? g??nl??ri
            </td>

            <td>
                {{ $payment->userPaymentsIdWorkDayNorm or 0 }} g??n / {{ $payment->userPaymentsIdWorkDayHourNorm or 0 }} saat
            </td>
        </tr>

        <tr class="item">
            <td>
                ????l??diyi g??nl??r
            </td>

            <td>
                {{ $payment->userPaymentsIdWorkDayFact or 0 }} g??n / {{ $payment->userPaymentsIdWorkHourFact  or 0 }}  saat
            </td>
        </tr>

        <tr class="item">
            <td>
                Bayram g??nl??ri
            </td>

            <td>
                {{ $payment->userPaymentsIdWorkHollidayDay or 0 }} g??n / {{ $payment->userPaymentsIdWorkHollidayHour  or 0 }}  saat
            </td>
        </tr>

        <tr class="item">
            <td>
                Gec?? n??vb??si (ax??am)
            </td>

            <td>
                {{ $payment->userPaymentsIdWorkNightHour1  or 0 }}  saat
            </td>
        </tr>

        <tr class="item">
            <td>
                Gec?? n??vb??si (gec??)
            </td>

            <td>
                {{ $payment->userPaymentsIdWorkNightHour2  or 0 }}  saat
            </td>
        </tr>

        <tr class="item">
            <td>
                Gec?? n??vb??si (c??mi)
            </td>

            <td>
                {{ $payment->userPaymentsIdWorkNightHour  or 0 }}  saat
            </td>
        </tr>

        <tr class="heading">
            <td>
                ??d??ni??l??r
            </td>

            <td>

            </td>
        </tr>

        <tr class="item">
            <td>
                V??zif?? maa????
            </td>

            <td>
                {{ $payment->salary or 0}} AZN
            </td>
        </tr>

        <tr class="item">
            <td>
                G??z????t
            </td>

            <td>
                {{ $payment->privilegeSum or 0 }} AZN
            </td>
        </tr>

        <tr class="item">
            <td>
                ??lav?? ??m??k haqq??
            </td>

            <td>
                {{ $payment->addPaymentSum or 0 }} AZN
            </td>
        </tr>

        <tr class="item">
            <td>
                ??m??k ????raitin?? g??r?? ??lav?? ??m??k haqq??
            </td>

            <td>
                {{ $payment->laborConditionsSum or 0 }} AZN
            </td>
        </tr>

        <tr class="item">
            <td>
                Gec?? n??vb??sin?? g??r??
            </td>

            <td>
                {{ $payment->workNightHourSum or 0 }} AZN
            </td>
        </tr>

        <tr class="item">
            <td>
                Bayram g??nl??rin?? g??r??
            </td>

            <td>
                {{ $payment->workHollidaySum or 0 }} AZN
            </td>
        </tr>

        <tr class="item sum">
            <td>
                C??mi hesablan??b
            </td>

            <td>
                {{ $payment->endCalcSum or 0 }} AZN
            </td>
        </tr>

        <tr class="item">
            <td>
                Avans
            </td>

            <td>
                {{ $payment->avanceSum or 0}} AZN
            </td>
        </tr>

        <tr class="item">
            <td>
                DSMF
            </td>

            <td>
                {{ $payment->spfSum or 0 }} AZN
            </td>
        </tr>

        <tr class="item">
            <td>
                H??mkarlar ittifaq??
            </td>

            <td>
                {{ $payment->tradeUnionSum or 0 }} AZN
            </td>
        </tr>

        <tr class="item">
            <td>
                Vergi
            </td>

            <td>
                {{ $payment->taxSum or 0 }} AZN
            </td>
        </tr>

        <tr class="item sum">
            <td>
                C??mi tutulmu??dur
            </td>

            <td>
                {{ $payment->totalDeductSum or 0 }} AZN
            </td>
        </tr>

        <tr class="item last" style="font-weight: 900; font-size: 1.5em;">
            <td>
                {{ $payment->userPaymentsIdIsPaid ? '??d??nilib' : '??d??nilm??lidir' }}
            </td>

            <td>
                {{ $payment->totalPaymentSum or 0}} AZN
            </td>
        </tr>
    </table>
</div>
<script>

    /**
     * Open print menu on document ready
     */
    window.onload = function() {

        window.print();

    }

</script>
</body>
</html>
