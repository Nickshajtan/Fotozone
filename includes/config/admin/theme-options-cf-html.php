		<table class="form-table">
			<tr valign="top">
				<th><?php echo __('Demo mode', 'hcc'); ?></th>
				<td>
					<p class="description"><?php echo __('This option allows to bypass form API and simulate successful delivery and redirect to thank you page.', 'hcc'); ?>
					<b><?php echo __('Make sure to disable it on production website!', 'hcc'); ?></b></p>
					<?php $demo = get_option('hcc-theme-cf-demo'); ?>
					<p><label><input name="hcc-theme-cf-demo" type="checkbox" value="1" <?php checked( '1', $demo); ?>/><?php echo __('Enable', 'hcc'); ?></label></p> 
				</td>
			</tr>
			<tr>
				<th><?php echo __('Redirect', 'hcc'); ?></th>
				<td>
					<p class="description"><?php echo __('Enter thank you page slug, ex. "thank-you" (without quotes). After successful submition user will be redirected to this page.', 'hcc'); ?></p>
					<p><input name="hcc-theme-cf-thanks" type="text" value="<?php echo get_option('hcc-theme-cf-thanks') ?>" /></p> 
				</td>
			</tr>
			<tr><td colspan="2"><hr></td></tr>
			<tr>
				<th><?php echo __('Admin Email', 'hcc'); ?></th>
				<td>
					<p class="description"><?php echo __('Enter Email for contact forms.', 'hcc'); ?></p>
					<p><input name="hcc-theme-cf-email" type="text" value="<?php echo get_option('hcc-theme-cf-email') ?>" /></p> 
				</td>
			</tr>
			<tr>
				<th><?php echo __('Saving Emails in admin panel', 'hcc'); ?></th>
				<td>
					<p class="description"><?php echo __('Save emails in admin panel', 'hcc'); ?><br/>
					<b><?php echo __('Attention: enabled this option is able to do your database oversizing', 'hcc'); ?></b></p>
					<?php $save_panel = get_option('hcc-theme-cf-panel-save'); ?>
					<p><label><input name="hcc-theme-cf-panel-save" type="checkbox" value="1" <?php checked( '1', $save_panel); ?>/><?php echo __('Enable', 'hcc'); ?></label></p> 
				</td>
			</tr>
			<?php do_settings_sections( 'hcc-mf-settings-theme' ); ?>
			<tr><td colspan="2"><hr></td></tr>
			    <th><?php echo __('Modal form', 'hcc'); ?></th>
			    <td>
					<p class="description"><?php echo __('Enable/disable modal form', 'hcc'); ?><br/>
					<?php $modal = get_option('hcc-theme-cf-modal'); ?>
					<p><label><input name="hcc-theme-cf-modal" type="checkbox" value="1" <?php checked( '1', $modal); ?>/><?php echo __('Enable', 'hcc'); ?></label></p> 
					<p class="description"><?php echo __('Enter title for modal form.', 'hcc'); ?></p>
                    <p><textarea name="hcc-theme-cf-modal-title" style="min-width: 400px; max-width: 100%;"><?php echo get_option('hcc-theme-cf-modal-title') ?></textarea></p>
				</td>
				<?php if( false ) : ?>
				<td>
				    <p class="description"><?php echo __('Modal form image.', 'hcc'); ?></p>
					<?php 
					if ( isset( $_REQUEST['saved'] ) ){
						echo '<div class="updated"><p>' . __('Saved.', 'hcc') . '</p></div>';
					}
					echo hcc_image_uploader_field( 'hcc-theme-mf-img', get_option( 'hcc-theme-mf-img' ) ); ?>
				</td>
				<?php endif; ?>
		</table>
