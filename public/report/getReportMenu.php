
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="menucc.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">

    <title></title>
</head>
<body>


<form name="reportForm" id="reportForm" method="POST" action="getReportMenu.php">

    <div class="header" >

        <a href="getReportMenu.php" title="?sas s?hif?y? qayıtmaq..." class="vtip" >
            <div class="asanlogo"></div>

        </a>

        <div class="header-title">
       <span class="hdtext">
            İnsan Resurslarının Qeydiyyatı İnformasiya Sistemi
       </span>
            <br>
            <span class="hdtextb">
               Hesabatlılıq Alt Sistemi
        </span>
            <br>



        </div>
        <br>
    </div>
    <?php
    $reportName = "";
    if(key_exists("reportName", $_REQUEST))
    {
//        var_dump( $_REQUEST['reportName']);
        $reportName = $_REQUEST['reportName'];
    }


    if(isset($_GET['reportName']))
    {
        $reportName = $_GET['reportName'];
    }
    require_once 'SSRSReportmenu.php';

    //load config file variables
    $settings = parse_ini_file("app.config", 1);
    $ddd=NULL;

    try
    {

        $ssrs_report = new SSRSReport(new Credentials($settings["UID"], $settings["PASWD"]),$settings["SERVICE_URL"]);
        $result_html = null;
        $controls = null;



        //check are process 'params'request parameter
        parsePostBack();


        //We need to get the report parameters, create controls, and fill in values
        if(key_exists("reportName", $_REQUEST))
        {

            $query = $_REQUEST["reportName"];

            $parmVals = getReportParameters();
//            var_dump($parmVals);
//            var_dump($parmVals);
//            exit;
            //this makes it easier to access the stored values below

            $arr = array();

            if(!empty ($parmVals))
            {
                foreach ($parmVals as $key => $val)
                {
                    //error checking code to print the values retrieved
                    //echo "\n<br />parameters[$key]=$val->Name:$val->Value";

                    $arr[$val->Name] = $val->Value;

                }
            }

            //get report parameters based on either defaults or changed values
            $reportParameters = $ssrs_report->GetReportParameters($query, null, true, $parmVals, null);
            $i=0;

            $controls .= "\n<div  class='div1'>";



            $controls .= "\n<br><table    style='min-width: 50%;'  align='center'>";
            foreach($reportParameters as $reportParameter)
            {
                //are we opening or continuing a row?
                $ddd=$i;
                if($i%2 == 0)

                    $controls .= "\n<tr><td><font color='#fffaf0'>";

                else

                    $controls .= "<td><font color='#fffaf0'>";

                //get the default value
                $default = null;
                foreach($reportParameter->DefaultValues as $vals)
                    foreach($vals as $key=>$def)
                        $default = $def;

                $controls .= $reportParameter->Prompt  . "</font></td><td>";

                //If there is a list, then it needs to be a Select box
                if(sizeof($reportParameter->ValidValues) > 0){
                    $dependencies = empty($reportParameter->Dependencies) ? "onchange='getParameters();'" : "";
                    $controls .= "\n<select name='$reportParameter->Name' $dependencies>";
                    foreach($reportParameter->ValidValues as $values)
                    {

                        //choose the default value only if nothing is set
                        if($parmVals == null)
                            $selected = ($values->Value == $default)
                                ? "selected='selected'"
                                : "";
                        else
                            $selected = (key_exists($reportParameter->Name, $arr) && $values->Value == $arr[$reportParameter->Name])
                                ? "selected='selected'"
                                : "";
                        $controls .= "\n<option  value='" . $values->Value . "' label='" . $values->Label . "' $selected> $values->Label </option>";
                    }
                    $controls .= "\n</select\n>";
                }
                //Boolean needs to be a CheckBox
                else if($reportParameter->Type == "Boolean")
                {
                    //choose the default value only if nothing is set
                    if($parmVals == null)
                        $selected = (!empty($default) && $default != "False")
                            ? "checked='checked'"
                            : "";
                    else
                        $selected = (key_exists($reportParameter->Name, $arr) && !empty($arr[$reportParameter->Name]))
                            ? "checked='checked'"
                            : "";
                    $controls .= "\n<input name='$reportParameter->Name' type='checkbox' $selected/>";
                }
                //the other types should be entered in TextBoxes (DateTime, Integer, Float)
                else
                {
                    //choose the default value only if nothing is set
                    if($parmVals == null)
                        $selected = (!empty($default))
                            ? "value='" . $default . "'"
                            : "";
                    else
                        $selected = (key_exists($reportParameter->Name, $arr) && !empty($arr[$reportParameter->Name]))
                            ? "value='" . $arr[$reportParameter->Name] . "'"
                            : "";
                    if($reportParameter->Type == "DateTime") {
                        $controls .= "\n<input value='2017-01-01'  name='$reportParameter->Name' type='date'  $selected/>";
                    }
                    if($reportParameter->Type == "String")
                    {
                        $controls .= "\n<input name='$reportParameter->Name' value='' type='text' $selected/>";
                    }
                }


                //same deal, are we continuing or closing a row?
                if($i%2 == 0)
                    $controls .= "</td> ";
                else
                    $controls .= "</td></tr>";
                $i++;
            }
            $controls .= "\n</table>";



            $controls .= "\n<button class='button' id='batt1' name='batt1' align='right'  onclick='renderReport();'><span>Hesabata bax </span></button>";
            $controls .= "\n</div>";

            $controls .= "\n<div class='' align='left'>";

            $controls .= getExportFormats($ssrs_report);
            $controls .= "\n</div>";
            $controls .= "\n<input type='text' value='' name='parameters' id='parameters' />";

            $controls .= "\n<div id='exportReportDiv' style='visibility: hidden;margin-left: 21%;margin-top: 10px;  width: 340px;'  >";
            $controls .= "\n <span class='doc-name'>Sənədin adı: </span>&nbsp;&nbsp;&nbsp;<input name='exportName' type='text' onkeypress='submitenter(event);' /> ";
            $controls .= "\n<input type='button' onclick='renderReport();' value=' Yuklə '   />";
            $controls .= "\n</div>";
        }
        //We need to get the list of available reports
        //Play with the Types to create a hierarchical menu

        $catalogItems = $ssrs_report->ListChildren("/", true);
        $reports = array();
//            $controls = "<b><font color='#f8f8ff' class='texarr2'>Report Adı:</font></b> <a id='report' href='#' name='report' onclick='setReport($catalogItem->Path); ' class='texarr1'>";
//            $controls .= "\n<option value='' label='Select Report' >Select Report</option>";
        $controls .= "\n <nav class='navigation' id='style-4'><ul>";

        foreach ($catalogItems as $catalogItem)
        {

//                    $controls .= "\n<option value='$catalogItem->Path' label='$catalogItem->Name' >$catalogItem->Name</option>";

            if($catalogItem->Type == "Report")
//                var_dump($catalogItem->Path);
                $controls .= "\n <li> </li>";
                $controls .= "\n <li><a id='report' href='#' name='report' class='report-link' title='$catalogItem->Path' onclick='setReport(title)' >$catalogItem->Name </a><i class='fa fa-chevron-right' style='float: right;color: white;position: absolute;top:15px;right: 10px;'></i></li>";

        }
        $controls .= "\n </ul></nav>";


        if((isset($_REQUEST['rs:Command']))
            || (key_exists("reportName", $_REQUEST) && (key_exists("parameters", $_REQUEST) && $_REQUEST["parameters"] != 'true')))
        {
            if (isset($_REQUEST['rs:ShowHideToggle']))
            {
                $ssrs_report->ToggleItem($_REQUEST['rs:ShowHideToggle']);
            }
            else if (isset($_REQUEST['rs:Command']))
            {
                switch($_REQUEST['rs:Command'])
                {
                    case 'Sort':
                        $ssrs_report->Sort2($_REQUEST['rs:SortId'],
                            $_REQUEST['rs:SortDirection'],
                            $_REQUEST['rs:ClearSort'],
                            PageCountModeEnum::$Estimate,
                            $ReportItem,
                            $ExecutionInfo);
                        break;
                    default:
                        echo 'Unknown :' . $_REQUEST['rs:Command'];
                        exit;
                }
            }
            else
            {
                $query = $_REQUEST["reportName"];
                $parameters = getReportParameters();

                if (isset($_REQUEST['ps:OrginalUri']))
                {
                    $length = strlen($settings["SERVICE_URL"]);
                    $query = substr($_REQUEST['ps:OrginalUri'], $length);
                    $parameters = getReportParametersFromGet();

                }

                $executionInfo = $ssrs_report->LoadReport2($query, NULL);
                //Use these if the SSRS DataSource is configured to use user prompt credentials
//           $dsCredential = new DataSourceCredentials();
//           $dsCredential->DataSourceName = $settings["DATA_SOURCE"]; /*AdventureWorks*/
//           $dsCredential->UserName = $settings["UID"]; /*PHPDemoUser*/
//           $dsCredential->Password = $settings["PASWD"]; /*Passw0rd!*/
//           $ssrs_report->SetExecutionCredentials2(array($dsCredential));
                $ssrs_report->SetExecutionParameters2($parameters);

            }

            $renderAsHTML = new RenderAsHTML();
            //The ReplcementRoot option of HTML rendering extension is used to
            //redirect all calls to reporting serice server to this php file.
            //The StreamRoot option of HTML rendering extension used instruct
            //HTML rendering extension about how to construct the URLs to images in the
            //report.
            //Please refer description of Sort2, Render2 and RenderStream API in
            //the userguide (./../../../docs/User Guide.html) for more details
            //about these options.
            $params = getStreamRootParams();
            $renderAsHTML->ReplacementRoot = getPageURL();
            //append form params with ReplacementRoot for preserving them
            //upon sort/toggle clicks.
            $renderAsHTML->ReplacementRoot .= $params;
            $renderAsHTML->StreamRoot = './images/';
            $result_html = $ssrs_report->Render2($renderAsHTML,
                PageCountModeEnum::$Actual,
                $Extension,
                $MimeType,
                $Encoding,
                $Warnings,
                $StreamIds
            );
            foreach($StreamIds as $StreamId)
            {
                $renderAsHTML->StreamRoot = null;
                $result_png = $ssrs_report->RenderStream($renderAsHTML,
                    $StreamId,
                    $Encoding,
                    $MimeType);

                if (!$handle = fopen("./images/" . $StreamId, 'wb'))
                {
                    echo "Cannot open file for writing output";
                    exit;
                }

                if (fwrite($handle, $result_png) === FALSE)
                {
                    echo "Cannot write to file";
                    exit;
                }
                fclose($handle);
            }
        }

        echo "\n" . '<div class="center-div" align="center">';
//        echo "\n" . ' <div class="header" ></div>';
        echo "\n<div   align='left'  >";
        echo $controls;
        echo "\n</div>  ";

        echo "\n" . '<div id="exi11"    >';

        if($result_html == null)
        {

            if(count($reportParameters)>0 || !isset($_GET['reportName']))
            {
                echo "\n" . '  <div class="info-alert"><i class="fa fa-info-circle" style="float:left;"></i><h3 style="font-weight:bold">Görmək isdədiyiniz hesabatı menyudan seçin </h3></div>';
            }else{
                echo "\n" . '  <div class="warning-alert"><i class="fa fa-info-circle" style="float:left;"></i><h3 style="font-weight:bold">Heç bir nəticə tapılmadı </h3></div>';
            }

        }else{
            echo $result_html;
        }


        echo "\n" . '</div> ';


//        echo "\n" . '</div>';

    }
    catch(SSRSReportException $serviceExcprion)
    {
        echo  "\n<br/>" . $serviceExcprion->GetErrorMessage();
        $trace = str_replace("#", "<br />", $serviceExcprion->getTraceAsString());
        echo  "<br />" . $trace;
    }

    echo "\n";

    /**
     *
     * @return <url>
     * This function returns the url of current page.
     */
    function getPageURL()
    {
        function curPageURL() {
            $pageURL = 'http';
            if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
            $pageURL .= "://";
            if ($_SERVER["SERVER_PORT"] != "80") {
                $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];}
            else {$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; }
            return $pageURL;}
