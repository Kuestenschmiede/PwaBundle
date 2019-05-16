<?php
$strName = 'tl_c4g_push_notification';

$GLOBALS['TL_LANG'][$strName]['messageTitle'] = ["Title of the push notification", "Insert a title for the push notification."];
$GLOBALS['TL_LANG'][$strName]['messageContent'] = ["Content of the push notification", "Insert the text that the notification should contain."];

$GLOBALS['TL_LANG'][$strName]['data_legend'] = "Notification content";

$GLOBALS['TL_LANG'][$strName]['new'] = array("Send push notification", "Send push notification");

$GLOBALS['TL_LANG']['tl_c4g_push_notification']['infoText'] =
    'Push notifications can be sent via the described interfaces (e.g. visit <a target="_blank" href="https://github.com/Kuestenschmiede/PwaBundle">GitHub</a>). This form is intended to be used on smaller websites, where manual notifications suffice. The specified message is sent upon saving the form.';