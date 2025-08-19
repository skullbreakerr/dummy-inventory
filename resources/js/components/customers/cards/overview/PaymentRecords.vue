<template>
    <div :class="`card  ${cardClasses}`">
      <div class="card-header border-0">
        <div class="card-title">
          <h2>Order Records</h2>
        </div>
        <div class="card-toolbar">
          <!-- <button
            type="button"
            class="btn btn-sm btn-flex btn-light-primary"
            data-bs-toggle="modal"
            data-bs-target="#kt_modal_add_payment"
          >
            <KTIcon icon-name="plus-square" icon-class="fs-3" />
            Add payment
          </button> -->
        </div>
      </div>
      <div class="card-body pt-0 pb-5">
        <Datatable
          :header="tableHeader"
          :data="tableData"
          :items-per-page="5"
          :items-per-page-dropdown-enabled="false"
        >
        <template v-slot:order_id="{ row: payment }">
          <!-- Use router-link to navigate to the order details page -->
          <router-link
            :to="'/apps/orders/orders-details/' + payment.uuid"
            class="sm light active-primary"
          >
            {{ payment.order_id }}
          </router-link>
        </template>
          <template v-slot:technology="{ row: payment }">{{ payment.technology.name }}</template>

          <template v-slot:material="{ row: payment }">{{ payment.material.name }}</template>
          <template v-slot:confirmation_date="{ row: payment }">{{ payment.confirmation_date }}</template>
          <template v-slot:expected_delivery_date="{ row: payment }">
            {{ payment.expected_delivery_date }}
          </template>
        </Datatable>
      </div>
    </div>
  </template>

  <script lang="ts">
  import { defineComponent, onMounted, ref } from "vue";
  import Datatable from "@/components/kt-datatable/KTDataTable.vue";
  import ApiService from "@/core/services/ApiService";

  export default defineComponent({
    name: "payment-records",
    props: {
      cardClasses: String,
    },
    components: {
      Datatable,
    },
    setup() {
      const tableHeader = [
        { columnName: "Order Id", columnLabel: "order_id", sortEnabled: true },
        {
          columnName: "Technology",
          columnLabel: "technology",
          sortEnabled: true,
        },
        { columnName: "Material", columnLabel: "material", sortEnabled: false },
        { columnName: "Confirm Date", columnLabel: "confirmation_date", sortEnabled: false},
        {
          columnName: "Exp Delivery Date",
          columnLabel: "expected_delivery_date",
          sortEnabled: false,
        },
      ];
      const tableData = ref([]);

      const fetchOrders = async () => {
        const id = localStorage.getItem("selectedID");
        const requestData = { user_uuid: id };

        try {
          const { data } = await ApiService.post("/api/users-orders", requestData);
          if (data.success) {
            tableData.value = data.data;
          } else {
            console.error("Failed to fetch orders:", data.message);
          }
        } catch (error) {
          console.error("Error fetching orders:", error);
        }
      };

      onMounted(() => {
        fetchOrders();
      });

      return { tableHeader, tableData };
    },
  });
  </script>
