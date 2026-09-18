USE smart_travel_local_explorer;
INSERT INTO users (name,email,password,role) VALUES ('Local Explorer Demo','explorer@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC4Xr3m4W3a0Z5q6h2y', 'Local Explorer');
SET @uid = LAST_INSERT_ID();
INSERT INTO local_explorer (user_id,location,bio) VALUES (@uid,'Dhaka, Bangladesh','Local travel enthusiast.');
SET @eid = LAST_INSERT_ID();
INSERT INTO question_response (explorer_id,traveler_id,question,response) VALUES (@eid,1,'What is a good hidden place to visit?','Try the quieter local spots and check the visiting guidelines first.');
INSERT INTO explorer_feedback (explorer_id,traveler_id,rating,comment) VALUES (@eid,1,5,'Very helpful local information.');
