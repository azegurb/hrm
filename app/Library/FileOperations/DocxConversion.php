<?php
namespace App\Library\FileOperations;

use App\Http\Controllers\Orders\OrderController;
use App\Http\Controllers\Orders\UserPositionController;
use App\Library\Service\Service;

class DocxConversion
{
    /**
     * @param $fileData
     * @param null $label
     * @return string
     */

    public function makeFile($fileData, $label=null){

        /* if custom label is set then use $label as method name else just use order label */


        $method = $label != null ? $label : isset($fileData->orderTypeLabel)?$fileData->orderTypeLabel:$fileData->fields->orderTypeLabel;

        $data = $this->$method($fileData);
//        dd($method);
        //starting html tag
        $doc = '<html>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <body>
                    '.$data.'
                </body>
                </html>';
        return $doc;
    }

    /**
     * @param $fileData
     * @return string
     */




    public function orderTransfer($fileData)
    {
        $addSalary = 0;

        $positionPayment = $fileData->appointment[0]->positionPayment;

        if($fileData->appointment[0]->valueSum != null) {

            if($fileData->appointment[0]->isPercent == true) {

                $addSalary = ($positionPayment/100)*$fileData->appointment[0]->valueSum;

            } elseif($fileData->appointment[0]->isPercent == false) {

                $addSalary = $fileData->appointment[0]->valueSum;

            }
        }

        $conditionalPayment = ($positionPayment * $fileData->appointment[0]->conditionalPayment) / 100;

        $totalSalaryAppointment = $positionPayment + $addSalary + $conditionalPayment;

        // Gather Employees in one place
        $employee = '';
        if($fileData->appointment[0]->trialPeriodMonth != null){
            $trialPeriodMonth = $fileData->appointment[0]->trialPeriodMonth.' ay';
        }
        else{
            $trialPeriodMonth = 'yoxdur';
        }

        if($fileData->appointment[0]->appointmentType == 1){
            $appType = '?????? q??bul bar??d??';
        }
        elseif ($fileData->appointment[0]->appointmentType == 2){
            $appType = 'Yerd??yi??m?? bar??d??';
        }else{
            $appType = '?????? q??bul v?? yerd??yi??m?? bar??d??';
        }

        $strIsPostCheck = '';
        if($fileData->appointment[0]->isPost != true){
            $strIsPostCheck = $fileData->appointment[0]->structure->text;
        }


        $structureSection = $fileData->appointment[0]->structure->parent.' '. $strIsPostCheck;
        $structurePosition = $fileData->appointment[0]->position_name->text;

        foreach($fileData->appointment[0]->employees as $employeeI) {
            $employeen = $employeeI->text;


            $employee .= $employeen;
        }


        if($fileData->appointment[0]->appointmentType == 1){
            // Ise qebul barede
            return '<p style="text-align: right; font-size: large "><strong>&ldquo;'. $appType .'&rdquo;</strong></p>
                <p style="text-align: center; font-size: large"><strong>??MR </strong></p>
                <p>&nbsp;</p>
                <p style="text-align: center;">??????inin ??riz??si v?? onunla ba??lanm???? ??m??k m??qavil??sin?? ??sas??n,</p>
                <p>&nbsp;</p>
                <p style="text-align: center; font-size: large"><strong>?? M R&nbsp;&nbsp; E D ?? R ?? M:</strong></p>
                <p>&nbsp;</p>
                <table class="ml-40 pull-left">
                    <tr>
                        <td style="padding-right: 120px"><b>1. ??????inin soyad??, ad??, atas??n??n ad??:</b></td>
                        <td>'.$employee.'</td>
                    </tr>
                    <tr>
                        <td><b>2. ?????? q??bul oldu??u struktur b??lm??:</b></td>
                        <td>'.$structureSection.'</td>
                    </tr>
                    <tr>
                        <td><b>3. ?????? q??bul oldu??u v??zif??:</b></td>
                        <td>'.$structurePosition.'</td>
                    </tr>
                    <tr>
                        <td><b>4. ?????? q??bul tarixi:</b></td>
                        <td>'.$fileData->appointment[0]->startDate.'</td>
                    </tr>
                    <tr>
                        <td><b>5. S??naq m??dd??ti:</b></td>
                        <td>'. $trialPeriodMonth .'</td>
                    </tr>
                    <tr>
                        <td><b>6. ??m??k haqq??:</b></td>
                        <td> '. $totalSalaryAppointment .' AZN (vergil??r v?? dig??r ??d??ni??l??r daxil olmaqla)</td>
                    </tr>
                </table>
                <table class="ml-60 pull-left">
                    <tr>
                        <td class="pr-30"><li>??tat ??zr?? ??sas ??m??k haqq??:</li></td>
                        <td>'. $positionPayment .' AZN </td>
                    </tr>
                    <tr>
                        <td><li>??m??k ????raitin?? g??r?? ??lav??:</li></td>
                        <td>'. $conditionalPayment .' AZN </td>
                    </tr>
                    <tr>
                        <td><li>Dig??r f??rdi ??lav??:</li></td>
                        <td>'. $addSalary .' AZN</td>
                    </tr>
                </table>
                <table class="ml-40 pull-left">
                    <tr>
                        <td>7. ??nsan Resurslar?? v?? Maliyy?? Departamentl??rin?? tap????r??ls??n ki, ??mrd??n ir??li g??l??n z??ruri m??s??l??l??rin h??llini t??min etsin.</td>
                    </tr>
                </table>
                <table><tr><td>
                </div>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p style="text-align: left;"><strong>Ba?? direktor :
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Taleh Ziyadov</strong></p>
                </td></tr></table>';

        }
        elseif ($fileData->appointment[0]->appointmentType == 2){
            // Yerdeyisme barede

            if(isset($fileData->appointment[0]->structureOld)){
                $oldStructure = $fileData->appointment[0]->structureOld;
            }else{
                $oldStructure = '';
            }
            if($fileData->appointment[0]->fromPositionId->text != null){
                $oldPosition = $fileData->appointment[0]->fromPositionId->text;
            }else{
                $oldPosition = '';
            }

            return '<p style="text-align: right; font-size: large "><strong>&ldquo;'. $appType .'&rdquo;</strong></p>
                <p style="text-align: center; font-size: large"><strong>??MR </strong></p>
                <p>&nbsp;</p>
                <p style="text-align: center;">??????inin ??riz??si v?? onunla ba??lanm???? ??m??k m??qavil??sin?? ??sas??naa,</p>
                <p>&nbsp;</p>
                <p style="text-align: center; font-size: large"><strong>?? M R&nbsp;&nbsp; E D ?? R ?? M:</strong></p>
                <p>&nbsp;</p>
                <table class="ml-40 pull-left">
                    <tr>
                        <td style="padding-right: 120px"><b>1. ??????inin soyad??, ad??, atas??n??n ad??:</b></td>
                        <td>'.$employee.'</td>
                    </tr>
                    <tr>
                        <td><b>2. Faktiki i??l??diyi struktur b??lm??:</b></td>
                        <td>'.$oldStructure.'</td>
                    </tr>
                    <tr>
                        <td><b>3. Faktiki i??l??diyi v??zif??:</b></td>
                        <td>'.$oldPosition.'</td>
                    </tr>
                    <tr>
                        <td><b>4. D??yi??iklik tarixi:</b></td>
                        <td>'.$fileData->appointment[0]->startDate.'</td>
                    </tr>
                    <tr>
                        <td><b>2. Ke??irildiyi struktur b??lm??:</b></td>
                        <td>'.$structureSection.'</td>
                    </tr>
                    <tr>
                        <td><b>3. Ke??irildiyi v??zif?? v??zif??:</b></td>
                        <td>'.$structurePosition.'</td>
                    </tr>
                    <tr>
                        <td><b>3. Ke??irilm?? m??dd??ti:</b></td>
                        <td> - </td>
                    </tr>
                    <tr>
                        <td><b>6. ??m??k haqq??:</b></td>
                        <td> '. $totalSalaryAppointment .' AZN (vergil??r v?? dig??r ??d??ni??l??r daxil olmaqla)</td>
                    </tr>
                </table>
                <table class="ml-60 pull-left">
                    <tr>
                        <td class="pr-30"><li>??tat ??zr?? ??sas ??m??k haqq??:</li></td>
                        <td>'. $positionPayment .' AZN</td>
                    </tr>
                    <tr>
                        <td><li>??m??k ????raitin?? g??r?? ??lav??:</li></td>
                        <td>'. $conditionalPayment .' AZN </td>
                    </tr>
                    <tr>
                        <td><li>Dig??r f??rdi ??lav??:</li></td>
                        <td>'. $addSalary . ' AZN </td>
                    </tr>
                </table>
                <table class="ml-40 pull-left">
                    <tr>
                        <td>7. ??nsan Resurslar?? v?? Maliyy?? Departamentl??rin?? tap????r??ls??n ki, ??mrd??n ir??li g??l??n z??ruri m??s??l??l??rin h??llini t??min etsin.</td>
                    </tr>
                </table>
                <table><tr><td>
                </div>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p style="text-align: left;"><strong>Ba?? direktor :
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Taleh Ziyadov</strong></p>
                </td></tr></table>';

        }else {

            return 'Error';
        }

    }

