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
            $appType = 'İşə qəbul barədə';
        }
        elseif ($fileData->appointment[0]->appointmentType == 2){
            $appType = 'Yerdəyişmə barədə';
        }else{
            $appType = 'İşə qəbul və yerdəyişmə barədə';
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
                <p style="text-align: center; font-size: large"><strong>ƏMR </strong></p>
                <p>&nbsp;</p>
                <p style="text-align: center;">İşçinin ərizəsi və onunla bağlanmış əmək müqaviləsinə əsasən,</p>
                <p>&nbsp;</p>
                <p style="text-align: center; font-size: large"><strong>Ə M R&nbsp;&nbsp; E D İ R Ə M:</strong></p>
                <p>&nbsp;</p>
                <table class="ml-40 pull-left">
                    <tr>
                        <td style="padding-right: 120px"><b>1. İşçinin soyadı, adı, atasının adı:</b></td>
                        <td>'.$employee.'</td>
                    </tr>
                    <tr>
                        <td><b>2. İşə qəbul olduğu struktur bölmə:</b></td>
                        <td>'.$structureSection.'</td>
                    </tr>
                    <tr>
                        <td><b>3. İşə qəbul olduğu vəzifə:</b></td>
                        <td>'.$structurePosition.'</td>
                    </tr>
                    <tr>
                        <td><b>4. İşə qəbul tarixi:</b></td>
                        <td>'.$fileData->appointment[0]->startDate.'</td>
                    </tr>
                    <tr>
                        <td><b>5. Sınaq müddəti:</b></td>
                        <td>'. $trialPeriodMonth .'</td>
                    </tr>
                    <tr>
                        <td><b>6. Əmək haqqı:</b></td>
                        <td> '. $totalSalaryAppointment .' AZN (vergilər və digər ödənişlər daxil olmaqla)</td>
                    </tr>
                </table>
                <table class="ml-60 pull-left">
                    <tr>
                        <td class="pr-30"><li>Ştat üzrə əsas əmək haqqı:</li></td>
                        <td>'. $positionPayment .' AZN </td>
                    </tr>
                    <tr>
                        <td><li>Əmək şəraitinə görə əlavə:</li></td>
                        <td>'. $conditionalPayment .' AZN </td>
                    </tr>
                    <tr>
                        <td><li>Digər fərdi əlavə:</li></td>
                        <td>'. $addSalary .' AZN</td>
                    </tr>
                </table>
                <table class="ml-40 pull-left">
                    <tr>
                        <td>7. İnsan Resursları və Maliyyə Departamentlərinə tapşırılsın ki, əmrdən irəli gələn zəruri məsələlərin həllini təmin etsin.</td>
                    </tr>
                </table>
                <table><tr><td>
                </div>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p style="text-align: left;"><strong>Baş direktor :
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
                <p style="text-align: center; font-size: large"><strong>ƏMR </strong></p>
                <p>&nbsp;</p>
                <p style="text-align: center;">İşçinin ərizəsi və onunla bağlanmış əmək müqaviləsinə əsasənaa,</p>
                <p>&nbsp;</p>
                <p style="text-align: center; font-size: large"><strong>Ə M R&nbsp;&nbsp; E D İ R Ə M:</strong></p>
                <p>&nbsp;</p>
                <table class="ml-40 pull-left">
                    <tr>
                        <td style="padding-right: 120px"><b>1. İşçinin soyadı, adı, atasının adı:</b></td>
                        <td>'.$employee.'</td>
                    </tr>
                    <tr>
                        <td><b>2. Faktiki işlədiyi struktur bölmə:</b></td>
                        <td>'.$oldStructure.'</td>
                    </tr>
                    <tr>
                        <td><b>3. Faktiki işlədiyi vəzifə:</b></td>
                        <td>'.$oldPosition.'</td>
                    </tr>
                    <tr>
                        <td><b>4. Dəyişiklik tarixi:</b></td>
                        <td>'.$fileData->appointment[0]->startDate.'</td>
                    </tr>
                    <tr>
                        <td><b>2. Keçirildiyi struktur bölmə:</b></td>
                        <td>'.$structureSection.'</td>
                    </tr>
                    <tr>
                        <td><b>3. Keçirildiyi vəzifə vəzifə:</b></td>
                        <td>'.$structurePosition.'</td>
                    </tr>
                    <tr>
                        <td><b>3. Keçirilmə müddəti:</b></td>
                        <td> - </td>
                    </tr>
                    <tr>
                        <td><b>6. Əmək haqqı:</b></td>
                        <td> '. $totalSalaryAppointment .' AZN (vergilər və digər ödənişlər daxil olmaqla)</td>
                    </tr>
                </table>
                <table class="ml-60 pull-left">
                    <tr>
                        <td class="pr-30"><li>Ştat üzrə əsas əmək haqqı:</li></td>
                        <td>'. $positionPayment .' AZN</td>
                    </tr>
                    <tr>
                        <td><li>Əmək şəraitinə görə əlavə:</li></td>
                        <td>'. $conditionalPayment .' AZN </td>
                    </tr>
                    <tr>
                        <td><li>Digər fərdi əlavə:</li></td>
                        <td>'. $addSalary . ' AZN </td>
                    </tr>
                </table>
                <table class="ml-40 pull-left">
                    <tr>
                        <td>7. İnsan Resursları və Maliyyə Departamentlərinə tapşırılsın ki, əmrdən irəli gələn zəruri məsələlərin həllini təmin etsin.</td>
                    </tr>
                </table>
                <table><tr><td>
                </div>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p style="text-align: left;"><strong>Baş direktor :
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
                    <td colspan="2"><b><em>“Əmək haqqına əlavənin edilməsi barədə”</em></b></td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: medium">
                    <td colspan="2">
                        Azərbaycan Respublikası Əmək Məcəlləsinin 185-ci maddəsini rəhbər tutaraq, işçinin ştat üzrə əmək haqqına fərdi əlavə edilməsi məqsədilə,
                    </td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: large">
                    <td colspan="2"><b>ƏMR EDİRƏM</b></td>
                </tr>
                <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                <tr>
                    <td colspan="2">1. Aşağıda adı qeyd olunan işçinin ştat üzrə əmək haqqında əlavə təyin edilsin.</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <ul>
                            <li>İşçinin soyadı, adı, atasının adı: <b>'.$data->userId->lastName.' '.$data->userId->firstName.' '.$data->userId->patronymic.'</b></li>
                            <li>İşlədiyi struktur bölmə: <b>'.$workData->structureId->name.'</b></li>
                            <li>Vəzifəsi: <b>'.$workData->posNameId->name.'</b></li>
                            <li>Fərdi əlavənin məbləği (vergilər və digər ödənişlər daxil olmaqla): <b>'.$data->valus.' '.$amount.'</b></li>
                            <li>Fərdi əlavənin verildiyi tarix: <b>'.$data->startDate.'</b></li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">2. İnsan Resursları və Maliyyə Departamentlərinə tapşırılsın ki, bu əmrdən irəli gələn məsələlərin həllini təmin etsin.</td>
                </tr>
                <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                <tr>
                    <td align="left"><b>Baş Direktor:</b></td>
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
            'text' => 'İşçinin soyadı, adı, atasının adı',
            'val'  =>  $fileData->dismissal[0]->relUserInOrderDismissalList[0]->text
        ];


        /* structure */
        $structure    = [
            'text' => 'İşlədiyi struktur bölmənin adı',
            'val'  =>  $fileData->dismissal[0]->listStructures->text
        ];

        /* position of user  */
        $position     = [
            'text' => 'Vəzifəsi',
            'val'  =>  $fileData->dismissal[0]->listPositionNames->text
        ];

        /* date of dismissal row */
        $date         = [
            'text' => 'İşdən azad olma tarixi',
            'val'  =>  $fileData->dismissal[0]->dismissalDate
        ];


        /* reason of dismissal row */
        $reason       = [
            'text' => 'İşdən azad olma səbəbi',
            'val'  =>  $fileData->dismissal[0]->listDismissalTypeId->text
        ];

        /* compensation row */
        $compensation = [
            'text' => 'İstifadə edilməmiş məzuniyyət günlərinə görə kompensasiya',
            'val'  =>  '---'
        ];

        /* notes row */
        $notes        = [
            'text' => 'Qeyd',
            'val'  =>  $note
        ];

        /*bursar task row */
        $bursar       = [
            'text' => 'Maliyyə Departamentinə tapşırılsın ki, ödəniş məsələlərini həll etsin',
            'val'  =>  null
        ];

        /* info to hr row */
        $hr           = [
            'text' => 'İnsan Resursları Departamentinə tapşırılsın ki, əmrlə işçi tanış edilsin',
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
        <p align="right"><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: small;"><span style="font-size: large;"><span lang="az-Latn-AZ"><strong>&rdquo;Əmək müqaviləsinə xitam verilməsi barədə&rdquo;</strong></span></span></span></span></p>
                <p lang="az-Latn-AZ" align="right">&nbsp;</p>
                <p align="center">&nbsp;</p>
                <p align="center"><span style="font-family: \'Times New Roman\', serif; font-size: large"><span lang="az-Latn-AZ"><strong>Ə M R &nbsp; E D İ R Ə M:</strong></span></span></p>
                <p lang="az-Latn-AZ" align="center">&nbsp;</p>
                <div class="container">
                <table>
                    '.$rows.'
                </table>
                </div>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p style="text-align: left;"><strong>Baş direktor :
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
                        <td style="padding-right: 80px"><b>Məzuniyyətin başlandığı tarix:</b></td>
                        <td>'.$data->child->startDate.'</td>
                    </tr>
                    <tr>
                        <td><b>Məzuniyyətin qurtardığı tarix:</b></td>
                        <td>'.$data->child->endDate.'</td>
                    </tr>
                    <tr>
                        <td><b>Məzuniyyət g&uuml;nlərinin sayı:</b></td>
                        <td>'.$data->child->vacationDay.'</td>
                    </tr>';

            $table = '<style>td{height:30px !important;}td > p{margin-bottom:0}</style>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                    <table cellspacing="0">
                    <tbody>
                    <tr>
                    <td colspan="2">
                    <p align="center"><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>'.$data->child->listVacationName.'</strong>&nbsp;<strong>məzuniyyətinin&nbsp;verilməsi&nbsp;haqqında</strong></span></span></p>
                    <p>&nbsp</p>
                    <p>&nbsp</p>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="2" valign="bottom">
                    <p align="center"><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: large;"><strong>Əmr №: '.$data->orderNumber.'</strong></span></span></p>
                    <p>&nbsp</p>
                    <p>&nbsp</p>
                    </td>
                    </tr>
                    <tr>
                        <td><b>İş&ccedil;i:</b></td>
                        <td>'.$data->child->userName.'</td>
                    </tr>
                    <tr>
                        <td><b>İşlədiyi struktur b&ouml;lmə:</b></td>
                        <td>'.$data->child->userStructure->structureIdName.'</td>
                    </tr>
                    <tr>
                        <td><b>Vəzifəsi (peşəsi):</b></td>
                        <td>'.$data->child->userStructure->posNameIdName.'</td>
                    </tr>
                    <tr>
                        <td style="padding-right: 20px"><b>Məzuniyyətin verilməsinin əsasları və g&uuml;nlərinin sayı:</b></td>
                        <td>'.$data->child->listVacationName.'-'.$data->child->vacationDay.'</td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Kollektiv m&uuml;qavilənin 9.1.7 maddəsinə əsasən-2, 5, və ya 7</b></td>
                    </tr>
                    '.$dates.'
                    <tr>
                        <td><b>İşə çıxma tarixi:</b></td>
                        <td>'.$data->child->workStartDate.'</td>
                    </tr> 
                    <tr>
                        <td><b>Qərarın verilməsi &uuml;&ccedil;&uuml;n əsaslar:</b></td>
                        <td>'.$data->orderBasis.'</td>
                    </tr>  
                    <tr>
                        <td colspan="2">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p style="text-align: left;"><strong>Baş direktor :
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
                        <td colspan="2"><b>“İşçiyə '.$fileData->child->listVacationTypeName.' verilməsi barədə”</b></td>
                    </tr>
                    <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                    <tr align="center" style="font-size: large">
                        <td colspan="2"><b>ƏMR EDİRƏM:</b></td>
                    </tr>
                    <tr><td><p>&nbsp;</p></td></tr>
                    <tr align="center">
                        <td colspan="2">Aşağıda məlumatları qeyd olunan işçiyə '.$fileData->child->listVacationTypeName.' verilsin.</td>
                    </tr>
                    <tr><td><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                    <tr>
                        <td><b>1. İşçinin soyadı, adı, atasının adı</b></td>
                        <td>'.$fileData->child->userName.'</td>
                    </tr>
                    <tr>
                        <td><b>2. Struktur bölmə</b></td>
                        <td>'.$fileData->child->userStructure->structureIdName.'</td>
                    </tr>
                    <tr>
                        <td><b>3. Vəzifəsi</b></td>
                        <td>'.$fileData->child->userStructure->posNameIdName.'</td>
                    </tr>
                    <tr>
                        <td><b>4. Məzuniyyətə buraxılma tarixləri</b></td>
                        <td>'.$fileData->child->startDate.' - '.$fileData->child->endDate.'</td>
                    </tr>
                    <tr>
                        <td><b>5. Məzuniyyətin müddəti</b></td>
                        <td>'.$fileData->child->vacationDay.'</td>
                    </tr>
                    <tr>
                        <td><b>6. İşə başlama tarixi</b></td>
                        <td>'.$fileData->child->workStartDate.'</td>
                    </tr>
                    <tr>
                        <td><b>7. Əlavə qeydlər</b></td>
                        <td></td>
                    </tr>
                    <tr><td><p>&nbsp;</p></td></tr>
                    <tr>
                        <td colspan="2"><b>&nbsp;&nbsp;&nbsp;&nbsp;Əsas: </b>'.$fileData->orderBasis.'</td>
                    </tr>
                    <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                    <tr>
                        <td align="left"><b>Baş Direktor:</b></td>
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
                        <td colspan="2"><b>“Qismən ödənişli sosial məzuniyyətin verilməsi barədə”</b></td>
                    </tr>
                    <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                    <tr align="center" style="font-size: medium">
                        <td colspan="2">' . $fileData->orderBasis . ',</td>
                    </tr>
                    <tr><td><p>&nbsp;</p></td></tr>
                    <tr align="center" style="font-size: large">
                        <td colspan="2"><b>ƏMR EDİRƏM</b></td>
                    </tr>
                    <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                    <tr>
                        <td colspan="2">1. Aşağıda məlumatları qeyd olunan işçiyə qismən ödənişli sosial məzuniyyət verilsin.</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <ul>
                                <li>İşçinin soyadı, adı, atasının adı:&nbsp;&nbsp;' . $fileData->child->userName . '</li>
                                <li>İşlədiyi struktur bölmə:&nbsp;&nbsp;' . $fileData->child->userStructure->structureIdName . '</li>
                                <li>Vəzifəsi:&nbsp;&nbsp;' . $fileData->child->userStructure->posNameIdName . '</li>
                                <li>Qismən ödənişli sosial məzuniyyətə buraxılma tarixləri:&nbsp;&nbsp;' . $fileData->child->startDate . ' - ' . $fileData->child->endDate . '</li>
                                <li>Qismən ödənişli sosial məzuniyyətin müddəti:&nbsp;&nbsp;' . $fileData->child->vacationDay . '</li>
                                <li>İşə başlama tarixi:&nbsp;&nbsp;' . $fileData->child->workStartDate . '</li>
                                <li>Əlavə qeydlər:&nbsp;&nbsp;</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">2. İnsan Resursları və Maliyyə Departamentlərinə tapşırılsın ki, əmrdən irəli gələn məsələlərin həllini təmin etsin.</td>
                    </tr>
                    <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                    <tr>
                        <td align="left"><b>Baş Direktor:</b></td>
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
                        <td colspan="3"><b>“İşçiyə əmək məzuniyyəti verilməsi barədə”</b></td>
                    </tr>
                    <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                    <tr align="center" style="font-size: large">
                        <td colspan="3"><b>ƏMR EDİRƏM:</b></td>
                    </tr>
                    <tr><td><p>&nbsp;</p></td></tr>
                    <tr align="center">
                        <td colspan="3">Aşağıda adı qeyd olunan işçiyə əmək məzuniyyəti verilsin.</td>
                    </tr>
                    <tr><td><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                    <tr> 
                        <td><b>1. İşçinin soyadı, adı, atasının adı</b></td>
                        <td>'.$fileDataObj->userIdLastName.' '.$fileDataObj->userIdFirstName.' '.$fileDataObj->userIdPatronymic.'</td>
                    </tr>
                    <tr>
                        <td><b>2. Struktur bölmə</b></td>
                        <td>'.$fileDataObj->structureIdName.'</td>
                    </tr>
                    <tr>
                        <td><b>3. Vəzifəsi</b></td>
                        <td>'.$fileDataObj->posNameIdName.'</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>4. Məzuniyyətin iş ili dövrü (dövrləri)</b></td></tr>';
            foreach($fileData->vacation->data as $dataPeriod) {

                $table=$table.'<tr><td></td><td> '.$dataPeriod->vacationWorkPeriodFrom.' </td><td> '.$dataPeriod->vacationWorkPeriodTo.'</td ></tr>';

            }
            $table=$table.'</tr>
                    <tr>
                        <td><b>5. Məzuniyyət müddəti</b></td>
                   </tr>
                    
                    <tr>

                        <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Əsas</td></tr>';
            foreach($fileData->vacation->data as $dataP) {
                $table=$table.'<td></td><td align = "center" > '.$dataP->mainVacationDay.'</td >
                        <td align = "center" > '.$dataP->mainVacationDay.'</td ></tr>';
            }



            $totalExpRow='<tr><td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Staja görə əlavə</td></tr>';
            $totalWorkConditionDay='<tr><td colspan="3">Əmək şəraitinə görə</td></tr>';
            $totalchild142Row='<tr><td colspan="3">14 yaşınadək &nbsp;&nbsp;&nbsp;2 uşağı olan qadınlara verilən əlavə</td></tr>';
            $totalchild143Row='<tr><td colspan="3">14 yaşınadək &nbsp;&nbsp;&nbsp;3 və daha çox uşağı olan qadınlara verilən əlavə</td></tr>';
            $allWomenDayRow='<tr><td colspan="3">Kollektiv müqaviləyə əsasən qadınlara verilən əlavə məzuniyyət</td></tr>';
            $totalChernobylAccidenDayRow='<tr><td colspan="3">&nbsp;Kollektiv müqaviləyə əsasən Çernobil qəzasının ləğvində iştirak etmiş və ya həmin qəzada zərər çəkmiş işçilərə verilən əlavə</td></tr>';
            foreach($fileData->vacation->orderVacationDetailAddArray as $key=>$wholeRow) {
                $totalExpRow = $totalExpRow . '<tr><td></td><td align="center">' . $fileData->vacation->orderVacationDetailAddArray[$key]->totalExperienceDay . '</td><td align="center">' . $fileData->vacation->orderVacationDetailAddArray[$key]->totalExperienceDay . '</td></tr>';
                $totalWorkConditionDay = $totalWorkConditionDay  . '<tr><td></td><td align="center">' . $fileData->vacation->orderVacationDetailAddArray[$key]->totalWorkConditionDay . '</td><td align="center">' . $fileData->vacation->orderVacationDetailAddArray[$key]->totalWorkConditionDay . '</td></tr>';

                $totalchild142Row = $totalchild142Row . '<tr><td></td><td align="center">' . $fileData->vacation->orderVacationDetailAddArray[$key]->totalChild142 . '</td><td align="center">' . $fileData->vacation->orderVacationDetailAddArray[$key]->totalChild142 . '</td></tr>';
                $totalchild143Row = $totalchild143Row . '<tr><td></td><td align="center">' . $fileData->vacation->orderVacationDetailAddArray[$key]->totalChild143 . '</td><td align="center">' . $fileData->vacation->orderVacationDetailAddArray[$key]->totalChild143 . '</td></tr>';
                $allWomenDayRow = $allWomenDayRow  . '<tr><td></td><td align="center">' . $fileData->vacation->orderVacationDetailCollectiveArray[$key]->allWomenDay . '</td><td align="center">' . $fileData->vacation->orderVacationDetailCollectiveArray[$key]->allWomenDay . '</td></tr>';
                $totalChernobylAccidenDayRow = $totalChernobylAccidenDayRow  . '<tr><td></td><td align="center">' . $fileData->vacation->orderVacationDetailCollectiveArray[$key]->totalChernobylAccidenDay . '</td><td align="center">' . $fileData->vacation->orderVacationDetailCollectiveArray[$key]->totalChernobylAccidenDay . '</td></tr>';

            }
//                    $table=$table+'<tr>
//                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Kollektiv müqaviləyə əsasən qadınlara verilən əlavə məzuniyyət</td>
//                        <td align="center">'.$fileData->vacation->orderVacationDetailCollectiveArray[0]->allWomenDay.'</td>
//                        <td align="center">'.$fileData->vacation->orderVacationDetailCollectiveArray[1]->allWomenDay.'</td>
//                    </tr>
//                    <tr>
//                        <td class="table-width-50">&nbsp;&nbsp;&nbsp;&nbsp;Kollektiv müqaviləyə əsasən Çernobil qəzasının ləğvində iştirak etmiş və ya həmin qəzada zərər çəkmiş işçilərə verilən əlavə</td>
//                        <td align="center">'.$fileData->vacation->orderVacationDetailCollectiveArray[0]->totalChernobylAccidenDay.'</td>
//                        <td align="center">'.$fileData->vacation->orderVacationDetailCollectiveArray[1]->totalChernobylAccidenDay.'</td>
//                    </tr>

            $table=$table.$totalExpRow.$totalWorkConditionDay.$totalchild142Row.$totalchild143Row.$allWomenDayRow.$totalChernobylAccidenDayRow.'<tr><td><b>6. Məzuniyyətin cəmi müddəti</b></td>

                        <td>'.$fileData->vacation->data[0]->totalVacationDay.'</td>
                    </tr>
                    <tr>
                        <td><b>7. Məzuniyyətə buraxılma tarixləri</b></td></tr>';

            foreach($fileData->vacation->data as $wholeRow) {
                $table=$table.'<tr><td></td><td > '.$wholeRow->startDate.'</td ><td> '.$wholeRow->startDate.'</td></tr>';
            }

            $table=$table.'<tr>
                        <td><b>8. İşə başlama tarixi</b></td>
                        <td>'.$fileDataObj->wsDate.'</td>
                    </tr>
                    <tr>
                        <td><b>9. Əlavə qeydlər</b></td>
                        <td></td>
                    </tr>
                    <tr><td><p>&nbsp;</p></td></tr>
                    <tr>
                        <td colspan="3"><b>&nbsp;&nbsp;&nbsp;&nbsp;Əsas: </b>'.$orderBasis.'</td>
                    </tr>
                    <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                    <tr>
                        <td align="left"><b>Baş Direktor:</b></td>
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
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>Məzuniyyətin əhatə etdiyi iş ili (illəri):</strong> &nbsp;&nbsp;&nbsp; ' . $date->vacationWorkPeriodFrom . ' &mdash; ' . $date->vacationWorkPeriodTo . '</span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 270.4px;" colspan="8" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>Məzuniyyətin başlandığı tarix:</strong> &nbsp;&nbsp;&nbsp; ' . $date->startDate . '</span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 270.4px;" colspan="8" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>Məzuniyyətin qurtardığı tarix (Əl ilə yazılır)</strong></span></span><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>:</strong></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 270.4px;" colspan="8" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>Məzuniyyət g&uuml;nlərinin sayı:</strong> &nbsp;&nbsp;&nbsp; ' . $date->vacationDay . '</span></span></p>
                    </td>
                    </tr><br>';
            }

            $table = '<style>td{height:30px !important;}td > p{margin-bottom:0}</style>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                    <table width="780" cellspacing="0">
                    <tbody>
                    <tr>
                    <td style="width: 706.4px;" colspan="21">
                    <p align="center"><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: large;"><strong>Əmək</strong>&nbsp;<strong>məzuniyyətinin&nbsp;verilməsi&nbsp;haqqında</strong></span></span></p>
                    <p>&nbsp</p>
                    <p>&nbsp</p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 706.4px;" colspan="21" valign="bottom">
                    <p align="center"><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: large;"><strong>Əmr №: ' . $fileData->orderNumber . '</strong></span></span></p>
                    <p>&nbsp</p>
                    <p>&nbsp</p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 56px;" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>İş&ccedil;i: &nbsp; &nbsp; &nbsp; ' . $fileData->vacation[0]->userIdLastName . ' ' . $fileData->vacation[0]->userIdFirstName . ' ' . $fileData->vacation[0]->userIdPatronymic . '</strong></span></span></p>
                    </td>
                    <td style="width: 620.8px;" colspan="19" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong></strong></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 229.6px;" colspan="6" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>İşlədiyi struktur b&ouml;lmə: &nbsp;&nbsp;&nbsp;&nbsp; ' . $fileData->vacation[0]->structureIdName . '</strong></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 164px;" colspan="4" valign="bottom">
                    <p><span style="font-family: \'Time s New Roman\', serif;"><span style="font-size: medium;"><strong>Vəzifəsi (peşəsi): &nbsp;&nbsp;&nbsp; ' . $fileData->vacation[0]->posNameIdName . '</strong></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 706.4px;" colspan="21" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>Məzuniyyətin verilməsinin əsasları və g&uuml;nlərinin sayı (faktiki ne&ccedil;ə g&uuml;n var):</strong></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 391.2px;" colspan="12" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>AR ƏM-nin 114-c&uuml; maddəsi, əsas məzuniyyət-30 və ya 21 gün</strong></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 391.2px;" colspan="12" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><span lang="en-US"><strong>AR ƏM-nin 116.1-ci maddəsi, əsas stajına g&ouml;rə-2, 4 və ya 6</strong></span></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 391.2px;" colspan="12" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><span lang="en-US"><strong>AR ƏM-nin 115.1-ci maddəsi, zərərə g&ouml;rə-6</strong></span></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 706.4px;" colspan="21" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>Kollektiv m&uuml;qavilənin 9.1.7 maddəsinə əsasən-2, 5, və ya 7</strong></span></span></p>
                    </td>
                    </tr>
                    ' . $dates . '
                    <tr>
                    <td style="width: 475.2px;" colspan="14" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>Məzuniyyət d&ouml;vr&uuml;nə d&uuml;şən bayram (h&uuml;zn) g&uuml;nləri:</strong></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 270.4px;" colspan="8" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>İşə çıxma tarixi: ' . $fileData->vacation[0]->wsDate . '</strong></span></span></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 270.4px;" colspan="8" valign="bottom">
                    <p><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: medium;"><strong>Qərarın verilməsi &uuml;&ccedil;&uuml;n əsaslar: &nbsp;&nbsp;&nbsp; ' . $fileData->orderBasis . '</strong></span></span></p>
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
                    <p style="float: left; "><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: large;"><span lang="az-Latn-AZ"><strong>Baş direktor:</strong></span></span></span></p>
                    <p style="float: right;"><span style="font-family: \'Times New Roman\', serif; flo"><span style="font-size: large;"><span lang="az-Latn-AZ"><strong>Taleh Ziyadov</strong></span></span></span></p>
                    </td>
                    </tr>
                    </tbody>
                    </table>';

            return $table;
        }
    }

    // Work Experience - Əmək müqaviləsi

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
        <p align="right"><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: small;"><span style="font-size: large;"><span lang="az-Latn-AZ"><strong>&rdquo;Maddi yardım göstərilməsi barədə&rdquo;</strong></span></span></span></span></p>
                <p lang="az-Latn-AZ" align="right">&nbsp;</p>
                <p align="center">&nbsp;'.$fileData->orderBasis.'</p>
                <p align="center"><span style="font-family: \'Times New Roman\', serif; font-size: large"><span lang="az-Latn-AZ"><strong>Ə M R &nbsp; E D İ R Ə M:</strong></span></span></p>
                <p lang="az-Latn-AZ" align="center">&nbsp;</p>
                <div class="container">
                <table>
                    <tbody>
                        <tr>
                            <td class="table-width-50"><strong>1. İşçinin soyadı, adı, atasının adı:</strong></td>
                            <td class="table-width-50"> '.$fileData->financialAid[0]->userId->firstName .'&nbsp; '. $fileData->financialAid[0]->userId->lastName .'&nbsp; '. $fileData->financialAid[0]->userId->patronymic .' </td>
                        </tr>
                        <tr>
                            <td><strong>2. İşlədiyi struktur bölmənin adı:</strong></td>
                            <td> '. $strName .' </td>
                        </tr>
                        <tr>
                            <td><strong>3. Vəzifəsi:</strong></td>
                            <td> '. $posName .' </td>
                        </tr>
                        <tr>
                            <td><strong>4. Maddi yardımın məbləği<br> (vergilər və digər ödənişlər xaric olmaqla):</strong></td>
                            <td style="vertical-align: bottom"> '. $fileData->financialAid[0]->value .' AZN</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>5. İnsan Resursları və Maliyyə Departamentlərinə tapşırılsın ki, Əmrdən irəli gələn məsələlərin həllini təmin etsinlər.</strong></td>
                        </tr>
                    </tbody>
                </table>
                <table>
                </div>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p style="text-align: left;"><strong>Baş direktor :
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
            $isExplanation = ' və işçinin izahatı';
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
        <p align="right"><span style="font-family: \'Times New Roman\', serif;"><span style="font-size: small;"><span style="font-size: large;"><span lang="az-Latn-AZ"><strong>&rdquo;İntizam tənbehinə cəlb edilmə barədə&rdquo;</strong></span></span></span></span></p>
                <p lang="az-Latn-AZ" align="right">&nbsp;</p>
                <p align="center">&nbsp;'.$fileData->orderBasis.'</p>
                <p align="center"><span style="font-family: \'Times New Roman\', serif; font-size: large"><span lang="az-Latn-AZ"><strong>Ə M R &nbsp; E D İ R Ə M:</strong></span></span></p>
                <p lang="az-Latn-AZ" align="center">&nbsp;</p>
                <div class="container">
                <table>
                    <tbody>
                        <tr>
                            <td class="table-width-50"><b>1. İntizam tənbehinə cəlb olunan işçinin soyadı, adı, atasının adı: </b></td>
                            <td>' . $fileData->discipline[0]->userId->firstName .' '. $fileData->discipline[0]->userId->lastName . ' ' . $fileData->discipline[0]->userId->patronymic . '</td>
                            
                        </tr>
                        <tr>
                            <td><b>2. İşlədiyi struktur bölmə:</b></td>
                            <td>' . $getPos->positionId->structureId->name . '</td>
                        </tr>
                        <tr>
                            <td><b>3. Vəzifəsi: </b></td>
                            <td>' . $getPos->positionId->posNameId->name . '</td>
                        </tr>
                        <tr>
                            <td><b>4. İşçinin cəlb edildiyi intizam tənbehi : </b></td>
                            <td>' . $fileData->discipline[0]->listDisciplinaryActionId->name . '</td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>5. İnsan Resursları Departamentinə tapşırılsın ki, əmrin surəti ilə aidiyyəti şəxs tanış edilsin.</b></td>
                        </tr>
                        <tr>
                            <td>&nbsp</td>    
                        </tr>
                        <tr>
                            <td colspan="2">Əsas: Struktur bölmə rəhbərinin təqdimatı ' . $isExplanation . ' <br> Təqdimatı təqdim edən struktur bölmə rəhbərinin<br> soyadı, adı, atasının adı:  ' . $fileData->discipline[0]->executorUserId->firstName .' '. $fileData->discipline[0]->executorUserId->lastName . ' ' . $fileData->discipline[0]->executorUserId->patronymic . '<br>Struktur bölmə: '. $str2 .'<br> Vəzifəsi:  ' . $pos2 . '</td>
                        </tr>
                    </tbody>
                </table>
                <table>
                </div>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p style="text-align: left;"><strong>Baş direktor :
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
                    <td colspan="2"><b>' . $data->listOrderTypes->text. ' haqqında</b></td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: medium">
                    <td colspan="2">
                        '. $data->additionalWorkTime->order->listExcessWorkTypeName .'
                    </td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: large">
                    <td colspan="2"><b>Ə M R&nbsp;&nbsp;&nbsp;E D İ R Ə M</b></td>
                </tr>
                <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>';
            $tablebody = '';
            for ($i=0; $i<sizeof($workers); $i++){

                $tablebody .= '
                <tr>
                    <td colspan="2">1. İşə cəlb edilən işçinin soyadı, adı, atasının adı: <b>' . $workers[$i]->userName . '</b></td>
                </tr>
                <tr>
                    <td colspan="2">2. İşə cəlb edilən işçinin işlədiyi struktur bölmə: <b>' . $workers[$i]->structureName . '</b></td>
                </tr>
                <tr>
                    <td colspan="2">3. İşə cəlb edilən işçinin vəzifəsi: <b>' . $workers[$i]->positionName . '</b></td>
                </tr>
                <tr>
                    <td colspan="2">4. İşə cəlb edilmə tarixi: <b>' . $date . '</b></td>
                </tr>
                <tr>
                    <td colspan="2">5. İşə cəlb edilmə saatları: <b>' . $workers[$i]->startTime . '-' . $workers[$i]->endTime . '</b></td>
                </tr>
                <tr>
                    <td colspan="2">6. Maliyyə Departamentinə tapşırılsın ki, işçiyə Azərbaycan Respublikası Əmək Məcəlləsinin 164-cü maddəsinin 1-ci hissəsinə əsasən əmək haqqı  ikiqat məbləğdə ödənilsin.</td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                ';
            };

            $tablefoot = '
            <tr><td><p>&nbsp;</p></td></tr>
                <tr>
                    <td align="left"><b>Baş Direktor:</b></td>
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
        if ($fileData->warning[0]->isExplanation == true){$exp = "və işçinin izahatı";}

        $tablehead = '
            <table width="100%" style="margin: 0 auto;">  
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <tr align="right" style="font-size: medium;">
                    <td colspan="2"><b>' . $fileData->listOrderTypes->text. ' haqqında</b></td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: medium">
                    <td colspan="2">
                        '.$fileData->orderBasis.'. AR Əmək Məcəlləsinin 186.3-cü maddəsini və Cəmiyyətin Daxili Nizam-intizam Qaydalarını rəhbər tutaraq, əmək və icra intizamına riayət edilməsini gücləndirmək məqsədilə,
                    </td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: large">
                    <td colspan="2"><b>Ə M R&nbsp;&nbsp;&nbsp;E D İ R Ə M</b></td>
                </tr>
                <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>';
        $tablebody = '';
        for ($i=0; $i<sizeof($users); $i++){

            $tablebody .= '
                <tr>
                    <td colspan="2">1. Aşağıda adı qeyd olunan işçiyə xəbərdarlıq edilsin.</td>
                </tr>
                <tr>
                    <td>
                        <ul>
                            <li>Xəbərdarlıq edilən işçinin soyadı, adı, atasının adı: <b>'.$users[$i]->name.'</b></li>
                            <li>İşçinin işlədiyi struktur bölmə: <b>'.$users[$i]->strName.'</b></li>
                            <li>İşçinin vəzifəsi: <b>'.$users[$i]->posName.'</b></li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">2. İnsan Resursları Departamentinə tapşırılsın ki, aidiyyəti şəxs əmrlə tanış edilsin.</td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                ';
        };

        $tablefoot = '
            <tr>
                <td colspan="2">Əsas: Struktur bölmə rəhbərinin təqdimatı '. $exp .'.</td>
            </tr>
            <tr>
                <td colspan="2">Təqdimat sahibinin soyadı, adı, atasının adı: <b>'.$executor->lastName.' '.$executor->firstName.' '.$executor->patronymic.'</b></td>
            </tr>
            <tr>
                <td colspan="2">Struktur bölmə: <b>'.$executorPos->positionId->structureId  ->name.'</b></td>
            </tr>
            <tr>
                <td colspan="2">Vəzifəsi: <b>'.$executorPos->positionId->posNameId->name.'</b></td>
            </tr>
            <tr><td><p>&nbsp;</p></td></tr>
                <tr>
                    <td align="left"><b>Baş Direktor:</b></td>
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
            $includingTaxes = "vergilər və digər ödənişlər daxil olmaqla";
        }else{
            $includingTaxes = "vergilər və digər ödənişlər xaric olmaqla";
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
                        Əmək funksiyasını yüksək peşəkarlıq səviyyəsində yerinə yetirdiyinə, üzərinə düşən vəzifə öhdəliklərini tam məsuliyyətlə icra etdiyinə görə, Azərbaycan Respublikası Əmək Məcəlləsinin 185-ci maddəsini rəhbər tutaraq, işçini həvəsləndirmək məqsədilə,
                    </td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: large">
                    <td colspan="2"><b>ƏMR EDİRƏM</b></td>
                </tr>
                <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                <tr>
                    <td colspan="2">1. Mükafatlandırılan işçinin soyadı, adı, atasının adı: <b>'.$reward->userId->text.'</b></td>
                </tr>
                <tr>
                    <td colspan="2">2. Struktur bölmə: <b>'.$reward->structure.'</b></td>
                </tr>
                <tr>
                    <td colspan="2">3. Vəzifəsi: <b>'.$reward->positionName.'</b></td>
                </tr>
                <tr>
                    <td colspan="2">4. Mükafatın məbləği AZN ('.$includingTaxes.'): <b>'.$reward->rewardAmount.'</b></td>
                </tr>
                <tr>
                    <td colspan="2">5. Maliyyə Departamentinə tapşırılsın ki, bu Əmrdən irəli gələn məsələlərin həllini təmin etsin.</td>
                </tr>
                <tr>
                    <td colspan="2">6. İnsan Resursları Departamentinə tapşırılsın ki, əmrin surəti ilə aidiyyatı şəxs tanış edilsin.</td>
                </tr>
               
                <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                <tr>
                    <td align="left"><b>Baş Direktor:</b></td>
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
                    <td colspan="2"><b>“Əmək haqqından tutulma barədə”</b></td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: medium">
                    <td colspan="2">
                        <!--Səbəb-->
                    </td>
                </tr>
                <tr align="center" style="font-size: 11pt">
                    <td colspan="2">
                        <em>Göstərilənləri nəzərə alaraq, müəssisədaxili intizam qaydalarını gücləndirmək  və dəymiş maddi ziyanın bərpa olunması məqsədilə</em>
                    </td>
                </tr>
                <tr><td colspan="2"><p>&nbsp;</p></td></tr>
                <tr align="center" style="font-size: large">
                    <td colspan="2"><b>ƏMR EDİRƏM</b></td>
                </tr>
                <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                <tr>
                    <td colspan="2">1. Aşağıda adı qeyd olunan işçinin aylıq əmək haqqından qeyd olunan məbləğ tutulsun.</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <ul>
                            <li>İşçinin soyadı, adı, atasının adı: <b>'.$userid->lastName.' '.$userid->firstName.' '.$userid->patronymic.' </b></li>
                            <li>İşlədiyi struktur bölmə: <b>'.$data->positionId->structureId->name.'</b></li>
                            <li>Vəzifəsi: <b>'.$data->positionId->posNameId->name.'</b></li>
                            <li>Tutulma məbləği: <b>'.$data->valueTotal.'</b></li>
                            <li>Tutulacağı aylar: <b>'.$data->relUserPaymentsId->startDate.' - '.$data->relUserPaymentsId->endDate.'</b></li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">2. Maliyyə Departamentinə tapşırılsın ki, əmək haqqından tutulma məsələlərini həll etsin.</td>
                </tr>
                <tr><td><p>&nbsp;</p></td></tr>
                <tr>
                    <td colspan="2">Əsas: '.$fileData->orderBasis.'</td>
                </tr>
                <tr><td><p>&nbsp;</p><p>&nbsp;</p></td></tr>
                <tr>
                    <td align="left"><b>Baş Direktor:</b></td>
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