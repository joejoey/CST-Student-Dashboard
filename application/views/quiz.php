		<div id="wrapper">
			<div id="header"></div>
			<div id="container">
				<div id="content">
					<div id="intro">
						<p>You are about to take the quiz <span class="quiz"><?php echo $name; ?></span>. You can take this quiz ______. If you don't want to take this quiz, you can go back to the class homepage or assignments page.</p>
					</div>
<?php
	$quiz = file_get_contents($path);

	$quiz = new SimpleXMLElement($quiz);

	foreach($quiz->question as $question): ?>
					<div class="question">
						<p><?php echo $question->prompt; ?></p>
<?php $answers = array();
		foreach($question->answers->answer as $answer)
		{
			$answers[] = $answer;
		}
		shuffle($answers); ?>
						<ul>
<?php foreach($answers as $answer): ?>
							<li><?php $answer; ?></li>
<?php endforeach; ?>
						</ul>
					</div>
<?php endforeach; ?>
				</div>
			</div>
		</div>