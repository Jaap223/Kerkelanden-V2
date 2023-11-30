
CREATE TABLE Locatie (
    locatie_id INT PRIMARY KEY,

    Adres VARCHAR(255),

    Tel_nr INT

);
 
CREATE TABLE Gebruiker (

    Gebruiker_id INT PRIMARY KEY,

    Adres VARCHAR(255),

    Wachtwoord VARCHAR(255),

    Naam VARCHAR(255),

    Gebortedatum DATE,

    Tel_nr INT,

    Rol VARCHAR(255),

    user_name VARCHAR(255)

);
 
CREATE TABLE Patiënt (

    Patiënt_id INT PRIMARY KEY,

    Naam VARCHAR(255),

    Gebortedatum DATE,

    Adres VARCHAR(255),

    Tel_nr INT,

    user_name VARCHAR(255),

    wachtwoord VARCHAR(255)

);
 
CREATE TABLE Behandeling (

    Behandeling_id INT PRIMARY KEY,

    behandeling_beschrijving VARCHAR(255),

    kosten DOUBLE

);
 
CREATE TABLE Afspraak (

    Afspraak_id INT PRIMARY KEY,

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
 
CREATE TABLE Factuur (

    Factuur_nr INT PRIMARY KEY,

    Bedrag DOUBLE,

    Status VARCHAR(255),

    Afspraak_id INT,

    FOREIGN KEY (Afspraak_id) REFERENCES Afspraak(Afspraak_id)

);
 
CREATE TABLE Afspraak_Behandeling (

    Afspraak_behandeling_id INT PRIMARY KEY,

    Afspraak_id INT,

    Behandeling_id INT,

    FOREIGN KEY (Afspraak_id) REFERENCES Afspraak(Afspraak_id),

    FOREIGN KEY (Behandeling_id) REFERENCES Behandeling(Behandeling_id)

);
