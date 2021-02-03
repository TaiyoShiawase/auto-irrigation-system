#include <ESP8266WiFi.h>
#include <WiFiClientSecure.h>

const char* ssid = "Teriyaki";
const char* password = "theresee";

const char* host = "automatic-irrigation-system.herokuapp.com";
const int httpsPort = 443;

const char fingerprint[] PROGMEM = "94fcf6236c37d5e792783c0b5fad0ce49efd9ea8";

void setup() {
  Serial.begin(115200);
  Serial.println();
  Serial.print("connecting to ");
  Serial.println(ssid);
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());

  pinMode(D4, OUTPUT);
}

void loop() {
  WiFiClientSecure client;
  Serial.print("connecting to ");
  Serial.println(host);

  Serial.printf("Using fingerprint '%s'\n", fingerprint);
  client.setFingerprint(fingerprint);

  if (!client.connect(host, httpsPort)) {
    Serial.println("connection failed");
    return;
  }

  int moisture = analogRead(A0);
      
  moisture = map(moisture, 1000,10,0,100);
  Serial.print("Mositure : ");
  Serial.print(moisture);
  Serial.println("%");
  Serial.println();
  
  if(moisture < 0){
    digitalWrite(D4, LOW); 
  }else{
    digitalWrite(D4, HIGH);
  }

  String url = "/post-moisture-data.php?api_key=tPmAT5Ab3j7F9&moisture=";
  url += moisture;
  Serial.print("requesting URL: ");
  Serial.println(url);

  client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" +
               "Content-Type: application/x-www-form-urlencoded"+ "\r\n" +
               "User-Agent: BuildFailureDetectorESP8266\r\n" +
               "Connection: close\r\n\r\n");

  Serial.println("request sent");

  delay(5000);
}
