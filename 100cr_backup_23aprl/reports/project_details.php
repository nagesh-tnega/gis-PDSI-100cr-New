
<?php 
	include('../php/session.php');
	include('../php/config.php');
    //print_r($_SESSION);
   /* if (!$_SESSION['100c_user_info']['role'] == 11){
		echo "!!! UNAUTHORISED USAGE !!!";
		die;
	}*/
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Projects - Report</title>
		<link rel="shortcut icon" type="image/png" href="<?php echo DOMAIN . 'images/logo2.png'; ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../css/bootstrap.min.css">

        

       <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">-->
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
            <h5>Reports - Project Details</h5>
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
             <tr>
                <th class="th-sm">Slno</th>
                <th class="th-sm">Department Name</th>
                <th class="th-sm">Implementing Agency</th>
                <th class="th-sm">Name of the Project</th>
                <th class="th-sm">Last updated time</th>
                <th class="th-sm">Funding Agency</th>
                <th class="th-sm">Project Start Date</th>
                <th class="th-sm">Project End Date</th>
                <th class="th-sm">Revised Project Start Date</th>
                <th class="th-sm">Revised Project End Date</th>
                <th class="th-sm">Project Cost</th>
                <th class="th-sm">Present Status</th>
                <th class="th-sm">Causes of Delay</th>
                <th class="th-sm">Time Overrun in Days</th>
                <th class="th-sm">Cost Over Run in Crores</th>
                <th class="th-sm">Reasons for Cost Over Run</th>
            </tr>
        </thead>
        <tbody>
           
           
           
           
            
        </tbody>
       
    </table>
</div>
	</div>
       </div>
      
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="<?php echo DOMAIN . 'js/bootstrap.min.js';?>"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>


		<script>
			$(document).ready(function() {

				$.ajax({
					url: '../php/function.php',
					type: 'POST',
					data: 'case=getAllProjectDetailsForReport',
					success: function (response) {
                        $("#tblReport tbody").empty();
                        var res = JSON.parse(response);
                        var content = "";
                        var slno =1;
                         var time_overrun = "";
                        function getDuration(milli){
                          let minutes = Math.floor(milli / 60000);
                          let hours = Math.round(minutes / 60);
                          let days = Math.round(hours / 24);

                          return (
                            (days && {value: days, unit: 'days'}) ||
                            (hours && {value: hours, unit: 'hours'}) ||
                            {value: minutes, unit: 'minutes'}
                            )
                      };
                        if(res.length != 0){
                            for(i=0;i<res.length;i++){

                                if(res[i].project_start_date == null){
                                    project_start_date = "-";
                                }else{
                                    project_start_date = res[i].project_start_date;
                                }

                                if(res[i].project_end_date == null){
                                    project_end_date = "-";
                                }else{
                                    project_end_date = res[i].project_end_date;
                                }

                                if(res[i].revised_start_date == null){
                                    revised_start_date = "-";
                                }else{
                                    revised_start_date = res[i].revised_start_date;
                                }

                                if(res[i].revised_end_date == null){
                                    revised_end_date = "-";
                                }else{
                                    revised_end_date = res[i].revised_end_date;
                                }

                                if(res[i].present_status == null){
                                    present_status = "-";
                                }else{
                                    present_status = res[i].present_status;
                                }

                                if(res[i].delay_desc == null){
                                    delay_desc = "-";
                                }else{
                                    delay_desc = res[i].delay_desc;
                                }
                                
                                 if(res[i].cost_overrun_reasons == null){
                                    cost_overrun_reasons = "-";
                                }else{
                                    cost_overrun_reasons = res[i].cost_overrun_reasons;
                                }

                                if(res[i].cost_overrun == null){
                                    cost_overrun = "-";
                                }else{
                                    cost_overrun = res[i].cost_overrun;
                                }

                                if(res[i].updated_time == null){
                                    updated_time = "-";
                                }else{
                                    updated_time = res[i].updated_time;
                                }

                                if(res[i].project_end_date == null || res[i].present_status == null ){
                                    time_overrun = "-"
                                } else if(res[i].project_end_date){
                                    if(!((res[i].present_status).toLowerCase() === "completed")){
                                        var endDate = new Date(res[i].project_end_date);
                                        var todayDate = new Date();
                                        var timeOverRun = 0;
                                        if(endDate < todayDate){


                                         timeOverRun = getDuration(todayDate - endDate);

                                        }
                                        if(!(timeOverRun.value == undefined)){
                                            time_overrun = timeOverRun.value;
                                        }else{
                                            time_overrun = "-"
                                        }
                                        
                                    }
                                }



                                 content += '<tr><td>'+ slno +'</td><td>'
                                        + res[i].department_name +'</td><td>'
                                        + res[i].implementing_agency +'</td><td>'
                                        + res[i].name_of_the_project +'</td><td>'
                                        + res[i].updated_time +'</td><td>'
                                        + res[i].funding_agency +'</td><td>'
                                        + project_start_date +'</td><td>'
                                        + project_end_date +'</td><td>'
                                        + revised_start_date +'</td><td>'
                                        + revised_end_date +'</td><td>'
                                        + res[i].project_cost +'</td><td>'
                                        + present_status +'</td><td>'
                                        + delay_desc +'</td><td>'
                                        + time_overrun +'</td><td>'
                                        + cost_overrun +'</td><td>'
                                        + cost_overrun_reasons   +'</td></tr>';
                                slno++;
                            }
                            $("#tblReport tbody").append(content);
                        }else{

                        }
						
                         $('#tblReport').dataTable({

                            scrollY:        "600px",
                            scrollX:        true,
                            scrollCollapse: false,
                            paging:         true,
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    extend: 'excel',
                                    text: '<i class="fa fa-file-excel-o"></i> <em>D</em>ownload',
                                    title: 'Project Details'
                                    
                                }
                            ]

                         });
   
						
						//$('#info_div').html(response);
						
					}
				});

               
 
    //new $.fn.dataTable.FixedHeader( table );
} );

		</script>
	</body>
</html>
