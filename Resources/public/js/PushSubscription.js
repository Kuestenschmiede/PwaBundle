if ('serviceWorker' in navigator) {
  navigator.serviceWorker.ready.then(function(registration) {
    if ('PushManager' in window) {
      registerForPush(registration.pushManager);
    }
  });
}

function registerForPush(pushManager) {
  let key = urlB64ToUint8Array('BJkdzqcCVqbN_5sW8_iP-TDyY2pTxz82ONPkxF0K3mC5vYkizWj6DOEMBCUoWg6AlmQTg-1EFOVGLzA41VzuK48');
  const options = {userVisibleOnly: true, applicationServerKey: key};
  console.log(options);
  pushManager.subscribe(options)
    .then(pushSubscription => {
      // user has allowed the subscription
      // send the subscription to server
      jQuery.ajax('/con4gis/pushSubscription', {
        method: 'POST',
        data: pushSubscription.toJSON()
      });
      // fetch('/con4gis/pushSubscription', {
      //   method: 'POST',
      //   headers: {'Content-Type': 'application/json' },
      //   body: JSON.stringify(pushSubscription.toJSON())
      // });
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