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
          <button
            type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#kt_modal_add_customer"
            @click="openModal('add')"
          >
            <KTIcon icon-name="plus" icon-class="fs-2" />
          </button>
        </div>
      </div>
    </div>
    <div class="card-body pt-0">
      <Datatable
        @on-sort="sort"
        @on-items-select="onItemSelect"
        :data="productData"
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
        <template v-slot:name="{ row: item }">
          {{ item.name }}
        </template>
        <template v-slot:product_code="{ row: item }">
          {{ item.product_code }}
        </template>
        <template v-slot:cost_price="{ row: item }">
          {{ item.cost_price }}
        </template>
        <template v-slot:actions="{ row: item }">
          <a
            class="btn btn-sm btn-primary btn-active-light-primary me-2"
            data-bs-toggle="modal"
            data-bs-target="#kt_modal_add_customer"
            @click="openModal('update',item)"
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
    <!-- <pre>{{ productStore.productData.length }}</pre>
    <pre>{{ productData.length }}</pre>
    <pre>{{meta }}</pre> -->
  </div>
  <AddProductModal :formData="formData" :disableFields="disabledFields"  @submitForm="handleSubmit"/>
</template>
<script>
import Datatable from "@/components/kt-datatable/KTDataTable.vue";
import {
  defineComponent,
  onMounted,
  reactive,
  ref,
  watch,
  computed,
} from "vue";
import debounce from "lodash/debounce";
import { useProductStore } from "@/stores/product.js";
import Swal from "sweetalert2";
import ApiService from "@/core/services/ApiService";
import AddProductModal from "@/components/modals/forms/AddProductModal.vue";
import { ElMessage } from "element-plus";
export default defineComponent({
  name: "product-listing",
  components: {
    Datatable,
    AddProductModal,
  },
  setup() {
    const formData = reactive({
      name: "",
      cost_price: 0,
      description: '',
      is_active: false,
      is_customizable: false,
    });

    const disableFields = reactive({});

    function getDisabledFields(keys = []) {
      return Object.fromEntries(
        Object.keys(formData).map(key => [key, keys.includes(key)])
      );
    }

    const openModal = (source,data) => {
        if(source === 'add') {
            Object.keys(formData).forEach((key) => {
                formData[key] = '';
            });
        } else if(source === 'update') {
          Object.keys(formData).forEach((key) => {
            formData[key] = data[key];
          });
          Object.assign(disableFields,getDisabledFields(['name', 'cost_price']));
        }
    };

    const tableHeader = ref([
      {
        columnName: "Product Code",
        columnLabel: "product_code",
        columnWidth: 175,
      },
      {
        columnName: "Name",
        columnLabel: "name",
        columnWidth: 175,
      },
      {
        columnName: "Cost Price",
        columnLabel: "cost_price",
        columnWidth: 50,
      },
      {
        columnName: "Actions",
        columnLabel: "actions",
        columnWidth: 135,
      },
    ]);
   
    const productStore = useProductStore();
    const productData = computed(()=> productStore.getProductData);
    const loading = computed (()=> productStore.isLoading);
    const perPage = ref(10);
    const page = ref(1);
    const search = ref("");
    const meta = computed(()=> productStore.getProductMeta);
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

    const fetchProductData = async (startDate, endDate) => {
      const rqData = {
        perPage: perPage.value,
        page: page.value,
        startDate: startDate ? startDate + " 00:00:00" : "",
        endDate: endDate ? endDate + " 23:59:59" : "",
        filter: data.value.filter,
        orderId: data.value.orderId,
        search: search.value,
      };
     await productStore.fetchProductData(rqData);
    };

    const debouncedSearchItems = debounce((event) => {
      search.value = event.target.value;
      console.log("Value: ", event.target.value);
    }, 500);

    watch([perPage, page, search], () => {
      fetchProductData(data.value.startDate, data.value.endDate);
    });
    
    onMounted(() => {
      fetchProductData(data.value.startDate, data.value.endDate);
    });

    const handleSubmit = (submittedFrom) => {
      if (submittedFrom === "add") {
        addProduct();
      } else if (submittedFrom === "update") {
        updateProduct();
      }
    };
    
    const addProduct = async () => {
      try {
        const { data } = await ApiService.post("api/add-product", formData);
        if (data.success) {
          productStore.addProductData(data.data);
          Swal.fire({
            title: "Success",
            text: "Product Added Successfully",
            icon: "success",
            timer: 3000,
          });
        }
      } catch (error) {
        console.error("Error in Adding Product", error);
      }
    };

    const updateProduct = async () => {
      try {
        const { data } = await ApiService.post("api/update-product", formData);
        if (data.success) {
          productStore.updateProduct(data.data);
          Swal.fire({
            title: "Success",
            text: "Product Updated Successfully",
            icon: "success",
            timer: 3000,
          });
        }
      } catch (error) {
        console.error("Error in Updating Product", error);
      }
    };

    const deleteRecord = async (item) => {
      try {
        const { data } = await ApiService.get(`/api/delete-product?sdx=${item.uuid}`);
        if (data.success) {
          productStore.deleteProduct(item.uuid);
          ElMessage({ message: "Record Deleted Successfully!!", type: "success" });
        }
      } catch (error) {
        console.error("Error in (delete-product): ", error);
        ElMessage({ message: error.message, type: "error" });
      }
    };
    return {
      loading,
      debouncedSearchItems,
      productStore,
      meta,
      perPage,
      page,
      search,
      data,
      deleteRecord,
      openModal,
      handleSubmit,
      formData,
      disableFields,
      productData,
      tableHeader,
    };
  },
});
</script>
