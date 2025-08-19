<template>
    <div class="card card-flush" :class="className">
        <!--begin::Header-->
        <div class="card-header pt-7">
            <!--begin::Title-->
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-800"
                    >Recent Orders</span
                >
                <!-- <span class="text-gray-400 mt-1 fw-semibold fs-6">Updated 37 minutes ago</span> -->
            </h3>
            <!--end::Title-->

            <!--begin::Toolbar-->
            <div class="card-toolbar">
                <!-- <a href="#" class="btn btn-sm btn-light">History</a> -->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body pt-6">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table
                    class="table table-row-dashed align-middle gs-0 gy-3 my-0"
                >
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                            <th class="p-0 pb-3 min-w-100px text-center">ID</th>
                            <th v-if="currentUserData.role?.role === 'Admin'" class="p-0 pb-3 min-w-100px text-center">
                                Client
                            </th>
                            <th class="p-0 pb-3 min-w-100px text-center">
                                Complete
                            </th>
                            <th class="p-0 pb-3 min-w-100px text-center">
                                Technology
                            </th>
                            <th class="p-0 pb-3 min-w-175px text-center">
                                Material
                            </th>
                            <th class="p-0 pb-3 min-w-175px text-center">
                                Inquiry Date
                            </th>
                            <th class="p-0 pb-3 min-w-175px text-center">
                                Confirmation Date
                            </th>
                            <th class="p-0 pb-3 min-w-175px text-center">
                                E.Delivery Date
                            </th>
                            <th class="p-0 pb-3 min-w-175px text-center">
                                Status
                            </th>
                            <th class="p-0 pb-3 min-w-175px text-center">
                                Delivery Status
                            </th>
                            <th class="p-0 pb-3 w-50px text-center">VIEW</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->

                    <!--begin::Table body-->
                    <tbody>
                        <tr v-for="(row, i) in table" :key="i">
                            <td>
                                <div class="d-flex align-items-center">
                                    <!-- <div class="symbol symbol-50px me-3">
                                        You can add an image here if needed
                                    </div> -->

                                    <div
                                        class="d-flex justify-content-center flex-column aliegn-items-center"
                                    >
                                        <!-- <router-link href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{ row.order_id }}</a> -->
                                        <router-link
                                            :to="
                                                '/apps/orders/orders-details/' +
                                                row.uuid
                                            "
                                            class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6 text-center"
                                        >
                                            {{ row.order_id }}
                                        </router-link>
                                        <!-- <span class="text-gray-400 fw-semibold d-block fs-7">{{ row.client.name }}</span> -->
                                    </div>
                                </div>
                            </td>

                            <td v-if="currentUserData.role?.role === 'Admin'" class="text-center">
                                <span
                                    class="text-gray-600 fw-bold fs-6 text-center"
                                    >{{ row.client.name }}</span
                                >
                            </td>

                            <td class="text-center">
                                <span
                                    class="text-gray-600 fw-bold fs-6 text-center"
                                >
                                    <div>
                                        <div class="progress">
                                            <div
                                                id="dynamic"
                                                class="progress-bar progress-bar-success progress-bar-striped active"
                                                role="progressbar"
                                                aria-valuenow="0"
                                                aria-valuemin="0"
                                                aria-valuemax="100"
                                                :style="{
                                                    width:
                                                        calculateProgressBarWidth(
                                                            row.order_status
                                                                .name
                                                        ) + '%',
                                                }"
                                            >
                                                {{
                                                    calculateProgressBarWidth(
                                                        row.order_status.name
                                                    )
                                                }}% Complete
                                            </div>
                                        </div>
                                    </div>
                                </span>
                            </td>

                            <td class="text-center pe-0">
                                <span
                                    class="text-gray-600 fw-bold fs-6 text-center"
                                    >{{ row.technology.name }}</span
                                >
                            </td>
                            <td class="text-center pe-0">
                                <span
                                    class="text-gray-600 fw-bold fs-6 text-center"
                                    >{{ row.material.name }}</span
                                >
                            </td>
                            <td class="text-center pe-0">
                                <span
                                    class="text-gray-600 fw-bold fs-6 text-center"
                                    >{{ row.inquiry_date }}</span
                                >
                            </td>
                            <td class="text-center pe-0">
                                <span
                                    class="text-gray-600 fw-bold fs-6 text-center"
                                    >{{ row.confirmation_date }}</span
                                >
                            </td>
                            <td class="text-center pe-0">
                                <span
                                    class="text-gray-600 fw-bold fs-6 text-center"
                                    >{{ row.expected_delivery_date }}</span
                                >
                            </td>

                            <td class="text-center pe-0">
                                <span
                                    class="text-gray-600 fw-bold fs-6 text-center"
                                    >{{ row.order_status.name }}</span
                                >
                            </td>
                            <td class="text-center pe-0">
                                <span
                                    class="text-gray-600 fw-bold fs-6 text-center"
                                >
                                    {{ calculateDelayStatus(row) }}
                                </span>
                            </td>

                            <td class="text-center">
                                <router-link
                                    :to="
                                        '/apps/orders/orders-details/' +
                                        row.uuid
                                    "
                                    class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px"
                                >
                                    <i
                                        class="ki-duotone ki-black-right fs-2 text-gray-500"
                                    ></i>
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                    <!--end::Table body-->
                </table>
            </div>
            <!--end::Table-->
        </div>
        <!--end: Card Body-->
    </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, ref } from "vue";
