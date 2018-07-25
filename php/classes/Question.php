<?php


namespace ChelseaDavid\DataDesign;
require_once ("autoloader.php");
require_once(dirname(__DIR__, 2) .  "../vendor/autoload.php");
use Ramsey\Uuid\Uuid;


/**
 * Small Cross Section of a GameStop question
 *
 * This question can be considered a small example of what services like GameStop store when questions/messages are sent
 * and received using GameStop. This can easily be extended to emulate more feature of GameStop.
 *
 * @author Chelsea David <cryan17@cnm.edu
 * @version 1
 **/
class Question  {
	use ValidateUuid;
	/**
	 * id for this question; this is the primary key
	 * @var Uuid $questionId
	 **/
	private $questionId;
	/** id of the profile that left this question; this is a foreign key
	 * @var UUid $questionProfileId
	 **/
	private $questionProfileId;
	/** actual textual content of this question
	 * @var string $questionContent
	 **/
	private $questionContent;
	/**
	 * date and time this question was sent, in a PHP DateTime object
	 * @var \DateTime $questionDate
	 **/
	private $questionDate;

	/**
	 * @param Uuid $newQuestionId
	 * @param $newQuestionProfileId
	 * @param $newQuestionContent
	 * @param DateTime $newQuestionDate
	 * @throws  InvalidArgumentException
	 * @throws RangeException
	 * @throws Exception
	 * @throws TypeError
	 **/

