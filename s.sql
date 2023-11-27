CREATE TABLE IF NOT EXISTS locatie (
    locatie_id INT PRIMARY KEY AUTO_INCREMENT,
    Adres VARCHAR(255),
    Tel_nr INT
);

CREATE TABLE IF NOT EXISTS patiënt (
    Patiënt_id INT PRIMARY KEY AUTO_INCREMENT,
    naam VARCHAR(255),
    Geboortedatum DATE,
    Tel_nr INT,
    user_name VARCHAR(50),
    wachtwoord VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS factuur (
    Factuur_nr INT PRIMARY KEY AUTO_INCREMENT,
    Bedrag DOUBLE,
    Status VARCHAR(255),
    Afspraak_id INT,
    FOREIGN KEY (Afspraak_id) REFERENCES Afspraak(Afspraak_id)
);

CREATE TABLE IF NOT EXISTS behandeling (
    Behandeling_id INT PRIMARY KEY AUTO_INCREMENT,
    behandeling_beschrijving VARCHAR(255),
    kosten DOUBLE
);

CREATE TABLE IF NOT EXISTS gebruiker (
    Gebruiker_id INT PRIMARY KEY AUTO_INCREMENT,
    Adres VARCHAR(255),
    Naam VARCHAR(50),
    Geboortedatum DATE,
    Tel_nr INT,
    Rol VARCHAR(255),
    user_name VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS Afspraak (
    Afspraak_id INT PRIMARY KEY AUTO_INCREMENT,
    Gebruiker_id INT,
    Patiënt_id INT,
    Locatie_id INT,
    Status VARCHAR(255),
    Datum DATE,
    Tijd TIME,
    Factuur_id INT,
    FOREIGN KEY (Patiënt_id) REFERENCES patiënt(Patiënt_id),
    FOREIGN KEY (Locatie_id) REFERENCES locatie(locatie_id),
    FOREIGN KEY (Gebruiker_id) REFERENCES gebruiker(Gebruiker_id)
);

CREATE TABLE IF NOT EXISTS Afspraak_Behandeling (
    Afspraak_behandeling INT PRIMARY KEY AUTO_INCREMENT,
    Afspraak_id INT,
    Behandeling_id INT,
    FOREIGN KEY (Behandeling_id) REFERENCES behandeling(Behandeling_id),
    FOREIGN KEY (Afspraak_id) REFERENCES Afspraak(Afspraak_id)
);
