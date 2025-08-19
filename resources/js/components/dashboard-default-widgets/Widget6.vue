<template>
  <div class="card card-flush">
    <!--begin::Header-->
    <div class="card-header pt-5">
      <!--begin::Title-->
      <h3 class="card-title align-items-start flex-column">
        <span class="card-label fw-bold text-dark">Recent Orders</span>
        <!-- <span class="text-gray-400 mt-1 fw-semibold fs-6"
          >Users from all channels</span
        > -->
      </h3>
      <!--end::Title-->

      <!--begin::Toolbar-->
      <!-- <div class="card-toolbar">
        <ul class="nav" id="kt_chart_widget_8_tabs">
          <li class="nav-item">
            <a
              class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1"
              data-bs-toggle="tab"
              id="kt_chart_widget_8_week_toggle"
              href="#kt_chart_widget_8_week_tab"
              >Month</a
            >
          </li>

          <li class="nav-item">
            <a
              class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 active"
              data-bs-toggle="tab"
              id="kt_chart_widget_8_month_toggle"
              href="#kt_chart_widget_8_month_tab"
              >Week</a
            >
          </li>
        </ul>
      </div> -->
      <!--end::Toolbar-->
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body pt-6">
        <Datatable
          @on-sort="sort"
          @on-items-select="onItemSelect"
          :data="tableData"
          :header="tableHeader"
        >
          <template v-slot:order_id="{ row: customer }">
            <a
            role="button"
            class="sm light active-primary"
                  data-bs-toggle="modal"
                  @click="updateOrder(customer.uuid)"
                  data-bs-target="#kt_modal_update_order"
                  >{{ customer.order_id }}</a>

          </template>
          <template v-slot:client_name="{ row: customer }">
            <router-link
                  to="/apps/customers/customer-details"
                      @click="setID(customer.client.uuid)"
                  > {{ customer.client.name }}</router-link>
          </template>
          <template v-slot:technology="{ row: customer }">
            {{ customer.technology.name }}
          </template>
          <template v-slot:material="{ row: customer }">
              {{ customer.material.name}}
          </template>

          <template v-slot:confirmation_date="{ row: customer }">
                {{ customer.confirmation_date }}
         </template>
          <template v-slot:expected_delivery_date="{ row: customer }">
                {{ customer.expected_delivery_date }}
         </template>
          <template v-slot:inquiry_date="{ row: customer }">
                {{ customer.inquiry_date }}
         </template>
          <template v-slot:order_status="{ row: customer }">
                {{ customer.order_status.name}}
         </template>

          <!-- <template v-slot:actions="{ row: customer }"> -->
            <!-- <a
              href="#"
              class="btn btn-sm btn-light btn-active-light-primary"
              data-kt-menu-trigger="click"
              data-kt-menu-placement="bottom-end"
              data-kt-menu-flip="top-end"
              >Actions
              <KTIcon icon-name="down" icon-class="fs-5 m-0" />
            </a> -->
            <!--begin::Menu-->
            <!-- <div
              class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semobold fs-7 w-125px py-4"
              data-kt-menu="true"
            > -->
            <!-- <div class="col-6" style="display:flex;"> -->
              <!--begin::Menu item-->
              <!-- <div class="menu-item px-3"> -->
                <!-- <router-link
                  to="/apps/customers/customer-details"
              class="btn btn-sm btn-light btn-active-primary"
                  >View</router-link
                > -->
                <!-- <router-link
                  to="/apps/order/customer-details"  class="btn btn-sm btn-light btn-active-primary"

                  >Details</router-link> -->

                  <!-- <a
                  class="btn btn-sm btn-light btn-active-primary"
                  type="button"
                  data-bs-toggle="modal"
                  @click="updateOrder(customer.uuid)"
                  data-bs-target="#kt_modal_update_order"
                  >Update</a>
                 <a
                   type="button"
                   class="btn btn-sm btn-light btn-active-primary"
                   @click="DeleteConfirmation(customer.uuid)">
                   Delete
                 </a> -->

              <!-- </div> -->
              <!--end::Menu item-->
            <!-- </div> -->
            <!--end::Menu-->
          <!-- </template> -->
        </Datatable>
      </div>
    <!--end::Body-->
  </div>

</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { defineComponent, onMounted, ref ,watch} from "vue";
import Datatable from "@/components/kt-datatable/KTDataTable.vue";
import type { Sort } from "@/components/kt-datatable//table-partials/models";
import ExportCustomerModal from "@/components/modals/forms/ExportCustomerModal.vue";
import moment from 'moment';
import type { ICustomer } from "@/core/data/customers";
import customers from "@/core/data/customers";
import arraySort from "array-sort";
import { MenuComponent } from "@/assets/ts/components";
import ApiService from "@/core/services/ApiService";
import Swal from "sweetalert2/dist/sweetalert2.js";

