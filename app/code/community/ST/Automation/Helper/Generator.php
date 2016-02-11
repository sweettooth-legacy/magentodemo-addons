<?php

class ST_Automation_Helper_Generator extends Mage_Core_Helper_Abstract
{
    public function generateFirstname()
    {
        $firstnames = array('Germane', 'Alec', 'Lenore', 'Daquan', 'Kimberley', 'Aimee', 'Jelani', 'Tallulah', 'Randall', 'Rhea', 'Chaim', 'Clinton', 'Hanae', 'Angela', 'Zenaida', 'Blair', 'Curran', 'Uma', 'Anthony', 'Lawrence', 'Hilda', 'Irene', 'Patience', 'Wade', 'Leandra', 'Dara', 'Judith', 'Maggie', 'Garth', 'Sacha', 'Wing', 'Britanney', 'Rhiannon', 'Jessamine', 'Denton', 'Lamar', 'Paul', 'Eagan', 'Nissim', 'Amena', 'Martina', 'Laith', 'Tashya', 'Sydney', 'Aline', 'Patricia', 'Nerea', 'Walker', 'Hilary', 'Juliet', 'Kyra', 'Martha', 'Pandora', 'Palmer', 'Germaine', 'Omar', 'Gisela', 'Lois', 'Beatrice', 'Clarke', 'Sloane', 'Lana', 'Cassandra', 'Noah', 'Remedios', 'Madison', 'Simone', 'Leo', 'Priscilla', 'Mia', 'Driscoll', 'Larissa', 'Barclay', 'Thomas', 'Jacob', 'Ariel', 'Medge', 'Ebony', 'Vaughan', 'Ava', 'Micah', 'Edward', 'Todd', 'Kane', 'Ivan', 'Lillith', 'Brandon', 'Haviva', 'Genevieve', 'Cheryl', 'Dacey', 'William', 'Tyler', 'Kaye', 'Renee', 'Vladimir', 'Karina', 'Lester', 'Zelenia', 'Cain', 'Imelda', 'Mariko', 'Reed', 'Desirae', 'Ashton', 'Yetta', 'Sarah', 'Colette', 'Tate', 'Karly', 'Chastity', 'Paula', 'Unity', 'Anne', 'Kenyon', 'Eve', 'Kirby', 'Carson', 'Jada', 'Sharon', 'Wayne', 'Ria', 'Lacey', 'Elijah', 'Sierra', 'Rooney', 'Phillip', 'Olympia', 'Gemma', 'Inez', 'Darrel', 'Aphrodite', 'Tara', 'Leilani', 'Aileen', 'Ursa', 'Briar', 'Laura', 'Idona', 'Nasim', 'Bradley', 'Maile', 'Eugenia', 'Althea', 'Lucas', 'Zeus', 'Brianna', 'Blaze', 'Lesley', 'Skyler', 'Chester', 'Rhoda', 'Rosalyn', 'Steven', 'Quentin', 'Pearl', 'Gwendolyn', 'Mufutau', 'Conan', 'Bryar', 'Xavier', 'Cherokee', 'Macy', 'Jin', 'Ulric', 'Ivor', 'Rinah', 'Tobias', 'Sylvester', 'Steel', 'Lysandra', 'Carla', 'Lacy', 'Oscar', 'Joan', 'Isaac', 'Ethan', 'Harlan', 'Summer', 'Wyatt', 'Ignatius', 'Margaret', 'Katelyn', 'Elton', 'Vernon', 'Elmo', 'Sophia');
        return $firstnames[array_rand($firstnames)];
    }
    
