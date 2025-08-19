<template>
  <div class="card">
    <div class="card-header border-0 pt-6">
      <div class="card-title">
        <div class="card-title">
          <div class="d-flex align-items-center position-relative my-1">
            <KTIcon icon-name="magnifier" icon-class="fs-1 position-absolute ms-6" />
            <input
              type="text"
              @input="debouncedSearchItems($event)"
              class="form-control form-control-solid w-250px ps-15"
              placeholder="Search Activities"
              autocomplete="off"
            />
          </div>
        </div>
      </div>
      <div class="card-toolbar">
        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
          <!-- <button
            type="button"
            class="btn btn-light-primary me-3"
            data-bs-toggle="modal"
            data-bs-target="#kt_customers_export_modal"
          >
            <KTIcon icon-name="exit-up" icon-class="fs-2" />
            Export
          </button> -->
          <button
            type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#kt_modal_add_customer"
            @click="openAddModal()"
          >
            <KTIcon icon-name="plus" icon-class="fs-2" />
            <!-- Add Customer -->
          </button>
        </div>
        <!-- <div
          v-else
          class="d-flex justify-content-end align-items-center"
          data-kt-customer-table-toolbar="selected"
        >
          <div class="fw-bold me-5">
            <span class="me-2">{{ selectedIds.length }}</span
            >Selected
          </div>
          <button
            type="button"
            class="btn btn-danger"
            @click="deleteFewCustomers()"
          >
            Delete Selected
          </button>
        </div>
        <div
          class="d-flex justify-content-end align-items-center d-none"
          data-kt-customer-table-toolbar="selected"
        >
          <div class="fw-bold me-5">
            <span
              class="me-2"
              data-kt-customer-table-select="selected_count"
            ></span
            >Selected
          </div>
          <button
            type="button"
            class="btn btn-danger"
            data-kt-customer-table-select="delete_selected"
          >
            Delete Selected
          </button>
        </div> -->
      </div>
    </div>
    <div class="card-body pt-0">
      <!-- <Datatable @on-sort="sort" @on-items-select="onItemSelect" :data="tableData" :header="tableHeader"
                    :enable-items-per-page-dropdown="true" checkbox-label="id" @page-change="page = $event"
                    :items-per-page="meta.per_page" @on-items-per-page-change="perPage = $event"
                    :items-per-page-dropdown-enabled="true" :checkbox-enabled="false" :total="meta.total"> -->
      <!-- <div v-if="loading">
        <div class="text-center">
          <el-spinner size="large" />
        </div>
      </div> -->
      <Datatable
        @on-sort="sort"
        @on-items-select="onItemSelect"
        :data="inventoryData"
        :header="tableHeader"
        :enable-items-per-page-dropdown="true"
        checkbox-label="id"
        @page-change="page = $event"
        :items-per-page="meta.per_page"
        @on-items-per-page-change="perPage = $event"
        :items-per-page-dropdown-enabled="true"
        :checkbox-enabled="true"
        :total="meta.total"
      >
        <!-- <template v-slot:name="{ row: item }">
                    <router-link to="/apps/customers/customer-details" @click="setID(customer.uuid)">
                        {{ customer.name }}</router-link>
                </template> -->
        <template v-slot:item="{ row: item }">
          {{ item.item.name }}
        </template>
        <template v-slot:quantity="{ row: item }">
          {{ item.item.qty }}
        </template>
        <template v-slot:per_unit_price="{ row: item }">
          {{ item.item.unit_price }}
        </template>
        <template v-slot:price="{ row: item }">
          {{ item.item.total_value }}
        </template>
        <template v-slot:seller="{ row: item }">
          {{ item.item.seller }}
        </template>
        <template v-slot:status="{ row: item }">
          <el-radio-group v-model="item.status" size="small" @change="updateStatus(item)">
            <el-radio-button label="In Stock" value="In Stock">In</el-radio-button>
            <el-radio-button label="Out Of Stock" value="Out Of Stock"
              >Out</el-radio-button
            >
          </el-radio-group>
        </template>
        <template v-slot:actions="{ row: item }">
          <a
            class="btn btn-sm btn-primary btn-active-light-primary me-2"
            @click="openEditModal(item.item)"
            >Edit
            <!-- <KTIcon icon-name="down" icon-class="fs-5 m-0" /> -->
          </a>
          <a
            class="btn btn-sm btn-light btn-active-light-danger"
            @click="deleteRecord(item)"
            >Delete
            <!-- <KTIcon icon-name="down" icon-class="fs-5 m-0" /> -->
          </a>
        </template>
      </Datatable>
    </div>
    <!-- <pre>{{ inventoryStore.inventoryData.length }}</pre>
    <pre>{{ inventoryData.length }}</pre>
    <pre>{{meta }}</pre> -->
  </div>
  <Form
    v-if="showModal"
    :name="formName"
    :formData="formData"
    :formRules="formRules"
    :formFields="formFields"
    @submitForm="handleSubmit"
    @cancel="showModal = !showModal"
  />