    /**
     * print dismissal orderTransfer
     * @param $fileData
     * @return string
     */


    public function salaryAddition($fileData){
        $amount = "%";
        $data = $fileData->salaryAddition->reluserpayment->data[0];
        $workData     = $fileData->salaryAddition->userInfo->positionId;
        if($data->isPercent == false){$amount = "AZN";};

        $table = '
            <table width="100%" style="margin: 0 auto;">  
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <tr align="right" style="font-size: medium;">
                    <td colspan="2"><b><em>?????m??k haqq??na ??lav??nin edilm??si bar??d?????</em></b></td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: medium">
                    <td colspan="2">
                        Az??rbaycan Respublikas?? ??m??k M??c??ll??sinin 185-ci madd??sini r??hb??r tutaraq, i????inin ??tat ??zr?? ??m??k haqq??na f??rdi ??lav?? edilm??si m??qs??dil??,
                    </td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: large">
                    <td colspan="2"><b>??MR ED??R??M</b></td>
                </tr>
                <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                <tr>
                    <td colspan="2">1. A??a????da ad?? qeyd olunan i????inin ??tat ??zr?? ??m??k haqq??nda ??lav?? t??yin edilsin.</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <ul>
                            <li>??????inin soyad??, ad??, atas??n??n ad??: <b>'.$data->userId->lastName.' '.$data->userId->firstName.' '.$data->userId->patronymic.'</b></li>
                            <li>????l??diyi struktur b??lm??: <b>'.$workData->structureId->name.'</b></li>
                            <li>V??zif??si: <b>'.$workData->posNameId->name.'</b></li>
                            <li>F??rdi ??lav??nin m??bl????i (vergil??r v?? dig??r ??d??ni??l??r daxil olmaqla): <b>'.$data->valus.' '.$amount.'</b></li>
                            <li>F??rdi ??lav??nin verildiyi tarix: <b>'.$data->startDate.'</b></li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">2. ??nsan Resurslar?? v?? Maliyy?? Departamentl??rin?? tap????r??ls??n ki, bu ??mrd??n ir??li g??l??n m??s??l??l??rin h??llini t??min etsin.</td>
                </tr>
                <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                <tr>
                    <td align="left"><b>Ba?? Direktor:</b></td>
                    <td align="right"><b>Taleh Ziyadov</b></td>
                </tr>
            </table>
        ';
        return $table;
    }


    /**
     * print dismissal order
     * @param $fileData
     * @return string
     */

    public function dismissal($fileData){

        $employee = '';
        $rows = '';

        /* if note exists */
        $note = count($fileData->dismissal[0]->orderDismissalNotes) > 0 ? $fileData->dismissal[0]->orderDismissalNotes[0]->note : 'val';

        /* employee name surname patronym */
        foreach($fileData->dismissal[0]->relUserInOrderDismissalList as $employeeI) {
            $employee .= $employeeI->text.',';
        }

        /* employee */
        $employee     =  [
            'text' => '??????inin soyad??, ad??, atas??n??n ad??',
            'val'  =>  $fileData->dismissal[0]->relUserInOrderDismissalList[0]->text
        ];


        /* structure */
        $structure    = [
            'text' => '????l??diyi struktur b??lm??nin ad??',
            'val'  =>  $fileData->dismissal[0]->listStructures->text
        ];

        /* position of user  */
        $position     = [
            'text' => 'V??zif??si',
            'val'  =>  $fileData->dismissal[0]->listPositionNames->text
        ];

        /* date of dismissal row */
        $date         = [
            'text' => '????d??n azad olma tarixi',
            'val'  =>  $fileData->dismissal[0]->dismissalDate
        ];


        /* reason of dismissal row */
        $reason       = [
            'text' => '????d??n azad olma s??b??bi',
            'val'  =>  $fileData->dismissal[0]->listDismissalTypeId->text
        ];

        /* compensation row */
        $compensation = [
            'text' => '??stifad?? edilm??mi?? m??zuniyy??t g??nl??rin?? g??r?? kompensasiya',
            'val'  =>  '---'
        ];

        /* notes row */
        $notes        = [
            'text' => 'Qeyd',
            'val'  =>  $note
        ];

        /*bursar task row */
        $bursar       = [
            'text' => 'Maliyy?? Departamentin?? tap????r??ls??n ki, ??d??ni?? m??s??l??l??rini h??ll etsin',
            'val'  =>  null
        ];

        /* info to hr row */
        $hr           = [
            'text' => '??nsan Resurslar?? Departamentin?? tap????r??ls??n ki, ??mrl?? i????i tan???? edilsin',
            'val'  =>  null
        ];


        /* all rows in array */
        $rowsInArray = [$employee, $structure, $position, $date, $reason, $compensation, $notes, $bursar, $hr];

        /* remove notes from array */
        if (count($fileData->dismissal[0]->orderDismissalNotes) <= 0) { array_splice($rowsInArray, 6, 1); }

        /* collect rows */
        foreach ($rowsInArray as $index => $row)
        {
            if ($row['val'] != null) {
                /* has value */
                $rows .= '<tr style="font-size: medium;">
                             <td>'. ++$index.'.	 '.$row['text'].': &nbsp; &nbsp; &nbsp;</td>
                             <td>'. $row['val']. '</td>
                          </tr>';
            } else {
                /* has colspan */
                $rows .= '<tr style="font-size: medium;">
                            <td colspan="2">'.++$index.'.	'.$row['text'].'.</td>
                          </tr>';
            }
        }

        return '
        <p align="right"><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: small;"><span style="font-size: large;"><span lang="az-Latn-AZ"><strong>&rdquo;??m??k m??qavil??sin?? xitam verilm??si bar??d??&rdquo;</strong></span></span></span></span></p>
                <p lang="az-Latn-AZ" align="right">&nbsp;</p>
                <p align="center">&nbsp;</p>
                <p align="center"><span style="font-family: \'Times New Roman\', serif; font-size: large"><span lang="az-Latn-AZ"><strong>?? M R &nbsp; E D ?? R ?? M:</strong></span></span></p>
                <p lang="az-Latn-AZ" align="center">&nbsp;</p>
                <div class="container">
                <table>
                    '.$rows.'
                </table>
                </div>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p style="text-align: left;"><strong>Ba?? direktor :
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Taleh Ziyadov</strong></p>
                </table>';
    }