    public function generateLastname()
    {
        $lastnames = array('Lane', 'Dyer', 'Cross', 'Lancaster', 'Haley', 'Hart', 'Chambers', 'Hardy', 'Sheppard', 'Vincent', 'Mcclure', 'Glass', 'Merrill', 'Griffith', 'Boyer', 'Sanders', 'Stevenson', 'Sherman', 'Horton', 'Tyler', 'Mooney', 'Fox', 'Schwartz', 'Manning', 'Howe', 'Walton', 'Young', 'Barnes', 'Oneill', 'Hooper', 'Robles', 'Burton', 'English', 'Howell', 'Martinez', 'Charles', 'Christensen', 'Macdonald', 'Valentine', 'Huff', 'Mccoy', 'Cooper', 'Walker', 'Ramos', 'Vargas', 'Munoz', 'Schroeder', 'Barron', 'Herrera', 'Salas', 'Blake', 'Welch', 'Wright', 'Nielsen', 'Savage', 'Fernandez', 'Mcdowell', 'Watson', 'Randall', 'Carr', 'Park', 'Joyce', 'Ellison', 'Snyder', 'Hinton', 'Alvarado', 'Norman', 'Rocha', 'Thompson', 'Torres', 'Richardson', 'Bowers', 'Mcdaniel', 'Collier', 'Jarvis', 'Mitchell', 'Harmon', 'Pate', 'Hancock', 'Sellers', 'Sutton', 'Levy', 'Sparks', 'Hutchinson', 'Mejia', 'Wiley', 'Houston', 'Diaz', 'Snider', 'Crosby', 'Parker', 'Jenkins', 'Gonzalez', 'Melton', 'Rogers', 'Nichols', 'Wynn', 'Riley', 'Andrews', 'Pruitt', 'Alexander', 'Cannon', 'Moses', 'Hebert', 'Weber', 'Mills', 'Brady', 'Gibbs', 'Potts', 'Drake', 'Garrison', 'Mayo', 'Roth', 'Lang', 'Ballard', 'Jacobson', 'Rivera', 'Roberts', 'Guthrie', 'Harding', 'Dudley', 'Warren', 'Booth', 'Stone', 'Stewart', 'Lambert', 'Morrison', 'Duran', 'Mccullough', 'Ferguson', 'Miles', 'Bryant', 'Harrell', 'Puckett', 'Nolan', 'York', 'Vinson', 'Bishop', 'Valenzuela', 'Stark', 'Stanton', 'Monroe', 'Salinas', 'Mclean', 'Reid', 'Kane', 'Grimes', 'Shields', 'Emerson', 'Hatfield', 'Rowe', 'Chavez', 'Walsh', 'Travis', 'Ryan', 'Molina', 'Green', 'Blair', 'Clay', 'Mcconnell', 'Glenn', 'Soto', 'Coffey', 'Mayer', 'Gibson', 'Henderson', 'Parsons', 'Hernandez', 'Barrera', 'Acosta', 'Carver', 'Bradford');
        return $lastnames[array_rand($lastnames)];
    }
    
    public function generateEmail()
    {
        $extensions = array('com', 'net', 'ca', 'co.uk', 'com.au', 'de');
        $domainPart = array('red', 'green', 'blue', 'orange', 'purple', 'yellow', 'kiwi', 'apple', 'pear', 'grape', 'peach', 'mango', 'acorn');
        $usernames = array('general', 'info', 'hello', 'support');
        $usernames[] = $this->generateFirstname();
        $usernames[] = $this->generateFirstname() . $this->generateLastname();
        $usernames[] = $this->generateLastname() . $this->generateFirstname();
        $usernames[] = $this->generateFirstname() . '.' . $this->generateLastname();
        $usernames[] = $this->generateLastname() . '.' . $this->generateFirstname();

        $username = strtolower($usernames[array_rand($usernames)]);
        $domain = $domainPart[array_rand($domainPart)] . strtolower($this->generateLipsumWord());
        $extension = $extensions[array_rand($extensions)];
        
        return "{$username}@{$domain}.{$extension}";
    }
    
    public function generatePassword()
    {
        return bin2hex(openssl_random_pseudo_bytes(4));
    }

    public function generatePhoneNumber()
    {
        return '1-' . rand(100, 999) . '-' . rand(100, 999) . '-' . rand(1000, 9999);
    }
    
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
    
