		<div id="message_container" class="<?php echo (isset($message))? $message : ''; ?>"><div id="message"></div><div id="close"></div></div>
		<?php if(!isset($signup)): ?>
		<form id="login_form" action="">
			<input type="text" id="username" name="Username" value="Username" />
			<input type="text" id="fakepassword" value="Password" />
			<input type="password" id="password" value="" style="display:none" />
			<p><a href="<?php echo base_url().'signup'; ?>">Create a new account</a></p>
			<input type="submit" value="">
		</form>
		<a href="reset" title="Reset Password"><p id="forgot"></p></a>
		<?php else: ?>
		<form id="signup_form" action="">
			<input type="text" id="first" name="First Name" value="First Name" />
			<input type="text" id="last" name="Last Name" value="Last Name" />
			<input type="text" id="username" name="Desired Username" value="Desired Username" />
			<input type="text" id="fakepassword" value="Password" />
			<input type="password" id="password" value="" style="display:none" />
			<input type="text" id="fakepassword2" value="Confirm Password" />
			<input type="password" id="password2" value="" style="display:none" />
			<p>Select all classes that apply</p>
			<div id="classes"><div class="class cst2"><input type="hidden" value="1" /></div><div class="class cnh2"><input type="hidden" value="2" /></div><div class="class cnh1"><input type="hidden" value="4" /></div><div class="class cst1"><input type="hidden" value="5" /></div><div class="class crep"><input type="hidden" value="7" /></div></div>
			<input type="submit" value="">
		</form>
		<?php endif; ?>