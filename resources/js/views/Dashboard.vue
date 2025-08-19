<template>
    <div class="row mb-10">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                <div class="row">
                    <div v-if="role === 'Admin'" class="col-lg-6 col-md-6 col-sm-12 col-xl-4 mt-5">
                            <router-link to="/apps/customers/customers-listing">
                                <div
    class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end hover-card"
    :class="className"
    :style="{ backgroundColor: bgColor, backgroundImage: `url('${bgImage}')` }"
  >
    <!--begin::Header-->
    <div class="card-header pt-8 pb-6">
      <!--begin::Title-->
      <div class="card-title d-flex flex-column">
        <!--begin::Amount-->
        <span class="fs-2hx fw-bold card-text me-2 lh-1 ls-n2">{{ dataCount.customers }}</span>
        <!--end::Amount-->

        <!--begin::Subtitle-->
        <span class="opacity-50 card-text pt-1 fw-semibold fs-6">Customers</span>
        <!--end::Subtitle-->
      </div>
      <KTIcon icon-name="user" class="card-text" style="font-size: 4rem;"/>
      <!--end::Title-->
    </div>
    <!--end::Header-->

    <!--begin::Card body-->
    
    <!--end::Card body-->
  </div>
                            </router-link>
                    </div>

                    <div v-if="role === 'Admin'" class="col-lg-6 col-md-6 col-sm-12 col-xl-4 mt-5">
                        <router-link to="/apps/orders/orders-listing">

