// firebase.js
import { initializeApp } from 'firebase/app';
import { getMessaging, getToken } from 'firebase/messaging';

const firebaseConfig = {
    apiKey: "AIzaSyBpBZdrB7--4pEvciWnyK0bB9FA1TSE5Js",
    authDomain: "eeee-elvish-bhai.firebaseapp.com",
    projectId: "eeee-elvish-bhai",
    storageBucket: "eeee-elvish-bhai.appspot.com",
    messagingSenderId: "86564333714",
    appId: "1:86564333714:web:509fa77e5fa708a3811e4b",
    measurementId: "G-DPXPLSWGKQ"
};


const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

export { messaging, getToken };