    public function sabbaticalLeaveHtml($data){

        $dates='';
//        dd($data);
        if($data->child->label=='sabbatical_leave' || $data->child->label=='paid_social_vacation' || $data->child->label=='paid_educational_vacation' || $data->child->label=='nonpaid_vacation'){

            $dates .= '
                    <tr>
                        <td style="padding-right: 80px"><b>M??zuniyy??tin ba??land?????? tarix:</b></td>
                        <td>'.$data->child->startDate.'</td>
                    </tr>
                    <tr>
                        <td><b>M??zuniyy??tin qurtard?????? tarix:</b></td>
                        <td>'.$data->child->endDate.'</td>
                    </tr>
                    <tr>
                        <td><b>M??zuniyy??t g&uuml;nl??rinin say??:</b></td>
                        <td>'.$data->child->vacationDay.'</td>
                    </tr>';

            $table = '<style>td{height:30px !important;}td > p{margin-bottom:0}</style>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                    <table cellspacing="0">
                    <tbody>
                    <tr>
                    <td colspan="2">
                    <p align="center"><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>'.$data->child->listVacationName.'</strong>&nbsp;<strong>m??zuniyy??tinin&nbsp;verilm??si&nbsp;haqq??nda</strong></span></span></p>
                    <p>&nbsp</p>
                    <p>&nbsp</p>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="2" valign="bottom">
                    <p align="center"><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: large;"><strong>??mr ???: '.$data->orderNumber.'</strong></span></span></p>
                    <p>&nbsp</p>
                    <p>&nbsp</p>
                    </td>
                    </tr>
                    <tr>
                        <td><b>????&ccedil;i:</b></td>
                        <td>'.$data->child->userName.'</td>
                    </tr>
                    <tr>
                        <td><b>????l??diyi struktur b&ouml;lm??:</b></td>
                        <td>'.$data->child->userStructure->structureIdName.'</td>
                    </tr>
                    <tr>
                        <td><b>V??zif??si (pe????si):</b></td>
                        <td>'.$data->child->userStructure->posNameIdName.'</td>
                    </tr>
                    <tr>
                        <td style="padding-right: 20px"><b>M??zuniyy??tin verilm??sinin ??saslar?? v?? g&uuml;nl??rinin say??:</b></td>
                        <td>'.$data->child->listVacationName.'-'.$data->child->vacationDay.'</td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Kollektiv m&uuml;qavil??nin 9.1.7 madd??sin?? ??sas??n-2, 5, v?? ya 7</b></td>
                    </tr>
                    '.$dates.'
                    <tr>
                        <td><b>?????? ????xma tarixi:</b></td>
                        <td>'.$data->child->workStartDate.'</td>
                    </tr> 
                    <tr>
                        <td><b>Q??rar??n verilm??si &uuml;&ccedil;&uuml;n ??saslar:</b></td>
                        <td>'.$data->orderBasis.'</td>
                    </tr>  
                    <tr>
                        <td colspan="2">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p style="text-align: left;"><strong>Ba?? direktor :
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Taleh Ziyadov</strong></p>
                        </td>
                    </tr>
                </table>';

        }

        return $table;

    }

    /**
     * @param $fileData
     * @return string
     */

