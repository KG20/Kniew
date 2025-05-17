<div id="addRazorpayAccountModal" class="modal fade" >
  <div  class="modal-dialog">
	   <div class="modal-content">
       <div class="modal-header crossbackground centertext"><h3> Create <img alt='Razorpay' src="<?php echo BASE_PATH . DS. 'images' . DS. 'icons' .DS . 'razorpay.svg'; ?>" class="heighth3 displayinline" />  Account</h3></div>
       <form class="form" action="" method = "POST"  role="form" id="createRPAccountForm">

       <div class="modal-body">
         <div class="row">
           <div class="col-xs-12 col-sm-6">
             <div class="form-group form-group-sm">
               <label>Email </label>
               <div class="input-group">
                   <div class="input-group-addon">
                     <span class="fa fa-envelope"></span>
                   </div>
                   <input required type="email" name="email"  class="form-control" placeholder="iamuser@example.com" value="<?php echo $_SESSION['email'] ?>" disabled/>
               </div>
             </div>

             <div>
               <h5 class="lightgreybottomborder">Business details</h5>
               <div class="form-group form-group-sm">
                 <label>Business Name</label>
                 <div class="input-group">
                     <div class="input-group-addon">
                       <span class="fa fa-building"></span>
                     </div>
                     <input required type="text" name="business_name"  class="form-control" placeholder="Business Name" value="<?php echo $_SESSION['name']; ?>" />
                 </div>
               </div>
               <div class="form-group form-group-sm">
                 <label>Business Type</label>
                 <div class="input-group">
                     <div class="input-group-addon">
                       <span class="fa fa-briefcase"></span>
                     </div>
                     <select class="form-control" name="business_type" required>
                        <option value="individual">Individual</option>
                        <option value="ngo">NGO</option>
                        <option value="partnership">Partnership</option>
                        <option value="proprietorship">Proprietorship</option>
                        <option value="private_limited">Private Limited</option>
                        <option value="public_limited">Public Limited</option>
                        <option value="llp">LLP</option>
                        <option value="not_yet_registered">Not yet registered</option>
                        <option value="other">Other</option>
                      </select>
                 </div>
               </div>
             </div>
           </div>
           <div class="col-xs-12 col-sm-6">
             <div>
               <h5 class="lightgreybottomborder">Bank Account Details</h5>
               <div class="form-group form-group-sm">
                 <label>Account Holder Name</label>
                 <div class="input-group">
                     <div class="input-group-addon">
                       <span class="fa fa-user"></span>
                     </div>
                     <input required type="text" name="beneficiary_name"  class="form-control" placeholder="Name Lastname" value="<?php echo $_SESSION['name']; ?>" />
                 </div>
               </div>
               <div class="form-group form-group-sm">
                 <label>IFSC code</label>
                 <div class="input-group">
                     <div class="input-group-addon">
                       <span class="fa fa-university"></span>
                     </div>
                     <input required type="text" name="ifsc_code"  class="form-control" placeholder="HDFC0CAGSBK" />
                 </div>
               </div>
               <!-- <div class="form-group form-group-sm">
                 <label>Account Type</label>
                 <div class="input-group">
                     <div class="input-group-addon">
                       <span class="fa fa-id-card"></span>
                     </div>
                     <input required type="text" name="account_type"  class="form-control" placeholder="savings" />
                 </div>
               </div> -->
               <div class="form-group form-group-sm">
                 <label>Account Number</label>
                 <div class="input-group">
                     <div class="input-group-addon">
                       <span class="fa fa-credit-card"></span>
                     </div>
                     <input required type="text" name="account_number"  class="form-control" placeholder="304030434" />
                 </div>
               </div>
             </div>
           </div>
           <div class="form-check col-xs-12">
            <label class="form-check-label">
              <input required type="checkbox" class="form-check-input" value="TRUE" name="tnc_accepted"> By signing up you agree to Razorpay's <a target="_blank" href="https://razorpay.com/privacy/">privacy policy</a> and <a target="_blank" href="https://razorpay.com/terms/">terms of use</a>.
            </label>
          </div>

       </div>
     </div>
       <div class="modal-footer">
         <div class="form-group-sm">
               <input required type="submit" name="RPaccount"  class="form-control btn btn-success" value="Create Razorpay Account" />
         </div>
       </div>
       <?php if(isset($threadid)) echo "<input type='hidden' name ='threadid' value='".$threadid."' />"; ?>
        </form>
     </div>
   </div>
 </div>
