<script type="text/javascript">

    $(document).ready(function () {
        $("#send_message").click(function () {
            if (!validate_fields()) {
                return false;
            }

            var originator = $("#originator").val();
            var body = $("#body").val();
            var recipients = $("#recipients").val();

            $.each(recipients.split(/\n/), function (i, recipient) {
                send_message(originator, body, recipient);
            });
        });
    });
</script>

<script>
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

    function send_message(originator, body_msg, recipient) {
        var mb = new MessageBird('<?= $api_key ?>');
        // Create a message.
        mb.createMessage(originator, body_msg, [recipient])
                .then((message) => {
                    //console.log(message);
                    successful_message(message);
                })
                .catch((err) => {
                    console.error(err);
                });
    }

    function successful_message(message) {
        var id = message['id'];
        var originator = message['originator'];
        var recipients = message['recipients'];
        var items = recipients['items'];
        var recipient = items[0]['recipient'];
        var body = message['body'];
        var created_date = message['createdDatetime'];

        $("#notification").fadeIn("slow").append('Your message with ID: ' + id + '<br/>from: ' + originator + '<br/>to: ' + recipient + '<br/>body: ' + body + '<br/>at: ' + created_date + ' has been succesfully sent');
        $(".dismiss").click(function () {
            $("#notification").fadeOut("slow");
        });

    }
</script>

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
        <div class="form_to_send">
            <div class="form_to_send_inner">
                <div class="row">
                    <div class="col-md-6">
                        <span class="input-errors" id="originator-error"></span>
                        <input id="originator" type="text" class="input_item origin_name" value="306976678923" placeholder="Originator"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <span class="input-errors" id="recipients-error"></span>
                        <textarea id="recipients" class="input_textarea rec_num" placeholder="Recipients - press enter to add more recipients">306976678923</textarea>
                    </div>
                    <div class="col-md-6">
                        <span class="input-errors" id="body-error"></span>
                        <textarea id="body" class="input_textarea message_body" placeholder="testing msg">test body</textarea>
                        <div class="tip_charges_per_sms">
                            <span>
                                0/1377, 0 SMS
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 pull-right">
                        <button type="submit" class="submit_btn btn-block btn-primary btn" value="SEND" id="send_message" onclick="validate_fields()">
                            <i class="fa fa-comment"></i>
                            Send SMS
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
