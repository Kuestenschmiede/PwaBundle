/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package   	con4gis
 * @version    6
 * @author  	con4gis contributors (see "authors.txt")
 * @license 	LGPL-3.0-or-later
 * @copyright 	Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
 */

if ('serviceWorker' in navigator) {
  navigator.serviceWorker.ready.then(function(registration) {
    if ('PushManager' in window) {
      registration.pushManager.getSubscription()
        .then(function(subscription) {
          if (!(subscription === null)) {
            // user is subscribed
            updateSubscriptionButton(true);
          } else {
            updateSubscriptionButton(false);
          }
        });
    } else {
      document.getElementById('btn-push-subscribe').style.display = "none";
    }
  });
}

function updateSubscriptionButton(isSubscribed) {
  let button = document.getElementById('btn-push-subscribe');

  if (isSubscribed) {
    button.innerHTML = document.getElementById('text-unsubscribe').innerText;//'Unsubscribe notifications';
    button.onclick = null;
    button.onclick = function(event) {
      navigator.serviceWorker.getRegistration().then(reg => unsubscribeNotifications(reg.pushManager));
    };
  } else {
    button.innerHTML = document.getElementById('text-subscribe').innerText;
    button.onclick = null;
    button.onclick = function(event) {
      navigator.serviceWorker.getRegistration().then(reg => registerForPush(reg.pushManager));
    };
  }
}

function unsubscribeNotifications(pushManager) {
  pushManager.getSubscription().then(function(subscription) {
    let endpoint = subscription.endpoint;
    subscription.unsubscribe().then(function (success) {
      jQuery.ajax('/con4gis/pushSubscription', {
        method: 'DELETE',
        data: {endpoint: endpoint}
      }).done(function(data) {
        updateSubscriptionButton(false);
      });
    }).catch(function(error) {
        window.alert("Unsubscription failed");
    });
  });
}

function registerForPush(pushManager) {
  jQuery.ajax('/con4gis/pushSubscription/getKey').done(function(data) {
    let key = urlB64ToUint8Array(data.key);
    const options = {userVisibleOnly: true, applicationServerKey: key};

    pushManager.subscribe(options)
      .then(pushSubscription => {
        // user has allowed the subscription
        // send the subscription to server
        let data = pushSubscription.toJSON();
        data.subscriptionType = document.getElementById('subscription-type').innerText;
        jQuery.ajax('/con4gis/pushSubscription', {
          method: 'POST',
          data: data
        }).done(function(data) {
          updateSubscriptionButton(true);
        });
      }).catch(error => {
      console.log(error);
    });
  });
}

function urlB64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - base64String.length % 4) % 4);
  const base64 = (base64String + padding)
    .replace(/\-/g, '+')
    .replace(/_/g, '/');

  const rawData = window.atob(base64);
  const outputArray = new Uint8Array(rawData.length);

  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
}