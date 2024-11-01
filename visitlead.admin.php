<?php if(!$in_visitlead) exit; ?>
	<div class="wrap">
		<?php screen_icon() ?>
		<h2><?php _e('Visitlead', 'visitlead') ?></h2>
		<div class="metabox-holder meta-box-sortables ui-sortable pointer">
			<div class="postbox" style="width:600px;">
				<h3 class="hndle"><span><?php _e('Setup', 'visitlead') ?></span></h3>
				<div class="inside" style="padding: 12px">
					<table style="margin: 18px 0">
						<tr>
							<td><a href="https://visitlead.com/" title="VISITLEAD Live Chat" target="_blank"><img src="<?php echo $plugin_dir; ?>visitlead.png" alt="VISITLEAD Live Chat" /></a></td>
							<td style="vertical-align: top; padding-left: 24px">
								<span>Interact and communicate with your online visitors in realtime. With live chat, video chat, monitoring ...</span>
							</td>
						</tr>
					</table>
					<p>You need to have an VISITLEAD Account to use this plugin. <a href="https://visitlead.com/register">Create a free Account</a></p>

					<form method="post" action="options.php">
						<?php settings_fields('visitlead'); ?>
						<div style="font-weight: bold">
							<label for="visitlead_cid">Enter here your VISITLEAD CID (Client ID)</label><br/>
							<input style="font-size: large; width: 500px" type="text" name="visitlead_cid" maxlength="24"  title="24 characters" value="<?php echo get_option('visitlead_cid'); ?>" style="width:100%" />
						</div>
						
						<p>Get your CID from your <a href="https://VISITELAD.com/login" target="_blank" style="margin: 0 3px">exisiting</a> 
							account - OR - 
							<a href="https://VISITELAD.com/register" target="_blank" style="margin: 0 3px">create a new</a> free account.
						</p>
						<p class="submit">
							<input type="submit" class="button-primary" value="<?php _e('Save') ?>" />
						</p>
					</form>
				</div>
			</div>									
		</div>
	</div>
