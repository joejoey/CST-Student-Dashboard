		<div id="header">
			<div id="logo"></div>
			<ul id="nav">
				<li id="nav_home" <?php echo ($this->uri->segment(3))? '' : 'class="sel"'; ?>><a href="<?php echo base_url().'classes/'.$this->uri->segment(2); ?>" title="Dashboard"></a></li>
				<li id="nav_assign" <?php echo ($this->uri->segment(3)=='assignments')? 'class="sel"' : ''; ?>><a href="<?php echo base_url().'classes/'.$this->uri->segment(2); ?>/assignments" title="Assignments"></a></li>
				<li id="nav_active" <?php echo ($this->uri->segment(3)=='activities')? 'class="sel"' : ''; ?>><a href="<?php echo base_url().'classes/'.$this->uri->segment(2); ?>/activities" title="Activities"></a></li>
				<li id="nav_logout"><a href="<?php echo base_url(); ?>logout" title="Log Out"></a></li>
			</ul>
		</div>