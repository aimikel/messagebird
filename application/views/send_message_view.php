<section class="main clearfix">
    <div class="col-md-12">
        <h1 class="head_title">
            Send a message
        </h1>
    </div>
    <div class="col-md-12">
        <div class="col-md-12 no-padding">
            <div id="notification" style="display: none;">
                <span class="dismiss"><a title="Dismiss this notification">X</a></span>
            </div>
        </div>
        <!--form which takes originator's number, recipients number(s) and the text message-->
        <div class="form_to_send">
            <div class="form_to_send_inner">
                <div class="row">
                    <div class="col-md-6">
                        <span class="input-errors" id="originator-error"></span>
                        <input id="originator" type="text" class="input_item origin_name" placeholder="Originator - type in your number"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <span class="input-errors" id="recipients-error"></span>
                        <textarea id="recipients" class="input_textarea rec_num" placeholder="Recipients - press enter to add more recipients"></textarea>
                    </div>
                    <div class="col-md-6">
                        <span class="input-errors" id="body-error"></span>
                        <textarea id="body" class="input_textarea message_body" placeholder="Type your message here"></textarea>
                      
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 pull-right">
                        <button type="submit" class="submit_btn btn-block btn-primary btn" value="SEND" id="send_message">
                            <i class="fa fa-comment"></i>
                            Send SMS
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

    $(document).ready(function () {
        $("#send_message").click(function () {
            if (!validate_fields()) {
                return false;
            }

            var originator = $("#originator").val();           
            var recipients = $("#recipients").val();
            var body = $("#body").val();
             
            //for each recipient seperated by enter, sends a message
            $.each(recipients.split(/\n/), function (i, recipient) {
                send_message(originator, body, recipient);
            });
        });
        
    });
    
    /*forms the notification error messages if one or all the
   required fields are empty*/
    function validate_fields() {
        var flag = true;
        if ($.trim($("#originator").val()) == "") {
            flag = false;
            $("#originator-error").text("* Originator field is required");
        } else {
            $("#originator-error").text("");
        }

        if ($.trim($("#recipients").val()) == "") {
            flag = false;
            $("#recipients-error").text("* Recipients field is required");
        } else {
            $("#recipients-error").text("");
        }

        if ($.trim($("#body").val()) == "") {
            flag = false;
            $("#body-error").text("* Body field is required");
        } else {
            $("#body-error").text("");
        }

        return flag;
    }
    
    /*sends the message using the originator, recipient and text body values 
    given by the user*/
    function send_message(originator, body_msg, recipient) {
        var mb = new MessageBird('<?= $api_key ?>');
        mb.createMessage(originator, body_msg, [recipient])
                .then((message) => {
                    successful_message(message);
                })
                .catch((err) => {
                    error_message(err);
                });
                
                $("#notification").html("");
    }
    /*
     * when message is sent shows an informative message
     * about the message and its recipient(s)
     */
    function successful_message(message) {
       
        var recipients = message['recipients'];
        var items = recipients['items'];
        var recipient = items[0]['recipient'];     
       
        $("#notification").fadeIn("slow").append('Your message to: ' + recipient + ' has been succesfully sent<br/>');
        $(".dismiss").click(function () {
            $("#notification").fadeOut("slow");
        });
    }
    /*
     * if an error is produced shows an informative message
     */
    function error_message(error) {
        $("#notification").fadeIn("slow").append(error);
        $(".dismiss").click(function () {
            $("#notification").fadeOut("slow");
        });
    }
</script>
