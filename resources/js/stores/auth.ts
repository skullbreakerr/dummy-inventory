import { ref } from "vue";
import { defineStore } from "pinia";
import ApiService from "@/core/services/ApiService";
import JwtService from "@/core/services/JwtService";
import { initializeApp } from "firebase/app";
// import { getMessaging , getToken, onMessage } from "firebase/messaging";
// // import  firebase  from 'firebase';
import { messaging, getToken, } from './firebase';


interface DesignationResource {
  uuid: string;
  name: string;
}

interface RoleResource {
  uuid: string;
  name: string;
}

export interface User {
  uuid: string;
  name: string;
  mobile: string;
  alt_mobile: string;
  email: string;
  company: string;
  address: string;
  designation: DesignationResource;
  role: RoleResource;
  created_at: string;
  updated_at: string;
  api_token: string;
}

export const useAuthStore = defineStore("auth", () => {
  const errors = ref({});
  const user = ref<User>({} as User);
  const notificationList = ref([]);
  const finalId= ref('');
  const notiCount= ref('');
  const isAuthenticated = ref(!!JwtService.getToken());
  const activeChatid = ref('');

  function setAuth(authUser: User) {
    isAuthenticated.value = true;
    user.value = authUser;
    errors.value = {};
    JwtService.saveToken(authUser.token);
  }

  function setError(error: any) {
    errors.value = { ...error };
  }

  function purgeAuth() {
    isAuthenticated.value = false;
    user.value = {} as User;
    errors.value = [];
    JwtService.destroyToken();
  }

  // function setDeviceToken(token){

  //   console.log(token)
  //   // alert(token);

  //   const data = {
  //     'token':token
  //   } 

  //     ApiService.setHeader();
  //     ApiService.post("set_device_token", { api_token: JwtService.getToken() },data)
  //       .then(({ data }) => {
  //         return;        
  //       })
  //       .catch(({ response }) => {
  //         console.log(response.data.errors);
  //       return;
  //       });

  //       return;
  // }
  // function requestPermission() {
  //   console.log('Requesting permission...');
  //   Notification.requestPermission().then((permission) => {
  //     if (permission === 'granted') {
  //       // alert('ok');

  //   getToken(messaging,{ vapidKey: "BHYO_aNScX__OkvDG-gmkHLJiIqegRyZJzWAbIQtqCMd_sFbyfFwz1ncYfqisfvlGY7n" }) 
  //     .then(currentToken => {
  //       console.log(currentToken);
  //       // alert(currentToken);
  //     });

  //     // alert('last')
  //     }else{
  //       // alert('bale bale')
  //     }
  //   })
  // }
  // const generateFcmToken = async () => {
  //   requestPermission();

  // };

  // const generateFcmToken =()=>{

  // const firebaseConfig = {
  //   apiKey: "AIzaSyAZW895vVsq-sGPPRm52fQI3V3j6yvylRc",
  //   authDomain: "push-project-e1ffa.firebaseapp.com",
  //   projectId: "push-project-e1ffa",
  //   storageBucket: "push-project-e1ffa.appspot.com",
  //   messagingSenderId: "237926722474",
  //   appId: "1:237926722474:web:46601acb7c7a30e8bc59d3",
  //   measurementId: "G-XQ36BHPE6Y",
  // };
  // firebase.initializeApp(firebaseConfig);
  // if ("Notification" in window && firebase.messaging.isSupported()) {
  //   const messaging = firebase.messaging();
  //   try {
  //     messaging
  //       .getToken({
  //         vapidKey:
  //           "BI-LFBucwec4l41jhP58h9z-HT7KSRzRlh84LSM8LboYSm7ksGCz_Mu4WZQAyPa7ZRMOyIlLy7xcjACK9YSmmVE",
  //       })
  //       .then((currentToken) => {
  //         if (currentToken) {
  //           //this.sendTokenToServer(currentToken);
  //           console.log(currentToken+" this is current token");
  //         } else {
  //           console.warn("Failed to get token.");
  //         }
  //       })
  //       .catch((err) => {
  //         console.log("An error occurred while retrieving token. ", err);
  //         //this.setTokenSentToServer(false);
  //       });
  //   } catch (e) {
  //     console.log(e);
  //   }
  // }
  // }


  function login(credentials: User) {
    return ApiService.post("login", credentials)
      .then(({ data }) => {
        if (data.success == true) {
          //  requestPermission();  
          setAuth(data);
          console.log(data);
          localStorage.setItem('notiID',data.data.uuid);
        } else {
          setError(data.errors);
        }
      })
      .catch(({ response }) => {
        setError(response.data.errors);
      });
  }

  function logout() {
    notificationList.value = [];
    purgeAuth();
  }

  function register(credentials: User) {
    return ApiService.post("register", credentials)
      .then(({ data }) => {
        setAuth(data);
      })
      .catch(({ response }) => {
        setError(response.data.errors);
      });
  }

  function forgotPassword(email: string) {
    return ApiService.post("forgot_password", email)
      .then(({ data }) => {
        // setError({});
        if (data.success == true) {
          setError(data.error)
        } else {
          setError(data.errors);
        }

      })
      .catch(({ response }) => {
        console.log(response);
        setError(response.data.errors);
      });
  }

  function verifyAuth() {
    if (JwtService.getToken()) {
      ApiService.setHeader();
      ApiService.post("verify_token", { api_token: JwtService.getToken() })
        .then(({ data }) => {
          setAuth(data);
          //   alert(data.success);
        })
        .catch(({ response }) => {
          alert(response.data.errors[0]);
          setError(response.data.errors);
          purgeAuth();
        });
    } else {
      purgeAuth();
    }
  }
  function getUserChat(id) {
    activeChatid.value = id;
  }
  function getNotify(id) {
    if (id === null) {
      finalId.value = localStorage.getItem('notiID');
    } else {
      finalId.value = id;
    }
    ApiService.post("/api/get-notification-list", { id: finalId.value })
        .then(({ data }) => {
          if (data.length >0) {
            notificationList.value = data.reverse();
            notiCount.value = notificationList.value.filter((notification) => !notification.is_read).length;
          } else {
            notificationList.value = [];
            notiCount.value = '';
          }
          //   alert(data.success);
        })
        .catch(({ response }) => {
          console.log(response.data);
        });
  }

  return {
    errors,
    user,
    isAuthenticated,
    login,
    logout,
    register,
    forgotPassword,
    verifyAuth,
    getNotify,
    notificationList,
    notiCount,
    activeChatid,
    getUserChat
  };
});