    public function vacation($fileData){

        if(!isset($fileData->child->label)){
            $fileData->child['label'] = is_array($fileData->vacation)?OrderController::getVacationLabelById($fileData->vacation[0]->listVacationTypeIdId):OrderController::getVacationLabelById($fileData->fields->vacation[0]->listVacationTypeIdId);
            $fileData->child = (object)$fileData->child;
        }
        $dates = '';

//         dd($fileData);
        if( $fileData->child->label=='sabbatical_leave'){
            return $this->sabbaticalLeaveHtml($fileData);

        } elseif ( $fileData->child->label=='paid_educational_vacation' ||
            $fileData->child->label=='paid_social_vacation' ||
            $fileData->child->label=='nonpaid_vacation'){
            $table= '
                <table width="100%" style="margin: 0 auto;">  
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                    <tr align="right" style="font-size: medium;">
                        <td colspan="2"><b>?????????iy?? '.$fileData->child->listVacationTypeName.' verilm??si bar??d?????</b></td>
                    </tr>
                    <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                    <tr align="center" style="font-size: large">
                        <td colspan="2"><b>??MR ED??R??M:</b></td>
                    </tr>
                    <tr><td><p>&nbsp;</p></td></tr>
                    <tr align="center">
                        <td colspan="2">A??a????da m??lumatlar?? qeyd olunan i????iy?? '.$fileData->child->listVacationTypeName.' verilsin.</td>
                    </tr>
                    <tr><td><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                    <tr>
                        <td><b>1. ??????inin soyad??, ad??, atas??n??n ad??</b></td>
                        <td>'.$fileData->child->userName.'</td>
                    </tr>
                    <tr>
                        <td><b>2. Struktur b??lm??</b></td>
                        <td>'.$fileData->child->userStructure->structureIdName.'</td>
                    </tr>
                    <tr>
                        <td><b>3. V??zif??si</b></td>
                        <td>'.$fileData->child->userStructure->posNameIdName.'</td>
                    </tr>
                    <tr>
                        <td><b>4. M??zuniyy??t?? burax??lma tarixl??ri</b></td>
                        <td>'.$fileData->child->startDate.' - '.$fileData->child->endDate.'</td>
                    </tr>
                    <tr>
                        <td><b>5. M??zuniyy??tin m??dd??ti</b></td>
                        <td>'.$fileData->child->vacationDay.'</td>
                    </tr>
                    <tr>
                        <td><b>6. ?????? ba??lama tarixi</b></td>
                        <td>'.$fileData->child->workStartDate.'</td>
                    </tr>
                    <tr>
                        <td><b>7. ??lav?? qeydl??r</b></td>
                        <td></td>
                    </tr>
                    <tr><td><p>&nbsp;</p></td></tr>
                    <tr>
                        <td colspan="2"><b>&nbsp;&nbsp;&nbsp;&nbsp;??sas: </b>'.$fileData->orderBasis.'</td>
                    </tr>
                    <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                    <tr>
                        <td align="left"><b>Ba?? Direktor:</b></td>
                        <td align="right"><b>Taleh Ziyadov</b></td>
                    </tr>
                </table>
             ';

            return $table;


        } elseif ($fileData->child->label=='partialpaid_social_vacation') {
            $table = '
                <table width="100%" style="margin: 0 auto;">  
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                    <tr align="right" style="font-size: medium;">
                        <td colspan="2"><b>???Qism??n ??d??ni??li sosial m??zuniyy??tin verilm??si bar??d?????</b></td>
                    </tr>
                    <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                    <tr align="center" style="font-size: medium">
                        <td colspan="2">' . $fileData->orderBasis . ',</td>
                    </tr>
                    <tr><td><p>&nbsp;</p></td></tr>
                    <tr align="center" style="font-size: large">
                        <td colspan="2"><b>??MR ED??R??M</b></td>
                    </tr>
                    <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                    <tr>
                        <td colspan="2">1. A??a????da m??lumatlar?? qeyd olunan i????iy?? qism??n ??d??ni??li sosial m??zuniyy??t verilsin.</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <ul>
                                <li>??????inin soyad??, ad??, atas??n??n ad??:&nbsp;&nbsp;' . $fileData->child->userName . '</li>
                                <li>????l??diyi struktur b??lm??:&nbsp;&nbsp;' . $fileData->child->userStructure->structureIdName . '</li>
                                <li>V??zif??si:&nbsp;&nbsp;' . $fileData->child->userStructure->posNameIdName . '</li>
                                <li>Qism??n ??d??ni??li sosial m??zuniyy??t?? burax??lma tarixl??ri:&nbsp;&nbsp;' . $fileData->child->startDate . ' - ' . $fileData->child->endDate . '</li>
                                <li>Qism??n ??d??ni??li sosial m??zuniyy??tin m??dd??ti:&nbsp;&nbsp;' . $fileData->child->vacationDay . '</li>
                                <li>?????? ba??lama tarixi:&nbsp;&nbsp;' . $fileData->child->workStartDate . '</li>
                                <li>??lav?? qeydl??r:&nbsp;&nbsp;</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">2. ??nsan Resurslar?? v?? Maliyy?? Departamentl??rin?? tap????r??ls??n ki, ??mrd??n ir??li g??l??n m??s??l??l??rin h??llini t??min etsin.</td>
                    </tr>
                    <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                    <tr>
                        <td align="left"><b>Ba?? Direktor:</b></td>
                        <td align="right"><b>Taleh Ziyadov</b></td>
                    </tr>
                </table>
             ';

            return $table;

        } elseif ($fileData->child->label=='labor_vacation'){

            $totalchild142=[];
            $totalchild143=[];
            $fileDataObj=is_array($fileData->vacation)?$fileData->vacation:$fileData->fields->vacation[0];
            $orderBasis=is_array($fileData->vacation)?$fileData->orderBasis:$fileData->fields->orderBasis;

            foreach($fileData->vacation->orderVacationDetailAddArray as $key=>$vacationArray){

                if(isset($fileData->vacation->orderVacationDetailAddArray[$key]) && $fileData->vacation->orderVacationDetailAddArray[$key]->totalChild142 != 0){

                    $totalchild142[$key] = $fileData->vacation->orderVacationDetailAddArray[$key]->totalChild142;
                }
                else {
                    $totalchild143[$key] = $fileData->vacation->orderVacationDetailAddArray[$key]->totalChild143;

                }

            }
//             if ($fileData->vacation->orderVacationDetailAddArray[0]->totalChild142 != 0){
//                 $totalChild0 = $fileData->vacation->orderVacationDetailAddArray[0]->totalChild142;
//             }else{
//                 $totalChild0 = $fileData->vacation->orderVacationDetailAddArray[0]->totalChild143;
//             }
//             if ($fileData->vacation->orderVacationDetailAddArray[1]->totalChild142 != 0){
//                 $totalChild1 = $fileData->vacation->orderVacationDetailAddArray[1]->totalChild142;
//             }else{
//                 $totalChild1 = $fileData->vacation->orderVacationDetailAddArray[1]->totalChild143;
//             }

            $table= '
                <table width="100%" style="margin: 0 auto;">  
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                    <tr align="right" style="font-size: medium;">
                        <td colspan="3"><b>?????????iy?? ??m??k m??zuniyy??ti verilm??si bar??d?????</b></td>
                    </tr>
                    <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                    <tr align="center" style="font-size: large">
                        <td colspan="3"><b>??MR ED??R??M:</b></td>
                    </tr>
                    <tr><td><p>&nbsp;</p></td></tr>
                    <tr align="center">
                        <td colspan="3">A??a????da ad?? qeyd olunan i????iy?? ??m??k m??zuniyy??ti verilsin.</td>
                    </tr>
                    <tr><td><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                    <tr> 
                        <td><b>1. ??????inin soyad??, ad??, atas??n??n ad??</b></td>
                        <td>'.$fileDataObj->userIdLastName.' '.$fileDataObj->userIdFirstName.' '.$fileDataObj->userIdPatronymic.'</td>
                    </tr>
                    <tr>
                        <td><b>2. Struktur b??lm??</b></td>
                        <td>'.$fileDataObj->structureIdName.'</td>
                    </tr>
                    <tr>
                        <td><b>3. V??zif??si</b></td>
                        <td>'.$fileDataObj->posNameIdName.'</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>4. M??zuniyy??tin i?? ili d??vr?? (d??vrl??ri)</b></td></tr>';
            foreach($fileData->vacation->data as $dataPeriod) {

                $table=$table.'<tr><td></td><td> '.$dataPeriod->vacationWorkPeriodFrom.' </td><td> '.$dataPeriod->vacationWorkPeriodTo.'</td ></tr>';

            }
            $table=$table.'</tr>
                    <tr>
                        <td><b>5. M??zuniyy??t m??dd??ti</b></td>
                   </tr>
                    
                    <tr>

                        <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;??sas</td></tr>';
            foreach($fileData->vacation->data as $dataP) {
                $table=$table.'<td></td><td align = "center" > '.$dataP->mainVacationDay.'</td >
                        <td align = "center" > '.$dataP->mainVacationDay.'</td ></tr>';
            }



            $totalExpRow='<tr><td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Staja g??r?? ??lav??</td></tr>';
            $totalWorkConditionDay='<tr><td colspan="3">??m??k ????raitin?? g??r??</td></tr>';
            $totalchild142Row='<tr><td colspan="3">14 ya????nad??k &nbsp;&nbsp;&nbsp;2 u??a???? olan qad??nlara veril??n ??lav??</td></tr>';
            $totalchild143Row='<tr><td colspan="3">14 ya????nad??k &nbsp;&nbsp;&nbsp;3 v?? daha ??ox u??a???? olan qad??nlara veril??n ??lav??</td></tr>';
            $allWomenDayRow='<tr><td colspan="3">Kollektiv m??qavil??y?? ??sas??n qad??nlara veril??n ??lav?? m??zuniyy??t</td></tr>';
            $totalChernobylAccidenDayRow='<tr><td colspan="3">&nbsp;Kollektiv m??qavil??y?? ??sas??n ??ernobil q??zas??n??n l????vind?? i??tirak etmi?? v?? ya h??min q??zada z??r??r ????kmi?? i????il??r?? veril??n ??lav??</td></tr>';
            foreach($fileData->vacation->orderVacationDetailAddArray as $key=>$wholeRow) {
                $totalExpRow = $totalExpRow . '<tr><td></td><td align="center">' . $fileData->vacation->orderVacationDetailAddArray[$key]->totalExperienceDay . '</td><td align="center">' . $fileData->vacation->orderVacationDetailAddArray[$key]->totalExperienceDay . '</td></tr>';
                $totalWorkConditionDay = $totalWorkConditionDay  . '<tr><td></td><td align="center">' . $fileData->vacation->orderVacationDetailAddArray[$key]->totalWorkConditionDay . '</td><td align="center">' . $fileData->vacation->orderVacationDetailAddArray[$key]->totalWorkConditionDay . '</td></tr>';

                $totalchild142Row = $totalchild142Row . '<tr><td></td><td align="center">' . $fileData->vacation->orderVacationDetailAddArray[$key]->totalChild142 . '</td><td align="center">' . $fileData->vacation->orderVacationDetailAddArray[$key]->totalChild142 . '</td></tr>';
                $totalchild143Row = $totalchild143Row . '<tr><td></td><td align="center">' . $fileData->vacation->orderVacationDetailAddArray[$key]->totalChild143 . '</td><td align="center">' . $fileData->vacation->orderVacationDetailAddArray[$key]->totalChild143 . '</td></tr>';
                $allWomenDayRow = $allWomenDayRow  . '<tr><td></td><td align="center">' . $fileData->vacation->orderVacationDetailCollectiveArray[$key]->allWomenDay . '</td><td align="center">' . $fileData->vacation->orderVacationDetailCollectiveArray[$key]->allWomenDay . '</td></tr>';
                $totalChernobylAccidenDayRow = $totalChernobylAccidenDayRow  . '<tr><td></td><td align="center">' . $fileData->vacation->orderVacationDetailCollectiveArray[$key]->totalChernobylAccidenDay . '</td><td align="center">' . $fileData->vacation->orderVacationDetailCollectiveArray[$key]->totalChernobylAccidenDay . '</td></tr>';

            }
//                    $table=$table+'<tr>
//                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Kollektiv m??qavil??y?? ??sas??n qad??nlara veril??n ??lav?? m??zuniyy??t</td>
//                        <td align="center">'.$fileData->vacation->orderVacationDetailCollectiveArray[0]->allWomenDay.'</td>
//                        <td align="center">'.$fileData->vacation->orderVacationDetailCollectiveArray[1]->allWomenDay.'</td>
//                    </tr>
//                    <tr>
//                        <td class="table-width-50">&nbsp;&nbsp;&nbsp;&nbsp;Kollektiv m??qavil??y?? ??sas??n ??ernobil q??zas??n??n l????vind?? i??tirak etmi?? v?? ya h??min q??zada z??r??r ????kmi?? i????il??r?? veril??n ??lav??</td>
//                        <td align="center">'.$fileData->vacation->orderVacationDetailCollectiveArray[0]->totalChernobylAccidenDay.'</td>
//                        <td align="center">'.$fileData->vacation->orderVacationDetailCollectiveArray[1]->totalChernobylAccidenDay.'</td>
//                    </tr>

            $table=$table.$totalExpRow.$totalWorkConditionDay.$totalchild142Row.$totalchild143Row.$allWomenDayRow.$totalChernobylAccidenDayRow.'<tr><td><b>6. M??zuniyy??tin c??mi m??dd??ti</b></td>

                        <td>'.$fileData->vacation->data[0]->totalVacationDay.'</td>
                    </tr>
                    <tr>
                        <td><b>7. M??zuniyy??t?? burax??lma tarixl??ri</b></td></tr>';

            foreach($fileData->vacation->data as $wholeRow) {
                $table=$table.'<tr><td></td><td > '.$wholeRow->startDate.'</td ><td> '.$wholeRow->startDate.'</td></tr>';
            }

            $table=$table.'<tr>
                        <td><b>8. ?????? ba??lama tarixi</b></td>
                        <td>'.$fileDataObj->wsDate.'</td>
                    </tr>
                    <tr>
                        <td><b>9. ??lav?? qeydl??r</b></td>
                        <td></td>
                    </tr>
                    <tr><td><p>&nbsp;</p></td></tr>
                    <tr>
                        <td colspan="3"><b>&nbsp;&nbsp;&nbsp;&nbsp;??sas: </b>'.$orderBasis.'</td>
                    </tr>
                    <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                    <tr>
                        <td align="left"><b>Ba?? Direktor:</b></td>
                        <td></td>
                        <td align="right"><b>Taleh Ziyadov</b></td>
                    </tr>
                </table>
             ';

            return $table;
        } else {

            foreach ($fileData->vacation[0]->dates as $date) {
                $dates .= '<tr>
                    <td style="width: 311.2px;" colspan="10" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>M??zuniyy??tin ??hat?? etdiyi i?? ili (ill??ri):</strong> &nbsp;&nbsp;&nbsp; ' . $date->vacationWorkPeriodFrom . ' &mdash; ' . $date->vacationWorkPeriodTo . '</span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 270.4px;" colspan="8" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>M??zuniyy??tin ba??land?????? tarix:</strong> &nbsp;&nbsp;&nbsp; ' . $date->startDate . '</span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 270.4px;" colspan="8" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>M??zuniyy??tin qurtard?????? tarix (??l il?? yaz??l??r)</strong></span></span><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>:</strong></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 270.4px;" colspan="8" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>M??zuniyy??t g&uuml;nl??rinin say??:</strong> &nbsp;&nbsp;&nbsp; ' . $date->vacationDay . '</span></span></p>
                    </td>
                    </tr><br>';
            }

            $table = '<style>td{height:30px !important;}td > p{margin-bottom:0}</style>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                    <table width="780" cellspacing="0">
                    <tbody>
                    <tr>
                    <td style="width: 706.4px;" colspan="21">
                    <p align="center"><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: large;"><strong>??m??k</strong>&nbsp;<strong>m??zuniyy??tinin&nbsp;verilm??si&nbsp;haqq??nda</strong></span></span></p>
                    <p>&nbsp</p>
                    <p>&nbsp</p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 706.4px;" colspan="21" valign="bottom">
                    <p align="center"><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: large;"><strong>??mr ???: ' . $fileData->orderNumber . '</strong></span></span></p>
                    <p>&nbsp</p>
                    <p>&nbsp</p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 56px;" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>????&ccedil;i: &nbsp; &nbsp; &nbsp; ' . $fileData->vacation[0]->userIdLastName . ' ' . $fileData->vacation[0]->userIdFirstName . ' ' . $fileData->vacation[0]->userIdPatronymic . '</strong></span></span></p>
                    </td>
                    <td style="width: 620.8px;" colspan="19" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong></strong></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 229.6px;" colspan="6" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>????l??diyi struktur b&ouml;lm??: &nbsp;&nbsp;&nbsp;&nbsp; ' . $fileData->vacation[0]->structureIdName . '</strong></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 164px;" colspan="4" valign="bottom">
                    <p><span style="font-family: \'Time s New Roman\', serif;"><span style="font-size: medium;"><strong>V??zif??si (pe????si): &nbsp;&nbsp;&nbsp; ' . $fileData->vacation[0]->posNameIdName . '</strong></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 706.4px;" colspan="21" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>M??zuniyy??tin verilm??sinin ??saslar?? v?? g&uuml;nl??rinin say?? (faktiki ne&ccedil;?? g&uuml;n var):</strong></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 391.2px;" colspan="12" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>AR ??M-nin 114-c&uuml; madd??si, ??sas m??zuniyy??t-30 v?? ya 21 g??n</strong></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 391.2px;" colspan="12" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><span lang="en-US"><strong>AR ??M-nin 116.1-ci madd??si, ??sas staj??na g&ouml;r??-2, 4 v?? ya 6</strong></span></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 391.2px;" colspan="12" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><span lang="en-US"><strong>AR ??M-nin 115.1-ci madd??si, z??r??r?? g&ouml;r??-6</strong></span></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 706.4px;" colspan="21" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>Kollektiv m&uuml;qavil??nin 9.1.7 madd??sin?? ??sas??n-2, 5, v?? ya 7</strong></span></span></p>
                    </td>
                    </tr>
                    ' . $dates . '
                    <tr>
                    <td style="width: 475.2px;" colspan="14" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>M??zuniyy??t d&ouml;vr&uuml;n?? d&uuml;????n bayram (h&uuml;zn) g&uuml;nl??ri:</strong></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 270.4px;" colspan="8" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>?????? ????xma tarixi: ' . $fileData->vacation[0]->wsDate . '</strong></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 270.4px;" colspan="8" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>Q??rar??n verilm??si &uuml;&ccedil;&uuml;n ??saslar: &nbsp;&nbsp;&nbsp; ' . $fileData->orderBasis . '</strong></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td>
                    <p>&nbsp</p>
                    <p>&nbsp</p>
                    <p>&nbsp</p>
                    </td>
                    <tr>
                    <tr>
                    <td style="width: 100%;">
                    <p style="float: left; "><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: large;"><span lang="az-Latn-AZ"><strong>Ba?? direktor:</strong></span></span></span></p>
                    <p style="float: right;"><span style="font-family: \'Times New Roman\', serif; flo"><span style="font-size: large;"><span lang="az-Latn-AZ"><strong>Taleh Ziyadov</strong></span></span></span></p>
                    </td>
                    </tr>
                    </tbody>
                    </table>';

            return $table;
        }
    }

