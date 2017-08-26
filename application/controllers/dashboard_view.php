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
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Direction</th>
                                        <th>Originator</th>
                                        <th>Recipients</th>
                                        <th>Body</th>
                                        <th>Created Date</th>
                                    </tr>
                                </thead>
                                <?php foreach ($messages as $message) { ?>
                                    <tr>
                                        <td><?= $message['id'] ?></td>
                                        <td><?= ($message['direction'] == "mt" ? "Sent" : "Received") ?></td>
                                        <td><?= $message['originator'] ?></td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <th>Recipient</th>
                                                    <th>Status</th>
                                                    <th>Status Date</th>
                                                </tr>
                                                <?php foreach ($message['recipients'] as $recipient) { ?>
                                                    <tr>
                                                        <td><?= $recipient['recipient'] ?></td>
                                                        <td><?= $recipient['status'] ?></td>
                                                        <td><?= $recipient['statusDatetime'] ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
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
