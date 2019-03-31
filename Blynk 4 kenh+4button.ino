#include <Blynk.h>
#include <ESP8266WiFi.h>
#include <ESP8266WebServer.h>
#include "EEPROM.h"
#define  BLYNK_PRINT Serial // Comment this out to disable prints and save space
#include <BlynkSimpleEsp8266.h>
ESP8266WebServer server(80);
const char*     ssid           = "T-SmartHome";
const char*     passphrase     = "chiyeuminhem";

// Blynk Cài Đặt Virtual V12 - V13 - V14 - V15
// Set your LED and physical button pins here
const int ledPin1 = 2; //Chân Relay - D6
const int ledPin2 = 12; //Chân Relay - D7
const int ledPin3 = 13; //Chân Relay - D5
const int ledPin4 = 3; //Chân Relay - RX

const int btnPin1 = 16; //Chân nút nhấn
const int btnPin2 = 5; //Chân nút nhấn
const int btnPin3 = 4; //Chân nút nhấn
const int btnPin4 = 14; //Chân nút nhấn
String          st;
String          content;
int             statusCode;

BlynkTimer timer;
void checkPhysicalButton();

int led1State = LOW;
int btn1State = LOW;

int led2State = LOW;
int btn2State = LOW;

int led3State = LOW;
int btn3State = LOW;

int led4State = LOW;
int btn4State = LOW;

// Every time we connect to the cloud...
BLYNK_CONNECTED() {
  // Request the latest state from the server
  Blynk.syncVirtual(V12);
  Blynk.syncVirtual(V13);
  Blynk.syncVirtual(V14);
  Blynk.syncVirtual(V15);

  // Alternatively, you could override server state using:
  //Blynk.virtualWrite(V12, led1State);
  //Blynk.virtualWrite(V13, led2State);
  //Blynk.virtualWrite(V14, led3State);
  //Blynk.virtualWrite(V15, led4State);

}

// Khi nút bấm được nhấn - hãy chuyển trạng thái
BLYNK_WRITE(V12) {
  led1State = param.asInt();
  digitalWrite(ledPin1, led1State);
}
  
 BLYNK_WRITE(V13) {
  led2State = param.asInt();
  digitalWrite(ledPin2, led2State);
 }
BLYNK_WRITE(V14) {
  led3State = param.asInt();
  digitalWrite(ledPin3, led3State);
}
BLYNK_WRITE(V15) {
  led4State = param.asInt();
  digitalWrite(ledPin4, led4State);
}

void checkPhysicalButton()
{
  if (digitalRead(btnPin1) == LOW) {
    // btn1State is used to avoid sequential toggles
    if (btn1State != LOW) {

      // Toggle LED state
      led1State = !led1State;
      digitalWrite(ledPin1, led1State);

      // Update Button Widget
      Blynk.virtualWrite(V12, led1State);
    }
    btn1State = LOW;
  } else {
    btn1State = HIGH;
  }

  if (digitalRead(btnPin2) == LOW) {
    // btnState is used to avoid sequential toggles
    if (btn2State != LOW) {

      // Toggle LED state
      led2State = !led2State;
      digitalWrite(ledPin2, led2State);

      // Update Button Widget
      Blynk.virtualWrite(V13, led2State);
    }
    btn2State = LOW;
  } else {
    btn2State = HIGH;
  }

  if (digitalRead(btnPin3) == LOW) {
    // btnState is used to avoid sequential toggles
    if (btn3State != LOW) {

      // Toggle LED state
      led3State = !led3State;
      digitalWrite(ledPin3, led3State);

      // Update Button Widget
      Blynk.virtualWrite(V14, led3State);
    }
    btn3State = LOW;
  } else {
    btn3State = HIGH;
  }

  if (digitalRead(btnPin4) == LOW) {
    // btnState is used to avoid sequential toggles
    if (btn4State != LOW) {

      // Toggle LED state
      led4State = !led4State;
      digitalWrite(ledPin4, led4State);

      // Update Button Widget
      Blynk.virtualWrite(V15, led4State);
    }
    btn4State = LOW;
  } else {
    btn4State = HIGH;
  }
}