import ApiService from "@/core/services/ApiService";
import moment from "moment";

export default defineComponent({
    name: "default-dashboard-widget-10",
    props: {
        className: { type: String, required: false },
    },
    methods: {
        calculateProgressBarWidth(orderStatus) {
            switch (orderStatus.toLowerCase()) {
                case "confirmation":
                    return 10;
                case "po pending":
                    return 20;
                case "po received":
                    return 30;
                case "pre-audit":
                    return 40;
                case "design modification":
                    return 50;
                case "3d printing":
                    return 60;
                case "post processing":
                    return 70;
                case "paint":
                    return 80;
                case "final audit":
                    return 90;
                case "shipped":
                    return 100;
                default:
                    return 0;
            }
        },
        calculateDelayStatus(customer) {
            const expectedDeliveryDate = moment(
                customer.expected_delivery_date,
                "DD-MM-YYYY"
            );
            const currentDate = moment(customer.shipped_date, "YYYY-MM-DD");

            const orderStatus = customer.order_status.name.toLowerCase();

            if (orderStatus === "shipped") {
                if (currentDate.isAfter(expectedDeliveryDate)) {
                    // Shipped and delayed
                    const delayDays = currentDate.diff(
                        expectedDeliveryDate,
                        "days"
                    );
                    return delayDays > 0
                        ? delayDays + " days Delay"
                        : "On Time";
                } else if (currentDate.isBefore(expectedDeliveryDate)) {
                    // Shipped and early
                    const earlyDays = expectedDeliveryDate.diff(
                        currentDate,
                        "days"
                    );
                    return earlyDays > 0
                        ? earlyDays + " days Early"
                        : "On Time";
                } else {
                    // Shipped and on time
                    return "On Time";
                }
            } else {
                // Not shipped, calculate dynamic delay
                const dynamicDelay = "---";
                return dynamicDelay;
            }
        },
    },
    setup() {
        const table = ref([]);
        const currentUserData = ref('');

        const fetchUser = (data) => {
            ApiService.post("/api/get-client",{user_uuid:data})
          .then(({data}) => {
          if(data.success == true){
              console.log(data);
  
              currentUserData.value = data.data;
          }else{
  
          }
          })
          .catch(({ response }) => {
              console.log(response);
          });
        }
        onMounted(() => {
            const id = localStorage.getItem('notiID');
            fetchUser(id);
            ApiService.get("/api/recent-order")
                .then(({ data }) => {
                    if (data.success == true) {
                        table.value = data.data; // Assuming that the data containing the project stats is in the "data" property
                    } else {
                        // Handle the case when the request is not successful
                    }
                })
                .catch(({ response }) => {
                    // Handle any errors
                    console.error(response);
                });
        });

        return {
            table,
            currentUserData
        };
    },
});
</script>
