<?php
require_once 'SSRSReport.php'; 
define("SERVICE_URL", "http://localhost/ReportServer_SQLEXPRESS/"); 
define("REPORT", "/SalesReport/SalesByCategory");

if(isset($_GET['reportFormat']) || isset($_GET['amp;rs:Format']))
{
	
	if(isset($_GET['reportFormat']))
		$format = $_GET['reportFormat'];
	else 
		$format=$_GET['amp;rs:Format'];	
	try
	{
		$ssrs_report = new SSRSReport(new Credentials('machineName\PHPDemoUser', 'user_password'), SERVICE_URL);
		
		switch($format)
		{	
			case 'HTML4.0':
				if (isset($_REQUEST['rs:ShowHideToggle']))
				{
				   $ssrs_report->ToggleItem($_REQUEST['rs:ShowHideToggle']);
				}
				else
				{
					$ssrs_report->LoadReport2(REPORT, NULL);
				}

				$renderAsHTML = new RenderAsHTML();
				$renderAsHTML->ReplacementRoot = getPageURL();
				$result_HTML = $ssrs_report->Render2($renderAsHTML,
											PageCountModeEnum::$Estimate,
											$Extension,
											$MimeType,
											$Encoding,
											$Warnings,
											$StreamIds);
				echo $result_HTML;
				break;
			
			case 'PDF':
				$ssrs_report->LoadReport2(REPORT, NULL);
				$renderAsPDF = new RenderAsPDF();
				$result_PDF = $ssrs_report->Render2($renderAsPDF,
											PageCountModeEnum::$Estimate,
											$Extension,
											$MimeType,
											$Encoding,
											$Warnings,
											$StreamIds);

				header('Content-type: application/pdf');
				echo $result_PDF;
				break;
			
			case 'EXCEL':
				$ssrs_report->LoadReport2(REPORT, NULL);
				$renderAsEXCEL = new RenderAsEXCEL();
				$result_EXCEL = $ssrs_report->Render2($renderAsEXCEL,
											 PageCountModeEnum::$Estimate,
											 $Extension,
											 $MimeType,
											 $Encoding,
											 $Warnings,
											 $StreamIds);


				$handle = fopen("C:\\path\\to\\desired\\folder\\" . "report.xls", 'wb');
				fwrite($handle, $result_EXCEL);
				fclose($handle);
				break;
		}
	}
	catch (SSRSReportException $serviceException)
	{
		print("<pre>");
		print_r($serviceException);
		print("</pre>");
	}
}
else
{
	print('<html><h2>Report format:</h2>
		<form>
			HTML<input type="radio" name="reportFormat" value="HTML4.0"/>&nbsp;&nbsp;
			PDF<input type="radio" name="reportFormat" value="PDF"/>&nbsp;&nbsp;
			EXCEL<input type="radio" name="reportFormat" value="EXCEL"/>&nbsp;&nbsp;
			<input type="submit" value="Get Report"/>
		</form></html>');
}

function getPageURL() 
{ 
    $PageUrl = $_SERVER["HTTPS"] == "on"? 'https://' : 'http://'; 
    $uri = $_SERVER["REQUEST_URI"]; 
    $index = strpos($uri, '?'); 
    if($index !== false) 
    { 
         $uri = substr($uri, 0, $index); 
    } 
    $PageUrl .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $uri; 
    return $PageUrl; 
}
?>