void setup()
{
  
    Serial.begin(115200);
  
   { pinMode(ledPin1, OUTPUT);
  pinMode(btnPin1, INPUT_PULLUP);
  digitalWrite(ledPin1, led1State);
  timer.setInterval(100L, checkPhysicalButton);}

 { pinMode(ledPin2, OUTPUT);
  pinMode(btnPin2, INPUT_PULLUP);
  digitalWrite(ledPin2, led2State);
  timer.setInterval(100L, checkPhysicalButton);}
{
  pinMode(ledPin3, OUTPUT);
  pinMode(btnPin3, INPUT_PULLUP);
  digitalWrite(ledPin3, led3State);
  timer.setInterval(100L, checkPhysicalButton);}

 { pinMode(ledPin4, OUTPUT);
  pinMode(btnPin4, INPUT_PULLUP);
  digitalWrite(ledPin4, led4State);

  // Setup a function to be called every 100 ms
  timer.setInterval(100L, checkPhysicalButton);}

  
  
    //Delay 5m, Red blink
    EEPROM.begin(512);
    delay(10);
    Serial.println("Startup");
    // read eeprom for ssid, pass and blynk
    Serial.println("Reading EEPROM ssid");
    String esid;
    for (int i = 0; i < 32; ++i) // do dai ma token blynk
    {
        esid += char(EEPROM.read(i));
    }
    Serial.print("SSID: ");
    Serial.println(esid.c_str());
    esid.trim();
 
    Serial.println("Reading EEPROM pass");
    String epass = "";
    for (int i = 32; i < 96; ++i)
    {
        epass += char(EEPROM.read(i));
    }
    Serial.print("PASS: ");
    Serial.println(epass.c_str());
    epass.trim();
 
    Serial.println("Reading EEPROM blynk");
    String eblynk = "";
    for (int i = 96; i < 128; ++i)
    {
        eblynk += char(EEPROM.read(i));
    }
    Serial.print("BLYNK: ");
    Serial.println(eblynk.c_str());
    eblynk.trim();
 
    if ( esid.length() > 1 )
    {
        WiFi.begin(esid.c_str(), epass.c_str());
        if (testWifi())
        {
            launchWeb(0);
            WiFi.disconnect();
 
            char * auth_ = new char[eblynk.length() + 1];
            eblynk.toCharArray(auth_, eblynk.length() + 1);
            Blynk.begin(auth_, esid.c_str(), epass.c_str());
            EEPROM.end();
            return;
        }
    }
    setupAP();
    EEPROM.end();
}
 
bool testWifi(void)
{
    int c = 0;
    Serial.println("DANG KET NOI TOI WIFI ");
    while ( c < 300 )  // đặt thời gian Tự kết nối lại khi mudule chưa kết nối vào mạng wifi: 300 = 5 phút
    {
        if (WiFi.status() == WL_CONNECTED)
        {
            return true;
        }
        delay(1000);
        Serial.print(WiFi.status());
        c++;
    }
    Serial.println("");
    Serial.println("KHONG THE KET NOI. VUI LONG KET NOI TOI MODULE WIFI VA NHAP DIA CHI 192.168.4.1 ");
    return false;
}
 
void launchWeb(int webtype)
{
    Serial.println("");
    Serial.println("WiFi DA KET NOI ");
    Serial.print("DIA CHI MANG IP: ");
    Serial.println(WiFi.localIP());
    Serial.print("DIA CHI WIFI IP: ");
    Serial.println(WiFi.softAPIP());
    createWebServer(webtype);
    // Start the server
    server.begin();
    Serial.println("MAY CHU BAT DAU ");
}
 
void setupAP(void)
{
    WiFi.mode(WIFI_STA);
    WiFi.disconnect();
    delay(100);
    int n = WiFi.scanNetworks();
    Serial.println("HOAN TAT TIM KIEM ");
    if (n == 0)
    {
        Serial.println("KHONG TIM THAY WIFI");
    }
    else
    {
        Serial.print(n);
        Serial.println("WIFI TIM THAY ");
        for (int i = 0; i < n; ++i)
        {
            // Print SSID and RSSI for each network found
            Serial.print(i + 1);
            Serial.print(": ");
            Serial.print(WiFi.SSID(i));
            Serial.print(" (");
            Serial.print(WiFi.RSSI(i));
            Serial.print(")");
            Serial.println((WiFi.encryptionType(i) == ENC_TYPE_NONE) ? " " : "*");
            delay(10);
        }
    }
    Serial.println("");
    st = "<ol>";
    for (int i = 0; i < n; ++i)
    {
        // Print SSID and RSSI for each network found
        st += "<li>";
        st += WiFi.SSID(i);
        st += " (";
        st += WiFi.RSSI(i);
        st += ")";
        st += (WiFi.encryptionType(i) == ENC_TYPE_NONE) ? " " : "*";
        st += "</li>";
    }
    st += "</ol>";
    delay(100);
    Serial.println("DIA CHI WIFI IP: ");
    Serial.println(ssid);
    Serial.println(passphrase);
    WiFi.softAP(ssid, passphrase, 6);
 
    launchWeb(1);
    Serial.println("KET THUC ");
}
 
