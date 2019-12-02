<?php

define('GLPI_ROOT', '../../..');
include_once (GLPI_ROOT . "/inc/includes.php");

setlocale(LC_TIME, "".$_SESSION['glpilanguage'].".utf8");

		if ($_POST['client'] != 'select') :

			$format = PluginInvoiceReport::getDateFormat();
			$report = new PluginInvoiceReport();
			$report->getSeller($_SESSION['glpiactive_entity']);
			$report->getClient($_POST['client']);

			$report->getTasks($_POST['client']);
			$tasks = $report->fields['tasks'];
			$sumt = $report->fields['sumt'];

			$report->getServices($_POST['client']);
			$services = $report->fields['services'];
			$sumserv = $report->fields['sumserv'];

			$s_date = date("t/m/Y", strtotime($_POST['_start_date']));

			//subtotal task + services
			$subtotal = number_format($sumt + $sumserv, 2);

			//tax
			$tax = number_format(($sumt + $sumserv) * ($_POST['tax'] / 100), 2);
			$grandtotal = number_format($sumt + $sumserv + $tax, 2);

?>

<!doctype html>
<html>
<head>
    <meta meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Invoice - Preview</title>

    <style>
    .invoice-box {
        max-width: 1000px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 22px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }

    .invoice-box table {
        width: 1000px;
        line-height: inherit;
        text-align: left;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: middle;
    }

    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-top: 5px;
		padding-bottom: 20px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
		text-align: center;
    }

    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
		text-align: center;
		padding: 5px;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

		.invoice-box table tr.subtotal td:nth-child(2) {
        border-top: 1px solid #eee;
        font-weight: bold;
				padding-right: 40px;
    }

    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
				padding-right: 40px;
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }

		a {
			text-decoration: none;
			color: #555;
		}

    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }

    .rtl table {
        text-align: right;
    }

    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table style="border-bottom: 1px solid #ddd; font-size: 13px; line-height: normal;">
                        <tr>
                            <td class="title">
                                <img src="./images/logo-<?php echo $_SESSION['glpiactive_entity']; ?>.png" style="width:133; max-width:300px;">
                            </td>

                            <td style="padding-right: 30px;">
                                <?php echo $report->fields['seller']['name']; ?><br>
                                <?php echo $report->fields['seller']['address']; ?><br>
                                <?php echo $report->fields['seller']['phonenumber']; ?><br>
																<?php echo $report->fields['seller']['email']; ?>
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
                                INVOICE TO:<br>
																<?php echo $report->fields['client']['name']; ?><br>
                                <?php echo $report->fields['client']['address']; ?><br>
                                <?php echo $report->fields['client']['email']; ?>
                            </td>

                            <td style="padding-right: 30px;">
                                Invoice #: <?php echo $_POST['invonum']; ?><br>
                                Date: <?php echo date($format); ?><br>
                                Due Date: <?php echo $_POST['due_date']; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
	<div>

<!-- Task hours -->

	<?php
			if(!empty($tasks->num_rows))	 {
	?>
        <table cellpadding="0" cellspacing="0">

            <tr class="heading">
				<td style="width:120px;">
                    Date
                </td>

				<td style="width:530px;">
                    Description
                </td>

                <td style="width:100px;">
                    Hour Price
                </td>

				<td style="width:100px;">
                    Hours
                </td>

				<td style="width:150px;">
                    Total
                </td>
            </tr>

	<?php
			while($row_tasks = $DB->fetch_assoc($tasks)) {
	?>
							<tr class="item">
								<td>
                    <?php echo $row_tasks["date"]; ?>
                </td>

                <td style="text-align: left; padding-left: 5px;">
									<a target="_blank" rel="noopener noreferrer" href="<?php echo GLPI_ROOT."/front/ticket.form.php?id=".$row_tasks["tID"]; ?>">
										<?php echo $row_tasks["task"]; ?></a>
                </td>

                <td>
                    $<?php echo $row_tasks["cost"]; ?>
                </td>

                <td>
                    <?php echo $row_tasks["time"]; ?>
                </td>

                <td>
                    $<?php echo number_format($row_tasks["cost"] * $row_tasks["actiontime"] / 3600, 2); ?>
                </td>
            </tr>
	<?php
	 }
	?>
		 <tr><td colspan="5" style="height: 15px"> </td></tr>
	 		</table>
	<?php
	}
	?>

<!--Monthly services -->
		<br>
<?php
				 if(!empty($services->num_rows)) {
?>
	 		<table cellpadding="0" cellspacing="0">

		 <tr class="heading">

 <td colspan="2" style="width:300px; text-align: left; padding-left: 20px;">
						 Montly services
				 </td>


				 <td style="width:550px;">

				 </td>

 <td style="width:150px;">
						 Total
				 </td>
		 </tr>

 <?php
	 			while($row_serv = $DB->fetch_assoc($services)) {
 ?>
<tr class="item">
 <td>
						 <?php echo $s_date; ?>
				 </td>

				 <td style="text-align: left; padding-left: 5px;">
						 <?php echo $row_serv['name']; ?>
				 </td>

				 <td>
						 <?php echo $row_serv['content']; ?>
				 </td>

				 <td>
						 $<?php echo $row_serv['cost']; ?>
				 </td>
		 </tr>
 <?php
	 }
 ?>
		<tr><td colspan="4" style="height: 15px"></td></tr>

			</table>
<?php
	}
?>
<!--Total cost -->
			<table cellpadding="0" cellspacing="0">

			<tr class="subtotal">

								<td style="width:800px;"> </td>
                <td style="width:200px;">
                  	Subtotal: $<?php echo $subtotal; ?>
                </td>
            </tr>

			<tr class="subtotal">

								<td> </td>
								<td>
                  Tax <?php echo $_POST['tax']."%: $".$tax; ?>
                </td>
            </tr>

			<tr class="total">

								<td> </td>
                <td>
                  Grand Total: $<?php echo $grandtotal; ?>
                </td>
            </tr>

        </table>
	</div>
    </div>
</body>
</html>

<?php

			else :

        echo "<script>alert('Select client')</script>";
				echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=invoice.php'>";

			 endif;
?>
