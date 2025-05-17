 <div class="image-editor" id="crop">

    <div class="form-group">
      <label>Display Image </label>
      <div class="input-group">
	    <div class="cropit-preview"><?php if($_GET['imgurl']) echo "<img class='previmg' src= ' " . BASE_PATH . $_GET['imgurl'] . " ' >"; ?></div>
      <div class="select-image-btn btn btn-info"><span class="fa fa-file-image-o"></span>  Select new image</div><br/>Or Drag n' Drop
      <input type="file" name="cropit-image-input"  class="form-control cropit-image-input "  accept="image/gif, image/jpeg,image/jpg, image/png" />
      <input type="hidden" name="image-data" class="hidden-image-data" />
      </div>


    </div>


    <div class="form-group zoomimage">
	    <label class="image-size-label"> Resize image </label>
      <div class="input-group">
          <div class="input-group-addon">
            <span class="fa fa-sliders"></span>
          </div>
          <input type="range" class="form-control cropit-image-zoom-input" />

	      <div class="input-group-addon">
	          <button class="rotate-ccw btn btn-default" type ="button"><span class="fa fa-rotate-left"></span></button>
	          <button class="rotate-cw btn btn-default" type ="button"><span class="fa fa-rotate-right"></span></button>
	           <!-- <div class="floatright"> -->
	            <!-- <button type="button" class="btn btn-info export" id = "artimg">Submit Image</button> -->
	          <!-- </div>   -->
          </div>

      </div>
       <!-- <p class="impinfo">Please remember to push the submit image button before submitting the form.</p> -->


    </div>

  </div>
