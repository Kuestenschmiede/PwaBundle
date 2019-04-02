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
    }
  });
}

function updateSubscriptionButton(isSubscribed) {
  let button = document.getElementById('btn-push-subscribe');

  if (isSubscribed) {
    button.innerHTML = 'Unsubscribe notifications';
    button.onclick = null;
    button.onclick = function(event) {
      navigator.serviceWorker.getRegistration().then(reg => unsubscribeNotifications(reg.pushManager));
    };
  } else {
    button.innerHTML = 'Subscribe notifications';
    button.onclick = null;
    button.onclick = function(event) {
      navigator.serviceWorker.getRegistration().then(reg => registerForPush(reg.pushManager));
    };
  }
}

function unsubscribeNotifications(pushManager) {
  pushManager.getSubscription().then(function(subscription) {
    let endpoint = subscription.endpoint;
    jQuery.ajax('/con4gis/pushSubscription', {
      method: 'DELETE',
      data: {endpoint: endpoint}
    }).done(function(data) {
      updateSubscriptionButton(false);
    });
  });
}

function registerForPush(pushManager) {
  // TODO publicKey vom server abfragen
  let key = urlB64ToUint8Array('BJkdzqcCVqbN_5sW8_iP-TDyY2pTxz82ONPkxF0K3mC5vYkizWj6DOEMBCUoWg6AlmQTg-1EFOVGLzA41VzuK48');
  const options = {userVisibleOnly: true, applicationServerKey: key};

  pushManager.subscribe(options)
    .then(pushSubscription => {
      // user has allowed the subscription
      // send the subscription to server
      jQuery.ajax('/con4gis/pushSubscription', {
        method: 'POST',
        data: pushSubscription.toJSON()
      }).done(function(data) {
        updateSubscriptionButton(true);
      });
    }).catch(error => {
      console.log(error);
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