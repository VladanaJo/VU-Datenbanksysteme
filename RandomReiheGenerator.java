import java.sql.*;
import oracle.jdbc.driver.*;
import java.util.Scanner;
import java.io.File;
import java.io.FileReader;
import java.io.BufferedReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.concurrent.ThreadLocalRandom;

public class RandomReiheGenerator{


//------------------------------------------------ NAMEN  -------------------------------------------------
public static ArrayList<String> namenListe = new ArrayList<String>();        // 2200 
public static String randomNameGenerator(){
       // die Namen werden aus einer Textdatei ausgelesen und in die ArrayList namenListe hineinkopiert 
       if(namenListe.size()==0){  
        try {
            File namenFile = new File("namen");
            FileReader fileReader = new FileReader(namenFile);
            BufferedReader bufferedReader = new BufferedReader(fileReader);
             String einName;
            while ((einName = bufferedReader.readLine()) != null) {
               namenListe.add(einName);
           }
           fileReader.close();
           
         } catch (IOException e) {
             e.printStackTrace();
            }
       }
       // wenn das Array befüllt ist, wähle einfach ein zufälliges Element aus dem Array
       int random = ThreadLocalRandom.current().nextInt(0, 2100 + 1);  // Bereich: 0-1000
       return namenListe.get(random);  
    }


//------------------------------------------------  REZEPT  -------------------------------------------------------
 public static ArrayList<String> namenRezeptListe = new ArrayList<String>();  // 1008
 public static String randomNameRezeptGenerator(){
       // die Namen werden aus einer Textdatei ausgelesen und in die ArrayList namenListe hineinkopiert 
       if(namenRezeptListe.size()==0){  
        try {
            File namenRezeptFile = new File("rezept");
            FileReader fileReaderRezept = new FileReader(namenRezeptFile);
            BufferedReader bufferedReader2 = new BufferedReader(fileReaderRezept);
             String einRezeptName;
            while ((einRezeptName = bufferedReader2.readLine()) != null) {
               namenRezeptListe.add(einRezeptName);
           }
           fileReaderRezept.close();
           
         } catch (IOException e) {
             e.printStackTrace();
            }
       }
       // wenn das Array befüllt ist, wähle einfach ein zufälliges Element aus dem Array
       int random2 = ThreadLocalRandom.current().nextInt(0, 1000 + 1);  // Bereich: 0-1008
       return namenRezeptListe.get(random2) + " (" + ThreadLocalRandom.current().nextInt(0,9999) + ")";  
    }



//-------------------------------------------------------  ZUTAT  -------------------------------------------------------------
 public static ArrayList<String> namenZutatListe = new ArrayList<String>();   // 300
 public static String randomZutatGenerator(){
       // die Namen werden aus einer Textdatei ausgelesen und in die ArrayList namenListe hineinkopiert 
       if(namenZutatListe.size()==0){  
        try {
            File namenZutatFile = new File("zutaten");
            FileReader fileReaderZutat = new FileReader(namenZutatFile);
            BufferedReader bufferedReader3 = new BufferedReader(fileReaderZutat);
             String einZutatName;
            while ((einZutatName = bufferedReader3.readLine()) != null) {
               namenZutatListe.add(einZutatName);
           }
           fileReaderZutat.close();
           
         } catch (IOException e) {
             e.printStackTrace();
            }
       }
       // wenn das Array befüllt ist, wähle einfach ein zufälliges Element aus dem Array
       int random3 = ThreadLocalRandom.current().nextInt(0, 299 + 1);  // Bereich: 0-300
       return namenZutatListe.get(random3) + " (" + ThreadLocalRandom.current().nextInt(0,9999) + ")";  
    }






    //----------------------------------------------- DIE INSERT FUNKTIONEN ----------------------------------------------------------------------------------------
   
