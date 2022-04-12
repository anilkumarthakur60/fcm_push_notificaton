importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "xxxxxxxxxxxx",
    projectId: "lxxxxxxxxxxxxx",
    messagingSenderId: "xxxxxxxxxxxx",
    appId: "1:xxxxxxxxxxxx"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({ data: { title, body, icon } }) {
    return self.registration.showNotification(title, { body, icon });
});