	public function __construct(string $newQuestionId,string $newQuestionProfileId, string $newQuestionContent,string $newQuestionDate) {
		try {
			$this->setQuestionId($newQuestionId);
			$this->setQuestionProfileId($newQuestionProfileId);
			$this->setQuestionContent($newQuestionContent);
			$this->setQuestionDate($newQuestionDate);

		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception)) ;
		}
	}
	/** accessor method for question id
	 *
	 * @return Uuid value of question id
	 *
	 **/
	public function getQuestionId() : Uuid {
		return($this->questionId);
	}
	/**
	 * mutator method for question id
	 *
	 * @param Uuid/string $newQuestionId new value of question id
	 * @throws \RangeExeption if $newQuestionId is n
	 * @throws \TypeError if $newQuestionId is not a uuid
	 **/
	public function setQuestionId( $newQuestionId) : void {
		try {
			$uuid = self ::validateUuid($newQuestionId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the question id
		$this->questionId = $uuid;
	}

	/**
	 * accessor method for question profile id
	 *
	 * @return Uuid value of question profile id
	 **/
	public function getQuestionProfileId() : Uuid{
		return($this->questionProfileId);
	}
      /**
		 * mutator method for question profile id
		 *
		 * @param string | Uuid $newQuestionProfileId new value of question profile id
		 * @throws \ InvalidArgumentException if $newQuestionProfileId is not a string or insecure
		 * @throws \TypeError if @newQuestionProfileId is not an Uuid
		 **/
      public function setQuestionProfileId( $newQuestionProfileId) : void {
      try {
      	$uuid = self::validateUuid($newQuestionProfileId);
		} catch(\InvalidArgumentException | \Exception | \TypeError $exception) {
      	$exceptionType = get_class($exception);
      	throw(new $exceptionType($exception->getMessage(),0,$exception));
		}
		// convert and store the profile id
			$this-> questionProfileId = $uuid;
      }
      /** accessor method for question content
		 *
		 return string value of question content
		 **/
      public function getQuestionContent() : string {
      	return($this->questionContent);
		}
		/** mutator method for question content

		 * @param string $newQuestionContent new value of question content
		 * @throws \ InvalidArgumentException if $newQuestionContent is not a string or insecure
		 * @throws \RangeException if $newQuestionContent is > 255 characters
		 * @throws \TypeError if $newQuestionContent is not a string
		 **/
		public function setQuestionContent(string $newQuestionContent) : void {
			//verify the question content is secure
			$newQuestionContent = trim($newQuestionContent);
			$newQuestionContent = filter_var($newQuestionContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newQuestionContent) === true) {
				throw(new \InvalidArgumentException("Question content is empty or insecure"));
			}
			//verify the question content will fit in the database
			if(strlen($newQuestionContent) > 255) {
				throw(new \RangeException("Question content is too large"));
			}
			//store the question content
			$this->questionContent = $newQuestionContent;
		}
		/** accessor method for question date
		 * @return \DateTime value of question date
		 * **/
	/**
	 * @return \DateTime
	 */
	public function getQuestionDate(): \DateTime {
		return $this->questionDate;
	}
	/** mutator method for question date

	 * @param \DateTime|string|null $newQuestionDate question date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newQuestionDate is not a valid object or string
	 * @throws \RangeException if $newQuestionDate is a date that does not exist
	 **/
	public function setQuestionDate($newQuestionDate = null) : void {
		//base case: if the date is null, use the current date and time
		if($newQuestionDate === null) {
			$this->questionDate = new \DateTime();
			return;
		}

		$this->questionDate = $newQuestionDate;
		}
	/**
	 * inserts this Question into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// create query template
		$query = "INSERT INTO question(questionId, questionProfileId, questionContent, questionDate) 
						VALUES(:questionId, :questionProfileId, :questionContent, :questionDate)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->questionDate->format("Y-m-d H:i:s.u");
		$parameters = ["questionId" => $this->questionId->getBytes(), "questionProfileId" => $this->questionProfileId->getBytes(), "questionContent" => $this->questionContent, "questionDate" => $formattedDate];
		$statement->execute($parameters);
	}
	/**
	 * deletes this question from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// create query template
		$query = "DELETE FROM question WHERE questionId = :questionId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["questionId" => $this->questionId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates this question in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// create query template
		$query = "UPDATE question SET questionProfileId = :questionProfileId, questionContent = :questionContent, questionDate = :questionDate WHERE questionId = :questionId";
		$statement = $pdo->prepare($query);
		$formattedDate = $this->questionDate->format("Y-m-d H:i:s.u");
		$parameters = ["questionId" => $this->questionId->getBytes(),"questionProfileId" => $this->questionProfileId->getBytes(), "questionContent" => $this->questionContent, "questionDate" => $formattedDate];
		$statement->execute($parameters);
	}
	/**
	 * gets the Question by questionId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string|Uuid $questionId question id to search for
	 * @return Question|null Question found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getQuestionByQuestionId(\PDO $pdo, $questionId) : ?Question {
		// sanitize the questionId before searching
		try {
			$questionId = self::validateUuid($questionId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT questionId, questionProfileId, questionContent, questionDate FROM question WHERE questionId = :questionId";
		$statement = $pdo->prepare($query);
		// bind the question id to the place holder in the template
		$parameters = ["questionId" => $questionId->getBytes()];
		$statement->execute($parameters);
		// grab the question from mySQL
		try {
			$question = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$question = new Question($row["questionId"], $row["questionProfileId"], $row["questionContent"], $row["questionDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($question);
	}
	/**
	 * gets the Question by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $questionProfileId profile id to search by
	 * @return \SplFixedArray SplFixedArray of Questions found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getQuestionByQuestionProfileId(\PDO $pdo, string  $questionProfileId) : \SPLFixedArray {
		try {
			$questionProfileId = self::validateUuid($questionProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT questionId, questionProfileId, questionContent, questionDate FROM question WHERE questionProfileId = :questionProfileId";
		$statement = $pdo->prepare($query);
		// bind the question profile id to the place holder in the template
		$parameters = ["questionProfileId" => $questionProfileId->getBytes()];
		$statement->execute($parameters);
		// build an array of questions
		$questions = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$question = new Question($row["questionId"], $row["questionProfileId"], $row["questionContent"], $row["questionDate"]);
				$questions[$questions->key()] = $question;
				$questions->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($questions);
	}
	/**
	 * gets the Question by content
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $questionContent question content to search for
	 * @return \SplFixedArray SplFixedArray of Questions found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getQuestionByQuestionContent(\PDO $pdo, string $questionContent) : \SPLFixedArray {
		// sanitize the description before searching
		$questionContent = trim($questionContent);
		$questionContent = filter_var($questionContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($questionContent) === true) {
			throw(new \PDOException("question content is invalid"));
		}
		// escape any mySQL wild cards
		$questionContent = str_replace("_", "\\_", str_replace("%", "\\%", $questionContent));
		// create query template
		$query = "SELECT questionId, questionProfileId, questionContent, questionDate FROM question WHERE questionContent LIKE :questionContent";
		$statement = $pdo->prepare($query);
		// bind the question content to the place holder in the template
		$questionContent = "%$questionContent%";
		$parameters = ["questionContent" => $questionContent];
		$statement->execute($parameters);
		// build an array of questions
		$questions = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$question = new Question($row["questionId"], $row["questionProfileId"], $row["questionContent"], $row["questionDate"]);
				$questions[$questions->key()] = $question;
				$questions->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($questions);
	}
	/**
	 * gets all Questions
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Questions found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllQuestions(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT questionId, questionProfileId, questionContent, questionDate FROM question";
		$statement = $pdo->prepare($query);
		$statement->execute();
		// build an array of questions
		$questions = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$question = new Question($row["questionId"], $row["questionProfileId"], $row["questionContent"], $row["questionDate"]);
				$questions[$questions->key()] = $question;
				$questions->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($questions);
	}
}
