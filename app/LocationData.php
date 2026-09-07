<?php

namespace App;

class LocationData
{
    public static function getAll()
    {
        return [
            'Nueva Ecija' => [
                'Aliaga' => [
                    'Betes', 'Bibiclat', 'Bucot', 'La Purisima', 'Magsaysay', 'Macabucod', 'Pantoc',
                    'Poblacion Centro', 'Poblacion East I', 'Poblacion East II', 'Poblacion West III',
                    'Poblacion West IV', 'San Carlos', 'San Emiliano', 'San Eustacio', 'San Felipe Bata',
                    'San Felipe Matanda', 'San Juan', 'San Pablo Bata', 'San Pablo Matanda', 'Santa Monica',
                    'Santiago', 'Santo Rosario', 'Santo Tomas', 'Sunson', 'Umangan'
                ],
                'Bongabon' => [
                    'Antipolo', 'Ariendo', 'Bantug', 'Calaanan', 'Commercial', 'Cruz', 'Digmala', 'Curva',
                    'Kaingin', 'Labi', 'Larcon', 'Lusok', 'Macabaclay', 'Magtanggol', 'Mantile', 'Olivete',
                    'Palo Maria', 'Pesa', 'Rizal', 'Sampalucan', 'San Roque', 'Santor', 'Sinipit',
                    'Sisilang na Ligaya', 'Social', 'Tugatug', 'Tulay na Bato', 'Vega'
                ],
                'City of Cabanatuan' => [
                    'Aduas Centro', 'Bagong Sikat', 'Bagong Buhay', 'Bakero', 'Bakod Bayan', 'Balite', 'Bangad',
                    'Bantug Bulalo', 'Bantug Norte', 'Barlis', 'Barrera District', 'Bernardo District', 'Bitas',
                    'Bonifacio District', 'Buliran', 'Caalibangbangan', 'Cabu', 'Campo Tinio', 'Kapitan Pepe',
                    'Cinco-Cinco', 'City Supermarket', 'Caudillo', 'Communal', 'Cruz Roja', 'Daang Sarile',
                    'Dalampang', 'Dicarma', 'Dimasalang', 'Dionisio S. Garcia', 'Fatima', 'General Luna',
                    'Ibabao Bana', 'Imelda District', 'Isla', 'Calawagan', 'Kalikid Norte', 'Kalikid Sur',
                    'Lagare', 'M. S. Garcia', 'Mabini Extension', 'Mabini Homesite', 'Macatbong',
                    'Magsaysay District', 'Matadero', 'Lourdes', 'Mayapyap Norte', 'Mayapyap Sur',
                    'Melojavilla', 'Obrero', 'Padre Crisostomo', 'Pagas', 'Palagay', 'Pamaldan', 'Pangatian',
                    'Patalac', 'Polilio', 'Pula', 'Quezon District', 'Rizdelis', 'Samon', 'San Isidro',
                    'San Josef Norte', 'San Josef Sur', 'San Juan Pob.', 'San Roque Norte', 'San Roque Sur',
                    'Sanbermicristi', 'Sangitan', 'Santa Arcadia', 'Sumacab Norte', 'Valdefuente', 'Valle Cruz',
                    'Vijandre District', 'Villa Ofelia-Caridad', 'Zulueta District', 'Nabao', 'Padre Burgos',
                    'Talipapa', 'Aduas Norte', 'Aduas Sur', 'Hermogenes C. Concepcion, Sr.', 'Sapang',
                    'Sumacab Este', 'Sumacab South', 'Caridad', 'Magsaysay South', 'Maria Theresa',
                    'Sangitan East', 'Santo Niño'
                ],
                'Cabiao' => [
                    'Bagong Buhay', 'Bagong Sikat', 'Bagong Silang', 'Concepcion', 'Entablado', 'Maligaya',
                    'Natividad North', 'Natividad South', 'Palasinan', 'San Antonio', 'San Fernando Norte',
                    'San Fernando Sur', 'San Gregorio', 'San Juan North', 'San Juan South', 'San Roque',
                    'San Vicente', 'Santa Rita', 'Sinipit', 'Polilio', 'San Carlos', 'Santa Isabel', 'Santa Ines'
                ],
                'Carranglan' => [
                    'R.A.Padilla', 'Bantug', 'Bunga', 'Burgos', 'Capintalan', 'Joson', 'General Luna', 'Minuli',
                    'Piut', 'Puncan', 'Putlan', 'Salazar', 'San Agustin', 'T. L. Padilla Pob.',
                    'F. C. Otic Pob.', 'D. L. Maglanoc Pob.', 'G. S. Rosario Pob.'
                ],
                'Cuyapo' => [
                    'Baloy', 'Bambanaba', 'Bantug', 'Bentigan', 'Bibiclat', 'Bonifacio', 'Bued', 'Bulala',
                    'Burgos', 'Cabileo', 'Cabatuan', 'Cacapasan', 'Calancuasan Norte', 'Calancuasan Sur',
                    'Colosboa', 'Columbitin', 'Curva', 'District I', 'District II', 'District IV', 'District V',
                    'District VI', 'District VII', 'District VIII', 'Landig', 'Latap', 'Loob', 'Luna',
                    'Malbeg-Patalan', 'Malineng', 'Matindeg', 'Maycaban', 'Nagcuralan', 'Nagmisahan',
                    'Paitan Norte', 'Paitan Sur', 'Piglisan', 'Pugo', 'Rizal', 'Sabit', 'Salagusog',
                    'San Antonio', 'San Jose', 'San Juan', 'Santa Clara', 'Santa Cruz', 'Simimbaan',
                    'Tagtagumbao', 'Tutuloy', 'Ungab', 'Villaflores'
                ],
                'Gabaldon' => [
                    'Bagong Sikat', 'Bagting', 'Bantug', 'Bitulok', 'Bugnan', 'Calabasa', 'Camachile', 'Cuyapa',
                    'Ligaya', 'Macasandal', 'Malinao', 'Pantoc', 'Pinamalisan', 'South Poblacion', 'Sawmill',
                    'Tagumpay'
                ],
                'City of Gapan' => [
                    'Bayanihan', 'Bulak', 'Kapalangan', 'Mahipon', 'Malimba', 'Mangino', 'Marelo', 'Pambuan',
                    'Parcutela', 'San Lorenzo', 'San Nicolas', 'San Roque', 'San Vicente', 'Santa Cruz',
                    'Santo Cristo Norte', 'Santo Cristo Sur', 'Santo Niño', 'Makabaclay', 'Balante', 'Bungo',
                    'Mabunga', 'Maburak', 'Puting Tubig'
                ],
                'General Mamerto Natividad' => [
                    'Balangkare Norte', 'Balangkare Sur', 'Balaring', 'Belen', 'Bravo', 'Burol', 'Kabulihan',
                    'Mag-asawang Sampaloc', 'Manarog', 'Mataas na Kahoy', 'Panacsac', 'Picaleon', 'Pinahan',
                    'Platero', 'Poblacion', 'Pula', 'Pulong Singkamas', 'Sapang Bato', 'Talabutab Norte',
                    'Talabutab Sur'
                ],
                'General Tinio' => [
                    'Bago', 'Concepcion', 'Nazareth', 'Padolina', 'Pias', 'San Pedro', 'Poblacion East',
                    'Poblacion West', 'Rio Chico', 'Poblacion Central', 'Pulong Matong', 'Sampaguita', 'Palale'
                ],
                'Guimba' => [
                    'Agcano', 'Ayos Lomboy', 'Bacayao', 'Bagong Barrio', 'Balbalino', 'Balingog East',
                    'Balingog West', 'Banitan', 'Bantug', 'Bulakid', 'Caballero', 'Cabaruan', 'Caingin Tabing Ilog',
                    'Calem', 'Camiing', 'Cardinal', 'Casongsong', 'Catimon', 'Cavite', 'Cawayan Bugtong',
                    'Consuelo', 'Culong', 'Escano', 'Faigal', 'Galvan', 'Guiset', 'Lamorito', 'Lennec',
                    'Macamias', 'Macapabellag', 'Macatcatuit', 'Manacsac', 'Manggang Marikit', 'Maturanoc',
                    'Maybubon', 'Naglabrahan', 'Nagpandayan', 'Narvacan I', 'Narvacan II', 'Pacac', 'Partida I',
                    'Partida II', 'Pasong Inchic', 'Saint John District', 'San Agustin', 'San Andres',
                    'San Bernardino', 'San Marcelino', 'San Miguel', 'San Rafael', 'San Roque', 'Santa Ana',
                    'Santa Cruz', 'Santa Lucia', 'Santa Veronica District', 'Santo Cristo District',
                    'Saranay District', 'Sinulatan', 'Subol', 'Tampac I', 'Tampac II & III', 'Triala', 'Yuson',
                    'Bunol'
                ],
                'Jaen' => [
                    'Calabasa', 'Dampulan', 'Hilera', 'Imbunia', 'Imelda Pob.', 'Lambakin', 'Langla', 'Magsalisi',
                    'Malabon-Kaingin', 'Marawa', 'Don Mariano Marcos', 'San Josef', 'Niyugan', 'Pamacpacan',
                    'Pakol', 'Pinanggaan', 'Ulanin-Pitak', 'Putlod', 'Ocampo-Rivera District', 'San Jose',
                    'San Pablo', 'San Roque', 'San Vicente', 'Santa Rita', 'Santo Tomas North', 'Santo Tomas South',
                    'Sapang'
                ],
                'Laur' => [
                    'Barangay I', 'Barangay II', 'Barangay III', 'Barangay IV', 'Betania', 'Canantong', 'Nauzon',
                    'Pangarulong', 'Pinagbayanan', 'Sagana', 'San Fernando', 'San Isidro', 'San Josef', 'San Juan',
                    'San Vicente', 'Siclong', 'San Felipe'
                ],
                'Licab' => [
                    'Linao', 'Poblacion Norte', 'Poblacion Sur', 'San Casimiro', 'San Cristobal', 'San Jose',
                    'San Juan', 'Santa Maria', 'Tabing Ilog', 'Villarosa', 'Aquino'
                ],
                'Llanera' => [
                    'A. Bonifacio', 'Caridad Norte', 'Caridad Sur', 'Casile', 'Florida Blanca', 'General Luna',
                    'General Ricarte', 'Gomez', 'Inanama', 'Ligaya', 'Mabini', 'Murcon', 'Plaridel', 'Bagumbayan',
                    'San Felipe', 'San Francisco', 'San Nicolas', 'San Vicente', 'Santa Barbara', 'Victoria',
                    'Villa Viniegas', 'Bosque'
                ],
                'Lupao' => [
                    'Agupalo Este', 'Agupalo Weste', 'Alalay Chica', 'Alalay Grande', 'J. U. Tienzo', 'Bagong Flores',
                    'Balbalungao', 'Burgos', 'Cordero', 'Mapangpang', 'Namulandayan', 'Parista', 'Poblacion East',
                    'Poblacion North', 'Poblacion South', 'Poblacion West', 'Salvacion I', 'Salvacion II',
                    'San Antonio Este', 'San Antonio Weste', 'San Isidro', 'San Pedro', 'San Roque', 'Santo Domingo'
                ],
                'Science City of Muñoz' => [
                    'Bagong Sikat', 'Balante', 'Bantug', 'Bical', 'Cabisuculan', 'Calabalabaan', 'Calisitan',
                    'Catalanacan', 'Curva', 'Franza', 'Gabaldon', 'Labney', 'Licaong', 'Linglingay',
                    'Mangandingay', 'Magtanggol', 'Maligaya', 'Mapangpang', 'Maragol', 'Matingkis', 'Naglabrahan',
                    'Palusapis', 'Pandalla', 'Poblacion East', 'Poblacion North', 'Poblacion South', 'Poblacion West',
                    'Rang-ayan', 'Rizal', 'San Andres', 'San Antonio', 'San Felipe', 'Sapang Cawayan', 'Villa Isla',
                    'Villa Nati', 'Villa Santos', 'Villa Cuizon'
                ],
                'Nampicuan' => [
                    'Alemania', 'Ambasador Alzate Village', 'Cabaducan East', 'Cabaducan West', 'Cabawangan',
                    'East Central Poblacion', 'Edy', 'Maeling', 'Mayantoc', 'Medico', 'Monic', 'North Poblacion',
                    'Northwest Poblacion', 'Estacion', 'West Poblacion', 'Recuerdo', 'South Central Poblacion',
                    'Southeast Poblacion', 'Southwest Poblacion', 'Tony', 'West Central Poblacion'
                ],
                'City of Palayan' => [
                    'Aulo', 'Bo. Militar', 'Ganaderia', 'Maligaya', 'Manacnac', 'Mapait', 'Marcos Village', 'Malate',
                    'Sapang Buho', 'Singalat', 'Atate', 'Caballero', 'Caimito', 'Doña Josefa', 'Imelda Valley',
                    'Langka', 'Santolan', 'Popolon Pagas', 'Bagong Buhay'
                ],
                'Pantabangan' => [
                    'Cadaclan', 'Cambitala', 'Conversion', 'Ganduz', 'Liberty', 'Malbang', 'Marikit', 'Napon-Napon',
                    'Poblacion East', 'Poblacion West', 'Sampaloc', 'San Juan', 'Villarica', 'Fatima'
                ],
                'Peñaranda' => [
                    'Callos', 'Las Piñas', 'Poblacion I', 'Poblacion II', 'Poblacion III', 'Poblacion IV', 'Santo Tomas',
                    'Sinasajan', 'San Josef', 'San Mariano'
                ],
                'Quezon' => [
                    'Bertese', 'Doña Lucia', 'Dulong Bayan', 'Ilog Baliwag', 'Barangay I', 'Barangay II', 'Pulong Bahay',
                    'San Alejandro', 'San Andres I', 'San Andres II', 'San Manuel', 'Santa Clara', 'Santa Rita',
                    'Santo Cristo', 'Santo Tomas Feria', 'San Miguel'
                ],
                'Rizal' => [
                    'Agbannawag', 'Bicos', 'Cabucbucan', 'Calaocan District', 'Canaan East', 'Canaan West',
                    'Casilagan', 'Aglipay', 'Del Pilar', 'Estrella', 'General Luna', 'Macapsing', 'Maligaya',
                    'Paco Roman', 'Pag-asa', 'Poblacion Central', 'Poblacion East', 'Poblacion Norte', 'Poblacion Sur',
                    'Poblacion West', 'Portal', 'San Esteban', 'Santa Monica', 'Villa Labrador', 'Villa Paraiso',
                    'San Gregorio'
                ],
                'San Antonio' => [
                    'Buliran', 'Cama Juan', 'Julo', 'Lawang Kupang', 'Luyos', 'Maugat', 'Panabingan', 'Papaya',
                    'Poblacion', 'San Francisco', 'San Jose', 'San Mariano', 'Santa Cruz', 'Santo Cristo',
                    'Santa Barbara', 'Tikiw'
                ],
                'San Isidro' => [
                    'Alua', 'Calaba', 'Malapit', 'Mangga', 'Poblacion', 'Pulo', 'San Roque', 'Sto. Cristo', 'Tabon'
                ],
                'San Jose City' => [
                    'A. Pascual', 'Abar Ist', 'Abar 2nd', 'Bagong Sikat', 'Caanawan', 'Calaocan', 'Camanacsacan',
                    'Culaylay', 'Dizol', 'Kaliwanagan', 'Kita-Kita', 'Malasin', 'Manicla', 'Palestina',
                    'Parang Mangga', 'Villa Joson', 'Pinili', 'Rafael Rueda, Sr. Pob.',
                    'Ferdinand E. Marcos Pob.', 'Canuto Ramos Pob.', 'Raymundo Eugenio Pob.',
                    'Crisanto Sanchez Pob.', 'Porais', 'San Agustin', 'San Juan', 'San Mauricio', 'Santo Niño 1st'
                ]
            ],
            'Tarlac' => [
                'Anao' => [
                    'Baguindoc', 'Bantog', 'Balete', 'Burog', 'Cabuluan', 'Caguay', 'Calungbuyan',
                    'Campos', 'Carmen', 'Casili', 'Don Ramon', 'Hernando', 'Lourdes', 'Nagrebcan',
                    'Poblacion', 'Rizal', 'San Francisco East', 'San Francisco West',
                    'San Jose North', 'San Jose South', 'San Juan', 'San Juan East', 'San Juan West',
                    'San Roque', 'Santo Domingo', 'Sibul', 'Silab', 'Timba', 'Tinang'
                ],
                'Bamban' => [
                    'Abang-Singit', 'Anupul', 'Banaba', 'Bangcu', 'Culubasa', 'Dela Cruz',
                    'Fatima', 'Invisible', 'La Paz', 'Lourdes', 'Maliwalo', 'Malonzo',
                    'Nagrambacan', 'San Nicolas', 'San Pedro', 'San Rafael', 'San Roque',
                    'San Vicente', 'Santo Niño', 'Virgen de la Paz'
                ],
                'Camiling' => [
                    'Anoling 1st', 'Anoling 2nd', 'Anoling 3rd', 'Bacabac', 'Bacsay', 'Bagbag',
                    'Bancay 1st', 'Bancay 2nd', 'Bilad', 'Birbira', 'Bobon 1st', 'Bobon 2nd',
                    'Bobon 3rd', 'Botol', 'Cablay', 'Cacatian', 'Calingcuan', 'Capataan',
                    'Coral 1st', 'Coral 2nd', 'Coral 3rd', 'Coral 4th', 'Coral 5th', 'Coral 6th',
                    'Coral 7th', 'Coral-Cristal', 'Culipat', 'Curibung', 'Dalayap', 'Del Pilar',
                    'Hacienda Mary', 'Iba', 'Libueg', 'Malacampa', 'Manupeg', 'Matadero',
                    'Nagmalitong 1st', 'Nagmalitong 2nd', 'Nagmalitong 3rd', 'Nagmalitong 4th',
                    'Nagmalitong 5th', 'Nagmalitong 6th', 'Nagrambacan', 'Nambalan', 'Padua',
                    'Palimbo Proper', 'Palimbo-Camiru', 'Parabur', 'Pindangan 1st', 'Pindangan 2nd',
                    'Pio', 'Poblacion A', 'Poblacion B', 'Poblacion C', 'Poblacion D',
                    'Poblacion E', 'Poblacion F', 'Poblacion G', 'Poblacion H', 'Poblacion I',
                    'Pogo', 'Rang-ayan', 'San Isidro', 'San Jose', 'San Juan', 'San Miguel',
                    'San Nicolas', 'Santo Niño', 'Sinait', 'Sinulatan', 'Subol', 'Tabacal'
                ],
                'Capas' => [
                    'Buenavista', 'Burgos', 'Calibung', 'Cubcub', 'Cutcut 1st', 'Cutcut 2nd',
                    'Dadalay', 'Desierto', 'Dolores', 'Estrada', 'Fenas', 'Iba', 'Kinasang',
                    'Lawy', 'Mababanaba', 'Maruglo', 'O\'Donnell', 'Patling', 'Poblacion Center',
                    'Poblacion East', 'Poblacion North', 'Poblacion South', 'Poblacion West',
                    'San Antonio', 'San Joaquin', 'Santa Juliana', 'Santa Lucia', 'Santo Cristo',
                    'Santo Domingo', 'Santo Niño', 'Talaga', 'Trapiche'
                ],
                'City of Tarlac' => [
                    'Aguso', 'Alvindia', 'Amucao', 'Armenia', 'Asturias', 'Balete', 'Balibay I',
                    'Balibay II', 'Balingcanaway', 'Banaba', 'Bantog', 'Baras-Baras', 'Batang-Batang',
                    'Buscay', 'Buenavista', 'Calingcuan', 'Camat', 'Capao', 'Cardona', 'Caribang',
                    'Caringtbucal', 'Carosales', 'Castañeda', 'Calingcuan', 'Concepcion', 'Cristo Rey',
                    'Cutcut', 'Cutud', 'Dao', 'Dela Paz', 'Embarcadero', 'Faldes', 'Falle',
                    'Fructuosa', 'Fulo', 'Green Village', 'Hacienda Dolores', 'Hacienda San Bartolome',
                    'Hacienda San Guillermo', 'Hacienda San Juan', 'Hacienda San Miguel',
                    'Hacienda Santa Elena', 'Hacienda Santa Ines', 'Hacienda Santa Lucia',
                    'Hacienda Santa Maria', 'Hacienda Santiago', 'Iba', 'Iba Este', 'Iba Oeste',
                    'La Paz', 'Laoag', 'Lapun Lapun', 'Lomboy', 'Lourdes', 'Lubigan', 'Luna',
                    'Lutao', 'Mabalot', 'Mabini', 'Mabilog', 'Macalino', 'Macamias', 'Maliwalo',
                    'Matatalaib', 'Mining', 'Nancamarinan', 'Ngoyog', 'Oapal', 'Paludpod',
                    'Parang', 'Parlas', 'Pitombayog', 'Pob. Block 1', 'Pob. Block 2',
                    'Pob. Block 3', 'Pob. Block 4', 'Pob. Block 5', 'Pob. Block 6',
                    'Pob. Block 7', 'Pob. Block 8', 'Pob. Block 9', 'Pob. Block 10',
                    'Pob. Block 11', 'Pob. Block 12', 'Pob. Block 13', 'Pob. Block 14',
                    'Pob. Block 15', 'Pob. Block 16', 'Pob. Block 17', 'Pob. Block 18',
                    'Pob. Block 19', 'Pob. Block 20', 'Pob. Block 21', 'Pob. Block 22',
                    'Pob. Block 23', 'Pob. Block 24', 'Pob. Block 25', 'Pob. Block 26',
                    'Pob. Block 27', 'Pob. Block 28', 'Pob. Block 29', 'Pob. Block 30',
                    'Pula', 'Ramirez', 'Rexville', 'Salapungan', 'San Carlos', 'San Francisco',
                    'San Isidro', 'San Jose', 'San Juan Bautista', 'San Juan de Mata',
                    'San Manuel', 'San Matias', 'San Miguel', 'San Nicolas', 'San Pablo',
                    'San Pedro', 'San Rafael', 'San Roque', 'San Sebastian', 'San Vicente',
                    'Santa Cruz', 'Santa Maria', 'Santa Rita', 'Santo Cristo', 'Santo Niño',
                    'Sapang Bato', 'Sapang Tagalog', 'Sepung Bulaon', 'Sepung Gubat', 'Sinait',
                    'Sisilang', 'Solo', 'Tancate', 'Tibag', 'Toledo', 'Ugad', 'Ungot',
                    'Villa Elena', 'Villa Esmeralda', 'Villa Lourdes', 'Villa Rosario', 'Villapaz'
                ],
                'Concepcion' => [
                    'Alfonso', 'Balutu', 'Cafe', 'Calius Gueco', 'Caluluan', 'Calingcuan',
                    'Camatbalon', 'Concepcion Poblacion', 'Corazon de Jesus', 'Culaylay',
                    'Dagat-dagat', 'Dolores', 'Iba', 'Ilog Cabe', 'Ilog Centro', 'Ilog Norte',
                    'Ilog Sur', 'Juan Luna', 'Lalo', 'Mabilog', 'Mabini', 'Malupa', 'Minane',
                    'New Santa Barbara', 'Paludpod', 'Parang', 'Parulang', 'Pinili',
                    'Plazang Toro', 'Poblacion Norte', 'Poblacion Sur', 'San Juan Bautista',
                    'San Martin', 'San Nicolas', 'San Vicente', 'Santa Lucia', 'Santa Monica',
                    'Santa Rita', 'Santo Cristo', 'Santo Niño', 'Sipat'
                ],
                'Gerona' => [
                    'Abagon', 'Ablang Sapang', 'Aglipay', 'Amacalan', 'Amsic', 'Aplaya',
                    'Balite', 'Baybayabas', 'Buenavista', 'Cabuluan', 'Cadsalan', 'Calayaan',
                    'Camposanto', 'Caturay', 'Don Basilio', 'Gubat', 'Lambayan', 'Lomboy',
                    'Lusca', 'Mabini', 'Malayantoc', 'Mangga', 'Mangusing', 'Maticmatic',
                    'Nagwirong', 'Nagpandayan', 'Padapada', 'Palis', 'Paluka', 'Parang',
                    'Patag', 'Poblacion', 'Purok', 'Salapungan', 'San Agustin', 'San Antonio',
                    'San Bartolome', 'San Jose', 'San Juan', 'San Lucas', 'San Miguel',
                    'San Pedro', 'Santo Niño', 'Sibul', 'Sibul Malaki', 'Sibul Mangga',
                    'Silang', 'Sulipa', 'Sulo', 'Tagumbao', 'Target', 'Temperancia',
                    'Toclong', 'Toledo', 'Tres Marias', 'Villa Aglipay', 'Villa Aguas',
                    'Villa Flores', 'Villa Gavino', 'Villa Ramirez', 'Villa Rizal'
                ],
                'La Paz' => [
                    'Balanoy', 'Bantog-Carait', 'Bantog-Saluad', 'Barangay I (Pob.)',
                    'Barangay II (Pob.)', 'Barangay III (Pob.)', 'Barangay IV (Pob.)',
                    'Barangay V (Pob.)', 'Barangay VI (Pob.)', 'Cato', 'Colibangbang',
                    'Dagao', 'Dinep', 'K. Murillo', 'Labney', 'Mabul', 'Macalong',
                    'Mayang', 'Nagsulang', 'Paz', 'Rizal'
                ],
                'Mayantoc' => [
                    'Ambalingit', 'Baybayaoas', 'Bigbiga', 'Binbinaca', 'Calabmayan',
                    'Cabangiran', 'Cahabaan', 'Calipayan', 'Canabay', 'Comon',
                    'Gayonggayong', 'Guimba', 'Ibguit', 'Lalapangan', 'Lampitak',
                    'Libay', 'Mamonit', 'Mangolayon', 'Mayamat', 'Nambalan',
                    'Poblacion Norte', 'Poblacion Sur', 'San Bartolome', 'San Isidro'
                ],
                'Moncada' => [
                    'Abaga', 'Andarayan', 'Bangar', 'Cabuluan', 'Calitlitan', 'Calma',
                    'Camangaan East', 'Camangaan West', 'Camiling', 'Camposanto 1 Norte',
                    'Camposanto 1 Sur', 'Camposanto 2', 'Capao', 'Carcueva', 'Cawayan',
                    'Cawayan Bugtong', 'Central East', 'Central West', 'Concepcion',
                    'Dolores', 'Don Ramon', 'Hacienda', 'Lapnit', 'Longos', 'Lourdes',
                    'Mabini', 'Mabuhay', 'Malate', 'Manaois', 'Matam-is', 'Matanlang',
                    'Maysan', 'Nampalogan', 'Paso', 'Poblacion I', 'Poblacion II',
                    'Poblacion III', 'Poblacion IV', 'Poblacion V', 'Pula', 'Quezon',
                    'Rizal', 'San Andres', 'San Carlos', 'San Juan', 'San Leon',
                    'San Miguel', 'San Pedro', 'San Rafael', 'San Roque', 'Santa Lucia',
                    'Santa Maria', 'Santo Niño', 'Santo Tomas', 'Sapang Maragul',
                    'Tapiat', 'Toledo', 'Tubigan', 'Villa Hermosa', 'Villa Ilang-Ilang',
                    'Villa Rizal'
                ],
                'Paniqui' => [
                    'Abogado', 'Alcalde', 'Bacnar', 'Bagong Bayan', 'Balanti',
                    'Bamban', 'Bantog', 'Bisaya', 'Bobon', 'Buenavista', 'Cabayaoasan',
                    'Canan', 'Cabuluan', 'Calingcuan', 'Camias', 'Carino', 'Carosalesan',
                    'Cayao', 'Colibangbang', 'Dumarais', 'Galeran', 'Garcia', 'Herrera',
                    'Igang', 'Isla', 'Lanting', 'Lomboy', 'Mabini', 'Malasa',
                    'Mangilaya', 'Matanlang', 'Naranjo', 'Nancamarinan', 'Padilla',
                    'Pagsaluhan', 'Pambar', 'Parungao', 'Poblacion Norte', 'Poblacion Sur',
                    'Ramos', 'Rizal', 'Salapungan', 'San Agustin', 'San Andres',
                    'San Benito', 'San Francisco', 'San Isidro', 'San Juan de Regla',
                    'San Jose', 'San Miguel', 'San Pedro', 'San Roque', 'San Vicente',
                    'Santa Barbara', 'Santa Cruz', 'Santa Rita', 'Santo Niño',
                    'Santo Rosario', 'Sapa', 'Sinulatan', 'Sulib', 'Tablang',
                    'Tagpos', 'Tibag', 'Tinang', 'Villa', 'Villaflores', 'Villanueva'
                ],
                'Pura' => [
                    'Linao', 'Mabilog', 'Maasin', 'Naya', 'Nilasin 1st', 'Nilasin 2nd',
                    'Poblacion 1', 'Poblacion 2', 'Poblacion 3', 'Poroc', 'Rizal',
                    'Samput', 'Singat', 'Santo Niño 1st', 'Santo Niño 2nd',
                    'Santo Rosario', 'Talimundoc'
                ],
                'Ramos' => [
                    'Calilayan', 'Comillas', 'Guevara', 'Kalang', 'Lapnit',
                    'Poblacion Center', 'San Juan', 'San Miguel', 'San Sebastian'
                ],
                'San Clemente' => [
                    'Anonang Norte', 'Anonang Sur', 'Bagbag', 'Bamban', 'Casecnan',
                    'Cuenca', 'Mangandingay', 'Masic', 'Maasin', 'Pili',
                    'Poblacion Norte', 'Poblacion Sur', 'San Isidro', 'San Marcos',
                    'San Pablo', 'Santa Rosa', 'Santo Niño'
                ],
                'San Jose' => [
                    'Aguilar', 'Burgos', 'Burgos II', 'Burgos III', 'Calaitan',
                    'Cambing', 'Cameron', 'Candelaria', 'Canrubang', 'Casilagan',
                    'Corazon', 'Fianza', 'Iba', 'La Consolacion', 'Lanete',
                    'Luna', 'Mabuhay', 'Malacampa', 'Mangalit', 'Maqueb',
                    'Maturanoc', 'Nambalan', 'Pinaripad', 'Poblacion', 'Pulong',
                    'Rizal', 'San Agustin', 'San Andres', 'San Antonio',
                    'San Bartolome', 'San Fernando', 'San Francisco', 'San Gabriel',
                    'San Isidro', 'San Juan', 'San Juan Bautista', 'San Juan de Dios',
                    'San Lorenzo', 'San Luis', 'San Manuel', 'San Miguel',
                    'San Nicolas', 'San Pablo', 'San Pascual', 'San Pedro',
                    'San Rafael', 'San Roque', 'San Sebastian', 'San Vicente',
                    'Santa Catalina', 'Santa Cruz', 'Santa Elena', 'Santa Lucia',
                    'Santa Maria', 'Santa Rita', 'Santo Cristo', 'Santo Niño',
                    'Santo Tomas', 'Sapa', 'Sibul', 'Sinigpit', 'Tabao',
                    'Tagumbao', 'Tibag', 'Tubigan', 'Unib', 'Vietnamburgos',
                    'Villa Aglipay', 'Villa Concepcion', 'Villa Estrella',
                    'Villa Gonzalez', 'Villa Maria', 'Villa Nizza',
                    'Villa Rosario', 'Villa San Jose'
                ],
                'San Manuel' => [
                    'Abot', 'Aguso', 'Alang-alang', 'Baluyut', 'Calbalete',
                    'Calsib', 'Canite', 'Canao', 'Cayanga', 'Colibangbang',
                    'Garcia', 'Guevarra', 'Laruan', 'Lourdes', 'Manaoag',
                    'Masantol', 'Nabu', 'Padapada', 'Panday Pira', 'Pannaratan',
                    'Poblacion', 'Radiw', 'Ramos', 'Rizam', 'Salapungan',
                    'San Cristobal', 'San Felipe', 'San Gregorio', 'San Isidro',
                    'San Jose', 'San Juan', 'San Lucas', 'San Marcelino',
                    'San Martin', 'San Mateo', 'San Miguel', 'San Nicolas',
                    'San Pablo', 'San Pedro', 'San Rafael', 'San Roque',
                    'San Vicente', 'Santa Ana', 'Santa Barbara', 'Santa Cruz',
                    'Santa Elena', 'Santa Fe', 'Santa Isabel', 'Santa Lucia',
                    'Santa Maria', 'Santa Monica', 'Santa Rita', 'Santa Rosa',
                    'Santo Cristo', 'Santo Domingo', 'Santo Niño', 'Santo Tomas',
                    'Sinait', 'Sison', 'Tabar', 'Tagabo', 'Tagumbao',
                    'Talimundoc', 'Tampaan', 'Tawiran', 'Toledo', 'Ugad',
                    'Uyong', 'Villa Aglipay', 'Villa Cadia', 'Villa Concepcion',
                    'Villa Corazon', 'Villa Flores', 'Villa Grace', 'Villa Leonor',
                    'Villa Luz', 'Villa Paz', 'Villa Rita', 'Villa Rosario',
                    'Villa Teresa', 'Villa Victoria'
                ],
                'Santa Ignacia' => [
                    'Baldios', 'Botbotones', 'Caanamongan', 'Cabaruan', 'Cabugbugan',
                    'Caduldulaoan', 'Calipayan', 'Macaguing', 'Nambalan', 'Padapada',
                    'Poblacion East', 'Poblacion West', 'San Agustin', 'San Antonio',
                    'San Francisco', 'San Juan', 'San Lorenzo', 'San Vicente',
                    'Santa Ines', 'Santa Maria', 'Santa Rita', 'Santo Niño',
                    'Santo Tomas', 'Sinalbagan'
                ],
                'Victoria' => [
                    'Bacungan', 'Baluart', 'Bangar', 'Bantog', 'Bayanbayanan',
                    'Calibungan', 'Canarem', 'Cariño', 'Casantolan', 'Concepcion',
                    'Culubasa', 'Estacion', 'Gubat', 'Lalapac', 'Mabini',
                    'Malabago', 'Malorena', 'Malvar', 'Mapandan', 'Merrising',
                    'Militar', 'Mozzozzin', 'Nagrebcan', 'Old Pagaspas',
                    'Pagaspas', 'Poblacion', 'Quirino', 'Rizal', 'San Antonio',
                    'San Bartolome', 'San Francisco', 'San Gabriel', 'San Isidro',
                    'San Jose', 'San Juan', 'San Luis', 'San Marcelino',
                    'San Mateo', 'San Miguel', 'San Nicolas', 'San Pablo',
                    'San Pedro', 'San Rafael', 'San Roque', 'San Sebastian',
                    'San Vicente', 'Santa Catalina', 'Santa Cruz', 'Santa Elena',
                    'Santa Lucia', 'Santa Maria', 'Santa Monica', 'Santa Rita',
                    'Santo Cristo', 'Santo Domingo', 'Santo Niño', 'Santo Rosario',
                    'Sapa', 'Sinait', 'Sulib', 'Tabug', 'Taguing', 'Talimundoc',
                    'Tambac', 'Tambang', 'Toledo', 'Tubuan', 'Ubando',
                    'Villa Aglipay', 'Villa Concepcion', 'Villa Marcos',
                    'Villa Rosario'
                ],
            ],
            'Aurora' => [
            ]
        ];
    }
}
