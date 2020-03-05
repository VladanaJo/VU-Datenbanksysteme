import java.sql.*;
import oracle.jdbc.driver.*;
import java.util.Scanner;
import java.io.File;
import java.io.FileReader;
import java.io.BufferedReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.concurrent.ThreadLocalRandom;

public class ReiheHinzu{

     public static boolean neuesTupel(Scanner eingabeScanner, Statement stmt,int option){
    switch(option){
      // neuen Verkaeufer hinzufügen---------------------------------------------------------------------------------------
      case 1: System.out.println("---------NEUER VERKAEUFER---------");
              System.out.println("Name:");
              String name = eingabeScanner.next();
              System.out.println("Gehalt:");
              String gehalt = eingabeScanner.next();
              System.out.println("Geschlecht(m/w):");
              String geschlecht = eingabeScanner.next();
              System.out.println("Kassa:");
              String kassa = eingabeScanner.next();

              try {
                String insertMitarbeiter="INSERT INTO Mitarbeiter(Name,Gehalt) VALUES('"+name+"',"+gehalt+")";
                stmt.executeUpdate(insertMitarbeiter); // Befehl ausführen
                ResultSet persNumSet = stmt.executeQuery("SELECT Personalnummer FROM MITARBEITER ORDER BY Personalnummer DESC");
                int persNum = 0;
                if(persNumSet.next()){
                  persNum = persNumSet.getInt(1);
                } 
                String insertVerkaeufer="INSERT INTO Verkaeufer(Personalnummer,Geschlecht,Kassa) VALUES("+persNum+",'"+geschlecht+"',"+kassa+")"; 
                 stmt.executeUpdate(insertVerkaeufer); // Befehl ausführen
                 System.out.println("Neuer Verkaeufer wurde hinzugefuegt! \n");
                  }
              catch (Exception e) {
                System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
                return false;
                }
          break;

     // neues Rezept hinzufügen-------------------------------------------------------------------------------------------
      case 2: System.out.println("---------NEUES REZEPT---------");
              System.out.println("Name:");
              String name2 = eingabeScanner.next();
              System.out.println("Dauer:");
              String dauer = eingabeScanner.next();
              try {
                String insertRezept="INSERT INTO Rezept(Name, Dauer) VALUES('"+name2+"',"+dauer+")";
                stmt.executeUpdate(insertRezept); // Befehl ausführen

                System.out.println("Zutaten (mit 'q' Eingabe beenden) :");
                boolean isTyping = true;
                while(isTyping){
                  String bezeichnung = eingabeScanner.next();
                  if(bezeichnung.equals("q")){
                    isTyping=false;
                  }
                  else{
                    ResultSet zutatCheck = stmt.executeQuery("SELECT Bezeichnung FROM ZUTAT WHERE Bezeichnung='"+bezeichnung+"'");
                      if (!zutatCheck.next()){
                        String insertZutat="INSERT INTO Zutat(Bezeichnung) VALUES('"+bezeichnung+"')";
                        stmt.executeUpdate(insertZutat); // Befehl ausführen
                      }
    
                    String insertRZ="INSERT INTO RezeptHatZutat(Name,Bezeichnung) VALUES('"+name2+"','"+bezeichnung+"')";
                    stmt.executeUpdate(insertRZ); // Befehl ausführen
                  }
                }
        
                
              
                 System.out.println("Neues Rezept wurde hinzugefuegt! \n");
                  }
              catch (Exception e) {
                System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
                return false;
                }
          break;

         // neue Vorbereitung hinzufügen
      case 3: System.out.println("---------NEUE VORBEREITUNG---------");
              System.out.println("Personalnummer des Baeckers");
              String personalnummer = eingabeScanner.next();
              System.out.println("Name des Suessigkeits");
              String name3 = eingabeScanner.next();

              try {
                 String insertVorbereitung="INSERT INTO Vorbereiten(Personalnummer, Name) VALUES('"+personalnummer+"','"+name3+"')"; // das INSERT-Statement wird zusammengesetzt
                 stmt.executeUpdate(insertVorbereitung); // Befehl ausführen
                 System.out.println("Neue Vorbereitung wurde hinzugefuegt! \n");
                  }
              catch (Exception e) {
                System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
                return false;
                }
          break;


      default: System.out.println("Fehler: Option ungueltig! Moegliche Optionen: 1,2,3.\n"); return false;
    }


      int count=0;

    try{
          ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Verkaeufer");  
           if (rs.next()) {
             count = rs.getInt(1);
              System.out.println("Anzahl der Verkaeufer in der Datenbank: " + count);
            }

            rs=stmt.executeQuery("SELECT COUNT(*) FROM RezeptHatZutat");
            if (rs.next()) {
                 count = rs.getInt(1);
                System.out.println("Anzahl der Rezepte in der Datenbank: " + count);
              }

            rs=stmt.executeQuery("SELECT COUNT(*) FROM Vorbereiten");
            if (rs.next()) {
                 count = rs.getInt(1);
                System.out.println("Anzahl der Vorbereitungen in der Datenbank: " + count+"\n");
              }

            rs.close();  // ResultSet schließen

     } catch(Exception e){
       System.err.println("Fehler im COUNT-Query:"+e.getMessage());
     }

      return true;
  }



}
