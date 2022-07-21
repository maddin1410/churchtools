# eine Dublettenerkennung und der ChurchTools Personenliste

Diese Applikation ist eine API-Anwendung basierend auf SLIM 4 um Doubletten in der Personenliste einer ChurchTools Tabaeel zu erkennen.

## Installationsanleitung

Um die anwendung auf einem lokalen PHP Server zu starten verwenen Sie den Befehl im Hauptverzeichniss:

```bash
composer start
```

Dabei wird ein "composer install" durchgeführt, um die benötigten Komponenten zu laden. anschließend wird ein lokaler PHP Server auf dem Port 8080 gestartet.

In der Datei app/Settings.php müssen (ab Zeile 26) die Verbindungsdaten zu einer lokalen instanz einer ChurchTools Datenbank angegeben weden.

## Anzeige der Anwendung im Browser

Anschließend ist die Anwendung unter der URL localhost:8080 zu erreichen. 
Momentan ist das einzige Ziel dieser Anwendung, dass finden und anzeigen von Doubletten in der Personenliste von einer ChurchTool Datenbank.
Hierfür muss die URL loacalhost:8080//admin/passwd/user_doublets aufgerufen werden.