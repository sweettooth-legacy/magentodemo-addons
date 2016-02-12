<?php

/**
 * Automation Generator Helper - Generate random data
 *
 * @category   ST
 * @package    ST_Automation
 * @author     Sweet Tooth Inc. <support@sweettoothrewards.com>
 */
class ST_Automation_Helper_Generator extends Mage_Core_Helper_Abstract
{
    /**
     * Generate a random first name
     * @return string
     */
    public function generateFirstname()
    {
        $firstnames = array('Rose', 'Annie', 'Margaret', 'Larry', 'Sean', 'Juan', 'Ann', 'Stephanie', 'Lisa', 'Billy', 'Anthony', 'Denise', 'Shawn', 'Ruby', 'Ruth', 'Lois', 'Jesse', 'Chris', 'Rachel', 'Louis', 'Nicholas', 'Maria', 'Dorothy', 'Mildred', 'Joshua', 'Christopher', 'Howard', 'Albert', 'Michelle', 'Wanda', 'Richard', 'Heather', 'Kenneth', 'Catherine', 'Jacqueline', 'Gary', 'Antonio', 'Jimmy', 'Jason', 'Steven', 'John', 'Diane', 'Jeremy', 'Donna', 'Christina', 'Diana', 'Alice', 'Eugene', 'Bruce', 'Janet', 'Katherine', 'Russell', 'Patricia', 'Jose', 'Kathy', 'Scott', 'Rebecca', 'Justin', 'Judith', 'Adam', 'Steve', 'Phillip', 'Douglas', 'Sandra', 'Judy', 'Brian', 'Eric', 'Deborah', 'Shirley', 'Irene', 'Pamela', 'Paul', 'Kathleen', 'Alan', 'Susan', 'Frances', 'Aaron', 'Earl', 'Lawrence', 'Joyce', 'Jennifer', 'Walter', 'Melissa', 'Brandon', 'Ashley', 'Kimberly', 'Patrick', 'Louise', 'Lori', 'Stephen', 'Amanda', 'Samuel', 'Julie', 'Anne', 'Martin', 'Sara', 'Angela', 'Theresa', 'Sarah', 'Henry', 'Joseph', 'Brenda', 'Carl', 'Evelyn', 'Timothy', 'Philip', 'Marilyn', 'Virginia', 'Bobby', 'Carol', 'Jane', 'Carolyn', 'Roy', 'Carlos', 'Gregory', 'Tina', 'Tammy', 'Lillian', 'Randy', 'Benjamin', 'Michael', 'Todd', 'Gerald', 'Christine', 'Ernest', 'Jerry', 'Jack', 'Terry', 'Julia', 'Kelly', 'Cynthia', 'Janice', 'William', 'Amy', 'Emily', 'Ryan', 'Matthew', 'George', 'Nicole', 'Charles', 'Arthur', 'Betty', 'Craig', 'Mary', 'Joan', 'Nancy', 'Karen', 'Andrew', 'Robin', 'Marie', 'Sharon', 'Bonnie', 'Dennis', 'Phyllis', 'Jessica', 'Linda', 'Roger', 'Jean', 'Paula', 'Frank', 'Jeffrey', 'Fred', 'Keith', 'Martha', 'Beverly', 'Ralph', 'Anna', 'Willie', 'Johnny', 'Peter', 'Joe', 'Cheryl', 'Thomas', 'Harry', 'Barbara', 'Edward', 'Clarence', 'Debra', 'Andrea', 'Victor', 'David', 'Kathryn', 'Daniel', 'Mark', 'Helen', 'Norma', 'Donald', 'Gloria', 'Robert', 'Raymond', 'Wayne', 'Laura', 'Doris', 'James', 'Kevin', 'Ronald', 'Harold', 'Jonathan', 'Teresa', 'Elizabeth', 'Nadine', 'Ali', 'Nasim', 'Channing', 'Hannah', 'Fallon', 'Tatum', 'Drew', 'Sloane', 'Aristotle', 'Riley', 'Yeo', 'Priscilla', 'Jenette', 'Miriam', 'Hedley', 'Katelyn', 'Quemby', 'Amelia', 'Kaseem', 'Azalia', 'Conan', 'Colton', 'Eliana', 'Chelsea', 'Kasper', 'Suki', 'Charissa', 'Benedict', 'Melvin', 'Noelle', 'Zachery', 'Melinda', 'Owen', 'Ivana', 'Jeanette', 'Demetria', 'Graham', 'Rosalyn', 'Yuri', 'Kessie', 'Cameron', 'Hanna', 'Rinah', 'Hermione', 'Ignatius', 'Nina', 'Thaddeus', 'Orlando', 'Macaulay', 'Raya', 'Sopoline', 'Theodore', 'Adria', 'Tallulah', 'Stella', 'Allistair', 'Isabella', 'Joy', 'Kasimir', 'Abdul', 'Moana', 'Kelsey', 'Ira', 'Calista', 'Sacha', 'Edan', 'Blythe', 'Bryar', 'Ocean', 'Quentin', 'Chloe', 'Wallace', 'Beck', 'Cally', 'Fatima', 'Rahim', 'Clio', 'Haley', 'Kalia', 'Daquan', 'Neve', 'Briar', 'Ignacia', 'Iona', 'Marvin', 'Jolie', 'Dolan', 'Eden', 'Wade', 'Raphael', 'Naida', 'Isaac', 'Luke', 'Jayme', 'Noah', 'Mason', 'Orli', 'Ashton', 'Abel', 'Shad', 'Madeline', 'Derek', 'Faith', 'Lani', 'Cooper', 'Daria', 'Pandora', 'Harrison', 'Vaughan', 'Armand', 'Jermaine', 'Aquila', 'Kyla', 'Hyatt', 'Ila', 'Magee', 'Hilary', 'Erich', 'Curran', 'Hadassah', 'Bruno', 'Buffy', 'McKenzie', 'Leilani', 'Georgia', 'Zeph', 'Zena', 'Jada', 'Regan', 'Dieter', 'Leandra', 'Shelley', 'Indigo', 'Taylor', 'Imelda', 'Carter', 'Willow', 'Seth', 'Brett', 'Lee', 'Noelani', 'Cathleen', 'Lareina', 'Moses', 'Quail', 'Malachi', 'Allegra', 'Lester', 'Finn', 'Kennedy', 'Hedwig', 'Keegan', 'MacKenzie', 'Naomi', 'Bertha', 'Cassady', 'Yen', 'Malik', 'Lane', 'Ferdinand', 'Orla', 'Ahmed', 'Hall', 'Nyssa', 'Keely', 'Rhonda', 'Fritz', 'Kadeem', 'Shelly', 'Sawyer', 'Declan', 'Thor', 'Rhona', 'Kirby', 'Yoshi', 'Nash', 'Kato', 'Colorado', 'Oliver', 'Keelie', 'India', 'Blake', 'Holmes', 'Joelle', 'Olga', 'Ulla', 'Madison', 'TaShya', 'Irma', 'Nathaniel', 'Boris', 'Shana', 'Alyssa', 'Donovan', 'Chancellor', 'Ivor', 'Eleanor', 'Echo', 'Aurelia', 'August', 'Deacon', 'Piper', 'Emery', 'Maia', 'Urielle', 'Veronica', 'Lillith', 'Griffith', 'Shelby', 'Blaine', 'Yolanda', 'Leigh', 'Madeson', 'Lenore', 'Vera', 'Kuame', 'Nora', 'Knox', 'Murphy', 'Flavia', 'Renee', 'Ivan', 'Roanna', 'Darius', 'Byron', 'Blair', 'Vincent', 'Chase', 'Clinton', 'Perry', 'Celeste', 'Baxter', 'Maile', 'Burke', 'Hunter', 'Acton', 'Jena', 'Ferris', 'Kylynn', 'Eaton', 'Desirae', 'Kim', 'Martena', 'Maryam', 'Hiram', 'Macy', 'Fredericka', 'Justina', 'Ezra', 'Eugenia', 'Grady', 'Sydney', 'Burton', 'Isadora', 'Ainsley', 'Illana', 'Hope', 'Tatyana', 'Rae', 'Sierra', 'Sage', 'April', 'Stone', 'Dante', 'Emerald', 'Felix', 'Nevada', 'Adele', 'Josiah', 'Keiko', 'Shaine', 'Leo', 'Camille', 'Natalie', 'Aretha', 'Karyn', 'Brenna', 'Deanna', 'Lacota', 'Nero', 'Rebekah', 'Reuben', 'Garrett', 'Hayden', 'Audra', 'Brynn', 'Pascale', 'Ina', 'Beatrice', 'Cadman', 'Vanna', 'Kieran', 'Wylie', 'Tad', 'Kaye', 'Megan', 'Adrienne', 'Cherokee', 'Marcia', 'Gemma', 'Victoria', 'Lucius', 'Kane', 'Kenyon', 'Yetta', 'Caleb', 'Wesley', 'Erin', 'Brynne', 'Illiana', 'Rhiannon', 'Tasha', 'Talon', 'Florence', 'Minerva', 'Cameran', 'Maite', 'Kermit', 'Aidan', 'Xavier', 'Cailin', 'Barry', 'Chaim', 'Melanie', 'Zachary', 'Cassidy', 'Willa', 'Amela', 'Geraldine', 'Lael', 'Tana', 'Walker', 'Lamar', 'Indira', 'Axel', 'Cain', 'Wynne', 'Maya', 'Hu', 'Danielle', 'Kareem', 'Claire', 'Basil', 'Igor', 'Alexa', 'Wing', 'Bree', 'Adena', 'Nolan', 'Laith', 'Lev', 'Fuller', 'Rudyard', 'Rooney', 'Noble', 'Summer', 'Yvonne', 'Lucas', 'Ori', 'Chava', 'Tanya', 'Elaine', 'Simone', 'Preston', 'Lunea', 'Brielle', 'Elvis', 'Linus', 'Desiree', 'Levi', 'Lisandra', 'Clare', 'Cassandra', 'Leonard', 'Avram', 'Svetlana', 'Bill', 'Beatrix', 'Magy', 'Flynn', 'Anabelle', 'Lucy', 'Duncan', 'Jana', 'Akeem', 'Brody', 'Harriet', 'Lance', 'May', 'Barrett', 'Judah', 'Cara', 'Myra', 'Rina', 'Myles', 'Iliana', 'Candace', 'Dominic', 'Karleigh', 'Bernard', 'Marshall', 'Zoe', 'Jaden', 'Solomon', 'Tate', 'Athena', 'Travis', 'Miranda', 'Noel', 'Arsenio', 'Ryder', 'Dean', 'Ifeoma', 'Molly', 'Hoyt', 'Bert', 'Octavius', 'Quinn', 'Drake', 'Amery', 'Marsden', 'Portia', 'Castor', 'Whitney', 'Romeo', 'Mohsen', 'Alex', 'Roel', 'Lynn', 'Daisy', 'Walt', 'Max', 'Mike', 'Kopila', 'Shane', 'Dave', 'Jasmine', 'Lavinia', 'Davis', 'Rajah', 'Baker', 'Charde', 'Halla', 'Keane', 'Darryl', 'Courtney', 'Nelle', 'Evangeline', 'Quon', 'Logan', 'Clark', 'Brady', 'Phoebe', 'Berk', 'Venus', 'Bell', 'Hashim', 'Norman', 'Erasmus', 'Abigail', 'Coby', 'Elliott', 'Ciara', 'Ariel', 'Alvin', 'Harlan', 'Jillian', 'Skyler', 'Giselle', 'Merrill', 'Nathan', 'Jael', 'Randall', 'Dana', 'Ishmael', 'Colby', 'Colin', 'Mechelle', 'Kyle', 'Felicia', 'Xander', 'Hanae', 'Amos', 'Inez', 'Alfreda', 'Yasir', 'Gillian', 'Jenna', 'Uta', 'Alexandra', 'Audrey', 'Bevis', 'Carissa', 'Tamekah', 'Tobias', 'Bradley', 'Daryl', 'Jamal', 'Whoopi', 'Aurora', 'Malcolm', 'Herrod', 'Fletcher', 'Britanney', 'Whilemina', 'Jessamine', 'Zephania', 'Merritt', 'Ivory', 'Ginger', 'Germaine', 'Nola', 'Rowan', 'Leah', 'Xanthus', 'Stacey', 'Lara', 'Xyla', 'Serina', 'Gail', 'Ima', 'Harding', 'Uriel', 'Samson', 'Dalton', 'Adrian', 'Elton', 'Jarrod', 'Vernon', 'Althea', 'Tarik', 'Silas', 'Blossom', 'Marah', 'Francesca', 'Kiona', 'Kitra', 'Meredith', 'Calvin', 'Jacob', 'Chastity', 'Connor', 'Ivy', 'Grace', 'Demetrius', 'Martina', 'Zia', 'Kameko', 'Jade', 'Alec', 'Bianca', 'Liberty', 'Oprah', 'Jin', 'Hayley', 'Quintessa', 'Nichole', 'Colt', 'Delilah', 'Jamalia', 'Guy', 'Nell', 'Porter', 'Ray', 'Ramona', 'Cleo', 'Manuella', 'Madalina', 'Georgiana', 'Selma', 'Magdalena', 'Jazabella', 'Hadley', 'Fay', 'Maisie', 'Kibo', 'Galena', 'Kellie', 'Farrah', 'Hakeem', 'Winifred', 'Ross', 'Guinevere', 'Amaya', 'Rafael', 'Amity', 'Mohammad', 'Xantha', 'Addison', 'Xandra', 'Erica', 'Aphrodite', 'Zephr', 'Quin', 'Grant', 'Francis', 'Hilda', 'Jakeem', 'Alea', 'Dustin');
        return $firstnames[array_rand($firstnames)];
    }
    
