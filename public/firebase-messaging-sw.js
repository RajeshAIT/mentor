// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: 'AIzaSyBqkk704v_Rl-P1B-XzH-EuhBYBwj2tgBI',
    authDomain: 'mentor-2c598.firebaseapp.com',
    databaseURL: 'https://"mentor-2c598.firebaseio.com',
    projectId: 'mentor-2c598',
    storageBucket: 'mentor-2c598.appspot.com',
    messagingSenderId: '502711347094',
    appId: '1:502711347094:web:325ddab2a7c7872ec31fb7',
    measurementId: 'G-JF7L5FXQ9M',
}); 


// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message received.", payload);

    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };

    return self.registration.showNotification(
        title,
        options,
    );
});