</template>
<script>
import Datatable from "@/components/kt-datatable/KTDataTable.vue";
import {
  defineComponent,
  handleError,
  onMounted,
  reactive,
  ref,
  watch,
  computed,
  watchEffect,
} from "vue";
import debounce from "lodash/debounce";
import { useInventoryStore } from "../../../stores/inventory.js";
import { Modal } from "bootstrap";
import Swal from "sweetalert2";
import ApiService from "@/core/services/ApiService";
import Form from "../../../components/modals/forms/Form.vue";
import { ElMessage } from "element-plus";
export default defineComponent({
  name: "inventory-listing",
  components: {
    Datatable,
    Form,
  },
  setup() {
    const formData = reactive({
      name: "",
      qty: 0,
      unit_price: 0,
      seller: "",
      total_value: 0,
      location: "",
      // category:'',
    });
    const formRules = ref({
      name: [
        {
          required: true,
          message: "Please Enter Name",
        },
      ],
      qty: [
        {
          required: true,
          message: "Please Enter Quantity",
        },
      ],
      unit_price: [
        {
          required: true,
          message: "Please Enter Unit Price",
        },
      ],
      seller: [
        {
          required: true,
          message: "Please Enter Seller",
        },
      ],
      location: [
        {
          required: true,
          message: "Please Enter the Location",
        },
      ],
      total_value: [
        {
          required: true,
          message: "Please Enter Total Value",
        },
      ],
      // category:[{ required:true,}]
    });
    const formFields = ref([
      {
        label: "Item",
        prop: "name",
        type: "text",
        placeholder: "Enter item name",
      },
      {
        label: "Quantity",
        prop: "qty",
        type: "number",
        placeholder: "Enter quantity",
        change: (e) => {
          formData.total_value = formData.qty * formData.unit_price;
        },
      },
      {
        label: "Per Unit Price",
        prop: "unit_price",
        type: "number",
        placeholder: "Enter per unit price",
        change: (e) => {
          formData.total_value = formData.qty * formData.unit_price;
        },
      },
      {
        label: "Seller",
        prop: "seller",
        type: "text",
        placeholder: "Enter seller name",
      },
      {
        label: "Total Value",
        prop: "total_value",
        type: "number",
        placeholder: "Enter total value",
        disabled: true,
      },
      {
        label: "Location",
        prop: "location",
        type: "text",
        placeholder: "Enter location",
      },
      // {
      //     label:'Category',
      //     prop:'category',
      //     type:'select',
      //     placeholder:'Select Category',
      //     options:[
      //         {name:'Electronics',uuid:'electronics'},
      //         {name:'Clothing',uuid:'clothing'},
      //         {name:'Grocery',uuid:'grocery'},
      //         {name:'Furniture',uuid:'furniture'},
      //         {name:'Stationary',uuid:'stationary'},
      //         {name:'Others',uuid:'others'},
      //     ],
      //     transformOptions:(option)=>({label:option.name, value:option.uuid}),
      // }
    ]);
    const showModal = ref(false);
    const formName = ref("");
    const tableHeader = ref([
      {
        columnName: "Item",
        columnLabel: "item",
        columnWidth: 175,
      },
      {
        columnName: "Per Unit Price",
        columnLabel: "per_unit_price",
        columnWidth: 50,
      },
      {
        columnName: "Quantity",
        columnLabel: "quantity",
        columnWidth: 50,
      },
      {
        columnName: "Price",
        columnLabel: "price",
        columnWidth: 50,
      },
      {
        columnName: "Seller",
        columnLabel: "seller",
        columnWidth: 75,
      },
      {
        columnName: "Status",
        columnLabel: "status",
        columnWidth: 50,
      },
      {
        columnName: "Actions",
        columnLabel: "actions",
        columnWidth: 135,
      },
    ]);
    const inventoryStore = useInventoryStore();
    const inventoryData = computed(()=> inventoryStore.getInventoryData);
    const loading = computed (()=> inventoryStore.isLoading);
    const perPage = ref(10);
    const page = ref(1);
    const search = ref("");
    const meta = computed(()=> inventoryStore.getInventoryMeta);
    const data = ref({
      status: "1",
      filter: "",
      orderId: "",
      author: true,
      customer: true,
      notifications: true,
      startDate: "",
      endDate: "",
    });

    const fetchInventoryData = async (startDate, endDate) => {
      const rqData = {
        perPage: perPage.value,
        page: page.value,
        startDate: startDate ? startDate + " 00:00:00" : "",
        endDate: endDate ? endDate + " 23:59:59" : "",
        filter: data.value.filter,
        orderId: data.value.orderId,
        search: search.value,
      };
    //   if (inventoryStore.getInventoryData(rqData).length === 0) {
        // await inventoryStore.fetchInventoryData(rqData);
    //     inventoryData.value = inventoryStore.getInventoryData(rqData);
    // } else {
    //     inventoryData.value = inventoryStore.getInventoryData(rqData);
    // }
    await inventoryStore.fetchInventoryData(rqData);
    };

    const debouncedSearchItems = debounce((event) => {
      search.value = event.target.value;
      console.log("Value: ", event.target.value);
    }, 500);

    watch([perPage, page, search], () => {
      fetchInventoryData(data.value.startDate, data.value.endDate);
    });
    onMounted(() => {
      fetchInventoryData(data.value.startDate, data.value.endDate);
    });

    const openAddModal = () => {
      formName.value = "Add Data To Inventory";
      // const modal = new Modal(document.getElementById('addModal'))
      // Modal.getInstance(document.getElementById('kt_modal_add_form')).show();
      showModal.value = true;
    };
    const updateStatus = async (item) => {
      const requestData = {
        uuid: item.uuid,
        status: item.status,
      };
      try {
        const { data } = await ApiService.post("/api/update-inventory", requestData);
        if (data.success) {
          inventoryStore.updateInventory(data.data);
          ElMessage({ message: "Status Updated Successfully!!", type: "success" });
        } else {
          ElMessage({ message: "Error in Updating Status!!", type: "error" });
        }
      } catch (error) {
        console.log("Error in (update-inventory): ", error);
        ElMessage({ message: error.message, type: "error" });
      }
    };
    const openEditModal = (item) => {
      formName.value = "Update Data To Inventory";
      Object.keys(formData).forEach((key) => {
        formData[key] = item[key];
      });
      formData.uuid = item.uuid;
      console.log("UpdateForm: ", formData.value);
      showModal.value = true;
    };
    const handleSubmit = async () => {
      try {
        const endpoint =
          formName.value === "Update Data To Inventory"
            ? "api/update-inventory"
            : "api/add-inventory";
        const { data } = await ApiService.post(endpoint, formData);
        if (data.success) {
          endpoint === "api/update-inventory"
            ? inventoryStore.updateInventory(data.data)
            : inventoryStore.addInventoryData(data.data);
          // showModal.value = !showModal.value;
          Swal.fire({
            title: "Success",
            text: "Inventory Added Successfully",
            icon: "success",
            timer: 3000,
          });
        }
      } catch (error) {
        console.error("Error in Adding Inventory", error);
      }
    };

    const deleteRecord = async (item) => {
      try {
        const { data } = await ApiService.get(`/api/delete-inventory?sdx=${item.uuid}`);
        if (data.success) {
          inventoryStore.deleteInventory(item.uuid);
          ElMessage({ message: "Record Deleted Successfully!!", type: "success" });
        }
      } catch (error) {
        console.error("Error in (delete-inventory): ", error);
        ElMessage({ message: error.message, type: "error" });
      }
    };
    return {
      loading,
      debouncedSearchItems,
      inventoryStore,
      meta,
      perPage,
      page,
      search,
      data,
      updateStatus,
      formName,
      openEditModal,
      deleteRecord,
      openAddModal,
      handleSubmit,
      formFields,
      showModal,
      formData,
      formRules,
      inventoryData,
      tableHeader,
    };
  },
});
</script>
