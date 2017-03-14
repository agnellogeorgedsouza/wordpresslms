<div style=" overflow: hidden;padding: 10px;">
<style>
	.html_editor_button{
		border-radius:0px;
		background-color: #9C9C9C;
		border-color: #9C9C9C;
		margin-bottom:20px;
	}
	</style>
	<h3><?php _e('Add Accordion',wpshopmart_accordion_text_domain); ?></h3>
	<input type="hidden" name="ac_save_data_action" value="ac_save_data_action" />
	<ul class="clearfix" id="accordion_panel">
	<?php
			$i=1;
			$accordion_data = unserialize(get_post_meta( $post->ID, 'wpsm_accordion_data', true));
			$TotalCount =  get_post_meta( $post->ID, 'wpsm_accordion_count', true );
			if($TotalCount) 
			{
				if($TotalCount!=-1)
				{
					foreach($accordion_data as $accordion_single_data)
					{
						 $accordion_title = $accordion_single_data['accordion_title'];
						 $accordion_title_icon = $accordion_single_data['accordion_title_icon'];
						 $enable_single_icon = $accordion_single_data['enable_single_icon'];
						 $accordion_desc = $accordion_single_data['accordion_desc'];
						?>
						<li class="wpsm_ac-panel single_acc_box" >
							<span class="ac_label"><?php _e('Accordion Title',wpshopmart_accordion_text_domain); ?></span>
							<input type="text" id="accordion_title[]" name="accordion_title[]" value="<?php echo esc_attr($accordion_title); ?>" placeholder="Enter Accordion Title Here" class="wpsm_ac_label_text">
							<span class="ac_label"><?php _e('Accordion Description',wpshopmart_accordion_text_domain); ?></span>
							<textarea  id="accordion_desc[]" name="accordion_desc[]"  placeholder="Enter Accordion Description Here" class="wpsm_ac_label_text"><?php echo esc_html($accordion_desc); ?></textarea>
							<a type="button" class="btn btn-primary btn-block html_editor_button" data-remodal-target="modal" href="#" id="<?php echo $i; ?>"  onclick="open_editor(<?php echo $i; ?>)">Use WYSIWYG Editor </a>
							
							<span class="ac_label"><?php _e('Accordion Icon',wpshopmart_accordion_text_domain); ?></span>
							<div class="form-group input-group">
								<input data-placement="bottomRight" id="accordion_title_icon[]" name="accordion_title_icon[]" class="form-control icp icp-auto" value="<?php echo  $accordion_title_icon; ?>" type="text" readonly="readonly" />
								<span class="input-group-addon "></span>
							</div>
							<span class="ac_label"><?php _e('Display Above Icon',wpshopmart_accordion_text_domain); ?></span>
							<select name="enable_single_icon[]" style="width:100%" >
								<option value="yes" <?php if($enable_single_icon == 'yes') echo "selected=selected"; ?>>Yes</option>
								<option value="no" <?php if($enable_single_icon == 'no') echo "selected=selected"; ?>>No</option>
								
							</select>
							
							<a class="remove_button" href="#delete" id="remove_bt" ><i class="fa fa-trash-o"></i></a>
							
						</li>
						<?php 
						$i++;
					} // end of foreach
				}else{
				echo "<h2>No Accordion Found</h2>";
				}
			}
			else 
			{
				  for($i=1; $i<=2; $i++)
				  {
					  ?>
					 <li class="wpsm_ac-panel single_acc_box" >
						<span class="ac_label"><?php _e('Accordion Title',wpshopmart_accordion_text_domain); ?></span>
						<input type="text" id="accordion_title[]" name="accordion_title[]" value="Accordion Sample Title" placeholder="Enter Accordion Title Here" class="wpsm_ac_label_text">
						<span class="ac_label"><?php _e('Accordion Description',wpshopmart_accordion_text_domain); ?></span>
						
						<textarea  id="accordion_desc[]" name="accordion_desc[]"  placeholder="Enter Accordion Description Here" class="wpsm_ac_label_text">Accordion Sample Description</textarea>
						<a type="button" class="btn btn-primary btn-block html_editor_button" data-remodal-target="modal" href="#" id="<?php echo $i; ?>"  onclick="open_editor(<?php echo $i; ?>)">Use WYSIWYG Editor </a>
						
						<span class="ac_label"><?php _e('Accordion Icon',wpshopmart_accordion_text_domain); ?></span>
						<div class="form-group input-group">
							<input data-placement="bottomRight" id="accordion_title_icon[]" name="accordion_title_icon[]" class="form-control icp icp-auto" value="fa-laptop" type="text" readonly="readonly" />
							<span class="input-group-addon "></span>
						</div>
						<span class="ac_label"><?php _e('Display Above Icon',wpshopmart_accordion_text_domain); ?></span>
							
						<select name="enable_single_icon[]" style="width:100%" >
								<option value="yes" selected=selected>Yes</option>
								<option value="no" >No</option>
						</select>
						<a class="remove_button" href="#delete" id="remove_bt" ><i class="fa fa-trash-o"></i></a>
						
					</li>
					 <?php
				}
			}
			?>
	</ul>
</div>
<!-- Modal Popup For Editor -->
<div class="remodal" data-remodal-options=" closeOnOutsideClick: false" data-remodal-id="modal" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
  <div>
	<h2 id="modal1Title">Accordion Editor</h2>
	<p id="modal1Desc">
	  <?php
		$content = '';
		$editor_id = 'get_text';
		wp_editor( $content, $editor_id );
	?>
	<input type="hidden" value="" id="get_id" />
	</p>
  </div>
  <br>
  <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
  <button data-remodal-action="confirm" class="remodal-confirm" onclick="insert_html()">OK</button>
</div>
	
	
	


<a class="wpsm_ac-panel add_wpsm_ac_new" id="add_new_ac" onclick="add_new_accordion()"   >
	<?php _e('Add New Accordion', wpshopmart_accordion_text_domain); ?>
</a>
<a  style="float: left;padding:10px !important;background:#31a3dd;" class=" add_wpsm_ac_new delete_all_acc" id="delete_all_acc"    >
	<i style="font-size:57px;"class="fa fa-trash-o"></i>
	<span style="display:block"><?php _e('Delete All',wpshopmart_accordion_text_domain); ?></span>
</a>
<div style="clear:left;"></div>
<h1>Get Support Help Here</h1>
<h3>If You have any issue then please ask us any time</h3>
<a href="https://wordpress.org/support/plugin/responsive-accordion-and-collapse" target="_blank" class="button button-primary button-hero ">Get Support</a>
<br> <br>


<?php require('add-ac-js-footer.php'); ?>