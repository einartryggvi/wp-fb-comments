<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2>Facebook Comments settings</h2>
	<?php if ($this->isPost()) :?>
	<div id="setting-error-settings_updated" class="updated settings-error"> 
		<p><strong>Stillingar vistaðar.</strong></p>
	</div>
	<?php endif; ?>
	<form action="" method="post">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="appID">Facebook AppID</label></th>
					<td><input name="appID" type="text" id="appID" value="<?php echo $this->getOption('appID'); ?>" class="regular-text"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="admins">Facebook Admins</label></th>
					<td><input name="admins" type="text" id="admins" value="<?php echo (is_array($this->getOption('admins'))) ? implode(',', $this->getOption('admins')) : ''; ?>" class="regular-text"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="numberOfComments">Number of comments</label></th>
					<td><input name="numberOfComments" type="text" id="numberOfComments" value="<?php echo $this->getOption('numberOfComments'); ?>" class="regular-text"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="width">Width</label></th>
					<td><input name="width" type="text" id="width" value="<?php echo $this->getOption('width'); ?>" class="regular-text"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="colorScheme">Color Scheme</label></th>
					<td>
						<select name="colorScheme" id="colorScheme">
							<option value="light">Light</option>
							<option value="dark">Dark</option>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Vista breytingar"></p>
	</form>
</div>
