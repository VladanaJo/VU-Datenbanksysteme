import java.sql.*;
import oracle.jdbc.driver.*;
import java.util.Scanner;
import java.io.File;
import java.io.FileReader;
import java.io.BufferedReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.concurrent.ThreadLocalRandom;

public class dbsGenerator {


  public static void main(String args[]) {

    try {
      Class.forName("oracle.jdbc.driver.OracleDriver");   

      System.out.println("JDBC Datengenerator. Autor: a01631235"); //Intro

      String user = "a01631235"; // Username
      String pass = "dbs293";    // Passwort 
    
      String database = "jdbc:oracle:thin:@131.130.122.4:1521:lab"; // Adresse der Datenbank 
      System.out.println("Verbindung zur Oracle-Datenbank wird hergestellt...");
      Connection con = DriverManager.getConnection(database, user, pass); 
      System.out.println("Verbunden! \n");
      Statement stmt = con.createStatement();  // ein Statement-Objekt, mit dem man SQL-Queries ausführen kann
    
    // Navigationsmenü:
     boolean repeat = true;  
    Scanner eingabeScanner = new Scanner(System.in); 
    
    while(repeat){
     System.out.println("Waehlen Sie eine Option aus, indem Sie die entsprechende Zahl eingeben:");
     System.out.println("[1] Neuen Verkäufer eintragen");
     System.out.println("[2] Neues Rezept eintragen");
     System.out.println("[3] Neue Vorbereitung eintragen");
     System.out.println("[4] 2200 Verkaeufern-Eintraege automatisch generieren");
     System.out.println("[5] 400 Baecker-Eintraege automatisch generieren");
     System.out.println("[6] 1000 Rezepte-Eintraege automatisch generieren");
     System.out.println("[7] 400 Suessigkeiten-Eintraege automatisch generieren");
     System.out.println("[8] 500 Vorbereitungen-Eintraege automatisch generieren");
     System.out.println("[9] Programm beenden");
     
     String option = eingabeScanner.next();

      switch(option){
        case "1": ReiheHinzu.neuesTupel(eingabeScanner,stmt,1); break;
        case "2": ReiheHinzu.neuesTupel(eingabeScanner,stmt,2); break;
        case "3": ReiheHinzu.neuesTupel(eingabeScanner,stmt,3); break;
        case "4": System.out.println("\n Datenbank wird befuellt... \n");
                  for(int i=0;i<2199;i++)
                     RandomReiheGenerator.insertRandomVerkaeufer(stmt);
                  System.out.println("Datenbank wurde erfolgreich mit 2200 Verkaeufern befuellt!");
                  break;
        case "5": System.out.println("\n Datenbank wird befuellt... \n");
                  for(int i=0;i<2199;i++)
                     RandomReiheGenerator.insertRandomBaecker(stmt);
                  System.out.println("Datenbank wurde erfolgreich mit 2200 Baeckern befuellt!");
                  break;
        case "6": System.out.println("\n Datenbank wird befuellt... \n");
                   for(int i=0; i<1000; i++)
                     RandomReiheGenerator.insertRandomRezept(stmt);
                  System.out.println("Datenbank wurde erfolgreich mit 1008 Rezepten befuellt!");
                  break;
        case "7": System.out.println("\n Datenbank wird befuellt...\n");
                  for(int i=0;i<400;i++)
                     RandomReiheGenerator.insertRandomSuessigkeit(stmt);
                  System.out.println("Datenbank wurde erfolgreich mit 400 Suessigkeiten befuellt!");
                  break;
        case "8": System.out.println("\n Datenbank wird befuellt... \n");
                  RandomReiheGenerator.insertRandomVorbereitung(stmt);
                  System.out.println("Datenbank wurde erfolgreich mit 500 Vorbereitungen befuellt!");
                  break;
        case "9": repeat=false; break;               
        default: System.out.println("Eingabe ungueltig! \n");
                    }


            }
     
     // Scanner schließen
     eingabeScanner.close();
     // alle Verbindungen schließen
     System.out.println("Abmeldung...");
      stmt.close();
      con.close();
    

      
    } catch (Exception e) {
      System.err.println(e.getMessage());
    }

  }
}

