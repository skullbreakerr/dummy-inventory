<template>
  <!--begin::Menu-->
  <div
    class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px"
    data-kt-menu="true"
  >
    <!--begin::Heading-->
    <div
      class="d-flex flex-column bgi-no-repeat rounded-top border"
    >
      <!--begin::Title-->
      <h3 class="text-primary fw-semobold px-9 mt-10 mb-6">
        Notifications <span class="fs-8 opacity-75 ps-3"></span>
      </h3>
      <!--end::Title-->

      <!--begin::Tabs-->
      <!-- <ul
        class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semobold px-9"
      >
        <li class="nav-item">
          <a
            class="nav-link text-white opacity-75 opacity-state-100 pb-4"
            data-bs-toggle="tab"
            href="#kt_topbar_notifications_1"
            >Alerts</a
          >
        </li>

        <li class="nav-item">
          <a
            class="nav-link text-white opacity-75 opacity-state-100 pb-4 active"
            data-bs-toggle="tab"
            href="#kt_topbar_notifications_2"
            >Updates</a
          >
        </li>

        <li class="nav-item">
          <a
            class="nav-link text-white opacity-75 opacity-state-100 pb-4"
            data-bs-toggle="tab"
            href="#kt_topbar_notifications_3"
            >Logs</a
          >
        </li>
      </ul> -->
      <!--end::Tabs-->
    </div>
    <!--end::Heading-->
    <!--begin::Tab content-->
    <div class="tab-content">
      <!--begin::Tab panel-->
      <!--end::Tab panel-->
      <!--begin::Tab panel-->
      <div
        class="tab-pane fade show active"
        id="kt_topbar_notifications_2"
        role="tabpanel"
      >
      <div v-if="sortedNotificationList.length <= 0" class="d-flex justify-content-center h-325px align-items-center  my-5 px-8">
        <!-- <span  class="spinner-border spinner-border-sm align-middle ms-2"></span> -->
        <label class="px-2" for="message">No New Notification</label>
      </div>
        <!--begin::Wrapper-->
        <div v-else class="scroll-y mh-325px my-5 px-8">
          <template v-for="(item, index) in sortedNotificationList.reverse()" :key="index">
            <!--begin::Item-->
            <div v-if="item.sender_role.role === 'Admin' && item.type === 'order'" @click="listOrder( item.sender_id, item.receiver_id , item.type ,item.order_id )" style="cursor: pointer;" class="d-flex flex-stack py-4">
              <!--begin::Section-->
              <div  class="d-flex align-items-center">
                <!--begin::Symbol-->
                <div class="symbol symbol-35px me-4">
                  <span :class="`bg-light-primary`" class="symbol-label">
                    <KTIcon
                      :icon-name="item.type === 'chat'?'message-text' : 'truck'"
                      :icon-class="`text-primary`"
                    />
                  </span>
                </div>
                <!--end::Symbol-->

                <!--begin::Title-->
                <div class="mb-0 me-2">
                  <div 
                    style="cursor: pointer;"
                    class="fs-6 text-gray-800 text-hover-primary fw-bold"
                    >{{ item.sender_name }}</div>
                  <div class="text-gray-400 fs-7">
                    {{ item.message }}
                  </div>
                </div>
                <!--end::Title-->
              </div>
              <!--end::Section-->

              <!--begin::Label-->
              <span class="badge badge-light fs-8">{{ formatDate(item.created_at) }}</span>
              <!--end::Label-->
            </div>
            <div v-if="item.sender_role.role === 'Admin' && item.type === 'chat'" id="kt_drawer_chat_toggle"  @click="checkCount(item.sender_id, item.receiver_id , item.type, null)" style="cursor: pointer;" class="d-flex flex-stack py-4">
              <!--begin::Section-->
              <div  class="d-flex align-items-center">
                <!--begin::Symbol-->
                <div class="symbol symbol-35px me-4">
                  <span :class="`bg-light-primary`" class="symbol-label">
                    <KTIcon
                      :icon-name="item.type === 'chat'?'message-text' : 'truck'"
                      :icon-class="`text-primary`"
                    />
                  </span>
                </div>
                <!--end::Symbol-->

                <!--begin::Title-->
                <div class="mb-0 me-2">
                  <div 
                    style="cursor: pointer;"
                    class="fs-6 text-gray-800 text-hover-primary fw-bold"
                    >{{ item.sender_name }}</div>
                  <div class="text-gray-400 fs-7">
                    {{ item.message }}
                  </div>
                </div>
                <!--end::Title-->
              </div>
              <!--end::Section-->

              <!--begin::Label-->
              <span class="badge badge-light fs-8">{{ formatDate(item.created_at) }}</span>
              <!--end::Label-->
            </div>
            <div v-if="item.sender_role.role === 'Client'"  @click="connectChat(item.sender_id, item.receiver_id)" style="cursor: pointer;"  class="d-flex flex-stack py-4">
              <!--begin::Section-->
              <div class="d-flex align-items-center">
                <!--begin::Symbol-->
                <div class="symbol symbol-35px me-4">
                  <span :class="`bg-light-primary`" class="symbol-label">
                    <KTIcon
                      :icon-name="item.type === 'chat'?'message-text' : 'truck'"
                      :icon-class="`text-primary`"
                    />
                  </span>
                </div>
                <!--end::Symbol-->

                <!--begin::Title-->
                <div class="mb-0 me-2">
                  <div
                    class="fs-6 text-gray-800 text-hover-primary fw-bold"
                    >{{ item.sender_name }}</div>
                  <div class="text-gray-400 fs-7">
                    {{ item.message }}
                  </div>
                </div>
                <!--end::Title-->
              </div>
              <!--end::Section-->

              <!--begin::Label-->
              <span class="badge badge-light fs-8">{{ formatDate(item.created_at) }}</span>
              <!--end::Label-->
            </div>
            <!--end::Item-->
          </template>
        </div>
        <!--end::Wrapper-->
      </div>
      <!--end::Tab panel-->

      <!--begin::Tab panel-->
      <!--end::Tab panel-->
    </div>
    <!--end::Tab content-->
  </div>
  <!--end::Menu-->
