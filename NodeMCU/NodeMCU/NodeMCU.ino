#include <MFRC522.h>
#include <SPI.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

#define SS_PIN D8 // RX slave select
#define RST_PIN D3
#define RedLed D0
#define GreenLed D1
#define BuzzerPin D2

MFRC522 mfrc522(SS_PIN, RST_PIN);

const char *ssid = "mmarte";
const char *password = "khev060919";
const char *serverUrl = "http://192.168.1.5/2/dataService.php";

const char* device_tokens[] = {
  "68b69620a21eed2a","4bd653fbcac0d6a3"
};

const int OnBoardLED = LED_BUILTIN; // Built-in LED on NodeMCU

void setup() {
  pinMode(RedLed, OUTPUT);
  pinMode(GreenLed, OUTPUT);
  pinMode(OnBoardLED, OUTPUT); // Set OnBoard LED as OUTPUT
  pinMode(BuzzerPin, OUTPUT);
  Serial.begin(115200);
  SPI.begin();
  mfrc522.PCD_Init();
  connectToWiFi();
}

void loop() {
  if (!WiFi.isConnected()) {
    connectToWiFi();
  }

  if (mfrc522.PICC_IsNewCardPresent() && mfrc522.PICC_ReadCardSerial()) {
    String uid = getUidAsString();
    sendDataToServer(uid);
    delay(1000); // Add a delay to avoid reading the same card multiple times
  }
}

void connectToWiFi() {
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    digitalWrite(OnBoardLED, LOW); // Turn off OnBoard LED while connecting
    delay(500);
    digitalWrite(OnBoardLED, HIGH); // Turn on OnBoard LED while not connected
    delay(500);
  }

  digitalWrite(OnBoardLED, LOW); // Turn off OnBoard LED when connected
  Serial.println("");
  Serial.println("Connected to WiFi");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
}

String getUidAsString() {
  String uidStr = "";
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    uidStr += String(mfrc522.uid.uidByte[i], HEX);
  }
  mfrc522.PICC_HaltA();
  return uidStr;
}

void sendDataToServer(String uid) {
  Serial.println("Sending data to server: " + uid);

  for (int i = 0; i < sizeof(device_tokens) / sizeof(device_tokens[0]); i++) {
    HTTPClient http;
    String dataService = "?card_uid=" + String(uid) + "&device_token=" + String(device_tokens[i]);
    String link = serverUrl + dataService;

    http.begin(link);
    int httpCode = http.GET();
    String response = http.getString();

    Serial.println("HTTP Response code: " + String(httpCode));
    Serial.println("Server response: " + response);

    digitalWrite(BuzzerPin, LOW); // Turn off the buzzer

    if (httpCode == 200) {
      if (response == "succesful") {
        digitalWrite(GreenLed, HIGH);
        digitalWrite(RedLed, LOW);
        buzzBuzzer(); // Buzz the buzzer
        blinkOnBoardLED(); // Call function to blink OnBoard LED
        digitalWrite(GreenLed, LOW); // Turn off the Green LED
        delay(1000); // Delay after Green LED turned off
      } else if (response == "Not found!" || response == "Not registerd!" || response == "Not Allowed!") {
        digitalWrite(GreenLed, LOW);
        digitalWrite(RedLed, HIGH);
        delay(1000); // Red LED stays on for 1 second
      } else {
        digitalWrite(GreenLed, HIGH);
        digitalWrite(RedLed, LOW);
        buzzBuzzer(); // Buzz the buzzer
        delay(1000); // Red LED stays on for 1 second
      }
    }else{
      digitalWrite(GreenLed, LOW);
      digitalWrite(RedLed, HIGH);
    }
    digitalWrite(RedLed, LOW);
    digitalWrite(GreenLed, LOW);
    http.end();
  }
}

void buzzBuzzer() {
  digitalWrite(BuzzerPin, HIGH); // Turn on the buzzer
  delay(500); // Buzzer sounds for 0.5 seconds
  digitalWrite(BuzzerPin, LOW); // Turn off the buzzer
}

void blinkOnBoardLED() {
  // Function to blink OnBoard LED
  for (int i = 0; i < 3; i++) { // Blink the LED 3 times
    digitalWrite(OnBoardLED, HIGH); // Turn on OnBoard LED
    delay(200); // Keep the LED on for 200 milliseconds
    digitalWrite(OnBoardLED, LOW); // Turn off OnBoard LED
    delay(200); // Keep the LED off for 200 milliseconds
  }
}

