-- The statement below sets the collation of the database to utf8
ALTER DATABASE cryan17 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- This will drop any currently existing tables --
DROP TABLE IF EXISTS answer;
DROP TABLE IF EXISTS question;
DROP TABLE IF EXISTS profile;

