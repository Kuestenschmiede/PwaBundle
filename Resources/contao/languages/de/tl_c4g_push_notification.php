<?php
$strName = 'tl_c4g_push_notification';

$GLOBALS['TL_LANG'][$strName]['messageTitle'] = ["Titel der Pushnachricht", "Geben Sie hier einen Titel für die Pushnachricht ein."];
$GLOBALS['TL_LANG'][$strName]['messageContent'] = ["Text der Pushnachricht", "Geben Sie hier den Text ein, den die Pushnachricht enthalten soll."];
$GLOBALS['TL_LANG'][$strName]['subscriptionTypes'] = ["Abonnement-Typ", "Wählen Sie den Abonnement-Typ aus, für den die Push-Nachricht bestimmt ist."];

$GLOBALS['TL_LANG'][$strName]['data_legend'] = "Inhalt der Pushnachricht";

$GLOBALS['TL_LANG'][$strName]['new'] = array("Pushnachricht versenden","Pushnachricht versenden");

$GLOBALS['TL_LANG']['tl_c4g_push_notification']['infoText'] =
    'Pushnachrichten können über die beschriebenen Schnittstellen (z.B. auf <a target="_blank" href="https://github.com/Kuestenschmiede/PwaBundle">GitHub</a>) versendet werden. Dieses Formular ist für kleinere Seiten gedacht, zur direkten Versendung an die Abonnementen. Sobald Sie das Formular speichern, wird die Nachricht verschickt.';