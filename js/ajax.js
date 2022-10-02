$(function(){
    //Hide the error/success message response on load
    $('#response').hide();
    $('.submit-btn').click(function(){
        //Hide the reponse from last time
        $('#response').hide();
        var formInputs = new Array();
        //Get the form ID
        var id = $(this).parent().attr('id');
        console.log('#' + id + ' input');
        $('#' + id + ' input').each(function(){
            //Remove any previously set errors
            $(this).removeClass('error');
            //Create a temp object that holds the input data
            var obj = {
                'value': $(this).val(),
                'id': $(this).attr('id')

            };
            //Add the object to the array
            formInputs.push(obj); 
            console.log(obj.value);
        });
        $.ajax({
            url: '../../signin.php',
            type: 'POST',
            data: {
                'inputs': formInputs
            },
            success: function(data) {
                //Check to see if the validation was successful
                if (data.success) {
                    //Turn the response alert into a success alert
                    
                    //Add the success message text into the alert
                    window.location.href = data.url;

                } else {
                    //There were some errors
                    //Turn the response alert into an error alert
                    
                    //Create a message and a HTML list to display in the response alert
                    var list = "errors";
                    $.each(data.errors, function(){
                        $('#' + this.field).addClass('error');
                        list += "<li>" + this.msg + "</li>";
                    });
                    list += "</ul>";
                    //Add the HTML to the response alert and fade it in
                    $('#response').html(list).fadeIn();

                    console.log(data.errors);
                }
            }
        });
    });
});
// //Create an array to store data that we will send back to the jQuery
//     $data = array(
//         'success' => false, //Flag whether everything was successful
//         'url'=>'',
//         'errors' => array() //Provide information regarding the error(s)
//     );
 
//     //Check to make sure that the inputs variable has been posted
//     if (isset($_REQUEST['inputs'])) {
//         $user = new User();
//         //Store the posted data into an array
//         $inputs = $_REQUEST['inputs'];
    
//         //Loop through each input field
//         foreach ($inputs as $input) {
//             $id = $input['id'];
//             $value = $input['value'];
//             //Determine what validation we need to be doing
//             switch($id) {
//                 //Username and real name need the same validation, so only need one case block here
//                 case "uemail":
//                     //Ensure that they are both at least 6 characters long
//                     if (empty($value)) {
//                         $msg="Email should not be empty";
//                     }
//                     else{
//                         if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
//                             $msg="Please Enter valid email";
//                         }
//                         else{
//                             $msg=null;
//                         }
//                     }
//                     break;
//                 case "upassword":
//                     //Use PHP filter to validate the E-Mail address
//                     if (empty($value)) {
//                         $msg="Password should not be empty";
//                     }
//                     else{
//                         if (strlen($value) < 6) {
//                             //To make it more readable, replace the "-"'s with spaces and make the first character upper case
//                             $msg = "your password is wrong";
//                         }else{
//                             $msg=null;
//                         }
//                     }
//                     break;
//                 default:
//                         //If some field has been passed over, we report the error
//                          $msg = "Sorry, we don't understand this data, please try again";
//                     break;
//             }

//             //If there is an error, add it to the errors array with the field id
//             if (!empty($msg)) {
//                 $data['errors'][] = array(
//                     'msg' => $msg,
//                     'field' => $id
//                 );
//             }
//         }
 
//         //Validation over, was it successful?
//         if (empty($data['errors'])) {
//             $data['success'] = true;
//             $data['url']="../../home.php";
//         }
 
//     } else {
//         $data['errors'][] = "Data missing";
//     }
 
//     //Set the content type and charset to ensure the browser is expecting the correct data format, also ensure charset is set-to UTF-8 and not utf8 to prevent any IE issues
//     header("Content-Type: application/json; charset=UTF-8");
//     echo json_encode((object)$data);