    // Work Experience - ??m??k m??qavil??si

    /**
     * @param $fileData
     * @return string
     */

  
    /* get labor contract for appointment */

    /**
     * @param $fileData
     * @return string
     */

   
    /**`
     * print dismissal order
     * @param $fileData
     * @return string
     */

    public function financialAid($fileData){


        $id = $fileData->financialAid[0]->userId->id;
        $getPos = UserPositionController::getPosByUserId2($id);

        if(isset($getPos->positionId->structureId->name)){
            $strName = $getPos->positionId->structureId->name;
        }else{
            $strName = '';
        }

        if(isset($getPos->positionId->posNameId->name)){
            $posName = $getPos->positionId->posNameId->name;
        }else{
            $posName = '';
        }




        return '
        <p align="right"><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: small;"><span style="font-size: large;"><span lang="az-Latn-AZ"><strong>&rdquo;Maddi yard??m g??st??rilm??si bar??d??&rdquo;</strong></span></span></span></span></p>
                <p lang="az-Latn-AZ" align="right">&nbsp;</p>
                <p align="center">&nbsp;'.$fileData->orderBasis.'</p>
                <p align="center"><span style="font-family: \'Times New Roman\', serif; font-size: large"><span lang="az-Latn-AZ"><strong>?? M R &nbsp; E D ?? R ?? M:</strong></span></span></p>
                <p lang="az-Latn-AZ" align="center">&nbsp;</p>
                <div class="container">
                <table>
                    <tbody>
                        <tr>
                            <td class="table-width-50"><strong>1. ??????inin soyad??, ad??, atas??n??n ad??:</strong></td>
                            <td class="table-width-50"> '.$fileData->financialAid[0]->userId->firstName .'&nbsp; '. $fileData->financialAid[0]->userId->lastName .'&nbsp; '. $fileData->financialAid[0]->userId->patronymic .' </td>
                        </tr>
                        <tr>
                            <td><strong>2. ????l??diyi struktur b??lm??nin ad??:</strong></td>
                            <td> '. $strName .' </td>
                        </tr>
                        <tr>
                            <td><strong>3. V??zif??si:</strong></td>
                            <td> '. $posName .' </td>
                        </tr>
                        <tr>
                            <td><strong>4. Maddi yard??m??n m??bl????i<br> (vergil??r v?? dig??r ??d??ni??l??r xaric olmaqla):</strong></td>
                            <td style="vertical-align: bottom"> '. $fileData->financialAid[0]->value .' AZN</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>5. ??nsan Resurslar?? v?? Maliyy?? Departamentl??rin?? tap????r??ls??n ki, ??mrd??n ir??li g??l??n m??s??l??l??rin h??llini t??min etsinl??r.</strong></td>
                        </tr>
                    </tbody>
                </table>
                <table>
                </div>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p style="text-align: left;"><strong>Ba?? direktor :
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Taleh Ziyadov</strong></p>
                </table>';
    }

  
    public function discipline($fileData){

        $id = $fileData->discipline[0]->userId->id;
        $getPos = UserPositionController::getPosByUserId2($id);


        $id2 = $fileData->discipline[0]->executorUserId->id;
        $getPos2 = UserPositionController::getPosByUserId2($id2);


        if($fileData->discipline[0]->isExplanation == true){
            $isExplanation = ' v?? i????inin izahat??';
        }else{
            $isExplanation = '';
        }

        if(isset($getPos2->positionId->structureId->name)){
            $str2 = $getPos2->positionId->structureId->name;
        }else{
            $str2 =  '';
        }

        if(isset($getPos2->positionId->posNameId->name)){
            $pos2 = $getPos2->positionId->posNameId->name;
        }else{
            $pos2 =  '';
        }

        return '
        <p align="right"><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: small;"><span style="font-size: large;"><span lang="az-Latn-AZ"><strong>&rdquo;??ntizam t??nbehin?? c??lb edilm?? bar??d??&rdquo;</strong></span></span></span></span></p>
                <p lang="az-Latn-AZ" align="right">&nbsp;</p>
                <p align="center">&nbsp;'.$fileData->orderBasis.'</p>
                <p align="center"><span style="font-family: \'Times New Roman\', serif; font-size: large"><span lang="az-Latn-AZ"><strong>?? M R &nbsp; E D ?? R ?? M:</strong></span></span></p>
                <p lang="az-Latn-AZ" align="center">&nbsp;</p>
                <div class="container">
                <table>
                    <tbody>
                        <tr>
                            <td class="table-width-50"><b>1. ??ntizam t??nbehin?? c??lb olunan i????inin soyad??, ad??, atas??n??n ad??: </b></td>
                            <td>' . $fileData->discipline[0]->userId->firstName .' '. $fileData->discipline[0]->userId->lastName . ' ' . $fileData->discipline[0]->userId->patronymic . '</td>
                            
                        </tr>
                        <tr>
                            <td><b>2. ????l??diyi struktur b??lm??:</b></td>
                            <td>' . $getPos->positionId->structureId->name . '</td>
                        </tr>
                        <tr>
                            <td><b>3. V??zif??si: </b></td>
                            <td>' . $getPos->positionId->posNameId->name . '</td>
                        </tr>
                        <tr>
                            <td><b>4. ??????inin c??lb edildiyi intizam t??nbehi : </b></td>
                            <td>' . $fileData->discipline[0]->listDisciplinaryActionId->name . '</td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>5. ??nsan Resurslar?? Departamentin?? tap????r??ls??n ki, ??mrin sur??ti il?? aidiyy??ti ????xs tan???? edilsin.</b></td>
                        </tr>
                        <tr>
                            <td>&nbsp</td>    
                        </tr>
                        <tr>
                            <td colspan="2">??sas: Struktur b??lm?? r??hb??rinin t??qdimat?? ' . $isExplanation . ' <br> T??qdimat?? t??qdim ed??n struktur b??lm?? r??hb??rinin<br> soyad??, ad??, atas??n??n ad??:  ' . $fileData->discipline[0]->executorUserId->firstName .' '. $fileData->discipline[0]->executorUserId->lastName . ' ' . $fileData->discipline[0]->executorUserId->patronymic . '<br>Struktur b??lm??: '. $str2 .'<br> V??zif??si:  ' . $pos2 . '</td>
                        </tr>
                    </tbody>
                </table>
                <table>
                </div>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p style="text-align: left;"><strong>Ba?? direktor :
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Taleh Ziyadov</strong></p>
                </table>';
    }

