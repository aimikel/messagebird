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
                <?php if ($messages['messages'] && !empty($messages['messages'])) { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped dashboard_messages" id="dashboard_messages">
                                <thead>
                                    <tr>
                                        <th>Originator</th>
                                        <th>Direction</th>
                                        <th>Recipients</th>
                                        <th>Body</th>
                                        <th>Created Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($messages['messages'] as $message) { ?>
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
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination">
                            <?php if ($messages['links']['first_offset'] != "") { ?>
                                <a id="first_offset" href="<?= base_url('dashboard/' . $messages['links']['first_offset']) ?>">First</a>
                            <?php } ?>

                            <?php if ($messages['links']['previous_offset'] != "") { ?>
                                <a id="previous_offset" href="<?= base_url('dashboard/' . $messages['links']['previous_offset']) ?>">Previous</a>
                            <?php } ?>

                            <?php if ($messages['links']['next_offset'] != "") { ?>
                                <a id="next_offset" href="<?= base_url('dashboard/' . $messages['links']['next_offset']) ?>">Next</a>
                            <?php } ?>

                            <?php if ($messages['links']['last_offset'] != "") { ?>
                                <a id="last_offset" href="<?= base_url('dashboard/' . $messages['links']['last_offset']) ?>">Last</a>
                            <?php } ?>
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
        $('#dashboard_messages').on('click', '.each_message', function () {
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

            var mgs = res['items'];
            $.each(mgs, function (i, data) {
                if (check_message_id_cookie(mgs[i].id) != 0) {
                    append_message(mgs[i]);
                    append_pagination(res);
                }
            });

        });
    }

    function append_message(message) {
        var id = message.id;
        var originator = message.originator;
        var direction = message.direction;
        var body = message.body;
        var created_date = message.createdDatetime;

        var recipients = message.recipients;
        var items = recipients['items'];
        var count_of_recipients = items.length;

        if (count_of_recipients > 1) {
            var recipient_string = count_of_recipients + " recipients";
        } else {
            var recipient_string = items[0]['recipient'];
        }

        var string = "<tr class='each_message' id=" + id + "><td>" + originator + "</td><td>" + direction + "</td><td>" + recipient_string + "</td><td>" + body + "</td><td>" + created_date + "</td></tr>";
        $(string).prependTo("#dashboard_messages tbody");
    }

    function append_pagination(res) {
        var f_offset = res.links['first'];
        if (f_offset != null) {
            var first_offset = f_offset.split("?offset=").pop();
            var href = "<?= base_url() ?>" + "dashboard/" + first_offset;
            $("#first_offset").attr('href', href);
        }

        var p_offset = res.links['previous'];
        if (p_offset != null) {
            var previous_offset = p_offset.split("?offset=").pop();
            var href = "<?= base_url() ?>" + "dashboard/" + previous_offset;
            $("#previous_offset").attr('href', href);
        }

        var n_offset = res.links['next'];
        if (n_offset != null) {
            var next_offset = n_offset.split("?offset=").pop();
            var href = "<?= base_url() ?>" + "dashboard/" + next_offset;
            $("#next_offset").attr('href', href);
        }

        var l_offset = res.links['last'];
        if (l_offset != null) {
            var last_offset = l_offset.split("?offset=").pop();
            var href = "<?= base_url() ?>" + "dashboard/" + last_offset;
            $("#last_offset").attr('href', href);
        }

    }

    function check_message_id_cookie(message_id) {
        var messages_ids_cookies = JSON.parse(Cookies.get('messages_ids'));
        var found = false;
        $.each(messages_ids_cookies, function (i, data) {
            if (data == message_id) {
                found = true;
                return 1;
            }
        });

        if (found == false) {
            messages_ids_cookies.push(message_id);
            Cookies.set('messages_ids', messages_ids_cookies);
            return 0;
        }
    }
</script>