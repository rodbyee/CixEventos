import { initializeApp } from "https://www.gstatic.com/firebasejs/12.12.1/firebase-app.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/12.12.1/firebase-analytics.js";

  const firebaseConfig = {
    apiKey: "AIzaSyBTzEWssvuFDhWK-Z3X32y1UICOv5oKbPc",
    authDomain: "cixeventos.firebaseapp.com",
    projectId: "cixeventos",
    storageBucket: "cixeventos.firebasestorage.app",
    messagingSenderId: "819405426399",
    appId: "1:819405426399:web:19d4af887230296ef3e36a",
    measurementId: "G-Z8KFH5V8PV"
  };

  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);