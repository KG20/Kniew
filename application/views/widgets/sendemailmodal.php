<?php adminProtectPage(); ?>
<div id="sendEmailModal" class="modal fade" >
  <div id="modal" class="modal-dialog">
   <div class="modal-content">
     <div class="modal-header crossbackground barsBack textaligncenter">
       <?php if(isset($sendEmailTitle)) echo $sendEmailTitle; else echo "<h2>Send Email</h2>"; ?>
     </div>
     <form class="form" action="" method="post" name="<?php if(isset($sendEmailModalId)) echo $sendEmailModalId; else echo "sendEmailModalForm"; ?>" id="<?php if(isset($sendEmailModalId)) echo $sendEmailModalId; else echo "sendEmailModalForm"; ?>">
       <input type="hidden" name="sendto" id="emailSendTo"/>
       <input type="hidden" name="name" id="nameSendTo"/>
       <div class="modal-body">
         <div class="form-group">
           <label class="boldtext">Subject</label>
           <p>
             <?php
              if(isset($addToSubject))
              {
                echo '<div class="input-group">
                  <span class="input-group-addon smallertext">'.$addToSubject.'</span>
                  <input type="text" class="form-control" name="subject" placeholder="';
                echo isset($subjectPlaceholder)?$subjectPlaceholder:"Subject of the Email";
                echo '" required/>
                </div>';
              }
              else echo '<input required type="text" name="subject"  class="form-control" placeholder="Subject of the Email" required/>';
              ?>

           </p>
         </div>
         <div class="form-group">
           <label class="boldtext"><?php if(isset($emailLabel)) echo $emailLabel; else echo "Content";?> </label>
           <?php if(isset($addToEmail)) echo $addToEmail; ?>
           <textarea name="content" id="emailContent"  class="form-control story" rows = "5" placeholder="Add email body" required></textarea>
           <p class="impinfo xsmalltext textalignjustify">*The system will automatically add salutations.<?php if(isset($addToImpinfo)) echo $addToImpinfo; ?></p>
         </div>

         <div class="errordiv"></div>

       </div>
       <div class="modal-footer">
         <div class="form-group">
           <input name="sendemail" type="submit" value="<?php if(isset($sendEmailSubmit)) echo $sendEmailSubmit; else echo "Send Email";?>" class="btn-lg  btn-primary fullwidth">
         </div>
       </div>
     </form>
   </div>
   </div>
 </div>