    /**
     * Generate a random last name
     * @return string
     */
    public function generateLastname()
    {
        $lastnames = array('Frost', 'Bernard', 'Haley', 'Le', 'Stinson', 'Albert', 'Rodriquez', 'Harrison', 'Riley', 'Beard', 'Bates', 'Franklin', 'Munoz', 'Cunningham', 'Bray', 'Tanner', 'Clark', 'Key', 'Simon', 'Vincent', 'Weaver', 'Rivers', 'Carrillo', 'Bender', 'Horne', 'Wolf', 'Brady', 'Todd', 'Wheeler', 'Maxwell', 'Bean', 'Hines', 'Gray', 'Petersen', 'Mckay', 'Estrada', 'Cole', 'Cook', 'Boyer', 'Adkins', 'Palmer', 'Reese', 'Collier', 'Dorsey', 'Rivas', 'Gordon', 'Swanson', 'Humphrey', 'Foster', 'Holden', 'Curtis', 'Montgomery', 'Hull', 'Wise', 'Bridges', 'Crane', 'Drake', 'Franco', 'Mcpherson', 'Bryan', 'Schneider', 'Berger', 'Torres', 'Cohen', 'Beasley', 'Sparks', 'Blankenship', 'Perez', 'Steele', 'Gross', 'Potter', 'Weeks', 'Romero', 'Terrell', 'Salazar', 'Mayo', 'Prince', 'Hatfield', 'Sheppard', 'Hartman', 'Callahan', 'Castaneda', 'Harrington', 'Padilla', 'Olsen', 'Gates', 'Rowland', 'Hodges', 'Kane', 'Buck', 'Valdez', 'Blackburn', 'Fulton', 'Flynn', 'Crosby', 'Byers', 'Bruce', 'Cline', 'Bonner', 'Finch', 'Mccall', 'Stephens', 'Rice', 'Sanders', 'Olson', 'Fry', 'May', 'Emerson', 'Cummings', 'Erickson', 'Benjamin', 'Kaufman', 'Nichols', 'Gill', 'Eaton', 'Lynch', 'Hudson', 'Hansen', 'Rich', 'Wade', 'Mccormick', 'Morin', 'Burt', 'Davidson', 'Doyle', 'Newman', 'Mitchell', 'Britt', 'Branch', 'Patterson', 'Graves', 'Downs', 'Rollins', 'Hampton', 'Church', 'Walter', 'Page', 'Jarvis', 'Black', 'Pate', 'Fowler', 'Adams', 'Frank', 'Hobbs', 'Glass', 'Serrano', 'Barnes', 'Lester', 'Mcgowan', 'Mccarthy', 'Duran', 'Saunders', 'Velez', 'Harper', 'Mcmillan', 'Workman', 'Yates', 'Macdonald', 'Barron', 'Hubbard', 'Chapman', 'Schwartz', 'Pope', 'Richard', 'Golden', 'Yang', 'Morgan', 'Alexander', 'Simpson', 'Fuller', 'Morrison', 'Marks', 'Barrett', 'Byrd', 'Good', 'Mann', 'Pena', 'Mcintosh', 'Harrell', 'Parker', 'Hardy', 'Huber', 'Stewart', 'Norris', 'Conner', 'Jackson', 'Roberson', 'Alvarez', 'Baldwin', 'Hyde', 'Mcneil', 'Stein', 'Chase', 'Clay', 'Copeland', 'Atkinson', 'Burris', 'Acosta', 'Sandoval', 'Bentley', 'Kelley', 'Haynes', 'Butler', 'Paul', 'Whitehead', 'Ryan', 'Nguyen', 'Conway', 'Hoover', 'Rocha', 'Flowers', 'Maddox', 'Oneil', 'Owens', 'Frederick', 'Nolan', 'Sherman', 'Holmes', 'Gomez', 'Lindsay', 'Bradley', 'Quinn', 'Dalton', 'Moreno', 'Woodward', 'Morse', 'Tyler', 'Guy', 'Bass', 'Richmond', 'Benson', 'Caldwell', 'Levine', 'Joyce', 'Gould', 'Greer', 'Vance', 'Atkins', 'Duncan', 'Rasmussen', 'Allison', 'Bradshaw', 'Kim', 'Shepherd', 'Acevedo', 'Bradford', 'Miller', 'York', 'Madden', 'Little', 'Wiggins', 'Terry', 'Booth', 'Decker', 'Vaughan', 'Figueroa', 'Gonzales', 'Christensen', 'Fitzgerald', 'Baird', 'Langley', 'Finley', 'Cherry', 'Rhodes', 'Cash', 'Reynolds', 'Williamson', 'Pittman', 'Salinas', 'Bryant', 'Watts', 'Clemons', 'Oneal', 'Mcintyre', 'Spence', 'Bond', 'Taylor', 'Ramirez', 'Whitaker', 'Sullivan', 'Rios', 'Lang', 'Dickson', 'Sosa', 'Bell', 'Hebert', 'Lancaster', 'Ford', 'Monroe', 'Henry', 'Casey', 'Hanson', 'Greene', 'Holland', 'William', 'Perkins', 'Payne', 'Obrien', 'Small', 'Skinner', 'Brooks', 'Trujillo', 'Roy', 'Crawford', 'Boone', 'Snow', 'Livingston', 'Koch', 'Gibson', 'Spencer', 'Faulkner', 'Strong', 'Abbott', 'Mcmahon', 'Sims', 'Tucker', 'Rosales', 'Ellis', 'Lowe', 'David', 'Nelson', 'Guerra', 'Travis', 'Hurley', 'Duke', 'Mullins', 'Burton', 'Calderon', 'Chandler', 'Avila', 'Dixon', 'Barker', 'Hurst', 'Gardner', 'Phillips', 'Gilmore', 'Stephenson', 'Floyd', 'Knapp', 'Shields', 'Raymond', 'Russell', 'House', 'Stark', 'Hutchinson', 'Mack', 'Hahn', 'Howe', 'Daugherty', 'England', 'Frye', 'Boyd', 'Sweeney', 'Calhoun', 'Ramos', 'Stanley', 'Mccray', 'Roth', 'Hamilton', 'Garcia', 'Allen', 'Pruitt', 'Martinez', 'Andrews', 'Marquez', 'Soto', 'Joyner', 'Leach', 'Hunter', 'Dudley', 'Hicks', 'Giles', 'Miranda', 'Mays', 'Dejesus', 'Freeman', 'Baxter', 'Owen', 'Ross', 'Montoya', 'Petty', 'Haney', 'Mclaughlin', 'Melendez', 'Nash', 'Burnett', 'Mendez', 'Castillo', 'Dominguez', 'Brewer', 'Fox', 'Frazier', 'Riddle', 'Kelly', 'Sampson', 'Powell', 'Mills', 'Schmidt', 'Snyder', 'Marshall', 'Myers', 'French', 'Newton', 'Robertson', 'Ayers', 'Juarez', 'Harmon', 'Mcleod', 'Roberts', 'Morton', 'Landry', 'Preston', 'Vargas', 'Reeves', 'Webb', 'Fischer', 'Lamb', 'Gallagher', 'Hester', 'Hogan', 'Combs', 'Mcfadden', 'Jensen', 'Barber', 'Boyle', 'Ramsey', 'Mcclain', 'Mendoza', 'Wells', 'Hooper', 'Carney', 'Mason', 'Barton', 'Wiley', 'Parks', 'Glenn', 'Gamble', 'Craig', 'Dennis', 'Walls', 'Cox', 'Powers', 'Moss', 'Matthews', 'West', 'Wall', 'Hinton', 'Mccullough', 'Clarke', 'Ewing', 'Conley', 'Armstrong', 'Mclean', 'Guzman', 'Noel', 'Mcdonald', 'Anderson', 'Woods', 'Hess', 'Chang', 'Malone', 'Alvarado', 'Carver', 'Francis', 'Keller', 'Ward', 'Lawson', 'Johnston', 'Wood', 'Dean', 'Arnold', 'Johnson', 'Price', 'Jordan', 'George', 'Hart', 'Carr', 'Hayes', 'Lee', 'Lawrence', 'Peterson', 'Oliver', 'Campbell', 'Garrett', 'Harris', 'Richardson', 'Gonzalez', 'Kennedy', 'Lopez', 'Wilson', 'Marsh', 'Bowman', 'Ingram', 'Peck', 'Sloan', 'Poole', 'Lara', 'Bowers', 'Odonnell', 'Nieves', 'Chaney', 'Dyer', 'Wynn', 'Higgins', 'Merrill', 'Mosley', 'Parsons', 'Vazquez', 'Randall', 'Farmer', 'Thornton', 'Lloyd', 'Cervantes', 'Sexton', 'Rivera', 'Reed', 'Oconnor', 'Sears', 'Bishop', 'Gregory', 'Lane', 'Richards', 'Mathis', 'Aguirre', 'Compton', 'Webster', 'Alford', 'Carter', 'Mcgee', 'Mckinney', 'Love', 'Curry', 'Burgess', 'Garza', 'Winters', 'Dotson', 'Walton', 'Tillman', 'Morris', 'Hardin', 'Craft', 'Santana', 'Williams', 'Warren', 'Rogers', 'Evans', 'Carpenter', 'Hernandez', 'Thomas', 'Murphy', 'Rose', 'Wright', 'Watkins', 'Peters', 'Baker', 'Welch', 'Perry', 'Washington', 'James', 'Bailey', 'Griffin', 'Jones', 'Gutierrez', 'Stone', 'Ortiz', 'Brown', 'Hall', 'Green', 'Harvey', 'Grant', 'Wallace', 'Walker', 'Thompson', 'Donovan', 'Grimes', 'Navarro', 'Goodwin', 'Franks', 'Wilder', 'Fuentes', 'Blair', 'Robbins', 'Garrison', 'Norton', 'Cooke', 'Mcfarland', 'Cameron', 'Savage', 'Booker', 'Silva', 'Mccoy', 'Whitfield', 'Schultz', 'Meyer', 'Kirkland', 'Collins', 'Ratliff', 'Espinoza', 'Dillard', 'Blanchard', 'Sykes', 'Hensley', 'Jenkins', 'Brennan', 'Nunez', 'Mooney', 'Delgado', 'Barr', 'Ortega', 'Dunn', 'Mcdaniel', 'Pitts', 'Galloway', 'Velasquez', 'Cruz', 'Cross', 'Willis', 'Larson', 'Fisher', 'Carroll', 'Graham', 'Bennett', 'Vasquez', 'Burns', 'Ray', 'White', 'Howard', 'Hughes', 'Sanchez', 'Turner', 'Davis', 'Flores', 'Smith', 'Burke', 'Porter', 'Jacobs', 'Murray', 'Stevens', 'Reyes', 'Hawkins', 'Lewis', 'Fernandez', 'Young', 'King', 'Gilbert', 'Day', 'Martin', 'Ferguson', 'Rodriguez', 'Simmons', 'Medina', 'Cantu', 'Elliott', 'Gillespie', 'Kidd', 'Mercer', 'Walsh', 'Odom', 'Moran', 'Moore', 'Wilkerson', 'Ruiz', 'Weiss', 'Chavez', 'Sanford', 'Solis', 'Mcknight', 'Luna', 'Moses', 'Santiago', 'Russo', 'Villarreal', 'Everett', 'Michael', 'Hendricks', 'Barnett', 'Henson', 'Valentine', 'Gallegos', 'Salas', 'Clements', 'Mcguire', 'Osborne', 'Zimmerman', 'Mejia', 'Kline', 'Mathews', 'Avery', 'Jimenez', 'Kemp', 'Fleming', 'Nixon', 'Davenport', 'Logan', 'Forbes', 'Rosario', 'Barrera', 'Pollard', 'Charles', 'Strickland', 'Mcconnell', 'Hill', 'Knight', 'Hunt', 'Cooper', 'Howell', 'Edwards', 'Diaz', 'Scott', 'Henderson', 'Shaw', 'Fields', 'Austin', 'Coleman', 'Robinson', 'Morales', 'Long', 'Daniels', 'Reid', 'Berry', 'Pierce', 'Watson', 'Wagner', 'Banks');
        return $lastnames[array_rand($lastnames)];
    }
    