<div
    class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end hover-card"
    :class="className"
    :style="{ backgroundColor: bgColor, backgroundImage: `url('${bgImage}')` }"
  >
    <!--begin::Header-->
    <div class="card-header pt-8 pb-6">
      <!--begin::Title-->
      <div class="card-title d-flex flex-column">
        <!--begin::Amount-->
        <span class="fs-2hx fw-bold card-text me-2 lh-1 ls-n2">{{ dataCount.orders }}</span>
        <!--end::Amount-->

        <!--begin::Subtitle-->
        <span class="card-text opacity-50 pt-1 fw-semibold fs-6">Orders</span>
        <!--end::Subtitle-->
      </div>
      <KTIcon icon-name="delivery" class="card-text" style="font-size: 4rem;"/>
      <!--end::Title-->
    </div>
    <!--end::Header-->

    <!--begin::Card body-->
    <!--end::Card body-->
  </div>
                                </router-link>

                    </div>

                    <div v-if="role === 'Admin'" class="col-lg-6 col-md-6 col-sm-12 col-xl-4 mt-5">
                        <router-link to="/apps/knowledge-center/knowledge-center-listing">
                            <div
    class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end hover-card"
    :class="className"
    :style="{ backgroundColor: bgColor, backgroundImage: `url('${bgImage}')` }"
  >
    <!--begin::Header-->
    <div class="card-header pt-8 pb-6">
      <!--begin::Title-->
      <div class="card-title d-flex flex-column">
        <!--begin::Amount-->
        <span class="fs-2hx fw-bold card-text me-2 lh-1 ls-n2">{{ dataCount.articles }}</span>
        <!--end::Amount-->

        <!--begin::Subtitle-->
        <span class="card-text opacity-50 pt-1 fw-semibold fs-6">Articles</span>
        <!--end::Subtitle-->
      </div>
      <KTIcon icon-name="book" class="card-text" style="font-size: 4rem;"/>
      <!--end::Title-->
    </div>
    <!--end::Header-->

    <!--begin::Card body-->

    <!--end::Card body-->
  </div>

                                </router-link>

                    </div>
                    <div v-if="role === 'Client'" class="col-lg-6 col-md-6 col-sm-12 col-xl-4 mt-5">
                        <router-link to="/apps/client-order/order-listing">
                            <div
    class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end hover-card"
    :class="className"
    :style="{ backgroundColor: bgColor, backgroundImage: `url('${bgImage}')` }"
  >
    <!--begin::Header-->
    <div class="card-header pt-8 pb-6">
      <!--begin::Title-->
      <div class="card-title d-flex flex-column">
        <!--begin::Amount-->
        <span class="fs-2hx fw-bold card-text me-2 lh-1 ls-n2">{{ clientCount.orders }}</span>
        <!--end::Amount-->

        <!--begin::Subtitle-->
        <span class="opacity-50 card-text pt-1 fw-semibold fs-6">Orders</span>
        <!--end::Subtitle-->
      </div>
      <KTIcon icon-name="delivery" class="card-text" style="font-size: 4rem;" />
      <!--end::Title-->
    </div>
    <!--end::Header-->

    <!--begin::Card body-->

    <!--end::Card body-->
  </div>

                                </router-link>

                    </div>
                    <div v-if="role === 'Client'" class="col-lg-6 col-md-6 col-sm-12 col-xl-4 mt-5">
                        <router-link to="/apps/client/client-order-detail">
                            <div
    class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end hover-card"
    :class="className"
    :style="{ backgroundColor: bgColor, backgroundImage: `url('${bgImage}')` }"
  >
    <!--begin::Header-->
    <div class="card-header pt-8 pb-6">
      <!--begin::Title-->
      <div class="card-title d-flex flex-column">
        <!--begin::Amount-->
        <span class="fs-2hx fw-bold card-text me-2 lh-1 ls-n2">{{ clientCount.files }}</span>
        <!--end::Amount-->

        <!--begin::Subtitle-->
        <span class="card-text opacity-50 pt-1 fw-semibold fs-6">Digital Inventory</span>
        <!--end::Subtitle-->
      </div>
      <KTIcon icon-name="some-files" class="card-text" style="font-size: 4rem;"/>
      <!--end::Title-->
    </div>
    <!--end::Header-->


    <!--end::Card body-->
  </div>

                                </router-link>

                    </div>
                    <div v-if="role === 'Client'" class="col-lg-6 col-md-6 col-sm-12 col-xl-4 mt-5">
                        <router-link to="/apps/knowledge-center/services">
                            <div
    class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end hover-card"
    :class="className"
    :style="{ backgroundColor: bgColor, backgroundImage: `url('${bgImage}')` }"
  >
    <!--begin::Header-->
    <div class="card-header pt-8 pb-6">
      <!--begin::Title-->
      <div class="card-title d-flex flex-column">
        <!--begin::Amount-->
        <span class="fs-2hx fw-bold card-text me-2 lh-1 ls-n2">{{ clientCount.services }}</span>
        <!--end::Amount-->

        <!--begin::Subtitle-->
        <span class="card-text opacity-50 pt-1 fw-semibold fs-6">Knowledge Center</span>
        <!--end::Subtitle-->
      </div>
      <KTIcon icon-name="book" class="card-text" style="font-size: 4rem;"/>
      <!--end::Title-->
    </div>
    <!--end::Header-->

    <!--begin::Card body-->
    <!--end::Card body-->
  </div>

                                </router-link>

                    </div>
                </div>
            </div>
        </div>
  <!--begin::Row-->
  <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <!--begin::Col-->
    <!-- <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">

      <Widget1
        className="h-md-50 mb-5 mb-xl-10"
        description="Active Projects"
        bgColor="#F1416C"
        :bgImage="getAssetPath('media/patterns/vector-1.png')"
      />

      <Widget2
        className="h-md-50 mb-5 mb-xl-10"
        :icon="false"
        stats="357"
        description="Professionals"
        labelColor="dark"
        textColor="gray-300"
      />
    </div> -->
    <!--end::Col-->

    <!--begin::Col-->
    <!-- <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
      <Widget3 className="h-md-50 mb-5 mb-xl-10" :chartSize="70" />

      <Widget4 className="h-lg-50" />
    </div> -->
    <!--end::Col-->

    <!--begin::Col-->
    <!-- <div class="col-xxl-6">
      <Widget5 className="h-md-100" />
    </div> -->
    <!--end::Col-->
  </div>
  <!--end::Row-->

  <!--begin::Row-->
  <!-- <div class="row gx-5 gx-xl-12"> -->
    <!--begin::Col-->
    <!-- <div class="col-xxl-6 mb-5 mb-xl-12">
      <Widget6 className="h-xl-100" height="275px" />
    </div> -->
    <!--end::Col-->

    <!--begin::Col-->
    <!-- <div class="col-xl-6 mb-5 mb-xl-10">
      <Widget7 className="h-xl-100" />
    </div> -->
    <!--end::Col-->
  <!-- </div> -->
  <!--end::Row-->

  <!--begin::Row-->
  <!-- <div class="row g-5 g-xl-10 mb-5 mb-xl-10"> -->
    <!--begin::Col-->
    <!-- <div class="col-xxl-6">
      <Widget8
        className="h-xl-100"
        :image="getAssetPath('media/stock/600x600/img-65.jpg')"
      />
    </div> -->
    <!--end::Col-->

    <!--begin::Col-->
    <!-- <div class="col-xl-6">
      <Widget9 className="h-lg-100" :height="300" />
    </div> -->
    <!--end::Col-->
  <!-- </div> -->
  <!--end::Row-->

  <!--begin::Row-->
  <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <!--begin::Col-->
    <!-- <div class="col-xl-4">
      <MixedWidget5
        widget-classes="card-xl-stretch mb-xl-8 h-md-100"
        chart-color="primary"
        chart-height="150"
      ></MixedWidget5>
    </div> -->
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-xl-12">
      <Widget10 className="h-md-100" />
    </div>
    <!--end::Col-->
  </div>
  <!--end::Row-->
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { defineComponent,onMounted ,ref} from "vue";
import Widget1 from "@/components/dashboard-default-widgets/Widget1.vue";
import Widget2 from "@/components/dashboard-default-widgets/Widget2.vue";
import Widget3 from "@/components/dashboard-default-widgets/Widget3.vue";
import Widget4 from "@/components/dashboard-default-widgets/Widget4.vue";
import Widget5 from "@/components/dashboard-default-widgets/Widget5.vue";
import Widget6 from "@/components/dashboard-default-widgets/Widget6.vue";
import Widget7 from "@/components/dashboard-default-widgets/Widget7.vue";
import Widget8 from "@/components/dashboard-default-widgets/Widget8.vue";
import Widget9 from "@/components/dashboard-default-widgets/Widget9.vue";
import Widget10 from "@/components/dashboard-default-widgets/Widget10.vue";
import MixedWidget5 from "@/components/widgets/mixed/Widget5.vue";
import ApiService from "@/core/services/ApiService";
import { useAuthStore } from "../stores/auth";

