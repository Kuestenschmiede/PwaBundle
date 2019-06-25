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
import {getLanguage} from "./pwa-i18n";

var language = document.documentElement.getAttribute('lang');
var langConstants = getLanguage(language);

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
  let container = document.createElement("ul");
  container.className = "subscription-option-container";
  for (let key in options) {
    if (options.hasOwnProperty(key)) {
      let listItem = document.createElement('li');
      let input = document.createElement('input');
      input.type = "checkbox";
      input.id = 'subscription-option-' + key;
      input.name = key;
      let label = document.createElement('label');
      label.setAttribute('for', input.id);
      label.innerText = options[key];
      listItem.appendChild(input);
      listItem.appendChild(label);
      container.appendChild(listItem);
    }
  }
  return container;
}

function updateInputForm(inputForm, types) {
  let listItems = inputForm.childNodes;
  for (let i = 0; i < listItems.length; i++) {
    let checkbox = listItems[i].firstChild;
    if (types.includes(checkbox.name)) {
      checkbox.checked = true;
    }
  }
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
          jQuery.ajax('/con4gis/pushSubscription', {
            method: "PUT",
            data: {
              endpoint: endpoint,
              types: subscriptionTypes,
              moduleId: window.moduleId
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
        window.alert(langConstants.UNSUBSCRIPTION_FAIL);
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
    title: langConstants.DIALOG_TITLE,
    showCancelButton: true,
    confirmButtonText: langConstants.DIALOG_CONFIRM,
    cancelButtonText: langConstants.DIALOG_CANCEL
  }).then(confirmed => {
    if (confirmed) {
      let checkedOptions = [];
      let listItems = inputForm.childNodes;
      for (let i = 0; i < listItems.length; i++) {
        let checkbox = listItems[i].firstChild;
        if (checkbox.checked) {
          checkedOptions.push(checkbox.name);
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
        data.moduleId = window.moduleId;
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