</template>

<script lang="ts">
import { getAssetPath, getIllustrationsPath } from "@/core/helpers/assets";
import { computed, defineComponent, onMounted, ref } from "vue";
import { useAuthStore } from "../../../stores/auth";
import { useRoute, useRouter } from "vue-router";
import ApiService from "@/core/services/ApiService";

export default defineComponent({
  name: "notifications-menu",
  components: {},
  setup() {

    const store = useAuthStore();
    const notiData = ref([]);
    const route = useRouter();
    const formatDate = (dateString) => {
  const date = new Date(dateString);
  const currentDate = new Date();

  const diffTime = Math.abs(currentDate - date);
  const diffHours = Math.ceil(diffTime / (1000 * 60 * 60));
  const diffMinutes = Math.ceil(diffTime / (1000 * 60));

  if (diffMinutes < 60) {
    return `${diffMinutes} ${diffMinutes > 1 ? 'minutes' : 'minute'} ago`;
  } else if (diffHours < 5) {
    return `${diffHours} ${diffHours > 1 ? 'hours' : 'hour'} ago`;
  } else {
    const day = date.getDate();
    const month = date.toLocaleString('default', { month: 'short' });
    const hours = date.getHours();
    const minutes = (date.getMinutes() < 10 ? '0' : '') + date.getMinutes();

    return `${day} ${month}, ${hours}:${minutes}`;
  }
};
const sortedNotificationList = computed(() => {
      return store.notificationList.slice().reverse();
    });
    const connectChat = (id, revId) => {
      checkCount(id, revId, 'chat', null);
      store.getUserChat(id);
      // localStorage.setItem('chatID', id);
        route.push({ name: "apps-private-chat" });
    }
    const checkCount = async (senderID, revId, type, order_id) => {
      const id = localStorage.getItem('notiID');
      const requestData = {
        id: senderID,
        receiver_id: revId,
        type: type,
      }
      if (type === 'order') {
        requestData.order_id = order_id;
      }
      await ApiService.post("/api/mark-all-read", requestData)
        .then(({ data }) => {
          store.getNotify(null);
        })
                .catch((error) => { });  
    }
    const listOrder = (senderId , revId, type, order_id) => {
      checkCount(senderId, revId, type, order_id);
      route.push('/apps/orders/orders-details/' + order_id);
    }

    return {
      store,
      notiData,
      getIllustrationsPath,
      getAssetPath,
      formatDate,
      connectChat,
      sortedNotificationList,
      listOrder,
      checkCount,
    };
  },
});
</script>
