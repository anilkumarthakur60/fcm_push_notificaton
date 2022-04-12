importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyCu709vqkvWoPcWjrZdWaC-cX98cgdbpiQ",
    projectId: "laravelfcmnotification",
    messagingSenderId: "157744396575",
    appId: "1:157744396575:web:f077b0d2ed3ad346db582a"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({ data: { title, body, icon } }) {
    return self.registration.showNotification(title, { body, icon });
});