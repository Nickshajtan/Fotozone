   	<table class="form-table">
			<tr valign="top">
				<th><?php echo __('WordPress cleanup', 'hcc'); ?></th>
				<td>
					<p class="description"><?php echo __("Disable core wordpress functions. This option will work only in case 'Clearfy' plugin is deactivated since it duplicates part of it's functionality.", 'hcc'); ?></p>
					<?php $cleaner = get_option('hcc-theme-wp-cleanup'); ?>
					<p> <label> <input name="hcc-theme-wp-cleanup" type="checkbox" value="1" <?php checked( '1', $cleaner); ?>/> <?php echo __('Enable', 'hcc'); ?> </label></p> 
					<ul>
						<li><b><?php echo __('This function removes', 'hcc'); ?>:</b></li>
						<li>- <?php echo __('Wordpress Meta Generator.', 'hcc'); ?></li>
						<li>- <?php echo __('Wordpress Rsd Link.', 'hcc'); ?></li>
						<li>- <?php echo __('Windows Live Writer Manifest Link.', 'hcc'); ?></li>
						<li>- <?php echo __('Wordpress Page/post Shortlinks.', 'hcc'); ?></li>
						<li>- <?php echo __('Rest Api Link Tag.', 'hcc'); ?></li>
						<li>- <?php echo __('Oembed Discovery Links.', 'hcc'); ?></li>
						<li>- <?php echo __('Rest Api Link In Http Headers.', 'hcc'); ?></li>
						<li>- <?php echo __('Global Rss, Rdf & Atom Feeds.', 'hcc'); ?></li>
						<li>- <?php echo __('Prevents Feed Links From Being Inserted In The head Of The Page.', 'hcc'); ?></li>
						<li>- <?php echo __('Comment Feeds.', 'hcc'); ?></li>
						<li>- <?php echo __("Emoji's.", 'hcc'); ?></li>
						<li>- <?php echo __('Emoji Cdn Hostname From Dns Prefetching Hints.', 'hcc'); ?></li>
						<li>- <?php echo __('jQuery migrate.', 'hcc'); ?></li>
					</ul>
				</td>
			</tr>
			<tr>
				<th><?php echo __('WordPress blog', 'hcc'); ?></th>
				<td>
					<p class="description"><?php echo __('Disable core wordpress blogging features.', 'hcc'); ?></p>
					<?php $blogging_dn = get_option('hcc-theme-wp-blog-dn'); ?>
					<p> <label> <input name="hcc-theme-wp-blog-dn" type="checkbox" value="1" <?php checked( '1', $blogging_dn); ?>/>  <?php echo __('Disable', 'hcc'); ?></label></p> 
					<ul>
						<li><b><?php echo __('This function removes / hides', 'hcc'); ?>:</b></li>
						<li>- <?php echo __('waiting on update', 'hcc'); ?></li>
					</ul>
				</td>
			</tr>
		</table>
