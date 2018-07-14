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
			<li>profileNickname</li>
			<li>profileLocation</li>
			<li>profileEmail</li>
		</ul>
			<h3>Questions</h3>
		<ul>
			<li>questionId (primary key)</li>
			<li>questionProfileId (foreign key) </li>
			<li>questionLocation</li>
			<li>questionText</li>
			<li>questionsDate</li>
		</ul>
			<h3>Answers</h3>
		<ul>
			<li>answerId(primary key)</li>
			<li>answerProfileId(foreign key)</li>
			<li>answerQuestionId (foreign key)</li>
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
		<img src="erd.jpg" alt="ERD Model">

		<a href="index.php">Home</a>
	</body>
</html>