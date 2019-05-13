# con4gis-PwaBundle

## Overview
Turn your Contao Website into a [progressive web app](https://developers.google.com/web/progressive-web-apps/).
The con4gis-PwaBundle provides everything you need for basic PWA functionality,
including generating a service worker script and a manifest file.

__Features include:__
* Configuration of required parameters for the webmanifest 
* Select a pwa configuration in the page root. On submit the service worker and manifest for this page root will be generated for you.
* Multiple offline behaviours: choose whether you want to cache everything or if you always want to redirect to a chosen offline page.
* WebPushConfiguration: configure the web push library in the backend so your users can register for push notifications.
* Add icons for app splashscreens (Android & iOS)

## Installation
Via composer:
```
composer require con4gis/pwa
```
Alternatively, you can use the Contao Manager to install the con4gis-PwaBundle.

## Requirements
- [Contao](https://github.com/contao/core-bundle) (latest stable release)
- [CoreBundle](https://github.com/Kuestenschmiede/CoreBundle/releases) (*latest stable release*)
- [WebPushBundle](https://github.com/web-push-libs/web-push-php) (3.* (latest))

## Sending a notification

There are three different ways to send push notifications with this bundle:
- Console Command (```con4gis:send-push <message>```)
- Backend Module
- Sending a notification programmatically

To send a notification in one of your scripts, you have to create a PushNotificationEvent and 
use the Symfony event dispatcher.
````php
// get the event dispatcher
$eventDispatcher = $this->eventDispatcher;
// instantiate event
$event = new PushNotificationEvent();
// this sends the notification to every subscribed user. You can send a notification to only one subscription, too
$event->setSendToAll(true);
// set message contents
$event->setTitle($title);
$event->setMessage($content);
// dispatch the event
$eventDispatcher->dispatch($event::NAME, $event);
````


## Documentation
Visit [docs.con4gis.org](https://docs.con4gis.org) for a user documentation. You can also contact us via the support forum there.