    /**
     * Generate a random email address
     * @return string
     */
    public function generateEmail($firstname = null, $lastname = null)
    {
        $extensions = array('com', 'net', 'ca', 'co.uk', 'com.au', 'de');
        $domainPart = array('red', 'green', 'blue', 'orange', 'purple', 'yellow', 'kiwi', 'apple', 'pear', 'grape', 'peach', 'mango', 'acorn');
        $usernames = array('general', 'info', 'hello', 'support');
        
        if (!$firstname) {
            $firstname = $this->generateFirstname();
        }
        
        if (!$lastname) {
            $lastname = $this->generateLastname();
        }
        
        $delimiters = array('','-','.','_');
        $usernames[] = $firstname;
        $usernames[] = $lastname;

        foreach ($delimiters as $delimiter) {
            $usernames[] = $firstname . $delimiter . $lastname;
            $usernames[] = $lastname . $delimiter . $firstname;
        }

        $username = strtolower($usernames[array_rand($usernames)]);
        $domain = $domainPart[array_rand($domainPart)] . strtolower($this->generateLipsumWord());
        $extension = $extensions[array_rand($extensions)];
        
        return "{$username}@{$domain}.{$extension}";
    }
    
    /**
     * Generate a random password (length = 8)
     * @return string
     */
    public function generatePassword()
    {
        return bin2hex(openssl_random_pseudo_bytes(4));
    }

