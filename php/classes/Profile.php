<?php

/**
 * Small Cross Section of a GameStop profile
 *
 * This profile can be considered a small example of what services like GameStop store when profiles are used in GameStop. This can easily be extended to emulate more feature of GameStop.
 *
 * @author Chelsea David <cryan17@cnm.edu
 * @version 1
 **/
class Profile {
	/**
	 * id for this profile; this is the primary key
	 * @var Uuid $profileId
	 **/
	private $profileId;
	/** location of the profile that left this question
	 * @var string $profileLocation
	 **/
	private $profileLocation;
	/** Nickname of this profile/user
	 * @var string $profileNickname
	 **/
	private $profileNickname;
	/**
	 * Email linked to this profile,
	 * @var string $profileEmail
	 **/
	private $profileEmail;

	/**
	 * @param Uuid $newProfileId
	 * @param $newProfileLocation
	 * @param $newProfileNickname
	 * @param $newProfileEmail
	 * @throws  InvalidArgumentException
	 * @throws RangeException
	 * @throws Exception
	 * @throws TypeError
	 **/

	public function __construct(string $newProfileId,string $newProfileLocation, string $newProfileNickname,string $newProfileEmail) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileLocation($newProfileLocation);
			$this->setProfileNickname($newProfileNickname);
			$this->setProfileEmail($newProfileEmail);

		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception)) ;
		}
	}
	/** accessor method for profile id
	 *
	 * @return Uuid value of profile id
	 *
	 **/
	public function getProfileId() : Uuid {
		return($this->profileId);
	}
	/**
	 * mutator method for profile id
	 *
	 * @param Uuid/string $newProfileId new value of profile id
	 * @throws \RangeExeption if $newProfileId is n
	 * @throws \TypeError if $newProfileId is not a uuid
	 **/
	public function setProfileId( $newProfileId) : void {
		try {
			$uuid = self ::validateUuid($newProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->profileId = $uuid;
	}

	/**
	 * accessor method for profile location
	 *
	 * @return string value of profile location
	 **/
	public function getProfileLoacation() : string {
		return($this->profileLocation);
	}
	/**
	 * mutator method for profile location
	 *
	 * @param string | string $newProfileLocation new value of profile location
	 * @throws \ InvalidArgumentException if $newProfileLocation is not a string or insecure
	 * @throws \TypeError if @newProfileLocation is not an string
	 **/
	public function setProfileLocation( $newProfileLocation) : void {
		try {
			$string = self::validateString($newProfileLocation);
		} catch(\InvalidArgumentException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(),0,$exception));
		}
		// convert and store the profile id
		$this-> profileLocation = $string;
	}
	/** accessor method for profile nickname
	 *
	return string value of profile nickname
	 **/
	public function getProfileNickname() : string {
		return($this->profileNickname);
	}
	/** mutator method for profile nickname

	 * @param string $newProfileNickname new value of profile nickname
	 * @throws \ InvalidArgumentException if $newProfileNickname is not a string or insecure
	 * @throws \RangeException if $newProfileNickname is > 32 characters
	 * @throws \TypeError if $newProfileNickname is not a string
	 **/
	public function setProfileNickname(string $newProfileNickname) : void {
		//verify the question content is secure
		$newProfileNickname = trim($newProfileNickname);
		$newProfileNickname = filter_var($newProfileNickname, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileNickname) === true) {
			throw(new \InvalidArgumentException("Profile Nickname is empty or insecure"));
		}
		//verify the profile nickname will fit in the database
		if(strlen($newProfileNickname) > 32) {
			throw(new \RangeException("Nickname is too large"));
		}
		//store the question content
		$this->profileNickname = $newProfileNickname;
	}
	/** accessor method for profile email
	 * @return string value of profile email
	 * **/
	/**
	 * @return string
	 */
	public function getProfileEmail(): string {
		return $this->profileEmail;
	}
	/** mutator method for profile email

	 * @param string $newProfileEmail new value of profile email
	 * @throws \ InvalidArgumentException if $newProfileEmail is not a string or insecure
	 * @throws \RangeException if $newProfileEmail is > 120 characters
	 * @throws \TypeError if $newProfileEmail is not a string
	 **/
	public function setProfileEmail(string $newProfileEmail) : void {
		//verify the profile email is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("Profile Email is empty or insecure"));
		}
		//verify the profile email will fit in the database
		if(strlen($newProfileEmail) > 120) {
			throw(new \RangeException("Email is too large"));
		}
		//store the profile email
		$this->profileNickname = $newProfileEmail;
	}
	/**
	 * inserts this Profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// create query template
		$query = "INSERT INTO profile(profileId, profileLocation, profileNickname, profileEmail) VALUES(:profileId, :profileLocation, :profileNickname, :profileEmail)";
		$statement = $pdo->prepare($query);
		$parameters = ["profileId" => $this->profileId->getBytes(), "profileLocation" => $this->profileLocation->getBytes(), "profileNickname" => $this->profileNickname, "profileEmail" => $this->profileEmail];
		$statement->execute($parameters);
	}
	/*
	 * deletes this profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// create query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["profileId" => $this->profileId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates this profile in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// create query template
		$query = "UPDATE profile SET profileLocation = :profileLocation, profileNickname = :profileNickname, profileEmail = :profileEmail WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		$parameters = ["profileId" => $this->profileId->getBytes(),"profileLocation" => $this->profileLocation->getBytes(), "profileNickname" => $this->profileNickname, "profileEmail" => $this->profileEmail];
		$statement->execute($parameters);
	}
	/**
	 * gets the Profile by profileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string|Uuid $profileId question id to search for
	 * @return Profile|null Profile found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getProfileByProfileId(\PDO $pdo, $profileId) : ?Profile {
		// sanitize the profileId before searching
		try {
			$profileId = self::validateUuid($profileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT profileId, profileLocation, profileNickname, profileEmail FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		// bind the profile id to the place holder in the template
		$parameters = ["profileId" => $profileId->getBytes()];
		$statement->execute($parameters);
		// grab the profile from mySQL
		try {
			$question = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileLocation"], $row["profileNickname"], $row["profileEmail"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}
	/**
	 * gets the Profile by location
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileLocation location to search by
	 * @return \SplFixedArray SplFixedArray of Profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileLocation(\PDO $pdo, string  $profileLocation) : \SPLFixedArray {
		try {
			$profileLocation = self::validateString($profileLocation);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT profileId, profileLocation, profileNickname, profileEmail FROM profile WHERE profileLocation = :profileLocation";
		$statement = $pdo->prepare($query);
		// bind the profile location to the place holder in the template
		$parameters = ["profileLocation" => $profileLocation->getBytes()];
		$statement->execute($parameters);
		// build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileLocation"], $row["profileNickname"], $row["profileEmail"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($profiles);
	}
	/**
	 * gets the Profile by nickname
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileNickname profile nickname to search for
	 * @return \SplFixedArray SplFixedArray of Profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileNickname(\PDO $pdo, string $profileNickname) : \SPLFixedArray {
		// sanitize the description before searching
		$profileNickname = trim($profileNickname);
		$profileNickname = filter_var($profileNickname, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileNickname) === true) {
			throw(new \PDOException("Nickname is invalid"));
		}
		// escape any mySQL wild cards
		$profileNickname = str_replace("_", "\\_", str_replace("%", "\\%", $profileNickname));
		// create query template
		$query = "SELECT profileId, profileLocation, profileNickname, profileEmail FROM profile WHERE profile.profileNickname LIKE :profileNickname";
		$statement = $pdo->prepare($query);
		// bind the question nickname to the place holder in the template
		$questionContent = "%$profileNickname%";
		$parameters = ["profileNickname" => $profileNickname];
		$statement->execute($parameters);
		// build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileLocation"], $row["profileNickname"], $row["profileEmail"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($profiles);
	}
	/**
	 * gets all Profiles
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Profiles found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllProfiles(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT profileId, profileLocation, profileNickname, profileEmail FROM profile";
		$statement = $pdo->prepare($query);
		$statement->execute();
		// build an array of questions
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileLocation"], $row["profileNickname"], $row["profileEmail"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}
}
