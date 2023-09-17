//Include libraries
#include <HTTPClient.h>              
#include <WiFi.h>                

//Add WIFI data
const char* ssid = "Hairstyle Salon";              
const char* password =  "blackpink101";        

//Variables used in the code
String barangay_id = "1";
String provincial_id = "2";                  //Just in case you control more than 1 LED
bool toggle_pressed = false;          //Each time we press the push button    
String data_to_send = "";             //Text data to send to the server
unsigned int Actual_Millis, Previous_Millis;
int refresh_time = 200;               //Refresh rate of connection to website (recommended more than 1s)




int barangay_LED = 13;                          
int provincial_LED= 12;
int response_code = 0;
//Button press interruption
void IRAM_ATTR isr() {
  toggle_pressed = true; 
}

void setup() {
  delay(10);
  Serial.begin(115200);           
  pinMode(barangay_LED, OUTPUT);             
  pinMode(provincial_LED, OUTPUT);    

  WiFi.begin(ssid, password);         
  Serial.print("Connecting...");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.print("Connected, my IP: ");
  Serial.println(WiFi.localIP());
  Actual_Millis = millis();              
  Previous_Millis = Actual_Millis; 
}


void loop() {  
  Actual_Millis = millis();
  if (Actual_Millis - Previous_Millis > refresh_time) {
    Previous_Millis = Actual_Millis;  
    if (WiFi.status() == WL_CONNECTED) {                  
      HTTPClient http;                                 
      http.begin("https://yortech.infinityfreeapp.com/update.php");  
      http.addHeader("Content-Type", "application/x-www-form-urlencoded"); 

      data_to_send = "check_status=" + barangay_id;    
      response_code = http.POST(data_to_send);                                  
      if (response_code == 200) {                                                 
        String response_body = http.getString();                               
        Serial.print("Server reply: ");                                 
        Serial.println(response_body);
        
        // Use .equals() for string comparison
        if (response_body.equals("LED_is_off")) {
          digitalWrite(barangay_LED, LOW);
        } else {
          digitalWrite(barangay_LED, HIGH);
        }
      }
      
      data_to_send = "check_status=" + provincial_id;    
      response_code = http.POST(data_to_send);                                
      if (response_code == 200) {                                                 
        String response_body = http.getString();                               
        Serial.print("Server reply: ");                                 
        Serial.println(response_body);
        
        // Use .equals() for string comparison
        if (response_body.equals("LED_is_off")) {
          digitalWrite(provincial_LED, LOW);
        } else {
          digitalWrite(provincial_LED, HIGH);
        }
      }
      
      http.end();                                                                
    } else {
      Serial.println("WIFI connection error");
    }
  }
}