export default defineComponent({
  name: "customers-listing",
  components: {
    Datatable,
    ExportCustomerModal,
  },
methods: {

DeleteConfirmation(uuid) {
Swal.fire({
  title: "Are you sure?",
  text: "You are about to delete this record.",
  icon: "warning",
  showCancelButton: true,
  confirmButtonText: "Yes, delete it!",
  cancelButtonText: "No, keep it",
}).then((result) => {
  if (result.value) {
    this.deleteCustomer(uuid);
  }
});
},
},

  setup() {
    const tableHeader = ref([
      {
        columnName: "Order Id",
        columnLabel: "order_id",
        sortEnabled: true,
        columnWidth: 175,
      },
      {
        columnName: "Client Name",
        columnLabel: "client_name",
        sortEnabled: true,
        columnWidth: 150,
      },
      {
        columnName: "Technology",
        columnLabel: "technology",
        sortEnabled: true,
        columnWidth: 150,
      },
      {
        columnName: "Material",
        columnLabel: "material",
        sortEnabled: true,
        columnWidth: 175,
      },
      {
        columnName: "Confirmation Date",
        columnLabel: "confirmation_date",
        sortEnabled: true,
        columnWidth: 175,
      },
      {
        columnName: "Expected Delivery Date",
        columnLabel: "expected_delivery_date",
        sortEnabled: true,
        columnWidth: 175,
      },
      {
        columnName: "Inquiry Date",
        columnLabel: "inquiry_date",
        sortEnabled: true,
        columnWidth: 175,
      },
      {
        columnName: "Status",
        columnLabel: "order_status",
        sortEnabled: true,
        columnWidth: 175,
      },
    //   {
    //     columnName: "Actions",
    //     columnLabel: "actions",
    //     sortEnabled: false,
    //     columnWidth: 125,
    //   },
    ]);


  const selectedIds = ref<Array<number>>([]);
  // const tableData = ref<Array<ICustomer>>(customers);
  const tableData = ref<Array<ICustomer>>([]);
  const initCustomers = ref<Array<ICustomer>>([]);

      const fetchAllOrder = ()=>{
      ApiService.get("/api/recent-order")
      .then(({data}) => {
        if(data.success == true){
           tableData.value = data.data;
           initCustomers.value = data.data;

       }else{

       }
      })
      .catch(({ response }) => {
          console.log(response);
      });
      initCustomers.value.splice(0, tableData.value.length, ...tableData.value);
      }

    onMounted(() => {
      fetchAllOrder();

    });

    const handleOrderAdded = () => {
      fetchAllOrder();
  };

      watch(() => {
        document.addEventListener("orderAdded", handleOrderAdded);
      });



    const deleteFewCustomers = () => {
      selectedIds.value.forEach((item) => {
        deleteCustomer(item);
      });
      selectedIds.value.length = 0;
    };

    const orderData = ref<Array<ICustomer>>([]);
    const updateCustomerData = ref(null);
    const updateOrder = (id:number)=>{

      const requestData = {
          order_uuid: id,
      };

      ApiService.post("/api/get-order",requestData)
      .then(({data}) => {
        if(data.success == true){
          // console.log(data);
          orderData.value = data.data

       }else{

       }
      })
      .catch(({ response }) => {
          console.log(response);
      });

    }

    const deleteCustomer = (id: number) => {
      const requestData = {
          order_uuid: id,
      };

      ApiService.post("/api/delete-order",requestData)
      .then(({data}) => {
          console.log(data);
        if(data.success == true){
          for (let i = 0; i < tableData.value.length; i++) {
              if (tableData.value[i].uuid == id) {
              tableData.value.splice(i, 1);
           }
          }

       }else{

       }
      })
      .catch(({ response }) => {
          console.log(response);
      });
    };

    const setID = (id:number)=>{
      localStorage.setItem('selectedID',id);
   }

  const search = ref<string>("");
      const searchItems = () => {
if (search.value !== "") {
  const searchTerm = search.value.toLowerCase();
  tableData.value = initCustomers.value.filter((customer) => {
    return (
      customer.client.name.toLowerCase().includes(searchTerm) ||
      customer.technology.name.toLowerCase().includes(searchTerm) ||
      customer.material.name.toLowerCase().includes(searchTerm) ||
      customer.order_status.name.toLowerCase().includes(searchTerm) ||
      customer.order_id.toString().includes(searchTerm) ||
      customer.confirmation_date.includes(searchTerm) ||
      customer.expected_delivery_date.includes(searchTerm) ||
      customer.inquiry_date.includes(searchTerm)
    );
  });
} else {
  tableData.value = [...initCustomers.value];
}
};


  const searchingFunc = (obj: any, value: string): boolean => {
    for (let key in obj) {
      if (!Number.isInteger(obj[key]) && !(typeof obj[key] === "object")) {
        if(obj.name.toLowerCase().indexOf(value.toLowerCase()) != -1){
          return true;
        }
      }
    }
    return false;
  };

    const sort = (sort: Sort) => {
      const reverse: boolean = sort.order === "asc";
      if (sort.label) {
        arraySort(tableData.value, sort.label, { reverse });
      }
    };
    const onItemSelect = (selectedItems: Array<number>) => {
      selectedIds.value = selectedItems;
    };

    return {
      tableData,
      tableHeader,
      deleteCustomer,
      search,
      searchItems,
      selectedIds,
      deleteFewCustomers,
      sort,
      onItemSelect,
      updateOrder,
      getAssetPath,
      updateCustomerData,
      setID,
      orderData,
    };
  },
});
</script>