    /**
     * Generate a random phone number (format: 1-xxx-xxx-xxxx)
     * @return string
     */
    public function generatePhoneNumber()
    {
        return '1-' . rand(100, 999) . '-' . rand(100, 999) . '-' . rand(1000, 9999);
    }
    
    /**
     * Generate a random street address. Possible formats are:
     * - P.O. Box xxx, xxxx Random Street
     * - xxx-xxxx Random Ave
     *  
     * @return string
     */
    public function generateStreetAddress()
    {
        $isPOBox = rand(0,1) == 1;
        $streetTypes = array('Street', 'Ave', 'Avenue', 'Boulevard', 'Road', 'Av.', 'St.', 'Blvd.', 'Rd,');
        
        $address = '';
        if ($isPOBox) {
            $address = 'P.O. Box ' . rand(100, 999) . ', '; 
        } else {
            $address = rand(100, 999) . '-';
        }
        
        $address .= rand(1000, 9999) . ' ' . $this->generateLipsumWord() 
            . ' ' . $streetTypes[array_rand($streetTypes)];
        
        return $address;
    }
    
    /**
     * Generate a random city
     * @return string
     */
    public function generateCity()
    {
        $cities = array('Ransart', 'Minneapolis', 'Fairbanks', 'Rezzoaglio', 'Leval-Chaudeville', 'Dro', 'Dumbarton', 'Belgrave', 'Silchar', 'Monte Vidon Corrado', 'Sangli', 'Bassano in Teverina', 'Laken', 'İnegöl', 'Wanneroo', 'San Giovanni la Punta', 'Hastings', 'Episcopia', 'Anzegem', 'Le Havre', 'Modakeke', 'Annapolis County', 'Hisar', 'Providencia', 'Wittenberg', 'Itzehoe', 'Warrington', 'Straubing', 'Puri', 'Cuenca', 'Kettering', 'Ostrowiec Świętokrzyski', 'San Lazzaro di Savena', 'San Pedro de Atacama', 'Bois-de-Villers', 'Rawalpindi', 'Vieux-Genappe', 'Titagarh', 'Thuin', 'Leipzig', 'Rotorua', 'Gold Coast', 'Arnesano', 'Berwick', 'Le Puy-en-Velay', 'Thurso', 'Corswarem', 'Götzis', 'Girifalco', 'Wiener Neustadt', 'Annapolis Royal', 'Cabano', 'Gresham', 'Camrose', 'Nampa', 'MŽlin', 'Colorado Springs', 'Haddington', 'Anzio', 'Lorient', 'Wolfurt', 'Ockelbo', 'La Seyne-sur-Mer', 'Pickering', 'Sandviken', 'De Haan', 'Turnhout', 'Bossire', 'Great Falls', 'Nurdağı', 'Bissegem', 'Inuvik', 'Sambalpur', 'Rijkevorsel', 'Yellowhead County', 'Labro', 'Cáceres', 'Sandy', 'Vauda Canavese', 'Hindupur', 'Sedgewick', 'GozŽe', 'Sonnino', 'Grandrieu', 'Tortel', 'Remagne', 'Iowa City', 'Plainevaux', 'Oostende', 'Kortrijk', 'Qualicum Beach', 'Chimbarongo', 'Kanpur', 'Scandriglia', 'Ambattur', 'Cuccaro Vetere', 'Tomé', 'Nederhasselt', 'Wilmont', 'Cariboo Regional District', 'Wilmington', 'Acoz', 'Saint-Prime', 'Gressoney-Saint-Jean', 'Oakham', 'Purén', 'La Roche-sur-Yon', 'Vespolate', 'Vannes', 'Kalken', 'Aalen', 'Mödling', 'Anthisnes', 'Thorembais-les-BŽguines', 'Acquedolci', 'Toronto', 'Carterton', 'Falisolle', 'Vihari', 'Riparbella', 'Ponte San Nicolò', 'Todi', 'Diano Arentino', 'Talca', 'Segni', 'Los Muermos', 'Ramsey', 'Arlon', 'Tywyn', 'Stroud', 'Rockford', 'GŽrouville', 'Ballarat', 'Oostkerke', 'Gary', 'Oteppe', 'Belgaum', 'Laja', 'Heusden', 'Kooigem', 'Coquitlam', 'Chhindwara', 'Geel', 'Berg', 'Requínoa', 'Thunder Bay', 'Lions Bay', 'Heerhugowaard', 'Acquafondata', 'Manavgat', 'Hull', 'Destelbergen', 'Lac La Biche County', 'Barrhead', 'Truro', 'Sluizen', 'Vallentuna', 'Cagli', 'Saarbrücken', 'Bloxham', 'Nocciano', 'La Valle/Wengen', 'Oswestry', 'Vremde', 'Wadgassen', 'Fresno', 'Jacksonville', 'Kearney', 'Carunchio', 'Montauban', 'Nevers', 'Muzaffarnagar', 'Asbestos', 'Sterrebeek', 'Haren', 'Balvano', 'Pittsburgh', 'San Massimo', 'Cottbus', 'Warminster', 'Châtellerault', 'Charlottetown', 'Punitaqui', 'San Lorenzo', 'Sint-Pieters-Leeuw', 'Meer', 'North Vancouver', 'Santu Lussurgiu', "Sant'Angelo in Pontano", 'Freire', 'Wörgl', 'Tongrinne', 'Dollard-des-Ormeaux', 'Roio del Sangro', 'Foz do Iguaçu', 'OugrŽe', 'Zittau', 'Gibsons', 'Chittoor', 'Aklavik', 'Jalandhar (Jullundur)', 'Bazzano', 'Appelterre-Eichem', 'Fallo', "Monteroni d'Arbia", 'Chicago', 'Colwood', 'Haguenau', 'Fontenoille', 'Izmir', 'Bellingen', 'Raj Nandgaon', 'Springdale', 'Russell', 'Motala', 'Woutersbrakel', 'Lampeter', 'Hameln', 'Curarrehue', 'Tilly', 'Gojra', 'Uppingham. Cottesmore', 'Glendon', 'Falciano del Massico', 'Gravelbourg', 'Santa Maria', 'Racine', 'Hennigsdorf', 'Montemilone', 'Pichilemu', 'Austin', 'Gifhorn', 'Wechelderzande', 'Sluis', 'Hilo', 'Woodlands County', 'Täby', 'Neerrepen', 'Casanova Elvo', 'Tavier', 'Gooik', 'Hubli', 'Monghidoro', 'Chemnitz', 'Bajardo', 'Cittanova', 'Colbún', 'Wolfsburg', 'Esneux', 'Smoky Lake', 'Oelegem', 'Salcito', 'Hachy', 'Besançon', 'Macul', 'Nueva Imperial', 'Dundee', "Ospedaletto d'Alpinolo", 'Fort Resolution', 'Stade', 'Lille', 'Limburg a.d. Lahn', 'Sivry', 'Alassio', 'Saint-Pierre', 'Harlech', 'Abbotsford', 'Castelvecchio Calvisio', 'Isernia', 'New Westminster', 'Tamworth', 'Blairgowrie', 'Notre-Dame-du-Nord', 'Weyburn', 'North Battleford', 'Orp-Jauche', 'Arrah', 'Aurangabad', 'Delianuova', 'Cawdor', 'Hamme-Mille', 'San Rosendo');
        return $cities[array_rand($cities)];
    }
    
