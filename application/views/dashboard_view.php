<section class="main dashboard">
    <div class="main_inner">
        <div class="row-same-height row-full-height">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="head_title">
                            Dashboard
                        </h1>
                    </div>    
                </div>
                <?php if ($messages && !empty($messages)) { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped dashboard_messages">
                                <thead>
                                    <tr>
                                        <th>Originator</th>
                                        <th>Direction</th>
                                        <th>Recipients</th>
                                        <th>Body</th>
                                        <th>Created Date</th>
                                    </tr>
                                </thead>
                                <?php foreach ($messages as $message) { ?>
                                    <tr class="each_message" id="<?= $message['id'] ?>">
                                        <td><?= $message['originator'] ?></td>
                                        <td><?= ($message['direction'] == "mt" ? "Sent" : "Received") ?></td>
                                        <td class="dashboard_recipients">
                                            <?php if (count($message['recipients']) > 1) { ?>
                                                <?= count($message['recipients']) ?> recipients
                                            <?php } else { ?>
                                                <?= $message['recipients'][0]['recipient'] ?>
                                            <?php } ?>
                                        </td>
                                        <td><?= $message['body'] ?></td>
                                        <td><?= $message['createdDatetime'] ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="message_info" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Message Information</h4>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <td>ID</td>
                        <td id="modal_id"></td>
                    </tr>
                    <tr>
                        <td>Originator</td>
                        <td id="modal_originator"></td>
                    </tr>
                    <tr>
                        <td>Send Date</td>
                        <td id="modal_send_time"></td>
                    </tr>
                    <tr>
                        <td>Body</td>
                        <td id="modal_body"></td>
                    </tr>
                </table>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Recipient</th>
                            <th>Status</th>
                            <th>Status Date</th>
                        </tr>
                    </thead>
                    <tbody id="recipients_body">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button id="dismiss_modal" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(window).load(function () {
        $(".each_message").click(function () {
            clear_modal();

            var id = $(this).attr('id');
            var data = {
                id: id
            }
            $.ajax({
                type: "POST",
                url: "<?= base_url('dashboard/retrieve_message') ?>",
                dataType: 'json',
                data: data,
            }).done(function (result) {
                $("#message_info #modal_id").html(result['id']);
                $("#message_info #modal_originator").html(result['originator']);
                $("#message_info #modal_send_time").html(result['createdDatetime']);
                $("#message_info #modal_body").html(result['body']);
                var recipients = result['recipients'];
                $.each(recipients, function (i, item) {
                    $("#message_info #recipients_body").append("<tr><td>" + recipients[i].recipient + "</td><td>" + recipients[i].status + "</td><td>" + recipients[i].statusDatetime + "</td></tr>");
                });
                $("#message_info").modal('show');
            });
        });
        
        receive_messages();
    });

    function clear_modal() {
        $("#message_info #modal_id").html("");
        $("#message_info #modal_originator").html("");
        $("#message_info #modal_send_time").html("");
        $("#message_info #modal_body").html("");
        $("#message_info #recipients_body").html("");
    }

    function receive_messages() {
        var mb = new MessageBird('<?= $api_key ?>');
        
        mb.receiveMessages((err, res) => {
            if (err) {
                return console.error(err);
            }
            console.log(res);
        });
    }
</script>