    public function educationVacation($fileData){

        $dates = '';

//         dd($fileData);
        if($fileData->child->label=='education_vacation' || $fileData->child->label=='paid_social_vacation' || $fileData->child->label=='paid_educational_vacation' || $fileData->child->label=='nonpaid_vacation'){
            return $this->sabbaticalLeaveHtml($fileData);
        }
        else {

            $table = 'test';

            return $table;
        }
    }

    public function additionalWorkTime($filedata){
        $data    = $filedata;
        $workers = $filedata->additionalWorkTime->order->workers;
        $date    = $filedata->additionalWorkTime->order->date;



            $tablehead = '
            <table width="100%" style="margin: 0 auto;">  
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <tr align="right" style="font-size: medium;">
                    <td colspan="2"><b>' . $data->listOrderTypes->text. ' haqq??nda</b></td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: medium">
                    <td colspan="2">
                        '. $data->additionalWorkTime->order->listExcessWorkTypeName .'
                    </td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: large">
                    <td colspan="2"><b>?? M R&nbsp;&nbsp;&nbsp;E D ?? R ?? M</b></td>
                </tr>
                <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>';
            $tablebody = '';
            for ($i=0; $i<sizeof($workers); $i++){

                $tablebody .= '
                <tr>
                    <td colspan="2">1. ?????? c??lb edil??n i????inin soyad??, ad??, atas??n??n ad??: <b>' . $workers[$i]->userName . '</b></td>
                </tr>
                <tr>
                    <td colspan="2">2. ?????? c??lb edil??n i????inin i??l??diyi struktur b??lm??: <b>' . $workers[$i]->structureName . '</b></td>
                </tr>
                <tr>
                    <td colspan="2">3. ?????? c??lb edil??n i????inin v??zif??si: <b>' . $workers[$i]->positionName . '</b></td>
                </tr>
                <tr>
                    <td colspan="2">4. ?????? c??lb edilm?? tarixi: <b>' . $date . '</b></td>
                </tr>
                <tr>
                    <td colspan="2">5. ?????? c??lb edilm?? saatlar??: <b>' . $workers[$i]->startTime . '-' . $workers[$i]->endTime . '</b></td>
                </tr>
                <tr>
                    <td colspan="2">6. Maliyy?? Departamentin?? tap????r??ls??n ki, i????iy?? Az??rbaycan Respublikas?? ??m??k M??c??ll??sinin 164-c?? madd??sinin 1-ci hiss??sin?? ??sas??n ??m??k haqq??  ikiqat m??bl????d?? ??d??nilsin.</td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                ';
            };

            $tablefoot = '
            <tr><td><p>&nbsp;</p></td></tr>
                <tr>
                    <td align="left"><b>Ba?? Direktor:</b></td>
                    <td align="right"><b>Taleh Ziyadov</b></td>
                </tr>
            </table>
            ';
            $table = $tablehead.$tablebody.$tablefoot;
            return $table;
    }

