<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Conceptual Model</title>
	</head>
	<body>
		<h1>Conceptual Model</h1>
		<br>
		<h2>Entities & Attributes</h2>

		<h3>Profile</h3>
		<ul>
			<li>profileId (primary key)</li>
			<li>profileQuestionId (foreign key)</li>
			<li>profileAnswerId( foreign key)</li>
		</ul>
			<h3>Questions</h3>
		<ul>
			<li>questionID (primary key)</li>
			<li>questionProfileId </li>
			<li>questionLocation</li>
			<li>questionText</li>
			<li>questionsDate</li>
		</ul>
			<h3>Answers</h3>
		<ul>
			<li>answerId(primary key)</li>
			<li>answerProfileId</li>
			<li>answerEmail</li>
			<li>answerLocation</li>
			<li>answerText</li>
			<li>answersDate</li>
		</ul>
		<h3>Relations</h3>
		<ul>
		<li>One user can answer many questions (1 to n)</li>
		<li>One question can have many answers  (1 to n)</li>
		</ul>
		<a href="index.php">Home</a>
	</body>
</html>