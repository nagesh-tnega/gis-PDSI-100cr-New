
<?php 
	include('../php/session.php');
	include('../php/config.php');
    require_once('../php/dbHandler.php');
    require_once('../api/mstDepartment.php');
    //print_r($_SESSION);
   /* if (!$_SESSION['100c_user_info']['role'] == 11){
		echo "!!! UNAUTHORISED USAGE !!!";
		die;
	}*/

    //get Causes of delay list from the master table.
    $getDeptList = mstDepartment::getDepartmentList(DBCON);
    //print_r($getDeptList);
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Projects - Abstract Report</title>
		<link rel="shortcut icon" type="image/png" href="<?php echo DOMAIN . 'images/logo2.png';?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1">


        <link rel="stylesheet" href="<?php echo DOMAIN . 'css/bootstrap.min.css';?>">
		<!--<link rel="stylesheet" href="../css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/fc-3.2.2/fh-3.1.2/r-2.1.0/sc-1.4.2/datatables.min.css" />
		

       <style>
            .err{
                color:red;
                font-size: 12px;
            }
       </style>
		
	</head>
	<body>
		
		
		<?php 
            include('../header.php');
            include('../menu.php'); 
        ?>

 <div class="row" style="margin:0px;">
    <div class="col-sm-3" style="margin-left:10px;">
       <div class="form-group row">
            
            <div class="col-md-10">
                <label class="col-md-12 col-form-label" for="department_name">Select Department<span class="required">*</span></label>
                <select class="form-control input-md" id="department_name" name="department_name">
                    <option value="" selected="selected">Select</option>
                    <option value="ALL">All</option>
                    <?php
                                            $opt = '';
                                            if(count($getDeptList) > 0){
                                                //print_r($transfer_category);
                                                for($i = 0;$i<count($getDeptList);$i++) {
                                                    
                                                    $opt .= '<option value="'.$getDeptList[$i]['dept_code'].'">'.$getDeptList[$i]["dept_name"].'</option>';
                                                }
                                                
                                                echo $opt;
                                            }

                                        ?>
                </select>
                <span class="err" id="err-dept-name"></span>
            </div>
        </div>

        <div class="form-group row">
             <div class="col-md-10">
                <label class="col-md-12 col-form-label" for="implementing_agency">Select Implementing Agency<span class="required">*</span></label>
                <select class="form-control input-md" id="implementing_agency" name="implementing_agency">
                    <option value="" selected="selected">Select</option>
                    <option value="ALL">All</option>
                </select>
                <span class="err" id="err-hod-name"></span>
            </div>
        </div>
        <div class="form-group row">
             <div class="col-md-10">
                <label class="col-md-12 col-form-label" for="project_name">Select Project<span class="required">*</span></label>
                <select class="form-control input-md" id="project_name" name="project_name">
                    <option value="" selected="selected">Select</option>
                    <option value="ALL">All</option>
                </select>
                <span class="err" id="err-project-name"></span>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-10">
                <center><button class="btn btn-primary" id="submit" >Submit</button></center>
            </div>
        </div>
    </div>
    <div class="col-sm-9" style="padding:0px !important;max-width: 72%;">

         <div class="row" style="background-color:#72A0C1;padding:7px; ">
        <div class="col-sm-8">
            <h5>Reports - Project Abstract</h5>
        </div>
        <div class="col-sm-4">
             <a style="float:right;color:#000;" id="downloadAbstractReport"><i class="fa fa-file-pdf-o"></i> Download</a>
        </div>
        <input type="hidden" class="form-control" id="hid_dept_code" name="hid_dept_code" />
        <input type="hidden" class="form-control" id="hid_dept_hod_code" name="hid_dept_hod_code" />
        <input type="hidden" class="form-control" id="hid_project_id" name="hid_project_id" />
    </div>
    
    

    <div class="row" style="border:2px solid #72A0C1;margin-top: 10px;overflow: scroll;height:600px;" id="abstractReportContent">
         
    
   
    </div>

   
        
            
        
       
    



    </div>
    <br />
   
       </div>
      
	 <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
     <script src="<?php echo DOMAIN . 'js/bootstrap.min.js';?>"></script>
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>


		<script>
			$(document).ready(function() {
                $("#abstractReportContent").hide();
                $("#downloadAbstractReport").hide();

                //Change department
                $("#department_name").change(function(){
                    $("#err-dept-name").text("");
                    var dept_code = $(this).val().trim();
                    if(dept_code == 'ALL'){
                        $("#implementing_agency").val("ALL");
                        $("#project_name").val("ALL");
                    }else{
                        $("#implementing_agency").val("");
                        $("#project_name").val("");

                        //Get Implementing Agency Based on department name.
                        $.ajax({
                            url: '../php/function.php',
                            type: 'GET',
                            data: 'case=getImplementingAgencyByDeptId&dId='+dept_code,
                            success: function (response) {
                                $("#implementing_agency").empty();
                                var res = JSON.parse(response);
                                var content = '<option value="" selected>Select</option><option value="ALL">ALL</option>';
                                for(i=0;i<res.length;i++){
                                    content += '<option value="'+res[i].hod_dept_code+'">'+res[i].hod_name+'</option>';
                                }
                                $("#implementing_agency").append(content);
                            }

                        });

                    }
                });

                //Change Implementing Agency
                $("#implementing_agency").change(function(){
                    $("#err-hod-name").text("");
                    var hod_code = $(this).val().trim();
                    if(hod_code == 'ALL'){
                       
                        $("#project_name").val("ALL");
                    }else{
                        
                        $("#project_name").val("");

                        //Get Project Name Based on department name and Implementing Agency.
                        $.ajax({
                            url: '../php/function.php',
                            type: 'GET',
                            data: 'case=getProjectNameByImplAgency&hId='+hod_code,
                            success: function (response) {
                                $("#project_name").empty();
                                var res = JSON.parse(response);
                                var content = '<option value="" selected>Select</option><option value="ALL">ALL</option>';
                                for(i=0;i<res.length;i++){
                                    content += '<option value="'+res[i].project_id+'">'+res[i].project_name+'</option>';
                                }
                                $("#project_name").append(content);
                            }

                        });

                    }
                });

                //Project Change Event
                $("#project").change(function(){
                    $("#err-project-name").text("");
                });

                //Submit Form
                $("#submit").click(function(){
                    $("#err-project-name").text("");
                    var dept_code = $("#department_name").val().trim();
                    var hod_code = $("#implementing_agency").val().trim();
                    var project_id = $("#project_name").val().trim();
                    if(dept_code == ""){
                        $("#err-dept-name").text("Please select department name");return false;
                    }
                    if(hod_code == ""){
                        $("#err-hod-name").text("Please select HOD name");return false;
                    }
                    if(project_id == ""){
                        $("#err-project-name").text("Please select project name");return false;
                    }

                    $.ajax({
                        url: '../php/function.php',
                        type: 'POST',
                        data: 'case=getProjectAbstract&dId='+dept_code+'&hId='+hod_code+'&pId='+project_id,
                        success: function (response) {
                             $("#abstractReportContent").show();
                            $("#abstractReportContent").empty();
                            $("#hid_dept_code").val(dept_code);
                            $("#hid_dept_hod_code").val(hod_code);
                            $("#hid_project_id").val(project_id);
                            //alert(response);
                             var res = JSON.parse(response);
                             var content = '<div class="col-sm-12"><br /><h4 style="text-align:center;">Abstract Report</h4><hr /></div>';
                             for(i=0;i<res.length;i++){
                                content +='<div class="col-sm-12" style="border-bottom: 1px solid black;margin:20px 0px;">';
        content += '<p><strong>Project Name:</strong> '+ res[i].project_name +'</p>';
        content += '<p><strong>Department Name:</strong> '+ res[i].department_name +'</p>';
        content += '<p><strong>Head Of Department:</strong> '+ res[i].hod_name +'</p>';
        content += '<p><strong>Implementing Agency:</strong> '+ res[i].implementing_agency +'</p>';
        content += '<p><strong>Project Description:</strong> '+ res[i].project_desc +'</p>';
        content += '<p><strong>Government Order:</strong> '+ res[i].government_orders +'</p>';
        content += '<p><strong>Funding Agency:</strong> '+ res[i].funding_agency +'</p>';
        if(res[i].project_start_date){var pro_start_dt = res[i].project_start_date}else{var pro_start_dt = " - ";}
        content += '<p><strong>Project Start Date:</strong> '+ pro_start_dt +'</p>';
        if(res[i].project_end_date){var pro_end_dt = res[i].project_end_date}else{var pro_end_dt = " - ";}
        content += '<p><strong>Project End Date:</strong> '+ pro_end_dt +'</p>';
        content += '<p><strong>Project Cost:</strong> '+ res[i].project_cost +' Cr</p>';
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
          if(res[i].project_end_date == null ){
                                    time_overrun = "0"
                                } else if(res[i].project_end_date){
                                  
                                        var endDate = new Date(res[i].project_end_date);
                                        var todayDate = new Date();
                                        var timeOverRun = 0;
                                        if(endDate < todayDate){


                                         timeOverRun = getDuration(todayDate - endDate);

                                        }
                                        if(!(timeOverRun.value == undefined)){
                                            time_overrun = timeOverRun.value;
                                        }else{
                                            time_overrun = "0"
                                        }
                                        
                                    
                                }
                                if(res[i].cost_overrun_reasons == null){
                                    cost_overrun_reasons = "0";
                                }else{
                                    cost_overrun_reasons = res[i].cost_overrun_reasons;
                                }

                                if(res[i].cost_overrun == null){
                                    cost_overrun = "0";
                                }else{
                                    cost_overrun = res[i].cost_overrun;
                                }

                                if(res[i].causes_of_delay == null){
                                    causes_of_delay = "None";
                                }else{
                                    causes_of_delay = res[i].causes_of_delay;
                                }

        content += '<p><strong>Project Time Overrun:</strong> '+ time_overrun +' Days</p>';
        content += '<p><strong>Project Time Overrun Reasons:</strong> '+ causes_of_delay +'</p>';
        content += '<p><strong>Project Cost Overrun:</strong> '+ cost_overrun +' Cr</p>';
        content += '<p><strong>Project Cost Overrun Reasons:</strong> '+ cost_overrun_reasons +' </p>';
        content += '<p><strong>Updated Date:</strong> '+ res[i].updated_time +'</p>';

        content += '</div>';
                            }
                             $("#abstractReportContent").append(content);
                             $("#downloadAbstractReport").show();
                             //$("#hid_dept_code").val($("#abstractReportContent").html());
                        }
                    });


                });


                $("#downloadAbstractReport").click(function(){
                   /* var dept_code = $("#hid_dept_code").val().trim();
                    var hod_code = $("#hid_dept_hod_code").val().trim();
                    var project_id = $("#hid_project_id").val().trim();
                    $.ajax({
                        url: '../php/function.php',
                        type: 'POST',
                        data: 'case=downloadAbstractReport&dId='+dept_code+'&hId='+hod_code+'&pId='+project_id,
                        success: function (response) {
                            
                        }
                    });*/

                    var content = $("#abstractReportContent").html();
                    // Generate the PDF.
                    html2pdf().from(content).set({
                        margin: 1,
                        filename: 'abstract_report.pdf',
                        html2canvas: { scale: 2 },
                        jsPDF: {orientation: 'portrait', unit: 'in', format: 'letter', compressPDF: true}
                    }).save();

                });



    //new $.fn.dataTable.FixedHeader( table );
} );

		</script>
	</body>
</html>
