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

import Swal from 'sweetalert2';


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

function getTypeOptions() {
  let selectBox = document.getElementById('subscription-types');
  let options = {};
  let selectOptions = selectBox.options;
  for (let key in selectOptions) {
    if (selectOptions.hasOwnProperty(key)) {
      options[selectOptions[key].value] = selectOptions[key].label;
    }
  }
  return options;
}

function getInputForm(options) {
  let container = document.createElement("div");
  for (let key in options) {
    if (options.hasOwnProperty(key)) {
      let input = document.createElement('input');
      input.type = "checkbox";
      input.id = 'subscription-option-' + key;
      input.name = key;
      let label = document.createElement('label');
      label.setAttribute('for', input.id);
      label.innerText = options[key];
      container.appendChild(input);
      container.appendChild(label);
    }
  }
  return container;
}

function updateInputForm(inputForm, types) {
  let checkboxes = inputForm.childNodes;
  for (let i = 0; i < checkboxes.length; i++) {
    if (types.includes(checkboxes[i].name)) {
      checkboxes[i].checked = true;
    }
  }
  // TODO maybe return?
}

function updateSubscriptionButton(isSubscribed) {
  let button = document.getElementById('btn-push-subscribe');

  if (isSubscribed) {
    button.innerHTML = document.getElementById('text-unsubscribe').innerText;//'Unsubscribe notifications';
    button.onclick = null;
    button.onclick = function(event) {
      navigator.serviceWorker.getRegistration().then(reg => updateSubscription(reg.pushManager));
    };
  } else {
    button.innerHTML = document.getElementById('text-subscribe').innerText;
    button.onclick = null;
    button.onclick = function(event) {
      navigator.serviceWorker.getRegistration().then(reg => registerForPush(reg.pushManager));
    };
  }
}

function updateSubscription(pushManager) {
  const typeOptions = getTypeOptions();
  let inputForm = getInputForm(typeOptions);
  const selectionDisabled = getSelectionState();
  if (selectionDisabled) {
    // normal unsubscription
    unsubscribeNotifications(pushManager);
  } else {
    pushManager.getSubscription().then(function(subscription) {
      let endpoint = subscription.endpoint;
      jQuery.ajax('/con4gis/pushSubscription', {
        method: 'GET',
        data: {endpoint: endpoint}
      }).done(async function(data) {
        let subscribedTypes = data.types;
        updateInputForm(inputForm, subscribedTypes);
        let subscriptionTypes = await createSubscriptionDialog(inputForm);
        if (subscriptionTypes.length === 0) {
          unsubscribeNotifications(pushManager);
        } else {
          // TODO an server senden, damit der entsprechend updated
          jQuery.ajax('/con4gis/pushSubscription', {
            method: "PUT",
            data: {
              endpoint: endpoint,
              types: subscriptionTypes
            }
          });
        }
      });
    })
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

function getSelectionState() {
  let span = document.getElementById('selection-disabled');
  return !!span;
}

async function createSubscriptionDialog(inputForm) {
  return Swal.fire({
    html: inputForm,
    title: "Wähle die Aktionen, bei denen du benachrichtigt werden willst",
    showCancelButton: true,
    confirmButtonText: "Bestätigen",
    cancelButtonText: "Abbrechen"
  }).then(confirmed => {
    if (confirmed) {
      let checkedOptions = [];
      let checkboxes = inputForm.childNodes;
      for (let i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
          checkedOptions.push(checkboxes[i].name);
        }
      }
      return checkedOptions;
    } else {
      return false;
    }
  });
}

function registerForPush(pushManager) {
  jQuery.ajax('/con4gis/pushSubscription/getKey').done(function(data) {
    let key = urlB64ToUint8Array(data.key);
    const options = {userVisibleOnly: true, applicationServerKey: key};
    const typeOptions = getTypeOptions();
    const inputForm = getInputForm(typeOptions);
    const selectionDisabled = getSelectionState();
    pushManager.subscribe(options)
      .then(async function (pushSubscription) {
        let subscriptionType = "";
        if (selectionDisabled) {
          subscriptionType = Object.keys(typeOptions);
        } else {
          subscriptionType = await createSubscriptionDialog(inputForm);
        }
        if (subscriptionType.length === 0) {
          return false;
        }

        let data = pushSubscription.toJSON();
        data.subscriptionTypes = subscriptionType;
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