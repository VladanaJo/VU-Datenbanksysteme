CREATE TABLE Mitarbeiter (
  Personalnummer INTEGER,
  Mentor_Personalnummer INTEGER,
  Name VARCHAR2(60) NOT NULL,
  Gehalt NUMBER(6,2) NOT NULL,

  PRIMARY KEY (Personalnummer),
  FOREIGN KEY (Mentor_Personalnummer) REFERENCES Mitarbeiter(Personalnummer),
  CONSTRAINT Gehalt_positiv CHECK(Gehalt>0 AND Gehalt<5000)
);

CREATE SEQUENCE Personalnummer_sequence
MINVALUE 1
START WITH 1
INCREMENT BY 1
CACHE 10;

CREATE OR REPLACE TRIGGER Personalnummer_auto_increment
BEFORE INSERT ON Mitarbeiter
  FOR EACH ROW
  BEGIN
select Personalnummer_sequence.nextval into :new.Personalnummer from dual;
END;

CREATE TABLE Baecker(
  Personalnummer INTEGER,
  Ausbildung VARCHAR2(60),
  Erfahrung VARCHAR2(200),

  PRIMARY KEY (Personalnummer),
  FOREIGN KEY (Personalnummer) REFERENCES Mitarbeiter
);

CREATE TABLE Verkaeufer(
  Personalnummer INTEGER,
  Kassa INTEGER NOT NULL,
  Geschlecht CHAR(1) NOT NULL,

  PRIMARY KEY (Personalnummer),
  FOREIGN KEY (Personalnummer) REFERENCES Mitarbeiter,
  CONSTRAINT Geschlecht_moeglich CHECK(Geschlecht='w' OR Geschlecht='m')
);

CREATE TABLE Backzubehoer(
  BackzubehoerID INTEGER,
  Personalnummer INTEGER,
  Name VARCHAR2(60) NOT NULL,
  Material VARCHAR(60),

  PRIMARY KEY (BackzubehoerID),
  FOREIGN KEY (Personalnummer) REFERENCES Baecker
);

CREATE SEQUENCE BackzubehoerID_sequence
MINVALUE 1
START WITH 1
INCREMENT BY 1
CACHE 10;

CREATE OR REPLACE TRIGGER BackzubehoerID_auto_increment
BEFORE INSERT ON Backzubehoer
  FOR EACH ROW
  BEGIN
select BackzubehoerID_sequence.nextval into :new.BackzubehoerID from dual;
END;


CREATE TABLE Vertrag(
  Personalnummer INTEGER,
  Stelle VARCHAR(100),
  Beginndatum DATE NOT NULL,
  Enddatum DATE,

  PRIMARY KEY (Personalnummer,Stelle),
  FOREIGN KEY (Personalnummer) REFERENCES Mitarbeiter,
  CONSTRAINT datum_konsistenz CHECK(Enddatum IS NULL OR Beginndatum<Enddatum) -- Vertrag nicht begrenzt
);

CREATE TABLE Rezept(
  Name VARCHAR(100),
  Dauer NUMBER(2,1),

  PRIMARY KEY (Name),
  CONSTRAINT Dauer_positiv CHECK(Dauer>0)
);

CREATE TABLE Zutat(
  Bezeichnung VARCHAR2(200),

  PRIMARY KEY (Bezeichnung)
);

CREATE TABLE RezeptHatZutat(
  Name VARCHAR(100),
  Bezeichnung VARCHAR2(200) NOT NULL,

  PRIMARY KEY (Name, Bezeichnung),
  FOREIGN KEY (Name) REFERENCES Rezept,
  FOREIGN KEY (Bezeichnung) REFERENCES Zutat
);

CREATE TABLE Lieferdienst(
  LieferdienstID INTEGER,
  TelNummer VARCHAR2(18),
  Name VARCHAR2(60) NOT NULL,

  PRIMARY KEY (LieferdienstID),
  UNIQUE (TelNummer),
  CONSTRAINT telNr_numeric CHECK (LENGTH(TRIM(TRANSLATE(TelNummer, ' 0123456789', ' '))) IS NULL)
  --wir überprüfen, ob sich bei der Telefonnumemer um einen numersichen VARCHAR handelt
);
CREATE SEQUENCE LieferdienstID_sequence
MINVALUE 1
START WITH 1
INCREMENT BY 1
CACHE 10;

CREATE OR REPLACE TRIGGER LieferdienstID_auto_increment
BEFORE INSERT ON Lieferdienst
  FOR EACH ROW
  BEGIN
select LieferdienstID_sequence.nextval into :new.LieferdienstID from dual;
END;

CREATE TABLE Kunde (
  Telnummer VARCHAR2(18), -- die laengstmoegliche europaeische Nummer (ohne Vorwahl) hat 13 Ziffern + bis zu 5 Ziffern für die Vorwahl (00387)
  Adresse VARCHAR2 (150),
  Name VARCHAR2(60),

  PRIMARY KEY (Telnummer),
  CONSTRAINT Telnummer_numeric CHECK (LENGTH(TRIM(TRANSLATE(Telnummer, ' 0123456789', ' '))) IS NULL)
);

CREATE TABLE Suessigkeit (
  Name VARCHAR(60),
  LieferdienstID INTEGER,
  KundeTelNummer VARCHAR2(18), -- die laengstmoegliche europaeische Nummer (ohne Vorwahl) hat 13 Ziffern + bis zu 5 Ziffern für die Vorwahl (00387)
  Preis NUMBER(5,2) NOT NULL,

  PRIMARY KEY (Name),
  FOREIGN KEY (LieferdienstID) REFERENCES Lieferdienst,
  FOREIGN KEY (KundeTelNummer) REFERENCES Kunde(Telnummer)
);

CREATE TABLE Torte (
  Name VARCHAR(60),
  Form VARCHAR(30),
  Gewicht NUMBER(3,2) NOT NULL,

  PRIMARY KEY (Name),
  FOREIGN KEY (Name) REFERENCES Suessigkeit,
  CONSTRAINT Gewicht_positiv CHECK(Gewicht>0)
);

CREATE TABLE Eiscreme (
  Name VARCHAR(60),
  istVegan CHAR(1) NOT NULL,
  Geschmack VARCHAR(20) NOT NULL,

  PRIMARY KEY (Name),
  FOREIGN KEY (Name) REFERENCES Suessigkeit,
  CONSTRAINT IstVegan_moeglich CHECK(istVegan='j' OR istVegan='n')
);

CREATE TABLE Vorbereiten (
  Name VARCHAR2(60),
  Personalnummer INTEGER,

  PRIMARY KEY (Name, Personalnummer),
  FOREIGN KEY (Name) REFERENCES Suessigkeit,
  FOREIGN KEY (Personalnummer) REFERENCES Baecker
);
