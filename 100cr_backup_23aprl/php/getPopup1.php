<?php
require_once ('dbHandler.php');

//$url = $_POST['pop_url'];
header('Access-Control-Allow-Origin: *');

$geousername = GSUSER;

$geopassword = GSPASS;

$var = $_POST['pop_url'];



//echo $var;
$json = json_decode($var, true);
$json = array_reverse($json);
$k = 0;
foreach ($json as $data)
{

    //echo  '<b>Layer Name</b> : '.$data['layer_name'];
    $ln = $data['popup_field'];

    $id = $data['uid'];
     $popup = $data['popup_field'];

    if ($k == 0)
    {

        $style = 'display:show';

    }

    else
    {

        $style = 'display:none';
    }

    $html = "<table class='table table-bordered table-sm'><tr style='background-color:#85be00' onClick=toggle_popup('" . $id . "')><th colspan='2' style='text-align: center;color:#FFF'>Layer Name : $ln</th></tr>";
    $url = $data['url'];
    $info = array(
        'grant_type' => 'client_credentials'
    );
    $post_field_string = http_build_query($info, '', '&');
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_USERPWD, "$geousername:$geopassword");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field_string);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $exec = curl_exec($ch);

    curl_close($ch);

    //echo $exec;
    if (trim($exec) == 'no features were found')
    {
        // return;
        //echo 'no features were found</br>';
		
        
    }
    else
    {
        $response = explode("\n\r\n", $exec);

        $infodata = explode("\n", $response[0]);

        $header = explode("\n", $response[0]);
		
		

        $len = sizeof($header) - 3;

        $popup_fields = getPopup($id);

        $popup_db_fields = $popup_fields['popup_db_fields'];
        $popup_db_fields = explode(',', $popup_db_fields);

        $popup_public_fields = $popup_fields['popup_public_fields'];
        $popup_public_fields = explode(',', $popup_public_fields);

        for ($x = 2;$x <= $len;$x++)
        {

            $ret = explode('=', $header[$x]);

            $array = explode(' ', $ret[0]);

            if (in_array($array[0], $popup_db_fields))
            {

                $index = array_search($array[0], $popup_db_fields);

                $ret[0] = $popup_public_fields[$index];

                
            }
			
			else{
				 $class = $id . '_tr';
                $html .= "<tr class = $class  style='background-color:#ffffff;$style'><td>$ret[0]</td><td>$ret[1]</td></tr>";
           
				
				
			}

        }

       if($ln=='gid'){
                $html.="<tr class = $class  style='background-color:#ffffff;$style'><td colspan=2><a href='search.php'>View Project Details</td></tr>";
        }

        $html .= "</table></br>";

        echo $html;

    }
    $k = $k + 1;

}

function getPopup($id)
{
    

    return array(
        'popup_db_fields' => 'the_geom, gid',
        'popup_public_fields' => ''
    );

}

?>
