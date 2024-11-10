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
                   <td> <?php echo esc($privacy->version); ?> </td>
                   <td> <?php echo esc($privacy->effective_date); ?> </td>
                   <td> <?php echo esc($privacy->created_at); ?> </td>
                   <td> <?php echo esc($privacy->is_active); ?> </td>
                   <td> <?php echo esc($privacy->is_draft); ?> </td>
                   <td> <button class="w3-button w3-xlarge w3-green editappoint"
                           title="<?php echo lang('Auth.editandconfirm'); ?>" id="editappoint"
                           data-id="<?php echo $appointment->id_appointment; ?>"><i class="fa fa-check-square"
                               aria-hidden="true"></i>
                       </button>
                   </td>
                   <td> <button class="w3-button w3-xlarge w3-green delappoint"
                           title="<?php echo lang('Auth.editandconfirm'); ?>" id="delappoint"
                           data-id="<?php echo $appointment->id_appointment; ?>"><i class="fa fa-trash"
                               aria-hidden="true"></i>
                       </button>
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

   </script>