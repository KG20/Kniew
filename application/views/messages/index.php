<?php
protectPage();
if($_SESSION['isauthentic'] === FALSE)
{
  isNotAuthenticMessage();
}
else {
?>
<div class="allmessages">
  <div class="body" id="allmessages">
      <?php
        if(!empty($initialresult)) echo $initialresult;
        ?>
  </div>
  <?php if($messagesize >= $numberofmessages) echo '<button type="button" class="btn btn-default col-xs-12" id="loadmoremessages" data-lastpage = "1">Load older messages</button>';
  ?>
  <p class ="loader nodisplay"> <i class= "fa fa-spinner fa-pulse fa-2x"></i></p>
</div>

<div id="singlemessage" class="body">
  <div class="col-xs-12 paddingleftzero paddingrightzero transparentBack positionAbsolute">
    <div class="col-xs-1 col-sm-1 padding2per" id="backtomessages"><i class="fa fa-arrow-left" aria-hidden="true"></i></div>
    <div id="downtoendmessages"><i class="fa fa-arrow-down" aria-hidden="true"></i></div>
  </div>

  <div class="col-xs-12 paddingleftzero paddingrightzero" id="loadsinglemessage">
  </div>
  <div class="col-xs-12" id="inputmessage">
    <button id='closemessage' class='btn btn-danger btn-xs' disabled><i class='fa fa-times'></i><span>Close Session</span></button>

    <form id="inputmessagebox" action="" method="post" class="form" name="inputmessageform" enctype="multipart/form-data">
      <div class="form-group">
        <textarea class="form-control" disabled row="1" id="inputmessagetext"  name="inputmessagetext" required></textarea>
        <input type="hidden" name="state" value="<?php echo $_SESSION['state']; ?>" />
      </div>
      <div class="form-group">
        <input type="submit" disabled id="sendpersonalmessage" name="sendpersonalmessage" value="Send Message!" class="btn pull-right"/>
        <!-- <div class="col-xs-6"> -->
          <input type="file" disabled accept=".bmp, .gif, .ico, .jpeg, .jpg, .png, .odp, .pps, .ppt, .pptx, .odsm, .xlr, .xls, .xlsx, .doc, .docx, .odt, .pdf, .rtf, .txt" name="attachment" id="inputmessageattachment" class="hidden maxwidth50"/><i id="removeinputmessageattachment" class="xsmalltext handcursor hidden redtext textunderline">Remove</i>
          <!-- application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/* -->
        <!-- </div> -->
      </div>
    </form>

  </div>

</div>
<?php } ?>