    //                                                  ***** VERKAUFER *****
    public static boolean insertRandomVerkaeufer(Statement stmt){

      String randomName = randomNameGenerator();
      int randomGehalt = ThreadLocalRandom.current().nextInt(1500, 2800 + 1);  // Bereich: 1500-2800
      int randomnum = ThreadLocalRandom.current().nextInt(1,10 + 1);
      String randomGeschlecht;
      if(randomnum<6)
         randomGeschlecht = "w";
      else
         randomGeschlecht = "m";
      int randomKassa = ThreadLocalRandom.current().nextInt(1, 5 + 1);  // Bereich: 1-5
 
      try {
           String insertMitarbeiter="INSERT INTO Mitarbeiter(Name,Gehalt) VALUES('"+randomName+"',"+randomGehalt+")";
           stmt.executeUpdate(insertMitarbeiter); // Befehl ausführen
           ResultSet persNumSet = stmt.executeQuery("SELECT Personalnummer FROM MITARBEITER ORDER BY Personalnummer DESC");
                int persNum = 0;
                if(persNumSet.next()){
                  persNum = persNumSet.getInt(1);
                } 
           String insertVerkaeufer= "INSERT INTO VERKAEUFER(Personalnummer,Geschlecht,Kassa) VALUES("+persNum+",'"+randomGeschlecht+"',"+randomKassa+")";
           stmt.executeUpdate(insertVerkaeufer); // Befehl ausführen
           }
      catch (Exception e) {
                System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
                return false;
          }
          return true;
    }


//                                              ***** BAECKER *****

public static boolean insertRandomBaecker(Statement stmt){
    String randomName = randomNameGenerator();
    int randomGehalt = ThreadLocalRandom.current().nextInt(1500, 2800 + 1);  // Bereich: 1500-2800
    int randomnum = ThreadLocalRandom.current().nextInt(1,10 + 1);
    int randomnum2 = ThreadLocalRandom.current().nextInt(1,10 + 1);
    String randomAusbildung;
    String randomErfahrung;

    if(randomnum<6)
       randomAusbildung = "Kochkurs";
    else
       randomAusbildung = "Kochschule";

    if(randomnum2<7){
        if(randomnum2<4)
          randomErfahrung = "5 Jahre";
        else
          randomErfahrung = "7 Jahre";
    }
    else
       randomErfahrung = "10 Jahre";

    try {
         String insertMitarbeiter="INSERT INTO Mitarbeiter(Name,Gehalt) VALUES('"+randomName+"',"+randomGehalt+")";
         stmt.executeUpdate(insertMitarbeiter); // Befehl ausführen
         ResultSet persNumSet = stmt.executeQuery("SELECT Personalnummer FROM MITARBEITER ORDER BY Personalnummer DESC");
              int persNum = 0;
              if(persNumSet.next()){
                persNum = persNumSet.getInt(1);
              } 
         String insertBaecker= "INSERT INTO BAECKER(Personalnummer,Ausbildung,Erfahrung) VALUES("+persNum+",'"+randomAusbildung+"','"+randomErfahrung+"')";
         stmt.executeUpdate(insertBaecker); // Befehl ausführen
         }
    catch (Exception e) {
              System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
              return false;
        }
        return true;
  }





//                                                ***** REZEPT *****

    public static boolean insertRandomRezept(Statement stmt){

      String randomRezeptName = randomNameRezeptGenerator();
      String randomZutatName = randomZutatGenerator();
      int randomDauer = ThreadLocalRandom.current().nextInt(1,5 + 1);
      try{
            String insertRezept="INSERT INTO Rezept(Name, Dauer) VALUES('"+randomRezeptName+"',"+randomDauer+")";
            stmt.executeUpdate(insertRezept); // Befehl ausführen

            ResultSet zutatCheck = stmt.executeQuery("SELECT Bezeichnung FROM ZUTAT WHERE Bezeichnung='"+randomZutatName+"'");
            if (!zutatCheck.next()){
                String insertZutat="INSERT INTO Zutat(Bezeichnung) VALUES('"+randomZutatName+"')";
                stmt.executeUpdate(insertZutat); // Befehl ausführen
            }

            String insertRZ="INSERT INTO RezeptHatZutat(Name,Bezeichnung) VALUES('"+randomRezeptName+"','"+randomZutatName+"')";
            stmt.executeUpdate(insertRZ); 
        } catch (Exception e) {
                System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
                return false;
          }
          return true;
    }
//                                           ***** SUESIGKEIT *****

public static boolean insertRandomSuessigkeit(Statement stmt){
    String randomSuessigkeitName = randomNameRezeptGenerator();
    int randomID = ThreadLocalRandom.current().nextInt(1,2 + 1);  // Bereich: 1-2
    String randomTel = "keine";
    int preis = ThreadLocalRandom.current().nextInt(5,15 + 1);  // Bereich: 5-15

    try{
    String insertSuessigkeit="INSERT INTO Suessigkeit(Name, LieferdienstID,KundeTelNummer,Preis) VALUES('"+randomSuessigkeitName+"',"+randomID+",'"+randomTel+"',"+preis+")";
    stmt.executeUpdate(insertSuessigkeit); // Befehl ausführen      
    }
    catch(Exception e) {
            System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
            return false;
    }
    return true;
}


//                                            ***** VORBEREITUNG *****

    public static boolean insertRandomVorbereitung(Statement stmt){

       try {
        ArrayList<String> persNumList = new ArrayList<String>();
        ResultSet persNumSet = stmt.executeQuery("SELECT Personalnummer FROM (SELECT Personalnummer FROM Baecker ORDER BY DBMS_RANDOM.VALUE) WHERE ROWNUM<501");
            while(persNumSet.next()){
               persNumList.add(persNumSet.getString(1));
            }
            if(persNumList.size()<500){
              System.out.println("ZU WENIG");
              return false;
            } 

        ArrayList<String> susNameList = new ArrayList<String>();
        ResultSet susNameSet = stmt.executeQuery("SELECT Name FROM (SELECT Name FROM Suessigkeit ORDER BY DBMS_RANDOM.VALUE) WHERE ROWNUM<501");
            while(susNameSet.next()){
               susNameList.add(susNameSet.getString(1));
            }
            if(susNameList.size()<500){
                System.out.println("ZU WENIG");
                return false;
            }
            String insertVorbereitung;
            for(int i=0; i<500; i++){
               String pNr= persNumList.get(i);
               String nSus= susNameList.get(i);
               System.out.println(pNr);
               System.out.println(nSus);
               insertVorbereitung= "INSERT INTO Vorbereiten(Name,Personalnummer) VALUES('"+nSus+"','"+pNr+"')";
               stmt.executeUpdate(insertVorbereitung); 
            }
        
        }
      catch (Exception e) {
                System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
                return false;
          }
          return true;
    }
}