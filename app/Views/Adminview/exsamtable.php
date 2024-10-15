<html lang="en">

    <head>
           <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </head>

    <body>
        <div id="exsamlistnodal" class="w3-modal" style="display: block;" >
            <!-- begin window exsamlist -->
            <div class="w3-modal-content w3-card-4">
                <header class="w3-container w3-dark-grey">
                    <span onclick="document.getElementById('exsamlistnodal').style.display='none'"
                        class="w3-button w3-display-topright">&times;</span>
                    <h2> <?php echo lang('Auth.Exsamlist'); ?></h2>
                </header>
               
                    <div class="w3-responsive" style="width:auto;height: 400px;">
                        <table class="w3-table-all">
                            <tr>
                                <th><?php echo lang('Auth.donationTypeLabel'); ?></th>
                                <th><?php echo lang('Auth.Donationdate'); ?></th>
                                <th><?php echo lang('Auth.daystop'); ?></th>
                                <th><?php echo lang('Auth.notestopLabel'); ?></th>
                                <th><?php echo lang('Auth.textnoteinpdf'); ?></th>
                                <th><?php echo lang('Auth.uploadfile'); ?></th>
                                <th><?php  echo lang('Auth.downloadfile'); ?></th>
                            </tr>
                            <?php foreach ($listexsam['listall'] as $list) { ?>
                            <tr>
                                <td><?php echo esc($list['exam_type']); ?> </td>
                                <td> <?php echo esc($list['donation_date']); ?></td>
                                <td> <?php echo esc($list['day_stop']); ?></td>
                                <td> <?php echo esc($list['stop_notice']); ?></td>
                                <td> <?php echo esc($list['notedoctor']); ?></td>
                                <td> <?php echo esc($list['upload_date']); ?></td>
                                <td> <?php echo esc($list['download_date']); ?></td>
                            </tr>
                            <?php }?>
                        </table>
                    </div>
                <footer class="w3-container w3-dark-grey">
                    <p><?php echo lang('Auth.Exsamlist'); ?></p>
                </footer>
            </div>
        </div>
    </body>

</html>