    /**
     * Fetch a random country code
     * @return string (country code)
     */
    public function generateCountry()
    {
        $countries = Mage::app()->getLocale()->getCountryTranslationList();
        return array_rand($countries);
    }
    
    /**
     * Generate random region
     * @return string
     */
    public function generateRegion()
    {
        $regions = array('Vienna', 'AQ', 'Hat', 'Samsun', 'SP', 'QC', 'Centre', 'MG', 'Maine', 'OV', 'SI', 'Leinster', 'Alabama', 'LX', 'Berlin', 'OR', 'MA', 'RJ', 'BA', 'North Island', 'VIC', 'AN', 'NO', 'South Australia', 'Champagne-Ardenne', 'Wie', 'VB', 'Ulster', 'Hatay', 'Connacht', 'Languedoc-Roussillon', 'Pomorskie', 'AP', 'Ist', 'Aquitaine', 'Dunbartonshire', 'Zl', 'MZ', 'Quebec', 'Bremen', 'ON', 'W', 'AK', 'Metropolitana de Santiago', 'WV', 'CE', 'MH', 'G', 'Galicia', 'AB', 'CO', 'MP', 'Stockholms län', 'Lanarkshire', 'SJ', 'PR', 'WA', 'BE', 'Cartago', 'Andalucía', 'MO', 'PM', 'DS', 'Pernambuco', 'Utah', 'Puglia', 'Paraíba', 'Campania', 'Los Lagos', 'Warmińsko-mazurskie', 'Östergötlands län', 'L.', 'HA', 'Roxburghshire', 'MI', 'South Island', 'U', 'Ankara', 'QLD', 'AS', 'Victoria', 'Newfoundland and Labrador', 'Małopolskie', 'Bursa', 'Maharastra', 'KA', 'PD', 'Poitou-Charentes', 'Minas Gerais', 'PE', 'E', 'O', 'Akwa Ibom', 'Gloucestershire', 'NI', 'Valparaíso', 'Arizona', 'Paraná', 'Hampshire', 'Waals-Brabant', 'Brussels Hoofdstedelijk Gewest', 'Gl', "Provence-Alpes-Côte d'Azur", 'HI', 'Santa Catarina', 'Ontario', 'PK', 'Jönköpings län', "O'Higgins", 'Washington', 'Rio Grande do Sul', 'N.', 'Pará', 'Benue', 'PUG', 'Nebraska', 'Staffordshire', 'Maule', 'Louisiana', 'Marche', 'Alajuela', 'Nevada', 'OP', 'RA', 'Uttar Pradesh', 'Noord Brabant', 'Kentucky', 'NÖ.', 'Manitoba', 'Istanbul', 'Oregon', 'ZP', 'Trentino-Alto Adige', 'Hawaii', 'Midlothian', 'Sardegna', 'SK', 'West Lothian');
        return $regions[array_rand($regions)];
    }
    
