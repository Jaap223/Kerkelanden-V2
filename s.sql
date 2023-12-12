CREATE TABLE Locatie (
    locatie_id INT PRIMARY KEY AUTO_INCREMENT,
    Adres VARCHAR(255),
    Tel_nr INT
);

 
CREATE TABLE Gebruiker (
    Gebruiker_id INT PRIMARY KEY AUTO_INCREMENT,
    Naam VARCHAR(255),
    Adres VARCHAR(255),
    Wachtwoord VARCHAR(255),
    Geboortedatum DATE,
    Tel_nr INT,
    Rol VARCHAR(255),
    user_name VARCHAR(255)  
);
 
CREATE TABLE Patiënt (
    Patiënt_id INT PRIMARY KEY AUTO_INCREMENT,
    Naam VARCHAR(255),
    Geboortedatum DATE,
    Adres VARCHAR(255),
    Tel_nr INT,
    user_name VARCHAR(255),
    wachtwoord VARCHAR(255)
);
 
CREATE TABLE Behandeling (
    Behandeling_id INT PRIMARY KEY AUTO_INCREMENT,
    behandeling_beschrijving VARCHAR(255),
    kosten DOUBLE
);
 
CREATE TABLE Afspraak (
    Afspraak_id INT PRIMARY KEY AUTO_INCREMENT,
    Gebruiker_id INT,
    Patiënt_id INT,
    Locatie_id INT,
    status VARCHAR(255),
    Datum DATE,
    Tijd TIME,
    Factuur_id INT,
    FOREIGN KEY (Gebruiker_id) REFERENCES Gebruiker(Gebruiker_id),
    FOREIGN KEY (Patiënt_id) REFERENCES Patiënt(Patiënt_id),
    FOREIGN KEY (Locatie_id) REFERENCES Locatie(locatie_id)
);
 dddd
CREATE TABLE Factuur (
    Factuur_nr INT PRIMARY KEY AUTO_INCREMENT,
    Bedrag DOUBLE,
    Status VARCHAR(255),
    Afspraak_id INT,
    FOREIGN KEY (Afspraak_id) REFERENCES Afspraak(Afspraak_id)
);
 
CREATE TABLE Afspraak_Behandeling (
    Afspraak_behandeling_id INT PRIMARY KEY AUTO_INCREMENT,
    Afspraak_id INT,
    Behandeling_id INT,
    FOREIGN KEY (Afspraak_id) REFERENCES Afspraak(Afspraak_id),
    FOREIGN KEY (Behandeling_id) REFERENCES Behandeling(Behandeling_id)
);