    public function warning($fileData){
        $id = $fileData->warning[0]->executorUserId->id;
        $executorPos = UserPositionController::getPosByUserId2($id);
        $users = $fileData->warning[0]->userId;
        $executor = $fileData->warning[0]->executorUserId;
        $exp = "";
        if ($fileData->warning[0]->isExplanation == true){$exp = "v?? i????inin izahat??";}

        $tablehead = '
            <table width="100%" style="margin: 0 auto;">  
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <tr align="right" style="font-size: medium;">
                    <td colspan="2"><b>' . $fileData->listOrderTypes->text. ' haqq??nda</b></td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: medium">
                    <td colspan="2">
                        '.$fileData->orderBasis.'. AR ??m??k M??c??ll??sinin 186.3-c?? madd??sini v?? C??miyy??tin Daxili Nizam-intizam Qaydalar??n?? r??hb??r tutaraq, ??m??k v?? icra intizam??na riay??t edilm??sini g??cl??ndirm??k m??qs??dil??,
                    </td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: large">
                    <td colspan="2"><b>?? M R&nbsp;&nbsp;&nbsp;E D ?? R ?? M</b></td>
                </tr>
                <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>';
        $tablebody = '';
        for ($i=0; $i<sizeof($users); $i++){

            $tablebody .= '
                <tr>
                    <td colspan="2">1. A??a????da ad?? qeyd olunan i????iy?? x??b??rdarl??q edilsin.</td>
                </tr>
                <tr>
                    <td>
                        <ul>
                            <li>X??b??rdarl??q edil??n i????inin soyad??, ad??, atas??n??n ad??: <b>'.$users[$i]->name.'</b></li>
                            <li>??????inin i??l??diyi struktur b??lm??: <b>'.$users[$i]->strName.'</b></li>
                            <li>??????inin v??zif??si: <b>'.$users[$i]->posName.'</b></li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">2. ??nsan Resurslar?? Departamentin?? tap????r??ls??n ki, aidiyy??ti ????xs ??mrl?? tan???? edilsin.</td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                ';
        };

        $tablefoot = '
            <tr>
                <td colspan="2">??sas: Struktur b??lm?? r??hb??rinin t??qdimat?? '. $exp .'.</td>
            </tr>
            <tr>
                <td colspan="2">T??qdimat sahibinin soyad??, ad??, atas??n??n ad??: <b>'.$executor->lastName.' '.$executor->firstName.' '.$executor->patronymic.'</b></td>
            </tr>
            <tr>
                <td colspan="2">Struktur b??lm??: <b>'.$executorPos->positionId->structureId  ->name.'</b></td>
            </tr>
            <tr>
                <td colspan="2">V??zif??si: <b>'.$executorPos->positionId->posNameId->name.'</b></td>
            </tr>
            <tr><td><p>&nbsp;</p></td></tr>
                <tr>
                    <td align="left"><b>Ba?? Direktor:</b></td>
                    <td align="right"><b>Taleh Ziyadov</b></td>
                </tr>
            </table>
            ';
        $table = $tablehead.$tablebody.$tablefoot;
        return $table;

    }