    /**
     * Generate a random zip code. Possible formats are:
     * - xxxxx (all ints)
     * - 0xxxx (all ints)
     * - xxxxxx (all ints)
     * - xxxxx-xxx (all ints)
     * - xxx xxx (ints or chars)
     * - xxxx xxx (ints or chars)
     * - xxxxxx (ints or chars)
     * 
     * @return string
     */
    public function generateZipcode()
    {
        $mode = rand(0, 6);
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        switch ($mode) {
            case 0:
                return rand(10000, 99999);
            case 1:
                return '0' . rand(1000, 9999);
            case 2: 
                return rand(100000, 999999);
            case 3:
                return rand(10000, 99999) . '-' . rand(100, 999);
            case 4:
                return substr(str_shuffle($characters), 0, 3) 
                    . ' ' . substr(str_shuffle($characters), 0, 3);
            case 5:
                return substr(str_shuffle($characters), 0, 4) 
                    . ' ' . substr(str_shuffle($characters), 0, 3);
            case 6:
                return substr(str_shuffle($characters), 0, 6);
        }
    }
    
    /**
     * Generate a random lorem ipsum pharagraph
     * @return string
     */
    public function generateLipsumPharagraph()
    {
        $lipsum = file_get_contents('http://loripsum.net/generate.php?p=1&l=short&pr=1');
        return preg_replace("/[^a-zA-Z 0-9]+/", "", $lipsum);
    }
    
