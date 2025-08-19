<template>
    <!-- begin::Layout -->
    <div class="d-flex flex-column flex-lg-row">
        <!-- begin::Sidebar -->
        <div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">
            <!-- begin::Contacts -->
            <div class="card card-flush">
                <!-- begin::Card header -->
                <div class="card-header pt-7" id="kt_chat_contacts_header">
                    <!-- begin::Form -->
                    <form class="w-100 position-relative" autocomplete="off">
                        <!-- begin::Icon -->
                        <KTIcon icon-name="magnifier"
                            icon-class="fs-2 fs-lg-1 text-gray-500 position-absolute top-50 ms-5 translate-middle-y" />
                        <!-- end::Icon -->
                        <!-- begin::Input -->
                        <input v-model="searchText" type="text" class="form-control form-control-solid px-15" name="search"
                            placeholder="Search by username or email..." />
                        <!-- end::Input -->
                    </form>
                    <!-- end::Form -->
                </div>
                <!-- end::Card header -->
                <!-- begin::Card body -->
                <div class="card-body pt-5" id="kt_chat_contacts_body">
                    <!-- begin::List -->
                    <div class="scroll-y me-n5 pe-5 h-200px h-lg-auto" ref="clientInRefs" data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_contacts_header"
                        data-kt-scroll-wrappers="#kt_content, #kt_chat_contacts_body" data-kt-scroll-offset="0px">
                        <template v-for="(item, index) in filteredClients" :key="index">
                            <div @click="fetchUser(item.uuid)" class="d-flex flex-stack py-4" style="cursor: pointer;">
                                <!-- begin::Details -->
                                <div class="d-flex align-items-center">
                                    <!-- begin::Avatar -->
                                    <!-- end::Avatar -->
                                    <!-- begin::Details -->
                                    <div class="ms-5">
                                        <a class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">{{ item.name }}</a>
                                        <div class="fw-semobold text-gray-400">
                                            {{ item.email }}
                                        </div>
                                    </div>
                                    <!-- end::Details -->
                                </div>
                                <!-- end::Details -->
                                <!-- begin::Last seen -->
                                <div class="d-flex flex-column align-items-end ms-2">
                                    <span class="text-muted fs-7 mb-1">{{
                                        item.time
                                    }}</span>
                                </div>
                                <!-- end::Last seen -->
                            </div>
                        </template>
                    </div>
                    <!-- end::List -->
                </div>
                <!-- end::Card body -->
            </div>
            <!-- end::Contacts -->
        </div>
        <!-- end::Sidebar -->

        <!-- begin::Content -->
        <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
            <!-- begin::Messenger -->
            <div class="card" id="kt_chat_messenger">
                <!-- begin::Card header -->
                <div class="card-header" id="kt_chat_messenger_header">
                    <!-- begin::Title -->
                    <div class="card-title">
                        <!-- begin::User -->
                        <div class="d-flex justify-content-center flex-column me-3">
                            <div v-if="isGroupChat" class="symbol-group symbol-hover">
                                <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" :src="
                                        getAssetPath(
                                            'media/avatars/300-5.jpg'
                                        )
                                    " />
                                </div>
                                <!-- ... other symbols ... -->
                                <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_view_users">
                                    <span class="symbol-label fs-8 fw-bold" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                        title="" data-bs-original-title="View more users">+42</span>
                                </a>
                                <!-- end::All users -->
                            </div>
                            <template v-else>
                                <router-link to="/apps/customers/customer-details" @click="setID(userData.uuid)"
                                    class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1">{{ userData.name
                                    }}</router-link>
                                <!-- ... other user details ... -->
                            </template>
                        </div>
                        <!-- end::User -->
                    </div>
                    <!-- end::Title -->
                    <!-- begin::Card toolbar -->
                    <div class="card-toolbar">
                        <!-- begin::Menu -->

                        <!-- end::Menu -->
                    </div>
                    <!-- end::Card toolbar -->
                </div>
                <!-- end::Card header -->
                <!-- begin::Card body -->
                <div class="card-body" id="kt_chat_messenger_body">
                    <!-- begin::Messages -->
                    <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" ref="messagesRef" data-kt-element="messages"
                        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                        data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_app_toolbar, #kt_toolbar, #kt_footer, #kt_app_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer"
                        data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_messenger_body"
                        data-kt-scroll-offset="5px">
                        <template v-for="(item, index) in messages" :key="index">
                            <MessageIn ref="messagesInRefs" v-if="item.type === 'in'" :name="item.name" :image="item?.image"
                                :fileUrl="item?.fileUrl" :fileExtension="item?.fileExtension" :fileName="item?.fileName"
                                :time="formatDate(item.time)" :text="item.text"></MessageIn>
                            <MessageOut ref="messagesOutRefs" v-if="item.type === 'out'" :image="item.image"
                                :fileUrl="item?.fileUrl" :fileExtension="item?.fileExtension" :fileName="item?.fileName"
                                :time="formatDate(item.time)" :text="item.text"></MessageOut>
                        </template>
                    </div>
                    <!-- end::Messages -->
                </div>
                <!-- end::Card body -->
                <!-- begin::Card footer -->
                <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                    <!-- begin::Input -->
                    <!-- <input v-model="newMessageText" @keydown.enter="addNewMessage"  class="form-control form-control-flush mb-3" data-kt-element="input" placeholder="Type a message" /> -->
                        <textarea v-model="newMessageText" @enter="addNewMessage" placeholder="Type a message" data-kt-element="input" name="" id="" cols="30" rows="3" class="form-control form-control-flush mb-3">
                        </textarea>
                    <!-- end::Input -->
                    <!-- begin:Toolbar -->
                    <div class="d-flex flex-stack">
                        <!-- begin::Actions -->
                        <div class="d-flex me-2">
                            <!-- <button
                                class="btn btn-sm btn-icon btn-active-light-primary me-1"
                                type="button"
                                data-bs-toggle="tooltip"
                                title="Coming soon"
                            >
                                <i class="bi bi-paperclip fs-3"></i>
                            </button> -->
                            <div class="input-group mb-3">
                                <input type="file" ref="file" @change="handleFileUpload" placeholder="Please Upload Image"
                                    class="form-control" id="fileInput" style="display: none" />
                                <label for="fileInput" class="btn btn-sm btn-icon btn-active-light-primary me-1">
                                    <i class="bi bi-upload fs-3"></i>
                                </label>
                                <span class="align-items-center d-flex" v-if="fileName">{{ fileName }}</span>
                            </div>
                        </div>
                        <!-- end::Actions -->
                        <!-- begin::Send -->
                        <button @click="addNewMessage" class="btn btn-primary" type="button" data-kt-element="send">
                            Send
                        </button>
                        <!-- end::Send -->
                    </div>
                    <!-- end::Toolbar -->
                </div>
                <!-- end::Card footer -->
            </div>
            <!-- end::Messenger -->
        </div>
    </div>
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { computed, defineComponent, ref, onMounted, watch } from "vue";
import { useRoute } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import Dropdown4 from "@/components/dropdown/Dropdown4.vue";
import contacts from "@/core/data/contacts";
import MessageIn from "@/components/messenger-parts/MessageIn.vue";
import MessageOut from "@/components/messenger-parts/MessageOut.vue";
import ApiService from "@/core/services/ApiService";
import { initializeApp } from "firebase/app";
import {
    getStorage,
    ref as FstorageRef,
    uploadBytesResumable,
    getDownloadURL,
} from "firebase/storage";
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

