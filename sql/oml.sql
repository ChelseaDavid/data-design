-- INSERT Statements
-- /sql/oml.sql is where this file should be created for data-design

-- hexadecimal explanation: https://www.mathisfun.com/hexadecimals.html
-- UUID generator: https://www.uuidgenorator.net/version4
-- hexadecimal generator https://www.browserling.com/tools/random-hex

 -- INSERT INTO profile(profileId, profileLocation, profileNickname, profileEmail)
-- VALUES (UNHEX("8c623648651a480e9efa01e735c1db0b"),"Sacremento","MDav","malwayzwrong5486@gmail.com");

-- INSERT INTO question(questionId, questionProfileId, questionContent, questionDate)
-- VALUES (UNHEX("c3c082933cdf4263b9d046c2a77c839e"),UNHEX("8c623648651a480e9efa01e735c1db0b"),"MDAV is seldom right","2018-07-22 11:23:45.123");

-- UPDATE profile SET profileNickname = "wo3636" WHERE profileNickname = "MDav";
-- UPDATE question SET questionContent = "Will Mdav ever stop making trouble for other people?" WHERE questionDate = "2018-07-22 11:23:45.123";
-- UPDATE profile SET profileEmail = "justkeepswimming33636@gmail.com" WHERE profileEmail = "malwayzwrong5486@gmail.com";

-- INSERT INTO profile(profileId, profileLocation, profileNickname, profileEmail) VALUES (UNHEX("ddfaf5e28381416c93d558ef3adf18d3"),"Miami","Mblame","willIeverberight963@yahoo.com");
-- INSERT INTO question(questionId, questionProfileId, questionContent, questionDate) VALUES (UNHEX("314e0311d2954bd0b03bc26ec5d58896"),UNHEX("ddfaf5e28381416c93d558ef3adf18d3"),"Has Matt D ever not been to blame?", "2018-03-22 03:22:45.123");

-- UPDATE profile SET profileLocation = "New York" WHERE profileId = "ddfaf5e28381416c93d558ef3adf18d3";
-- DELETE FROM profile WHERE profileId = UNHEX("ddfaf5e28381416c93d558ef3adf18d3");

-- SELECT questionContent, questionDate FROM question WHERE questionDate="2018-03-22 03:22:45.123";

UPDATE question SET questionContent = "How many times has MDav been to blame?" WHERE questionContent = "Has Matt D ever not been to blame?";