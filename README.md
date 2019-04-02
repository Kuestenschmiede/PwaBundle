# PwaBundle

Aktuelle TODOS:
* [X] PWA-Konfig: Offline-Seite
* [X] PWA-Konfig: Orientation-Feld
* [X] PWA-Konfig: Auswahl ob SW generiert werden soll oder eigene Datei
* [X] ServiceWorkerFileWriter: Die einzelnen cache.matches Einträge dynamisch generieren
* [ ] ServiceWorkerCreationService: Aktuell werden nur eine Ebene tief die Kindseiten automatisch gecached
* [ ] Push-Notifications: Clientseitige Push Registrierung implementieren
* [X] Push-Notifications: Server-Endpoint (Symfony API) inkl. Aufruf des WebPushBundles für die Subscription
* [X] Push-Notifications: Möglichkeit um Nachrichten rauszuschicken (server)
* [X] Push-Notifications: Notification-Banner bei push event anzeigen (Service worker)
* [ ] ServiceWorker: Caching dynamischer gestalten, aktuell werden initial alle Seiten einmal geladen. Nur in Cache schreiben, wenn gerade angefordert wurde?
* [ ] ServiceWorker: Nichts im Contao Backend machen. Der SW darf sich nicht im Contao BE registrieren.