interface clientDetails {
    address: string;
    name: string;
    uuid: string;
    mobile: string;
    email: string;
}

export default defineComponent({
    name: "private-chat",
    components: {
        MessageIn,
        MessageOut,
        Dropdown4,
    },
    setup() {
        const messagesRef = ref<null | HTMLElement>(null);
        const messagesInRefs = ref<null | HTMLElement>(null);
        const messagesOutRefs = ref<null | HTMLElement>(null);
        const clientInRefs = ref<null | HTMLElement>(null);
        const room = ref("");
        const route = useRoute();
        const store = useAuthStore();
        const isChat = ref('');
        const messages = ref<Array<KTMessage>>([
            // Your initial messages data here
        ]);

        const fileToUpload = ref(null);
        const searchText = ref("");

        const filteredClients = computed(() => {
            if (!searchText.value) {
                return clients.value;
            } else {
                const query = searchText.value.toLowerCase();
                return clients.value.filter((client) => {
                    return (
                        client.name.toLowerCase().includes(query) ||
                        client.email.toLowerCase().includes(query)
                    );
                });
            }
        });
        const userData = ref([]);
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
        const activeChat = ref('');
        const fetchUser = async (id) => {
            messages.value = [];
            const requestedData = {
                user_uuid: id,
            };

            await ApiService.post("/api/get-client", requestedData)
                .then(({ data }) => {
                    if (data.success == true) {
                        userData.value = data.data;
                        room.value = data.data.uuid;
                    } else {
                    }
                })
                .catch(({ response }) => { });

            const db = await config();
            const roomRef = Fref(db, `chatRooms/${room.value}`);
            onValue(roomRef, (snapshot) => {
                messages.value = [];
                if (snapshot.exists()) {
                    const roomData = snapshot.val();
                    // alert(roomData.length);
                    for (const key in roomData) {
                        if (roomData.hasOwnProperty(key) && roomData[key]["timestamp"]) {
                            if (roomData[key]["sender_id"] != room.value) {
                                messages.value.push({
                                    type: "out",
                                    image: getAssetPath(
                                        "images/profile_icon.png"
                                    ),
                                    fileUrl: roomData[key]["fileUrl"],
                                    fileExtension: roomData[key]["fileExtension"],
                                    fileName: roomData[key]["fileName"],
                                    time: roomData[key]["timestamp"],
                                    text: roomData[key]["message"],
                                });
                                // store.getNotify(null);
                            } else {
                                messages.value.push({
                                    type: "in",
                                    name: getClientName(roomData[key]["sender_id"]),
                                    image: getAssetPath(
                                        "images/profile_icon.png"
                                    ),
                                    fileUrl: roomData[key]["fileUrl"],
                                    fileExtension: roomData[key]["fileExtension"],
                                    fileName: roomData[key]["fileName"],
                                    time: roomData[key]["timestamp"],
                                    text: roomData[key]["message"],
                                });
                                // store.getNotify(null);
                            }
                        }
                    }
                } else {
                    console.log("Room does not exist.");
                }
                setTimeout(() => {
                    if (messagesRef.value) {
                        messagesRef.value.scrollTop = messagesRef.value.scrollHeight;
                    }
                }, 1000);
                // store.getNotify(null);
            });
            await setTimeout(() => {
                if (messagesRef.value) {
                    messagesRef.value.scrollTop = messagesRef.value.scrollHeight;

                }
            }, 1000);
            store.getNotify(null);
            activeChat.value = id;
            console.log(messages.value);
        };
        const formatDate = (timestamp) => {
            const today = new Date();
            const date = new Date(timestamp);

            if (date.getDate() === today.getDate() && date.getMonth() === today.getMonth() && date.getFullYear() === today.getFullYear()) {
                const hours = date.getHours();
                const minutes = date.getMinutes();
                const amOrPm = hours >= 12 ? 'pm' : 'am';
                const formattedTime = `${hours % 12 || 12}:${minutes.toString().padStart(2, '0')} ${amOrPm}`;
                return `Today ${formattedTime}`;
            }

            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            const formattedDate = date.toLocaleDateString('en-US', options);

            const hours = date.getHours();
            const minutes = date.getMinutes();
            const amOrPm = hours >= 12 ? 'pm' : 'am';
            const formattedTime = `${hours % 12 || 12}:${minutes.toString().padStart(2, '0')} ${amOrPm}`;

            return `${formattedDate} ${formattedTime}`;
        };
        const newMessageText = ref("");
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

            await setTimeout(() => {
                if (messagesRef.value) {
                    messagesRef.value.scrollTop =
                        messagesRef.value.scrollHeight;
                }
            }, 1);
        };
        const updateTime = async (reveiverId, time) => {
            await ApiService.post("/api/edit-chattime", { id: reveiverId, time: time }).then(({ data }) => {
                fetchClient();
                setTimeout(() => {
                    if (clientInRefs.value) {
                        clientInRefs.value.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                }, 500);
            })
        }
        const addNewMessage = async () => {

            const newMessage = newMessageText.value;
            const htmlMessage = newMessage.replace(/\n/g,"</br>");

            if (file.value) {
                await uploadFile();
            }
            if (!newMessageText.value && !file.value) {
                return;
            }
            await ApiService.get("/api/user-details")
                .then(({ data }) => {
                    if (data.success == true) {
                        if (data.data.role.role == "Admin") {
                            triggerNotification(data.data.uuid, userData.value.uuid, file.value ? 'file' : newMessageText.value);

                            // const htmlMessage = newMessageText.value.replace(/\n/g, '<br/>');

                            // alert(htmlMessage);
                            createRoom(room.value, data.data.uuid, htmlMessage);
                            updateTime(room.value, chatDate());
                            newMessageText.value = "";
                        } else {
                            createRoom(
                                data.data.uuid,
                                data.data.uuid,
                                htmlMessage,
                            );
                            newMessageText.value = "";
                        }
                    } else {
                        // Handle error
                    }
                })
                .catch(({ response }) => { });

            newMessageText.value = "";
            file.value = null;
            fileName.value = null;
            filePath.value = null;
            fileExtension.value = null;
        };
        const file = ref(null);
        const filePath = ref(null);
        const fileExtension = ref(null);
        const fileName = ref(null);

        const handleFileUpload = (event) => {
            file.value = event.target.files[0];
            fileExtension.value = file.value.type;
            fileName.value = file.value.name;
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

        const fetchClient = async () => {
            await ApiService.post("/api/all-chat-client")
                .then(({ data }) => {
                    if (data.success == true) {
                        clients.value = data.data;
                    } else {
                    }
                })
                .catch(({ response }) => {

                });
        }

        const latestChat = computed(() => {
            fetchUser(store.activeChatid)
            return store.activeChatid;
        });
        const clients = ref<clientDetails[]>([]);
        onMounted(async () => {
            await fetchClient();
            isChat.value = store.activeChatid;
            if (isChat.value) {
                fetchUser(isChat.value);
                localStorage.removeItem('chatID');
            }
            if (!isChat.value) {
                fetchUser(clients.value[0].uuid)
            }
        });
        const getClientName = (id) => {
            const client = clients.value.find((c) => c.uuid === id);
            return client ? client.name : "Unknown";
        };
        const triggerNotification = async (senderId, recId, value: any) => {
            const requestData = {
                title: "Admin",
                message: value,
                sender_id: senderId,
                receiver_id: recId,
                type: 'chat'
            };

            await ApiService.post("/api/send-notification", requestData)
                .then(({ data }) => {
                    store.getNotify(null);
                })
                .catch((error) => { });
        };
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

            const firebaseApp = initializeApp(firebaseConfig);
            const db = getDatabase(firebaseApp);
            return db;
        };
        let timeout;

        function debounce(func, delay) {
            clearTimeout(timeout);
            timeout = setTimeout(func, delay);
        }

        const setID = (id: number) => {
            localStorage.setItem("selectedID", id);
        };


        watch(
            () => store.notificationList,
            () => {
                debounce(fetchClient, 300);
            }
        );

        const isGroupChat = computed(() => {
            return route.path.indexOf("/group-chat") !== -1;
        });

        return {
            messages,
            messagesRef,
            newMessageText,
            addNewMessage,
            messagesInRefs,
            messagesOutRefs,
            contacts,
            isGroupChat,
            getAssetPath,
            clients,
            fetchUser,
            userData,
            filteredClients,
            searchText,
            clientInRefs,
            uploadFile,
            handleFileUpload,
            fileName,
            formatDate,
            activeChat,
            setID
        };
    },
});
</script>
