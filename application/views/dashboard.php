<?php
	$class = $this->uri->segment(2);
	$page = ($this->uri->segment(3))? $this->uri->segment(3) : 'home';
?>

		<div id="wrapper">
<?php if($page=='home'): ?>
			<div id="itinerary">
<?php foreach($itins as $itin): ?>
				<div class="post">
					<h2><?php echo strtoupper($class).' - '.date("l, F jS", strtotime($itin->timestamp)); ?></h2>
					<?php echo $itin->content."\n"; ?>
				</div>
<?php endforeach; ?>
			</div>
			<div id="sidebar">
				<ul>
<?php foreach($assigns as $assign): ?>
					<li><?php echo $assign->title; ?></li>
<?php endforeach; ?>
				</ul>
			</div>
<?php elseif($page==''): ?>
		
<?php endif; ?>
		</div>