    public function generateCity()
    {
        $cities = array('Ransart', 'Minneapolis', 'Fairbanks', 'Rezzoaglio', 'Leval-Chaudeville', 'Dro', 'Dumbarton', 'Belgrave', 'Silchar', 'Monte Vidon Corrado', 'Sangli', 'Bassano in Teverina', 'Laken', 'İnegöl', 'Wanneroo', 'San Giovanni la Punta', 'Hastings', 'Episcopia', 'Anzegem', 'Le Havre', 'Modakeke', 'Annapolis County', 'Hisar', 'Providencia', 'Wittenberg', 'Itzehoe', 'Warrington', 'Straubing', 'Puri', 'Cuenca', 'Kettering', 'Ostrowiec Świętokrzyski', 'San Lazzaro di Savena', 'San Pedro de Atacama', 'Bois-de-Villers', 'Rawalpindi', 'Vieux-Genappe', 'Titagarh', 'Thuin', 'Leipzig', 'Rotorua', 'Gold Coast', 'Arnesano', 'Berwick', 'Le Puy-en-Velay', 'Thurso', 'Corswarem', 'Götzis', 'Girifalco', 'Wiener Neustadt', 'Annapolis Royal', 'Cabano', 'Gresham', 'Camrose', 'Nampa', 'MŽlin', 'Colorado Springs', 'Haddington', 'Anzio', 'Lorient', 'Wolfurt', 'Ockelbo', 'La Seyne-sur-Mer', 'Pickering', 'Sandviken', 'De Haan', 'Turnhout', 'Bossire', 'Great Falls', 'Nurdağı', 'Bissegem', 'Inuvik', 'Sambalpur', 'Rijkevorsel', 'Yellowhead County', 'Labro', 'Cáceres', 'Sandy', 'Vauda Canavese', 'Hindupur', 'Sedgewick', 'GozŽe', 'Sonnino', 'Grandrieu', 'Tortel', 'Remagne', 'Iowa City', 'Plainevaux', 'Oostende', 'Kortrijk', 'Qualicum Beach', 'Chimbarongo', 'Kanpur', 'Scandriglia', 'Ambattur', 'Cuccaro Vetere', 'Tomé', 'Nederhasselt', 'Wilmont', 'Cariboo Regional District', 'Wilmington', 'Acoz', 'Saint-Prime', 'Gressoney-Saint-Jean', 'Oakham', 'Purén', 'La Roche-sur-Yon', 'Vespolate', 'Vannes', 'Kalken', 'Aalen', 'Mödling', 'Anthisnes', 'Thorembais-les-BŽguines', 'Acquedolci', 'Toronto', 'Carterton', 'Falisolle', 'Vihari', 'Riparbella', 'Ponte San Nicolò', 'Todi', 'Diano Arentino', 'Talca', 'Segni', 'Los Muermos', 'Ramsey', 'Arlon', 'Tywyn', 'Stroud', 'Rockford', 'GŽrouville', 'Ballarat', 'Oostkerke', 'Gary', 'Oteppe', 'Belgaum', 'Laja', 'Heusden', 'Kooigem', 'Coquitlam', 'Chhindwara', 'Geel', 'Berg', 'Requínoa', 'Thunder Bay', 'Lions Bay', 'Heerhugowaard', 'Acquafondata', 'Manavgat', 'Hull', 'Destelbergen', 'Lac La Biche County', 'Barrhead', 'Truro', 'Sluizen', 'Vallentuna', 'Cagli', 'Saarbrücken', 'Bloxham', 'Nocciano', 'La Valle/Wengen', 'Oswestry', 'Vremde', 'Wadgassen', 'Fresno', 'Jacksonville', 'Kearney', 'Carunchio', 'Montauban', 'Nevers', 'Muzaffarnagar', 'Asbestos', 'Sterrebeek', 'Haren', 'Balvano', 'Pittsburgh', 'San Massimo', 'Cottbus', 'Warminster', 'Châtellerault', 'Charlottetown', 'Punitaqui', 'San Lorenzo', 'Sint-Pieters-Leeuw', 'Meer', 'North Vancouver', 'Santu Lussurgiu', "Sant'Angelo in Pontano", 'Freire', 'Wörgl', 'Tongrinne', 'Dollard-des-Ormeaux', 'Roio del Sangro', 'Foz do Iguaçu', 'OugrŽe', 'Zittau', 'Gibsons', 'Chittoor', 'Aklavik', 'Jalandhar (Jullundur)', 'Bazzano', 'Appelterre-Eichem', 'Fallo', "Monteroni d'Arbia", 'Chicago', 'Colwood', 'Haguenau', 'Fontenoille', 'Izmir', 'Bellingen', 'Raj Nandgaon', 'Springdale', 'Russell', 'Motala', 'Woutersbrakel', 'Lampeter', 'Hameln', 'Curarrehue', 'Tilly', 'Gojra', 'Uppingham. Cottesmore', 'Glendon', 'Falciano del Massico', 'Gravelbourg', 'Santa Maria', 'Racine', 'Hennigsdorf', 'Montemilone', 'Pichilemu', 'Austin', 'Gifhorn', 'Wechelderzande', 'Sluis', 'Hilo', 'Woodlands County', 'Täby', 'Neerrepen', 'Casanova Elvo', 'Tavier', 'Gooik', 'Hubli', 'Monghidoro', 'Chemnitz', 'Bajardo', 'Cittanova', 'Colbún', 'Wolfsburg', 'Esneux', 'Smoky Lake', 'Oelegem', 'Salcito', 'Hachy', 'Besançon', 'Macul', 'Nueva Imperial', 'Dundee', "Ospedaletto d'Alpinolo", 'Fort Resolution', 'Stade', 'Lille', 'Limburg a.d. Lahn', 'Sivry', 'Alassio', 'Saint-Pierre', 'Harlech', 'Abbotsford', 'Castelvecchio Calvisio', 'Isernia', 'New Westminster', 'Tamworth', 'Blairgowrie', 'Notre-Dame-du-Nord', 'Weyburn', 'North Battleford', 'Orp-Jauche', 'Arrah', 'Aurangabad', 'Delianuova', 'Cawdor', 'Hamme-Mille', 'San Rosendo');
        return $cities[array_rand($cities)];
    }
    
