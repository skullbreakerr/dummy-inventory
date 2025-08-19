<template>
    <div
      class="modal fade"
      id="kt_modal_show_files"
      ref="addCustomerModalRef"
      tabindex="-1"
      aria-hidden="true"
    >
      <!--begin::Modal dialog-->
      <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
          <!--begin::Modal header-->
          <div class="modal-header" id="kt_modal_add_customer_header">
            <!--begin::Modal title-->
            <h2 class="fw-bold">Order Files</h2>
            <!--end::Modal title-->

            <!--begin::Close-->
            <div
              id="kt_modal_add_customer_close"
              data-bs-dismiss="modal"
              class="btn btn-icon btn-sm btn-active-icon-primary"
            >
              <KTIcon icon-name="cross" icon-class="fs-1" />
            </div>
            <!--end::Close-->
          </div>
          <!--end::Modal header-->
          <!--begin::Form-->
          <el-form
            :model="formData"
            ref="formRef"
          >
            <!--begin::Modal body-->
            <div class="modal-body py-10 px-lg-17">
              <!--begin::Scroll-->
              <div
                class="scroll-y me-n7 pe-7"
                id="kt_modal_add_customer_scroll"
                data-kt-scroll="true"
                data-kt-scroll-activate="{default: false, lg: true}"
                data-kt-scroll-max-height="auto"
                data-kt-scroll-dependencies="#kt_modal_add_customer_header"
                data-kt-scroll-wrappers="#kt_modal_add_customer_scroll"
                data-kt-scroll-offset="300px"
              >
                    <div v-if="preselectedFiles.length > 0" class="mb-3">
                      <!-- <h4>Selected Files:</h4> -->
                      <div class="d-flex flex-wrap">
                        <div v-for="(file, index) in preselectedFiles" :key="index" >
                          <div class="d-flex align-items-center" style="margin: 10px;">
                            <a :href="file.path" target="_blank" >{{ file.path }}</a>
                          </div>
                        </div>
                      </div>
                    </div>
                <!--end::Billing form-->
              </div>
              <!--end::Scroll-->
            </div>
            <!--end::Modal body-->
          </el-form>
        </div>
      </div>
    </div>
  </template>

  <script lang="ts">
  import { getAssetPath } from "@/core/helpers/assets";
  import { defineComponent,onMounted,ref,watch } from "vue";
  import { hideModal } from "@/core/helpers/dom";
  import { countries } from "@/core/data/countries";
  import Swal from "sweetalert2/dist/sweetalert2.js";
  import ApiService from "@/core/services/ApiService";
  import axios from "axios"; // Import Axios
  const fileData = ref(null);

  export default defineComponent({
    name: "add-customer-modal",
    components: {},

    data() {
  return {
    selectedImages: [],

  };
    },
methods:{
    handleFile(event) {
          const selectedFiles = this.$refs.file.files;
          if (selectedFiles.length > 0) {
            fileData.value = [];
            for (let i = 0; i < selectedFiles.length; i++) {
              fileData.value.push(selectedFiles[i]);

              // Add the file information to selectedImages
              this.selectedImages.push({
                name: selectedFiles[i].name,
                url: URL.createObjectURL(selectedFiles[i]),
              });
            }
          } else {
            fileData.value = null;
          }
        },
    },
    props:{
        details:{
            type:Object,
        },
    },
    setup(props) {


      const formRef = ref<null | HTMLFormElement>(null);
      const addCustomerModalRef = ref<null | HTMLElement>(null);
      const loading = ref<boolean>(false);
      const formData = ref({
        update_confirmation_date: "",
        update_technology: "",
        update_material:"",
        update_expected_delivery_date:"",
        update_description:"",
        update_client:"",
        update_inquiry_date:"",
        uuid:"",
        files: "",
        update_order_status: "",
      });
      const preselectedFiles = ref([]);

      watch(() => props.details, (newDetails, oldDetails) => {
        formData.value = {
          update_confirmation_date: newDetails.confirmation_date,
          update_expected_delivery_date: newDetails.expected_delivery_date,
          update_inquiry_date: newDetails.inquiry_date,
          update_description: newDetails.description,
          uuid: newDetails.uuid,
        };

        if (Array.isArray(newDetails.files)) {
          preselectedFiles.value = newDetails.files.map((file) => ({
            path: file.path,
            uuid: file.uuid, // Add the file's uuid property
          }));
        } else {
          preselectedFiles.value = [];
        }
     });

    const selectedImages = ref([]);

      return {
        formData,
        formRef,
        loading,
        addCustomerModalRef,
        getAssetPath,
        countries,
        preselectedFiles,
        selectedImages,
      };
    },
  });
  </script>
