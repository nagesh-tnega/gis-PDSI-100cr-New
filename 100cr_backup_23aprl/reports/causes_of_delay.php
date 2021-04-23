
<?php 
	include('../php/session.php');
	include('../php/config.php');
    require_once('../php/dbHandler.php');
    require_once('../api/mstCausesOfDelay.php');

    $causes_of_delay = mstCausesOfDelay::getCausesOfDelay(DBCON);


    //print_r($_SESSION);
   /* if (!$_SESSION['100c_user_info']['role'] == 11){
		echo "!!! UNAUTHORISED USAGE !!!";
		die;
	}*/
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Projects - Causes Of Delay</title>
		<link rel="shortcut icon" type="image/png" href="<?php echo DOMAIN . 'images/logo2.png'; ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--<link rel="stylesheet" href="../css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/fc-3.2.2/fh-3.1.2/r-2.1.0/sc-1.4.2/datatables.min.css" />
		

       
		
	</head>
	<body>
		
		
	<?php 
        include('../header.php');
        include('../menu.php'); 
    ?>

 <div class="container">
    <br />
    <div class="row" style="background-color:#72A0C1;padding:7px; ">
        <div class="col-sm-8">
            <h5>Reports - Causes Of Delay</h5>
        </div>
        <div class="col-sm-4">
             <!--<a style="float:right;color:#000;" href="../php/function.php?case=downloadProjectReport"><i class="fa fa-file-excel-o"></i> Download</a>-->
        </div>
    </div>
    
    <br />
    <div class="row">

<div class="table-responsive">
	
		<table id="tblReport" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr class="text-center">
                <?php
                     if(count($causes_of_delay) > 0){
                        $tblHeader = '<th class="th-sm">Departments</th>';
                        for($i = 0;$i<count($causes_of_delay);$i++) {
                            $tblHeader .= '<th class="th-sm">Delay due to '. $causes_of_delay[$i]['delay_desc'] .'</th>';
                        }
                     }
                     echo $tblHeader.'<th class="tn-sm">Total Delayed Projects</th><th class="tn-sm">Total On-Time Projects</th><th class="tn-sm">Total Number of Projects</th>';
                ?>
               
               
            </tr>
        </thead>
        <tbody>
           <tr><td colspan="12"><strong><center>No record found...</center></strong></td></tr>
           
           
           
            
        </tbody>
       
    </table>
</div>
	</div>
       </div>
      
	 <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
     <script src="<?php echo DOMAIN . 'js/bootstrap.min.js';?>"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>

		<script>
			$(document).ready(function() {

				/*$.ajax({
					url: '../php/function.php',
					type: 'POST',
					data: 'case=getCausesOfDelayReport',
					success: function (response) {
                        $("#tblReport tbody").empty();
                        var res = JSON.parse(response);
                        var content = "";
                        var slno =1;
                        if(res.length != 0){
                            for(i=0;i<res.length;i++){
                                content += '<tr><td>'+ slno +'</td><td>'+ res[i].department_name +'</td><td>'+ res[i].implementing_agency +'</td><td>'+ res[i].name_of_the_project +'</td><td>'+ res[i].funding_agency +'</td><td>'+ res[i].project_start_date +'</td><td>'+ res[i].project_end_date +'</td><td>'+ res[i].revised_start_date +'</td><td>'+ res[i].revised_end_date +'</td><td>'+ res[i].project_cost +'</td><td>'+ res[i].present_status +'</td><td>'+ res[i].causes_of_delay +'</td><td>'+ res[i].id +'</td></tr>';
                                slno++;
                            }
                            $("#tblReport tbody").append(content);
                        }else{

                        }
						
                         $('#tblReport').dataTable({
                            scrollY:        "600px",
                            scrollX:        true,
                            scrollCollapse: false,
                            paging:         true
                            });
   
						
						//$('#info_div').html(response);
						
					}
				});*/

               
 
    //new $.fn.dataTable.FixedHeader( table );
} );

		</script>
	</body>
</html>
