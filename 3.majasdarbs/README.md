3.Majasdarbs uzdevumi 

Jums ir jāsāk veidot savs konstruktors sava programma. Programma var darīt jebko, tikai jāizpilda šādi nosacījumi:
Kodam jābūt komentētam
Kodam jābūt korekti noformētam
Jāievieš ārēja konfigurācijas avota lasīšana
Jāievieš lasīšana/rakstīšana ārējā DB
Jāizveido vismaz viena DB migrācija datu bāzes struktūras izveidei.

Lai palaistu pievienoto projektu, jāizmanto web serveris kurš satur datubāzi. Piemēram: xammp priekš lokāli izveota web servera 

Failā config.php jaaizpilda savas ārējie datubāzes dati, tajām jābūt .json formātā 

Datubāze automātiski tiktu izveidota , pārlūka adrešu logā papildus jāpieraksta .../install.php. Tas izveidos tukšu datubāzi ar vajadzīgiem galdiem.

Ekspermenta vajadzībām var pievienot datus no ProjectSQL.sql faila, tas izveido lietotājus, veikala produktus, pasūtījumus un vēl pāris lietas.

Datubāzes migrēšanai izmantot phpMyAdmin funkcijas vai ierakstīt pārlūka adrese logā .../migrate.php. Fails izveidos sql failu lai izveidotu datubāzi savā izvēlētā datubāzes vidē.