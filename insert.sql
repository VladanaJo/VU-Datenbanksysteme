INSERT INTO Mitarbeiter(Name,Gehalt) VALUES('Max Mustermann','2000'); -- Personalnummer ist automatisch 1 und Max hat kein Mentor
INSERT INTO Mitarbeiter(Mentor_Personalnummer,Name,Gehalt) VALUES('1','Erika Mustermann','1900'); -- Personalnummer ist automatisch 2
INSERT INTO Mitarbeiter(Mentor_Personalnummer,Name,Gehalt) VALUES('2','Anna Mustermann','2100');  -- Personalnummer ist automatisch 3
INSERT INTO Mitarbeiter(Mentor_Personalnummer,Name,Gehalt) VALUES('2','Daniel Mustermann','2200');  -- Personalnummer ist automatisch 11

INSERT INTO Baecker(Personalnummer,Ausbildung,Erfahrung) VALUES('1','Kochschule','3 Jahre');
INSERT INTO Baecker(Personalnummer,Ausbildung,Erfahrung) VALUES('2','Kochschule','5 Jahre');
INSERT INTO Verkaeufer(Personalnummer,Kassa, Geschlecht) VALUES('3','1','w');
INSERT INTO Verkaeufer(Personalnummer,Kassa, Geschlecht) VALUES('11','2','m');

INSERT INTO Backzubehoer(Personalnummer,Name,Material) VALUES('1','Loeffel','Holz'); -- BackID ist 1
INSERT INTO Backzubehoer(Personalnummer,Name,Material) VALUES('2','Messer','Edelstahl'); -- BackID ist 2

INSERT INTO Vertrag(Personalnummer,Stelle,Beginndatum,Enddatum) VALUES('1','Baecker',TO_DATE('27/11/2015','DD/MM/YYYY'),TO_DATE('27/11/2019','DD/MM/YYYY'));
INSERT INTO Vertrag(Personalnummer,Stelle,Beginndatum) VALUES('2','Baecker',TO_DATE('01/01/2014','DD/MM/YYYY')); -- Vertrag nicht begrenzt
INSERT INTO Vertrag(Personalnummer,Stelle,Beginndatum,Enddatum) VALUES('3','Verkaufer',TO_DATE('27/11/2015','DD/MM/YYYY'),TO_DATE('27/11/2019','DD/MM/YYYY'));
INSERT INTO Vertrag(Personalnummer,Stelle,Beginndatum) VALUES('11','Verkaufer',TO_DATE('01/01/2016','DD/MM/YYYY')); -- Vertrag nicht begrenzt

INSERT INTO Rezept(Name, Dauer) VALUES('Sacher Torte',1.5);
INSERT INTO Rezept(Name, Dauer) VALUES('Krapfen',1.1);
INSERT INTO Rezept(Name, Dauer) VALUES('Karottenkuchen',1.4);

INSERT INTO Zutat(Bezeichnung) VALUES('Zucker');
INSERT INTO Zutat(Bezeichnung) VALUES('Mehl');
INSERT INTO Zutat(Bezeichnung) VALUES('Karotte');

INSERT INTO RezeptHatZutat(Name, Bezeichnung) VALUES('Sacher Torte','Zucker');
INSERT INTO RezeptHatZutat(Name, Bezeichnung) VALUES('Krapfen','Mehl');
INSERT INTO RezeptHatZutat(Name, Bezeichnung) VALUES('Karottenkuchen','Karotte');

INSERT INTO Lieferdienst(TelNummer,Name) VALUES(' 34 567823','Foodora'); -- ID ist 1
INSERT INTO Lieferdienst(TelNummer,Name) VALUES(' 35 322456','Mjam'); -- ID ist 2

INSERT INTO Kunde(TelNummer,Adresse,Name) VALUES(' 12 3456789','Waehringer Strasse 3/5','Phillip');
INSERT INTO Kunde(TelNummer,Adresse,Name) VALUES(' 34 5678912','Spitalgasse 15/4','Markus');

INSERT INTO Suessigkeit(Name,LieferdienstID,KundeTelNummer,Preis) VALUES('Sacher Torte','1',' 12 3456789',15);
INSERT INTO Suessigkeit(Name,LieferdienstID,KundeTelNummer,Preis) VALUES('Schneeball','1',' 34 5678912', 2);
INSERT INTO Suessigkeit(Name,LieferdienstID,KundeTelNummer,Preis) VALUES('Marzipantorte','1',' 12 3456789',13);
INSERT INTO Suessigkeit(Name,LieferdienstID,KundeTelNummer,Preis) VALUES('Herrentorte','1',' 12 3456789',16);

INSERT INTO Eiscreme(Name,istVegan,Geschmack) VALUES ('Schneeball','j','Vanilla und Kokos');
INSERT INTO Torte(Name,Form,Gewicht) VALUES('Sacher Torte','Kreis','2');
INSERT INTO Torte(Name,Form,Gewicht) VALUES('Marzipantorte','Kreis','2');
INSERT INTO Torte(Name,Form,Gewicht) VALUES('Herrentorte','Kreis','3');

INSERT INTO Vorbereiten(Name, Personalnummer) VALUES('Sacher Torte','1');
INSERT INTO Vorbereiten(Name, Personalnummer) VALUES('Schneeball','2');


/*-------------------------- D I E    V I E W S  ----------------------------------*/

-- Waehle alle Mitarbeiter, dessen Gehalt groesser als das durchschnittliche Gehalt ist
CREATE VIEW Over_Average AS SELECT * FROM Mitarbeiter WHERE Gehalt>(SELECT AVG(Gehalt) FROM Mitarbeiter);
SELECT * FROM Over_Average;


--Namen und Gehaelter von Mitarbeiter(Baecker) die Backzubehoer haben
CREATE VIEW HatBackzubehoer AS SELECT m.Name, Gehalt FROM Mitarbeiter m INNER JOIN BACKZUBEHOER b on m.PERSONALNUMMER = b.PERSONALNUMMER;
SELECT * from HatBackzubehoer;


--Anzahl bestellten Suessigkeiten, Durchschnittspreise und Kundetelnummer
CREATE VIEW ProduktAnzahlProKunde AS
  SELECT COUNT(Name) AS Anzahl,
         AVG(Preis) AS Durchschnitt,
         Kundetelnummer
 FROM Suessigkeit
 GROUP BY Kundetelnummer
 ORDER BY Durchschnitt DESC;

SELECT * FROM ProduktAnzahlProKunde;
DROP VIEW ProduktAnzahlProKunde;
/*-----------------------------------------------------------------------------------*/




DELETE FROM Zutat WHERE Bezeichnung='Karoptte';

SELECT * FROM Lieferdienst;
SELECT * FROM SUESSIGKEIT;
SELECT * FROM TORTE;
SELECT * FROM SUESSIGKEIT;
SELECT * FROM EISCREME;
SELECT * FROM BACKZUBEHOER;
SELECT * FROM VERTRAG;
SELECT * FROM BAECKER;
SELECT * FROM VORBEREITEN;
SELECT * FROM MITARBEITER;
