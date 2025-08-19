<template>
    <!--begin::Chat drawer-->
    <div
        id="kt_drawer_chat"
        class="bg-body"
        data-kt-drawer="true"
        data-kt-drawer-name="chat"
        data-kt-drawer-activate="true"
        data-kt-drawer-overlay="true"
        data-kt-drawer-width="{default:'300px', 'md': '500px'}"
        data-kt-drawer-direction="end"
        data-kt-drawer-toggle="#kt_drawer_chat_toggle"
        data-kt-drawer-close="#kt_drawer_chat_close"
    >
        <!--begin::Messenger-->
        <div class="card w-100" id="kt_drawer_chat_messenger">
            <!--begin::Card header-->
            <div class="card-header pe-5" id="kt_drawer_chat_messenger_header">
                <!--begin::Title-->
                <div class="card-title">
                    <!--begin::User-->
                    <div class="d-flex justify-content-center flex-column me-3">
                        <a
                            href="#"
                            class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1"
                            >Admin</a
                        >

                        <!--begin::Info-->
                        <!-- <div class="mb-0 lh-1">
                            <span
                                class="badge badge-success badge-circle w-10px h-10px me-1"
                            ></span>
                            <span class="fs-7 fw-semobold text-gray-400"
                                >Active</span
                            >
                        </div> -->
                        <!--end::Info-->
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Menu-->
                    <!--end::Menu-->

                    <!--begin::Close-->
                    <div
                        class="btn btn-sm btn-icon btn-active-icon-primary"
                        id="kt_drawer_chat_close"
                    >
                        <KTIcon icon-name="cross" icon-class="fs-2x" />
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body" id="kt_drawer_chat_messenger_body">
                <!--begin::Messages-->
                <div
                    class="scroll-y me-n5 pe-5"
                    ref="messagesRef"
                    data-kt-element="messages"
                    data-kt-scroll="true"
                    data-kt-scroll-activate="true"
                    data-kt-scroll-height="auto"
                    data-kt-scroll-dependencies="#kt_drawer_chat_messenger_header, #kt_drawer_chat_messenger_footer"
                    data-kt-scroll-wrappers="#kt_drawer_chat_messenger_body"
                    data-kt-scroll-offset="0px"
                >
                    <template v-for="(item, index) in messages" :key="index">
                        <MessageIn
                            ref="messagesInRef"
                            v-if="item.type === 'in'"
                            :name="item.name"
                            :image="item.image"
                            :fileUrl="item.fileUrl"
                            :fileExtension="item?.fileExtension"
                            :fileName="item.fileName"
                            :time="item.time"
                            :text="item.text"
                        ></MessageIn>
                        <MessageOut
                            ref="messagesOutRef"
                            v-if="item.type === 'out'"
                            :image="item.image"
                            :time="item.time"
                            :fileUrl="item.fileUrl"
                            :fileExtension="item.fileExtension"
                            :fileName="item.fileName"
                            :text="item.text"
                        ></MessageOut>
                    </template>
                </div>
                <!--end::Messages-->
            </div>
            <!--end::Card body-->

            <!--begin::Card footer-->
            <div class="card-footer pt-4" id="kt_drawer_chat_messenger_footer">
                <!--begin::Input-->
                <!-- <input
                    class="form-control form-control-flush mb-3"
                    data-kt-element="input"
                    placeholder="Type a message"
                    v-model="newMessageText"
                    @keydown.enter="addNewMessage"
                /> -->
                <!--end::Input-->

                <textarea 
                    v-model="newMessageText" @enter="addNewMessage" 
                    placeholder="Type a message" 
                    data-kt-element="input" 
                    cols="30" 
                    rows="2" 
                    class="form-control form-control-flush mb-3"
                >
                
                </textarea>

                <!--begin:Toolbar-->
                <div class="d-flex flex-stack">
                    <!--begin::Actions-->
                    <div class="d-flex  me-2">
                        <!-- <button
                            class="btn btn-sm btn-icon btn-active-light-primary me-1"
                            type="button"
                            data-bs-toggle="tooltip"
                            title="Coming soon"
                        >
                            <i class="bi bi-paperclip fs-3"></i>
                        </button> -->
                        <div class="input-group mb-3">
                                <input
                                        type="file"
                                        ref="file"
                                        @change="handleFileUpload"
                                        placeholder="Please Upload Image"
                                        class="form-control"
                                        id="fileInput"
                                        style="display: none"
                                    />
                                <label
                                    for="fileInput"
                                    class="btn btn-sm btn-icon btn-active-light-primary me-1"
                                >
                                    <i class="bi bi-upload fs-3"></i>
                                </label>
                                <span class="align-items-center d-flex" v-if="fileName">{{ fileName }}</span>
                            </div>
                    </div>
                    <!--end::Actions-->

                    <!--begin::Send-->
                    <button
                        @click="addNewMessage"
                        class="btn btn-primary"
                        type="button"
                        data-kt-element="send"
                    >
                        Send
                    </button>
                    <!--end::Send-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card footer-->
        </div>
        <!--end::Messenger-->
    </div>
    <!--end::Chat drawer-->
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import {
    defineComponent,
    onMounted,
    ref,
    getCurrentInstance,
    watch,
} from "vue";
import MessageIn from "@/components/messenger-parts/MessageIn.vue";
import MessageOut from "@/components/messenger-parts/MessageOut.vue";
import Dropdown4 from "@/components/dropdown/Dropdown4.vue";
import ApiService from "@/core/services/ApiService";
import { initializeApp, getApps, getApp } from "firebase/app";
import {
    getDatabase,
    orderByChild,
    equalTo,
    get,
    onValue,
    ref as Fref,
    query as Fquery,
    push,
    set,
    serverTimestamp,
} from "firebase/database";
import { useAuthStore } from "../../../stores/auth";
interface KTMessage {
    type: string;
    name?: string;
    image: string;
    time: string;
    text: string;
    fileUrl: string;
    fileExtension: string;
    fileName: string;
}

