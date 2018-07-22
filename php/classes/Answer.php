<?php


/**
 * Small Cross Section of a GameStop answer
 *this answer can be considered a small example of what services like GameStop store when reply's are sent
 * using GameStop. This can easily be extended to emulate more feature of GameStop.
 *
 * @author Chelsea David <cryan17@cnm.edu>
 * @version 1.0
 **/
class Answer {

	/**
	 * id for the profile that is answering; this is the foreign key
	 * @var Uuid $answerProfileId
	 **/
	private $answerProfileId;
	/**
	 * id for the question to be answered; this is the foreign key
	 * @var Uuid $answerQuestionId
	 **/
	private $answerQuestionId;
	/**
	 * actual textual content of the answer/reply
	 * @var string $answerContent
	 **/
	private $answerContent;

	/**
	 * date and time this Answer was sent, in a PHP DateTime object
	 * @var \DateTime $AnswerDate
	 **/
	private $answerDate;

	/**
	 * @param $newAnswerProfileId
	 * @param $newAnswerQuestionId
	 * @param $newAnswerContent
	 * @param $newAnswerDate
	 * @catch InvalidArgumentException | RangeException | Exception | TypeError
	 * @throws Exception
	 **/

	public function __construct(string $newAnswerProfileId, string $newAnswerQuestionId, string $newAnswerContent, DateTime $newAnswerDate) {
		try {
			$this->setAnswerProfileId($newAnswerProfileId);
			$this->setAnswerQuestionId($newAnswerQuestionId);
			$this->setAnswerContent($newAnswerContent);
			$this->setAnswerDate($newAnswerDate);

		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for answer profile id
	 *
	 * @return Uuid value of answer profile id
	 **/
	public function getAnswerProfileId(): Uuid {
		return ($this->answerProfileId);
	}

	/**
	 * mutator method for answer profile id
	 *
	 * @param string | Uuid $newAnswerProfileId new value of answer profile id
	 * @throws \RangeException if $newAnswerProfileId is not positive
	 * @throws \TypeError if $newAnswerProfileId is not an UUI
	 **/
	public function setAnswerProfileId($newAnswerProfileId): void {
		try {
			$uuid = self::validateUuid($newAnswerProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the profile id
		$this->answerProfileId = $uuid;
	}

	/**
	 * accessor method for answer question id
	 *
	 * @return Uuid value of answer question id
	 **/
	public function getAnswerQuestionId(): Uuid {
		return ($this->answerQuestionId);
	}

	/**
	 * mutator method for answer question id
	 *
	 * @param string | Uuid $newAnswerQuestionId new value of answer question id
	 * @throws \RangeException if $newAnswerQuestionId is not positive
	 * @throws \TypeError if $newAnswerQuestionId is not an UUI
	 **/
	public function setAnswerQuestionId($newAnswerQuestionId): void {
		try {
			$uuid = self::validateUuid($newAnswerQuestionId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the answer question id
		$this->answerQuestionId = $uuid;
	}

	/**
	 * accessor method for answer content
	 *
	 * @return string value of answer content
	 **/
	public function getAnswerContent(): string {
		return ($this->AnswerContent);
	}

	/**
	 * mutator method for answer content
	 *
	 * @param string $newAnswerContent new value of answer content
	 * @throws \InvalidArgumentException if $newAnswerContent is not a string or insecure
	 * @throws \RangeException if $newAnswerContent is > 500 characters
	 * @throws \TypeError if $newAnswerContent is not a string
	 **/
	public function setAnswerContent(string $newAnswerContent): void {
		// verify the answer content is secure
		$newAnswerContent = trim($newAnswerContent);
		$newAnswerContent = filter_var($newAnswerContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAnswerContent) === true) {
			throw(new \InvalidArgumentException("Answer content is empty or insecure"));
		}

		// verify the answer content will fit in the database
		if(strlen($newAnswerContent) > 500) {
			throw(new \RangeException("Answer content exceeds the max number of characters allowed. Please try again."));
		}

		// store the answer content
		$this->answerContent = $newAnswerContent;
	}

	/**
	 * accessor method for answer date
	 *
	 * @return \DateTime value of answer date
	 **/
	public function getAnswerDate(): \DateTime {
		return ($this->answerDate);
	}

	/**
	 * mutator method for answer date
	 *
	 * @param \DateTime|string|null $newAnswerDate answer date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newAnswerDate is not a valid object or string
	 * @throws \RangeException if $newAnswerDate is a date that does not exist
	 **/
	public function setAnswerDate($newAnswerDate = null): void {
		// base case: if the date is null, use the current date and time
		if($newAnswerDate === null) {
			$this->answerDate = new \DateTime();
			return;
		}


		$this->answerDate = $newAnswerDate;
	}

}