			<table class="form-table">
				<!-- guttenberg by cpt -->
				<tr valign="top">
					<th><?php echo __('Gutenberg by PT', 'hcc'); ?></th>
					<td>
						<p class="description"><?php echo __('Disable gutenberg editor for certain post types.', 'hcc'); ?></p>
						<?php $post_type_list_saved = get_option('hcc-theme-gtb-pt');
						if (empty($post_type_list_saved)) {
							$post_type_list_saved = array();
                            //update_option('hcc-theme-gtb-pt', $post_type_list_saved);
						}
						$post_type_list = '
						<br/>
						<label>
						<input name="hcc-theme-gtb-pt[]" type="checkbox" value="post"'.(in_array( 'post', $post_type_list_saved )? "checked" : "").'/> ' .  __('Post.', 'hcc') . '
						</label>
						<br/>
						<label>
						<input name="hcc-theme-gtb-pt[]" type="checkbox" value="page"'.(in_array( 'page', $post_type_list_saved )? "checked" : "").'/> ' .  __('Page.', 'hcc') . '
						</label>
						';
						$post_types = get_post_types( array('public'   => true, '_builtin' => false), 'names' );
						if (!empty($post_types)) {
							foreach ( $post_types as $post_type ) {
								$post_type_list .= '
								<br/>
								<label>
								<input name="hcc-theme-gtb-pt[]" type="checkbox" value="' . $post_type . '"'.(in_array( $post_type , $post_type_list_saved )? "checked" : "").'/> ' . $post_type . '
								</label>
								';
							}
						}
						echo $post_type_list; ?> 
					</td>
				</tr>
				<!-- guttenberg by template -->
				<tr valign="top">
					<th><?php echo __('Gutenberg by template', 'hcc'); ?></th>
					<td>
						<p class="description"><?php echo __('Disable gutenberg editor for certain templates.', 'hcc'); ?></p>
						<?php 
						$template_list_saved = get_option('hcc-theme-gtb-tmpl');
						if (empty($template_list_saved)) {
							$template_list_saved = array();
						}
                        if( isset($template_list_saved) ){
                            array_push( $template_list_saved, 'templates/template-acf-flexible.php' );
                            array_push( $template_list_saved, 'template-acf-flexible.php');
                            update_option('hcc-theme-gtb-tmpl', $template_list_saved);
                        }
						$template_list = '';
						$tmplts = get_page_templates();

						if (!empty($tmplts)) {
							foreach ( $tmplts as $k => $tmpl ) {
                                if( $tmpl === 'templates/template-acf-flexible.php' || $tmpl === 'template-acf-flexible.php' ){
                                    $template_list .= '
                                    <br/>
                                    <label>
                                    <input name="hcc-theme-gtb-tmpl[]" type="checkbox" value="' . $tmpl . ' " checked="checked" disabled/> ' . $k . '
                                    </label>
                                    ';
                                }
                                else{
                                    $template_list .= '
                                    <br/>
                                    <label>
                                    <input name="hcc-theme-gtb-tmpl[]" type="checkbox" value="' . $tmpl . '"'.(in_array( $tmpl , $template_list_saved )? "checked" : "").'/> ' . $k . '
                                    </label>
                                    ';   
                                }
							}
						} else {
							$template_list = '<p>' .  __('No custom template files found.', 'hcc') . '</p>';
						}

						echo $template_list;
						?> 
					</td>
				</tr>
			</table>