export default defineComponent({
    name: "upgrade-to-pro",
    components: {
        MessageIn,
        MessageOut,
        Dropdown4,
    },
    setup() {
        const messagesRef = ref<null | HTMLElement>(null);
        const messagesInRef = ref<null | HTMLElement>(null);
        const messagesOutRef = ref<null | HTMLElement>(null);
        const store = useAuthStore();
        const messages = ref<Array<KTMessage>>([

        ]);

        const newMessageText = ref("");

        const config = () => {
            const firebaseConfig = {
                apiKey: "AIzaSyBpBZdrB7--4pEvciWnyK0bB9FA1TSE5Js",
                authDomain: "eeee-elvish-bhai.firebaseapp.com",
                databaseURL:
                    "https://eeee-elvish-bhai-default-rtdb.firebaseio.com/",
                projectId: "eeee-elvish-bhai",
                storageBucket: "eeee-elvish-bhai.appspot.com",
                messagingSenderId: "86564333714",
                appId: "1:86564333714:web:509fa77e5fa708a3811e4b",
                measurementId: "G-DPXPLSWGKQ",
            };

            const firebaseApp = getApps().length === 0 ? initializeApp(firebaseConfig) : getApp();;
            const db = getDatabase(firebaseApp);
            return db;
        };

        const room = ref("");
        onMounted(async () => {
            await ApiService.get("/api/user-details")
                .then(({ data }) => {
                    if (data.success == true) {
                        if (data.data.role.role == "Admin") {
                        } else {
                            room.value = data.data.uuid;
                        }
                    } else {
                    }
                })
                .catch(({ response }) => {});
            const db = await config();

            const roomRef = Fref(db, `chatRooms/${room.value}`);
            onValue(roomRef, (snapshot) => {
                messages.value = [];
                if (snapshot.exists()) {
                    const roomData = snapshot.val();
                    for (const key in roomData) {
                        if (roomData.hasOwnProperty(key)) {
                            // alert(roomData[key]['message'])
                            if (roomData[key]["sender_id"] == room.value) {
                                messages.value.push({
                                    type: "out",
                                    image: getAssetPath(
                                        "images/profile_icon.png"
                                    ),
                                    fileUrl: roomData[key]["fileUrl"],
                                    fileExtension: roomData[key]["fileExtension"],
                                    fileName: roomData[key]["fileName"],
                                    time: roomData[key]["time"],
                                    text: roomData[key]["message"],
                                });
                                // store.getNotify(null);
                            } else {
                                messages.value.push({
                                    type: "in",
                                    name: "Admin",
                                    image: getAssetPath(
                                        "images/profile_icon.png"
                                    ),
                                    fileUrl: roomData[key]["fileUrl"],
                                    fileExtension: roomData[key]["fileExtension"],
                                    fileName: roomData[key]["fileName"],
                                    time: roomData[key]["time"],
                                    text: roomData[key]["message"],
                                });
                                // store.getNotify(null);
                            }

                            // console.log(key, roomData[key]);
                        }
                    }
                } else {
                    console.log("Room does not exist.");
                }
                setTimeout(() => {
                if (messagesRef.value) {
                    messagesRef.value.scrollTop = messagesRef.value.scrollHeight;
                }
                store.getNotify(null);
                }, 1000);
            });
        });
        const triggerNotification = async (senderId, recId, title: string, value: string) => {
            const requestData = {
                title: title,
                message: value,
                sender_id: senderId,
                receiver_id: recId,
                type: 'chat'
            };

           await ApiService.post("/api/send-notification", requestData)
                .then(({ data }) => {
                 store.getNotify(null);
                })
                .catch((error) => {});
        };
        const file = ref(null);
        const filePath = ref(null);
        const fileName = ref(null);
        const fileExtension = ref(null);
        
const handleFileUpload = (event) => {
    file.value = event.target.files[0];
    fileName.value = file.value.name;
    fileExtension.value = file.value.type;
};

const uploadFile = async () => {
  let formData = new FormData();
  formData.append('image', file.value);

  try {
    const response = await ApiService.post('/api/chat-file', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    }).then(({ data }) => {
        filePath.value = data.original.image_path;
    });
    // handle the response and store the URL in Firebase or elsewhere
  } catch (error) {
    console.error(error);
  }
};

        const createRoom = async (id, senderId, message) => {
            const db = await config();
            const userId = id;
            const roomName = userId;

            const chatRoomsRef = Fref(db, `chatRooms/${roomName}`);
            const newRoomRef = push(chatRoomsRef);
            const currentDate = new Date();
            const currentTimeString = currentDate.toLocaleTimeString().replace(/(.*)\D\d+/, '$1');
            set(newRoomRef, {
                message: message,
                fileUrl: filePath.value ?? null,
                fileExtension: fileExtension.value ?? null,
                fileName: fileName.value ?? null,
                seen: false,
                time: currentTimeString,
                sender_id: senderId,
                timestamp: serverTimestamp(),
            });
            roomName.value = "";
            messages.value = [];
            console.log(messages.value);
        };

        const updateTime = async(reveiverId, time) => {
            await ApiService.post("/api/edit-chattime", { id: reveiverId, time: time }).then(({ data }) => {
            })
        }
        const chatDate = () => {
            const currentDate = new Date();

            const year = currentDate.getFullYear();
            const month = String(currentDate.getMonth() + 1).padStart(2, '0');
            const day = String(currentDate.getDate()).padStart(2, '0');
            const hours = String(currentDate.getHours()).padStart(2, '0');
            const minutes = String(currentDate.getMinutes()).padStart(2, '0');
            const seconds = String(currentDate.getSeconds()).padStart(2, '0');

            const formattedDateTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            return formattedDateTime
        }
        const addNewMessage = async () => {

            const newMessage = newMessageText.value;
            const htmlMessage = newMessage.replace(/\n/g,"</br>");

            if (!newMessageText.value  && !file.value) {
                return;
            }
            
            if (file.value) {
                await uploadFile();
            }

            // messages.value = [];
            await ApiService.get("/api/user-details")
                .then(({ data }) => {
                    if (data.success == true) {
                        if (data.data.role.role == "Admin") {
                            createRoom(
                                data.data.uuid,
                                data.data.uuid,
                                htmlMessage
                            );
                            // room id  , sender id ,message
                        } else {
                            createRoom(
                                data.data.uuid,
                                data.data.uuid,
                                htmlMessage
                            );
                            updateTime(data.data.uuid, chatDate());
                            triggerNotification(data.data.uuid, 'admin' ,data.data.name, (file.value ? 'file' : newMessageText.value));
                        }
                    } else {
                    }
                })
                .catch(({ response }) => {});
            //     messages.value.push({
            //     type: "out",
            //     image: getAssetPath("media/avatars/300-1.jpg"),
            //     time: "Just now",
            //     text: newMessageText.value,
            // });

            if (messagesRef.value) {
                    messagesRef.value.scrollTop =
                    messagesRef.value.scrollHeight;
                    // messagesRef.value.scrollIntoView({ behavior: "smooth" });

            }
            // setTimeout(() => {
            // }, 1000);
            newMessageText.value = "";
            file.value = null;
            filePath.value = null; 
            fileName.value = null;
            fileExtension.value = null;
        };

        return {
            messages,
            messagesRef,
            newMessageText,
            addNewMessage,
            messagesInRef,
            messagesOutRef,
            getAssetPath,
            handleFileUpload,
            uploadFile,
            fileName
        };
    },
});
</script>
