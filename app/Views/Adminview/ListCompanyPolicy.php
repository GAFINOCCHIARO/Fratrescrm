   <div class="w3-container w3-section w3-margin-top">
       <div class="w3-bar w3-dark-grey w3-large w3-margin">
           <a href="<?php echo site_url('/AdminHome'); ?>" class=" w3-xxlarge w3-left"
               title="<?php echo lang('Auth.goadminmenu'); ?>" style="margin-left:25px; margin-top:8px;"
               onclick="$('#loading').show();">
               <i class="fa fa-home" aria-hidden="true"></i>
           </a>
           <a href="#" class=" w3-xxlarge w3-right" title="<?php echo lang('Auth.InsertPrivacyPolicy'); ?>"
               style="margin-right:25px; margin-top:8px;"
               onclick="document.getElementById('insertprivacy').style.display='block'">
               <i class="fa fa-plus" aria-hidden="true"></i>
           </a>
       </div>
   </div>
   <h2 class="w3-center"> Privacy policy</h2>
   <?php echo csrf_field(); ?>
   <div class="w3-responsive w3-margin w3-container w3-card-4">
       <table class="w3-table w3-striped w3-white w3-border-black" style=" max-height: 300px; overflow:scroll "
           id="RequestAppointmentTable">
           <thead>
               <th><?php echo lang('Auth.privacytext'); ?></th>
               <th><?php echo lang('Auth.privacyversion'); ?></th>
               <th><?php echo lang('Auth.privacyeffective_date'); ?></th>
               <th><?php echo lang('Auth.privacycreated_at'); ?></th>
               <th> <?php echo lang('Auth.privacyis_active'); ?></th>
               <th><?php echo lang('Auth.privacyis_draft'); ?></th>
               <th></th>
           </thead>
           <tbody>
               <?php

                foreach ($allprivacy as $privacy) {
                ?>
                   <tr id="rowpendig<?php echo $privacy->id; ?>">
                       <td> <textarea class="w3-input w3-border w3-round-xlarge" cols="60" rows="5"><?php echo esc($privacy->policy_text); ?></textarea> </td>
                       <td> <?php echo esc($privacy->version); ?> </td>
                       <td> <?php echo esc($privacy->effective_date); ?> </td>
                       <td> <?php echo esc($privacy->created_at); ?> </td>
                       <td> <?php if ($privacy->is_active == 0) {
                            ?><button class="w3-green w3-btn active data-id=" <?php echo $privacy->id; ?>">
                                   <i class="fa fa-check-square" aria-hidden="true"></i>
                                   Attiva</button> <?php
                                                } else {
                                                    echo lang('Auth.privacyactive');
                                                } ?></td>
                       <td> <?php if ($privacy->is_draft) { ?>
                               <button class="w3-btn w3-blue edit" data-id="<?php echo $privacy->id; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button><?php } ?>
                       </td>
                       <td>
                       </td>
                       <td>
                       </td>

                   </tr>
               <?php
                }
                ?>
           </tbody>
           <tfoot></tfoot>
       </table>
   </div>
   <div class="w3-container">
       <div id="insertprivacy" class="w3-modal">
           <div class="w3-modal-content">
               <header class="w3-container w3-dark-grey">
                   <span onclick="document.getElementById('insertprivacy').style.display='none'"
                       class="w3-button w3-display-topright">&times;</span>
                   <h5><?php echo lang('Auth.InsertPrivacyPolicy'); ?></h5>
               </header>
               <div class=" w3-container w3-margin ">
                   <div class="w3-row">
                       <textarea name="privacytext" id="privacytext" cols="100" rows="10"
                           class="w3-inputw3 w3-border w3-round-xlarge"
                           placeholder="<?php echo lang('Auth.textareaprovacypolicyplaceholder'); ?>"></textarea>
                   </div>
                   <div class="w3-row">
                       <button class="w3-button w3-block w3-section w3-green w3-ripple w3-padding"
                           id="saveprivacypolicy"><?php echo lang('Auth.btnsave'); ?></button>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <script type="text/javascript">
       $('#saveprivacypolicy').click(function(e) {
           e.preventDefault();
           $('#loading').show();
           var csrfName = 'csrf_token'; // CSRF Token name
           var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
           $.ajax({
               type: "post",
               url: "<?php echo site_url('saveprivacypolicy'); ?>",
               data: {
                   privacytext: $('#privacytext').val(),
                   [csrfName]: csrfHash,
               },
               dataType: "json",
               success: function(data) {
                   $('#loading').hide();
                   $('input[name="csrf_token"]').val(data.token);
                   $('#error').html(data.error);


               }
           });
       })
       $('.edit').click(function(e) {
           e.preventDefault
           alert('edit');
       });
       $('.active').click(function(e) {
           e.preventDefault();
           alert('active');
       });
   </script>