//    $PageUrl = $_SERVER["HTTPS"] == "on"? 'https://' : 'http://';
//    $uri = $_SERVER["REQUEST_URI"];
//    $index = strpos($uri, '?');
//    if($index !== false)
//    {
//	$uri = substr($uri, 0, $index);
//    }
//    $PageUrl .= $_SERVER["SERVER_NAME"] .
//                ":" .
//                $_SERVER["SERVER_PORT"] .
//                $uri;
//    return $PageUrl;
    }

    /**
     * Parse params varible and populate the
     * $_REQUEST object.
     */
    function parsePostBack()
    {
        if(!key_exists("params", $_REQUEST))
        {
            return;
        }

        //Check for Drill down, means user navigate to a new report so the params
        //are not valid. We can assume user moved to new page if ps:OrginalUri
        //is set and no sort or toggle flags are on.
        if(key_exists("ps:OrginalUri", $_REQUEST) &&
            !key_exists("rs:Command", $_REQUEST) &&
            !key_exists("rs:ShowHideToggle", $_REQUEST))
        {
            unset($_REQUEST['params']);
            $settings = parse_ini_file("app.config", 1);
            $length = strlen($settings["SERVICE_URL"]);
            $query = substr($_REQUEST['ps:OrginalUri'], $length + 2); //adding for ?
            $_REQUEST['reportName'] = $query;
        }

        $parameters = array();
        $params = explode('$$', $_REQUEST['params']);
        foreach($params as $param)
        {
            $keyval = explode('=', $param);
            if(count($keyval) == 2)
            {
                $_REQUEST[$keyval[0]] = $keyval[1];
            }
        }
        unset($_REQUEST['params']);
    }

    /**
     * The RenderAsHTML::StreamRoot memeber variable can be used to preserve
     * form variables upon sort/toggle clicks. This function will create a string
     * of keyvalue pairs (form variable name and value) seperated by '$$' symbol.
     */
    function getStreamRootParams()
    {
        $params = null;
        $i=0;
        foreach($_REQUEST as $key => $post)
        {
            if($key == "params")
                continue;
            if(strpos($key,'rc:') === 0)
                continue;
            if(strpos($key,'rs:') === 0)
                continue;
            if(strpos($key,'ps:') === 0)
                continue;

            if(!empty($post))
            {
                $params .= $key . '=' . $post . '$$';
                $i++;
            }
            if($i > 100)
                break;
        }

        return ($params == null ? null: '?params=' . $params);
    }

    function getReportParameters()
    {

        if(key_exists("parameters", $_REQUEST))
        {
            $parameters = array();
            $i=0;
            foreach($_REQUEST as $key => $post)
            {
//
//                if($post == " ")
//                {
//                    $post = "%%";
//                }
                if($key == "reportName")
                {

                    continue;
                }

                if($key == "parameters")
                {

                    continue;
                }

                if($key == "exportSelect")
                {

                    continue;
                }

                if($key == "exportName")
                    continue;
                if($key == "params")
                {

                    continue;
                }

                if(strpos($key,'rc:') === 0)
                    continue;
                if(strpos($key,'rs:') === 0)
                    continue;
                if(strpos($key,'ps:') === 0)
                    continue;
                if(!empty($post))
                {

                    $parameters[$i] = new ParameterValue();
                    $parameters[$i]->Name = $key;
                    $parameters[$i]->Value = $post;
                    $i++;
                }else{
//                        var_dump($key);
                        if($key != "batt1")
                        {
                            $post = "%%";
                            $parameters[$i] = new ParameterValue();
                            $parameters[$i]->Name = $key;
                            $parameters[$i]->Value = $post;
                            $i++;
                        }

                }
                if($i > 100)
                    break;
            }
            return $parameters;
        }
        else
            return null;
    }

    function getReportParametersFromGet()
    {
        $parameters = array();
        $i=0;
        foreach($_GET as $key => $post)
        {
            if(strrpos($key, ":"))
                continue;
            if(!empty($post))
            {
                $parameters[$i] = new ParameterValue();
                $key = substr($key, strpos($key, ";") + 1);
                $parameters[$i]->Name = $key;
                $parameters[$i]->Value = $post;
                $i++;
            }
        }

        return $parameters;
    }

    function getExportFormats($ssrs_report)
    {
        $extensions = $ssrs_report->ListRenderingExtensions();
        $result = array();
        foreach($extensions as $extension)
        {
            $result[] = $extension->Name;
        }

        $controls = "<div class='div1-1'><b   class=''>Export üçün fayl formatı seçin:</b> <select id='exportSelect' name='exportSelect' onchange='exportType(value)'  style='width:140px'>";
        foreach ($result as $format)
        {
            $selected = ($format == "HTML4.0")
                ? "selected='selected'"
                : "";

            if($format != "RGDI" && $format != "RPL" && ($format=="WORD" || $format == "HTML4.0" || $format == "EXCEL" || $format == "PDF"))
                $controls .= "\n<option value='$format' label='$format' $selected >$format</option>";
        }
        $controls .= "\n</select></div>";
        return $controls;
    }


    ?>
    <input type="hidden" id="reportName" name="reportName"
           value="<?php if(key_exists("reportName", $_REQUEST)) echo $_REQUEST["reportName"]; ?>" />