    /**
     * Generate a random lorem ipsum word
     * @return string
     */
    public function generateLipsumWord() 
    {
        $paragraph = $this->generateLipsumPharagraph();
        $words = explode(' ', $paragraph);
        shuffle($words);
        
        return $words[0];
    }
    
    /**
     * Generate a full magento address with random data
     * @return Mage_Customer_Model_Address
     */
    public function generateFullAddress($firstname = null, $lastname = null)
    {
        if (!$firstname) {
            $firstname = $this->generateFirstname();
        }
        
        if (!$lastname) {
            $lastname = $this->generateLastname();
        }
        
        $data = array (
            'firstname' => $firstname,
            'lastname' => $lastname,
            'street' => array (
                '0' => $this->generateStreetAddress(),
            ),
            'city' => $this->generateCity(),
            'region' => $this->generateRegion(),
            'postcode' => $this->generateZipcode(),
            'country_id' => $this->generateCountry(),
            'telephone' => $this->generatePhoneNumber()
        );
        
        return Mage::getModel('customer/address')->setData($data);
    }
    
    /**
     * Return a random adjective
     * @return string
     */
    public function generateRandomAdjective()
    {
        $adjectives = array("different", "used", "important", "every", "large", "available", "popular", "able", "basic", "known", "various", "difficult", "several", "united", "historical", "hot", "useful", "mental", "scared", "additional", "emotional", "old", "political", "similar", "healthy", "financial", "medical", "traditional", "federal", "entire", "strong", "actual", "significant", "successful", "electrical", "expensive", "pregnant", "intelligent", "interesting", "poor", "happy", "responsible", "cute", "helpful", "recent", "willing", "nice", "wonderful", "impossible", "serious", "huge", "rare", "technical", "typical", "competitive", "critical", "electronic", "immediate", "whose", "aware", "educational", "environmental", "global", "legal", "relevant", "accurate", "capable", "dangerous", "dramatic", "efficient", "powerful", "foreign", "hungry", "practical", "psychological", "severe", "suitable", "numerous", "sufficient", "unusual", "consistent", "cultural", "existing", "famous", "pure", "afraid", "obvious", "careful", "latter", "obviously", "unhappy", "acceptable", "aggressive", "distinct", "eastern", "logical", "reasonable", "strict", "successfully", "administrative", "automatic", "civil", "former", "massive", "southern", "unfair", "visible", "alive", "angry", "desperate", "exciting", "friendly", "lucky", "realistic", "sorry", "ugly", "unlikely", "anxious", "comprehensive", "curious", "impressive", "informal", "inner", "pleasant", "sexual", "sudden", "terrible", "unable", "weak", "wooden", "asleep", "confident", "conscious", "decent", "embarrassed", "guilty", "lonely", "mad", "nervous", "odd", "remarkable", "substantial", "suspicious", "tall", "tiny", "more", "some", "one", "all", "many", "most", "other", "such", "even", "new", "just", "good", "any", "each", "much", "own", "great", "another", "same", "few", "free", "right", "still", "best", "public", "human", "both", "local", "sure", "better", "general", "specific", "enough", "long", "small", "less", "high", "certain", "little", "common", "next", "simple", "hard", "past", "big", "possible", "particular", "real", "major", "personal", "current", "left", "national", "least", "natural", "physical", "short", "last", "single", "individual", "main", "potential", "professional", "international", "lower", "open", "according", "alternative", "special", "working", "TRUE", "whole", "clear", "dry", "easy", "cold", "commercial", "full", "low", "primary", "worth", "necessary", "positive", "present", "close", "creative", "green", "late", "fit", "glad", "proper", "complex", "content", "due", "effective", "middle", "regular", "fast", "independent", "original", "wide", "beautiful", "complete", "active", "negative", "safe", "visual", "wrong", "ago", "quick", "ready", "straight", "white", "direct", "excellent", "extra", "junior", "pretty", "unique", "classic", "final", "overall", "private", "separate", "western", "alone", "familiar", "official", "perfect", "bright", "broad", "comfortable", "flat", "rich", "warm", "young", "heavy", "valuable", "correct", "leading", "slow", "clean", "fresh", "normal", "secret", "tough", "brown", "cheap", "deep", "objective", "secure", "thin", "chemical", "cool", "extreme", "exact", "fair", "fine", "formal", "opposite", "remote", "total", "vast", "lost", "smooth", "dark", "double", "equal", "firm", "frequent", "internal", "sensitive", "constant", "minor", "previous", "raw", "soft", "solid", "weird", "amazing", "annual", "busy", "dead", "FALSE", "round", "sharp", "thick", "wise", "equivalent", "initial", "narrow", "nearby", "proud", "spiritual", "wild", "adult", "apart", "brief", "crazy", "prior", "rough", "sad", "sick", "strange", "external", "illegal", "loud", "mobile", "nasty", "ordinary", "royal", "senior", "super", "tight", "upper", "yellow", "dependent", "funny", "gross", "ill", "spare", "sweet", "upstairs", "usual", "brave", "calm", "dirty", "downtown", "grand", "honest", "loose", "male", "quiet", "brilliant", "dear", "drunk", "empty", "female", "inevitable", "neat", "ok", "representative", "silly", "slight", "smart", "stupid", "temporary", "weekly", "that", "this", "what", "which", "time", "these", "work", "no", "only", "first", "over", "business", "his", "game", "think", "after", "life", "day", "home", "economy", "away", "either", "fat", "key", "training", "top", "level", "far", "fun", "house", "kind", "future", "action", "live", "period", "subject", "mean", "stock", "chance", "beginning", "upset", "chicken", "head", "material", "salt", "car", "appropriate", "inside", "outside", "standard", "medium", "choice", "north", "square", "born", "capital", "shot", "front", "living", "plastic", "express", "mood", "feeling", "otherwise", "plus", "saving", "animal", "budget", "minute", "character", "maximum", "novel", "plenty", "select", "background", "forward", "glass", "joint", "master", "red", "vegetable", "ideal", "kitchen", "mother", "party", "relative", "signal", "street", "connect", "minimum", "sea", "south", "status", "daughter", "hour", "trick", "afternoon", "gold", "mission", "agent", "corner", "east", "neither", "parking", "routine", "swimming", "winter", "airline", "designer", "dress", "emergency", "evening", "extension", "holiday", "horror", "mountain", "patient", "proof", "west", "wine", "expert", "native", "opening", "silver", "waste", "plane", "leather", "purple", "specialist", "bitter", "incident", "motor", "pretend", "prize", "resident");
        return $adjectives[array_rand($adjectives)];
    }
}
