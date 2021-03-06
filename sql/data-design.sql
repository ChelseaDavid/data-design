-- The statement below sets the collation of the database to utf8
ALTER DATABASE cryan17 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- This will drop any currently existing tables --
DROP TABLE IF EXISTS answer;
DROP TABLE IF EXISTS question;
DROP TABLE IF EXISTS profile;

-- Creates profile table--
CREATE TABLE profile (
	-- this creates the attribute for the primary key
	-- not null means the attribute is required!
	profileId BINARY(16) NOT NULL,
	-- to make something optional, exclude the not null
	profileLocation CHAR(32),
	profileNickname VARCHAR(32) NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	-- to make sure duplicate data cannot exist, create a unique index
	UNIQUE(profileEmail),
	-- this officiates the primary key for the entity
	PRIMARY KEY (profileId)
);

-- creates the question entity
CREATE TABLE question (
	-- this is for yet another primary key...
	questionId BINARY(16) NOT NULL,
	-- this is for a foreign key
	questionProfileId BINARY(16) NOT NULL,
	questionContent VARCHAR(255) NOT NULL,
	questionDate DATETIME(6) NOT NULL,
	-- this creates an index before making a foreign key
	INDEX(questionProfileId),
	-- this creates the actual foreign key relation
	FOREIGN KEY(questionProfileId) REFERENCES profile(profileId),
	-- and finally create the primary key
	PRIMARY KEY(questionId)
);

-- create the like entity (a weak entity from an m-to-n for profile --> tweet)
CREATE TABLE answer (
	-- these are still foreign keys
	answerProfileId BINARY(16) NOT NULL,
	answerQuestionId BINARY(16) NOT NULL,
	answerContent VARCHAR(500) NOT NULL,
	answerDate DATETIME(6) NOT NULL,
	-- index the foreign keys
	INDEX(answerProfileId),
	INDEX(answerQuestionId),
	-- create the foreign key relations
	FOREIGN KEY(answerProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(answerQuestionId) REFERENCES question(questionId),
	-- finally, create a composite foreign key with the two foreign keys
	PRIMARY KEY(answerProfileId, answerQuestionId)
);