</form>

<script type="text/javascript">

    function exportType(value)
    {
        if(value.match("HTML."))
            exportReportDiv.style.visibility = 'hidden';
        else
            exportReportDiv.style.visibility = '';
    }

    function getParameters()
    {
        reportForm.parameters.value = true;
        reportForm.submit();
    }

    function setReport(report)
    {
        var ss=reportForm.reportName.value;


        if(report != "" && ss =="")
        {

            reportForm.reportName.value = report;
            reportForm.submit();


        }
        else {

//            header('Location: http://localhost/SSRSReportDxr/GetReportMenu.php');
//            header(location:GetReportMenu.php);
//            reportForm.submit();

            window.location.href = "getReportMenu.php?reportName="+report;
            reportForm.reportName.value = report;
//            window.location.replace("http://www.google.com");
//            alert(report);
        }
    }

    function renderReport()
    {
        value = reportForm.exportSelect.value;
        reportForm.parameters.value = false;
        if(reportForm.exportName.value == "" && !value.match("HTML."))
        {
            alert("Please enter a name for the report!");
            return;
        }

        if(value.match("HTML."))
            reportForm.action = "getReportMenu.php";
        else
            reportForm.action = "Download.php";
        reportForm.submit();
    }

    function submitenter(e)
    {
        var keycode;
        if (window.event) keycode = window.event.keyCode;
        else if (e) keycode = e.which;
        else return true;

        if (keycode == 13)
        {
            renderReport();
            return false;
        }
        else
            return true;
    }
    var reportName =  "<?php echo $reportName ?>";
    document.querySelector('.report-link').remove('selected')
    document.querySelector('a[title="'+reportName+'"]').className += " selected";

</script>
</body>
</html>