export default defineComponent({
  name: "main-dashboard",
  components: {
    Widget1,
    Widget2,
    Widget3,
    Widget4,
    Widget5,
    Widget6,
    Widget7,
    Widget8,
    Widget9,
    Widget10,
    MixedWidget5,
  },
  props: {
    className: { type: String, required: false },
    bgColor: { type: String, required: false, default: "#4682e3" },
    bgImage: { type: String, required: false },
    description: { type: String, required: true },
  },
  setup() {
    const dataCount = ref([]);
    const role = ref("");
    const clientCount = ref("");
    const store = useAuthStore();
    const userId = ref('');

    onMounted(() => {
      ApiService.get("/api/data-count")
        .then(({ data }) => {
          if (data.success == true) {
            dataCount.value = data.data
          } else {

          }
        })
        .catch(({ response }) => {
          console.log(response);
        });
      ApiService.get("/api/client-recent-order")
        .then(({ data }) => {
          if (data.success == true) {
            clientCount.value = data.data
          } else {

          }
        })
        .catch(({ response }) => {
          console.log(response);
        });

      ApiService.get("/api/user-details")
        .then(({ data }) => {
          if (data.success == true) {
            role.value = data.data.role.role;
            userId.value = data.data.uuid;
            // store.getNotify(userId.value);
          } else {

          }
        })
        .catch(({ response }) => {
          console.log(response);
        });
    });
    return {
      getAssetPath,dataCount,role,clientCount
    };
  },
});
</script>

<style scoped>
.hover-card{
  background: transparent !important;
}
.hover-card:hover{
  background: #4682e3 !important;
}
.hover-card .card-text{
  color: #4682e3 ;
}
.hover-card:hover .card-text{
  color: white;
}
</style>