void createWebServer(int webtype)
{
    if ( webtype == 1 )
    {
        server.on("/", []()
        {
            IPAddress ip = WiFi.softAPIP();
            String ipStr = String(ip[0]) + '.' + String(ip[1]) + '.' + String(ip[2]) + '.' + String(ip[3]);
            content = "<!DOCTYPE HTML>\r\n<html><title>T Smart Home Blynk</title><center><h2>T Smart Home</h2>";
            content += ipStr;
            content += "<form method=\"get\" action=\"setting\">";
            content += "<div>T&#234;n wifi</div>";
            content += "<div><input name=\"ssid\" size=\"40\"></div>";
            content += "<div>M&#7853;t Kh&#7849;u wifi</div>";
            content += "<div><input name=\"pass\" size=\"40\"></div>";
            content += "<div>M&#227; Blynk</div>";
            content += "<div><input name=\"blynk\" size=\"40\"></div>";
            content += "<div><input type='submit' value='X&#225;c Nh&#7853;n'></div>";
            content += "<p>";
            content += st;
            content += "</p><br/><a href='./reset'>Kh&#7903;i &#272;&#7897;ng L&#7841;i H&#7879; Th&#7889;ng</a><br/><br/>4 ch&#226;n GPIO ra relay: GPIO02, GPIO12, GPIO13, GPIO03 <br/>4 Ph&#237;m B&#7845;n &#272;i&#7873;u Khi&#7875;n GPIO Ngo&#224;i: GPIO16, GPIO05, GPIO04, GPIO14<br/>C&#224;i &#272;&#7863;t C&#225;c Ch&#226;n Virtual Trong app Blynk V12 - V13 - V14 - V15<br/>X&#243;a D&#7919; Li&#7879;u &#272;&#227; L&#432;u: /cleareeprom</center>";
            content += "</html>";
            server.send(200, "text/html", content);
    
    
        });
        server.on("/setting", []()
        {
            String qsid = server.arg("ssid");
            String qpass = server.arg("pass");
            String qblynk = server.arg("blynk");
            if (qsid.length() > 0 && qpass.length() > 0)
            {
                EEPROM.begin(512);
                Serial.println("clearing eeprom");
                for (int i = 0; i < 128; ++i)
                {
                    EEPROM.write(i, 0);
                }
                EEPROM.commit();
                Serial.println(qsid);
                Serial.println("");
                Serial.println(qpass);
                Serial.println("");
                Serial.println(qblynk);
                Serial.println("");
 
                Serial.println("writing eeprom ssid:");
                for (int i = 0; i < qsid.length(); ++i)
                {
                    EEPROM.write(i, qsid[i]);
                    Serial.print("Wrote: ");
                    Serial.println(qsid[i]);
                }
 
                Serial.println("writing eeprom pass:");
                for (int i = 0; i < qpass.length(); ++i)
                {
                    EEPROM.write(32 + i, qpass[i]);
                    Serial.print("Wrote: ");
                    Serial.println(qpass[i]);
                }
 
                Serial.println("writing eeprom blynk:");
                for (int i = 0; i < qblynk.length(); ++i)
                {
                    EEPROM.write(96 + i, qblynk[i]);
                    Serial.print("Wrote: ");
                    Serial.println(qblynk[i]);
                }
                EEPROM.commit();
                EEPROM.end();
                //Chop den  sau khi lam xong
                pinMode(15, OUTPUT);
                digitalWrite(15, LOW);
                digitalWrite(15, HIGH);
                delay(500);
                digitalWrite(15, LOW);
                content = "<!DOCTYPE HTML>\r\n<html>";
                content += "D&#7919; Li&#7879; &#272;&#227; &#272;&#432;&#7907;c L&#432;u V&#224;o B&#7897; Nh&#7899; - <a href='./reset'>&#7844;n V&#224;o &#272;&#226;y &#272;&#7875; Kh&#7903;i &#272;&#7897;ng L&#7841;i H&#7879; Th&#7889;ng</a>";
                //statusCode = 200;
                  content += "</html>";
                  server.send(200, "text/html", content);
            }
            else
            {
                content = "{\"Error\":\"404 not found\"}";
                statusCode = 404;
                Serial.println("Sending 404");
            }
            server.send(statusCode, "application/json", content);

        
        });

        server.on("/reset", []()
        {
          Serial.println("Reset..");
    ESP.restart();
    delay(1000);
        });
        
    }
    else if (webtype == 0)
    {
        server.on("/", []()
        {
            IPAddress ip = WiFi.localIP();
            String ipStr = String(ip[0]) + '.' + String(ip[1]) + '.' + String(ip[2]) + '.' + String(ip[3]);
            content = "<br/>Code By: V&#361; Tuy&#7875;n<br/>FB: <a href='https://fb.com/100008756118319' target='_blank'>Facebook</a><br/>Mail: anhtuyenvipcr5@gmail.com<br/>V&#224;o &#272;&#7871;n &#272;&#226;y L&#224; B&#7841;n T&#242; M&#242; Qu&#225; R&#7891;i &#272;&#7845;y</b>";
            server.send(200, "text/html", "<center><b>IP: " + ipStr + content+"</b></center>");
        });

    }
        server.on("/cleareeprom", []()
        {
            content = "<!DOCTYPE HTML>\r\n<html>";
            content += "<h2>T Smart Home</h2><p>&#272;&#227; X&#243;a EEPROM, &#272;ang kh&#7903;i &#273;&#7897;ng l&#7841;i....</p></html>";
            server.send(200, "text/html", content);
            Serial.println("clearing eeprom");
 EEPROM.begin(512);
  // write a 0 to all 512 bytes of the EEPROM
  for (int i = 0; i < 512; i++) {
    EEPROM.write(i, 0);
  }

  // turn the LED on when we're done
  pinMode(15, OUTPUT);
  digitalWrite(15, HIGH);
  EEPROM.end();
  ESP.restart();
  delay(1000);
        });
    
}
 
void loop()
{
    server.handleClient();
    Blynk.run();
     timer.run();
}