    public function generateCountry()
    {
        $countries = Mage::app()->getLocale()->getCountryTranslationList();
        return array_rand($countries);
    }
    
    public function generateRegion()
    {
        $regions = array('Vienna', 'AQ', 'Hat', 'Samsun', 'SP', 'QC', 'Centre', 'MG', 'Maine', 'OV', 'SI', 'Leinster', 'Alabama', 'LX', 'Berlin', 'OR', 'MA', 'RJ', 'BA', 'North Island', 'VIC', 'AN', 'NO', 'South Australia', 'Champagne-Ardenne', 'Wie', 'VB', 'Ulster', 'Hatay', 'Connacht', 'Languedoc-Roussillon', 'Pomorskie', 'AP', 'Ist', 'Aquitaine', 'Dunbartonshire', 'Zl', 'MZ', 'Quebec', 'Bremen', 'ON', 'W', 'AK', 'Metropolitana de Santiago', 'WV', 'CE', 'MH', 'G', 'Galicia', 'AB', 'CO', 'MP', 'Stockholms län', 'Lanarkshire', 'SJ', 'PR', 'WA', 'BE', 'Cartago', 'Andalucía', 'MO', 'PM', 'DS', 'Pernambuco', 'Utah', 'Puglia', 'Paraíba', 'Campania', 'Los Lagos', 'Warmińsko-mazurskie', 'Östergötlands län', 'L.', 'HA', 'Roxburghshire', 'MI', 'South Island', 'U', 'Ankara', 'QLD', 'AS', 'Victoria', 'Newfoundland and Labrador', 'Małopolskie', 'Bursa', 'Maharastra', 'KA', 'PD', 'Poitou-Charentes', 'Minas Gerais', 'PE', 'E', 'O', 'Akwa Ibom', 'Gloucestershire', 'NI', 'Valparaíso', 'Arizona', 'Paraná', 'Hampshire', 'Waals-Brabant', 'Brussels Hoofdstedelijk Gewest', 'Gl', "Provence-Alpes-Côte d'Azur", 'HI', 'Santa Catarina', 'Ontario', 'PK', 'Jönköpings län', "O'Higgins", 'Washington', 'Rio Grande do Sul', 'N.', 'Pará', 'Benue', 'PUG', 'Nebraska', 'Staffordshire', 'Maule', 'Louisiana', 'Marche', 'Alajuela', 'Nevada', 'OP', 'RA', 'Uttar Pradesh', 'Noord Brabant', 'Kentucky', 'NÖ.', 'Manitoba', 'Istanbul', 'Oregon', 'ZP', 'Trentino-Alto Adige', 'Hawaii', 'Midlothian', 'Sardegna', 'SK', 'West Lothian');
        return $regions[array_rand($regions)];
    }
    
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
                return rand(10000, 99999);
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
    
    public function generateLipsumPharagraph()
    {
        $lipsum = file_get_contents('http://loripsum.net/generate.php?p=1&l=short&pr=1');
        return preg_replace("/[^a-zA-Z 0-9]+/", "", $lipsum);
    }
    
    public function generateLipsumWord() 
    {
        $paragraph = $this->generateLipsumPharagraph();
        $words = explode(' ', $paragraph);
        shuffle($words);
        
        return $words[0];
    }
    
    public function generateFullAddress()
    {
        $data = array (
            'firstname' => $this->generateFirstname(),
            'lastname' => $this->generateLastname(),
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
}
