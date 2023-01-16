# Projektuppgift - webbutveckling III - DT173G
## Student : Beatrice Björn

Det här repositoryt innehåller ett API skapat för projektuppgiften i kursen webbutveckling III.  
I mappen "api" ligger de endpoints som kan användas för att konsumera webbtjänsten och i mappen "classes"  
ligger de klasser som kontrollerar data innan insättning till databasen samt ställer sql-frågor mot databasen för  
de olika anropten som görs. 

## Konsumering av API
Det här APIet är öppet och tillgängligt för alla som vill konsummera det.  

### **INSTALL**
| Filer | Beskrivning |
| --- | --- |
| install.php |  Installation av tabeller till databasen|

### **API**
| Filer | Beskrivning |
| --- | --- |
| config.php |  Databaskoppling, aktivering av felmeddelande i utvecklingsläge och autoinkludering av klasser |
| head.php | Header inställningar för API samt kontroll av om ett id finns tillgängligt|
| rest_about.php |  Fullt stöd för CRUD för att modifiera data i databastabellen aboutUs |
| rest_admin.php | Stöd för POST-anrop mot databas |
| rest_alcohol.php |  Fullt stöd för CRUD för att modifiera data i databastabellen alcohol |
| rest_appetizers.php |  Fullt stöd för CRUD för att modifiera data i databastabellen appetizers |
| rest_booking.php |  Fullt stöd för CRUD för att modifiera data i databastabellen bookings |
| rest_desserts.php |  Fullt stöd för CRUD för att modifiera data i databastabellen desserts |
| rest_hotDrinks.php |  Fullt stöd för CRUD för att modifiera data i databastabellen hotDrinks |
| rest_mains.php |  Fullt stöd för CRUD för att modifiera data i databastabellen mains |
| rest_noAlcohol.php |  Fullt stöd för CRUD för att modifiera data i databastabellen noAlcohol |

### **Classes**
| Filer | Beskrivning |
| --- | --- |
| About.class.php |  Metoder för att lägga in, uppdatera, läsa ut och radera data i databastabellen aboutUs. Samt set-metoder för att kontrollera värden innan de sätts in i databasen |
| Admin.class.php | Metoder för att logga in användare genom att kontrollera användarnamn och lösenord i databasen. Samt set-metoder för att kontrollera att korrekt data skickats med|
| Alcohol.class.php |  Metoder för att lägga in, uppdatera, läsa ut och radera data i databastabellen alcohol. Samt set-metoder för att kontrollera värden innan de sätts in i databasen |
| Appetizer.class.php | Metoder för att lägga in, uppdatera, läsa ut och radera data i databastabellen appetizers. Samt set-metoder för att kontrollera värden innan de sätts in i databasen |
| Booking.class.php | Metoder för att lägga in, uppdatera, läsa ut och radera data i databastabellen bookings. Samt set-metoder för att kontrollera värden innan de sätts in i databasen |
| Dessert.class.php |  Metoder för att lägga in, uppdatera, läsa ut och radera data i databastabellen desserts. Samt set-metoder för att kontrollera värden innan de sätts in i databasen |
| HotDrink.class.php |  Metoder för att lägga in, uppdatera, läsa ut och radera data i databastabellen hotDrinks. Samt set-metoder för att kontrollera värden innan de sätts in i databasen |
| Main.class.php |  Metoder för att lägga in, uppdatera, läsa ut och radera data i databastabellen mains. Samt set-metoder för att kontrollera värden innan de sätts in i databasen |
| NoAlcohol.class.php |  Metoder för att lägga in, uppdatera, läsa ut och radera data i databastabellen noAlcohol. Samt set-metoder för att kontrollera värden innan de sätts in i databasen |

### **Användning**
| Metod/metoder | Endpoint | Beskrivning |
| --- | --- | --- |
| POST | /rest_admin.php |  Kontrollerar att användare existerar. JSON-objekt innehållande korrekt data måste skickas med |
| GET, POST, PUT, DELETE | /rest_*.php | Resterande filer tillåter GET, POST, PUT och DELETE-anrop. Vid GET-anrop kontrolleras om det finns värden lagrade i databasen. Finns det värden skickas respons-kod 200 (success) och finns det inga värden skickas respons-kod 404 (Not found). För POST-anrop kontrolleras skickade värden men hjälp av klassen. Värden skickas som json-objekt (se exemplet nedan för illustration). Om alla värden är korrekt ifyllda skickas respons-kod 201 (created) och värdena sätts in i databasen. Skulle värden vara felaktigt ifyllda skickas respons-kod 500 (internal error) och om värden saknas skickas respons.kod 400 (bad request). Samma procedur som för POST gäller för PUT-anrop. För DELETE-anrop kontrolleras om ett id skickats med i adressraden. Finns ett id skickas respons-kod 200 (success) och finns inget id skickas respons-kod 400 (bad request).   

### **Json-object**  
{  
    "id" : 1,   
    "titel" : "About Us",   
    "info" : "Information about the company"    
}    



### Pga tidsbrist är användarnamn och lösenord i nuläget hårdkodat.  
Användarnamn : admin  
Lösenord : password



