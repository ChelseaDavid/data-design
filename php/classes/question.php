<?php
class Question {
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
		 * @throws \RangeException if $newProfileId is not positive
		 * @throws \TypeError if @newQuestionProfileId is not an Uuid
		 **/
      public function setQuestionProfileId( $newQuestionProfileId) : void {
      try {
      	$uuid = self :: validateUuid($newQuestionProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
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
	 * @return DateTime
	 */
	public function getQuestionDate(): DateTime {
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
		// store the like date using the ValidateDate trait
		try {
			$newQuestionDate = self::validateDateTime($newQuestionDate);
		} catch(\InvalidArgumentException|\RangeException $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(),0, $exception));
		}
		$this->questionDate = $newQuestionDate;
		}
}