    public function Reward($fileData){

        $reward = $fileData->Reward[0];
        if ($reward->includingTaxes == true) {
            $includingTaxes = "vergil??r v?? dig??r ??d??ni??l??r daxil olmaqla";
        }else{
            $includingTaxes = "vergil??r v?? dig??r ??d??ni??l??r xaric olmaqla";
        }

        $table = '
            <table width="100%" style="margin: 0 auto;">  
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <tr align="right" style="font-size: medium;">
                    <td colspan="2"><b><em>'.$fileData->listOrderTypes->text.'</em></b></td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: medium">
                    <td colspan="2">
                        ??m??k funksiyas??n?? y??ks??k pe????karl??q s??viyy??sind?? yerin?? yetirdiyin??, ??z??rin?? d??????n v??zif?? ??hd??likl??rini tam m??suliyy??tl?? icra etdiyin?? g??r??, Az??rbaycan Respublikas?? ??m??k M??c??ll??sinin 185-ci madd??sini r??hb??r tutaraq, i????ini h??v??sl??ndirm??k m??qs??dil??,
                    </td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: large">
                    <td colspan="2"><b>??MR ED??R??M</b></td>
                </tr>
                <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                <tr>
                    <td colspan="2">1. M??kafatland??r??lan i????inin soyad??, ad??, atas??n??n ad??: <b>'.$reward->userId->text.'</b></td>
                </tr>
                <tr>
                    <td colspan="2">2. Struktur b??lm??: <b>'.$reward->structure.'</b></td>
                </tr>
                <tr>
                    <td colspan="2">3. V??zif??si: <b>'.$reward->positionName.'</b></td>
                </tr>
                <tr>
                    <td colspan="2">4. M??kafat??n m??bl????i AZN ('.$includingTaxes.'): <b>'.$reward->rewardAmount.'</b></td>
                </tr>
                <tr>
                    <td colspan="2">5. Maliyy?? Departamentin?? tap????r??ls??n ki, bu ??mrd??n ir??li g??l??n m??s??l??l??rin h??llini t??min etsin.</td>
                </tr>
                <tr>
                    <td colspan="2">6. ??nsan Resurslar?? Departamentin?? tap????r??ls??n ki, ??mrin sur??ti il?? aidiyyat?? ????xs tan???? edilsin.</td>
                </tr>
               
                <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                <tr>
                    <td align="left"><b>Ba?? Direktor:</b></td>
                    <td align="right"><b>Taleh Ziyadov</b></td>
                </tr>
            </table>
        ';
        return $table;
    }

    public function damage($fileData){

        $data   = $fileData->damage->RelUserDamage->data[0];
        $userid = $data->relUserPaymentsId->userId;

        $table = '
            <table width="100%" style="margin: 0 auto;">  
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <tr align="right" style="font-size: medium;">
                    <td colspan="2"><b>?????m??k haqq??ndan tutulma bar??d?????</b></td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: medium">
                    <td colspan="2">
                        <!--S??b??b-->
                    </td>
                </tr>
                <tr align="center" style="font-size: 11pt">
                    <td colspan="2">
                        <em>G??st??ril??nl??ri n??z??r?? alaraq, m????ssis??daxili intizam qaydalar??n?? g??cl??ndirm??k  v?? d??ymi?? maddi ziyan??n b??rpa olunmas?? m??qs??dil??</em>
                    </td>
                </tr>
                <tr><td colspan="2"><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: large">
                    <td colspan="2"><b>??MR ED??R??M</b></td>
                </tr>
                <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                <tr>
                    <td colspan="2">1. A??a????da ad?? qeyd olunan i????inin ayl??q ??m??k haqq??ndan qeyd olunan m??bl???? tutulsun.</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <ul>
                            <li>??????inin soyad??, ad??, atas??n??n ad??: <b>'.$userid->lastName.' '.$userid->firstName.' '.$userid->patronymic.' </b></li>
                            <li>????l??diyi struktur b??lm??: <b>'.$data->positionId->structureId->name.'</b></li>
                            <li>V??zif??si: <b>'.$data->positionId->posNameId->name.'</b></li>
                            <li>Tutulma m??bl????i: <b>'.$data->valueTotal.'</b></li>
                            <li>Tutulaca???? aylar: <b>'.$data->relUserPaymentsId->startDate.' - '.$data->relUserPaymentsId->endDate.'</b></li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">2. Maliyy?? Departamentin?? tap????r??ls??n ki, ??m??k haqq??ndan tutulma m??s??l??l??rini h??ll etsin.</td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr>
                    <td colspan="2">??sas: '.$fileData->orderBasis.'</td>
                </tr>
                <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                <tr>
                    <td align="left"><b>Ba?? Direktor:</b></td>
                    <td align="right"><b>Taleh Ziyadov</b></td>
                </tr>
            </table>
        ';
        return $table;
    }

    public function salaryDeduction($fileData){
        dd($fileData);
    }

   
  
}