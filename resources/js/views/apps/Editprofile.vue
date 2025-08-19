<template>
    <!--begin::Layout-->
    <div class="d-flex flex-column flex-xl-row">
      <!--begin::Sidebar-->
      <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
        <!--begin::Card-->
        <div class="card mb-5 mb-xl-8">
          <!--begin::Card body-->
          <div class="card-body pt-15">
            <!--begin::Summary-->
            <div class="d-flex flex-center flex-column">
              <!--begin::Avatar-->
              <div class="symbol symbol-100px symbol-circle mb-7">
                <img :src="getAssetPath('images/profile_icon.png')" alt="image" />
              </div>
              <!--end::Avatar-->
  
              <!--begin::Name-->
              <a
                href="#"
                class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1"
              >
              {{ customerData.name }}
              </a>
              <!--end::Name-->
  
              <!--begin::Position-->
              <div class="fs-5 fw-semobold text-muted mb-6">{{ customerData.salesperson_bde }}</div>
              <!--end::Position-->
  
            </div>
            <!--end::Summary-->
  
            <!--begin::Details toggle-->
            <div class="d-flex flex-stack fs-4 py-3">
              <div
                class="fw-bold rotate collapsible"
                data-bs-toggle="collapse"
                href="#kt_customer_view_details"
                role="button"
                aria-expanded="false"
                aria-controls="kt_customer_view_details"
              >
                Details
                <span class="ms-2 rotate-180">
                  <KTIcon icon-name="down" icon-class="fs-3" />
                </span>
              </div>
  
              <span
                data-bs-toggle="tooltip"
                data-bs-trigger="hover"
                title="Edit customer details"
              >
                <!-- <a
                  href="#"
                  class="btn btn-sm btn-light-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#kt_modal_update_customer"
                >
                  Edit
                </a> -->
              </span>
            </div>
            <!--end::Details toggle-->
  
            <div class="separator separator-dashed my-3"></div>
  
            <!--begin::Details content-->
            <div id="kt_customer_view_details" class="collapse show">
              <div class="fs-6">
                <!--begin::Badge-->
                <!-- <div class="badge badge-light-info d-inline">Premium user</div> -->
                <!--begin::Badge-->
                <!--begin::Details item-->
                <!-- <div class="fw-bold mt-5">Account ID</div>
                <div class="text-gray-600">ID-45453423</div> -->
                <!--begin::Details item-->
                <!--begin::Details item-->
                <div class="fw-bold mt-5">Billing Email</div>
                <div class="text-gray-600">
                  <a href="#" class="text-gray-600 text-hover-primary"
                    >
              {{ customerData.email }}
  
                    </a>
                </div>
                <!--begin::Details item-->
                <!--begin::Details item-->
                <div class="fw-bold mt-5">Billing Address</div>
                <div class="text-gray-600">
                  <!-- 101 Collin Street, <br />Melbourne 3000 VIC <br />Australia -->
              {{ customerData.address }}
  
                </div>
  
                <div class="fw-bold mt-5">Shipping Address</div>
                <div class="text-gray-600">
                  <!-- 101 Collin Street, <br />Melbourne 3000 VIC <br />Australia -->
              {{ customerData.shopping_address ?? 'N/A' }}
  
                </div>
                <!--begin::Details item-->
                <!--begin::Details item-->
                <div class="fw-bold mt-5">Company</div>
  
                <div class="text-gray-600">{{ customerData.company}}</div>
                <!--begin::Details item-->
                <!--begin::Details item-->
                <div class="fw-bold mt-5">Mobile Number</div>
                <div class="text-gray-600">{{ customerData.mobile }}</div>
  
                <div class="fw-bold mt-5">Alter Mobile Number</div>
                <div class="text-gray-600">{{ customerData.alt_mobile ?? 'N/A' }}</div>
                <!--begin::Details item-->
                <!--begin::Details item-->
                <div class="fw-bold mt-5">GST Number</div>
                <div class="text-gray-600">{{ customerData.gst ?? 'N/A'}}</div>
                <!--begin::Details item-->
              </div>
            </div>
            <!--end::Details content-->
          </div>
          <!--end::Card body-->
        </div>
        <!--end::Card-->
  
  
      </div>
      <!--end::Sidebar-->
  
      <!--begin::Content-->
      <div class="flex-lg-row-fluid ms-lg-15">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_customer_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Update a Profile</h2>
                    <!--end::Modal title-->
                    <button
                    @click="userPass = !userPass"
                            class="btn btn-md btn-primary"
                            type="button"
                        >
                                Change Password ?
                        </button>
                </div>
                <!--end::Modal header-->
                <!--begin::Form-->
                <div v-if="customerData?.role?.role !== 'Admin'">
                    <el-form 
                    v-if="userPass"
                ref="passRef"
                @submit.prevent="changePassword()"
                :model="adminFormdata"
                :rules="passRules"
                >
                    <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semobold mb-2"
                                    >New Password</label
                                >
                                <!--end::Label-->

                                <!--begin::Input-->
                                <el-form-item prop="update_password">
                                    <el-input
                                        v-model="adminFormdata.update_password"
                                        type="password"
                                        placeholder="Please Enter Password"
                                        id="userName"
                                    />
                                </el-form-item>
                                <!--end::Input-->
                            </div>
                    <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semobold mb-2"
                                    >Confirm Password</label
                                >
                                <!--end::Label-->

                                <!--begin::Input-->
                                <el-form-item prop="confirm_password">
                                    <el-input
                                        v-model="adminFormdata.confirm_password"
                                        type="password"
                                        placeholder="Please Enter Confirm Password"
                                        id="userName"
                                    />
                                </el-form-item>
                                <!--end::Input-->
                            </div>
                            <div class="modal-footer flex-center">
                        <!--begin::Button-->

                        <!--end::Button-->

                        <!--begin::Button-->
                        <button
                            :data-kt-indicator="loading ? 'on' : null"
                            class="btn btn-lg btn-primary"
                            type="submit"
                        >
                            <span v-if="!loading" class="indicator-label">
                                Save
                            </span>
                            <span v-if="loading" class="indicator-progress">
                                Please wait...
                                <span
                                    class="spinner-border spinner-border-sm align-middle ms-2"
                                ></span>
                            </span>
                        </button>
                        <!--end::Button-->
                    </div>
                </el-form> 
                    <el-form
                    v-else
                    @submit.prevent="submit()"
                    :model="formData"
                    :rules="rules"
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
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semobold mb-2"
                                    >Name</label
                                >
                                <!--end::Label-->

                                <!--begin::Input-->
                                <el-form-item prop="update_name">
                                    <el-input
                                        v-model="formData.update_name"
                                        type="text"
                                        placeholder="Please Enter Name"
                                        id="userName"
                                    />
                                </el-form-item>
                                <!--end::Input-->
                            </div>

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semobold mb-2">
                                    <span class="required">Email</span>

                                    
                                </label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <el-form-item prop="update_email">
                                    <el-input
                                        v-model="formData.update_email"
                                        placeholder="Please Enter Email"
                                        readonly
                                    />
                                </el-form-item>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semobold mb-2"
                                    >Mobile</label
                                >
                                <!--end::Label-->

                                <!--begin::Input-->
                                <el-form-item prop="update_mobile">
                                    <el-input
                                        v-model="formData.update_mobile"
                                        type="text"
                                        placeholder="Please Enter Mobile Number"
                                        @keydown="
                                            nameKeydown($event, 'update_mobile')
                                        "
                                    />
                                </el-form-item>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semobold mb-2"
                                    >Alt Mobile</label
                                >
                                <!--end::Label-->

                                <!--begin::Input-->
                                <el-form-item prop="update_alt_mobile">
                                    <el-input
                                        v-model="formData.update_alt_mobile"
                                        type="text"
                                        placeholder="Please Enter Mobile Alternate Number"
                                        @keydown="
                                            nameKeydown(
                                                $event,
                                                'update_alt_mobile'
                                            )
                                        "
                                    />
                                </el-form-item>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semobold mb-2"
                                    >GST Number</label
                                >
                                <!--end::Label-->

                                <!--begin::Input-->
                                <el-form-item prop="update_gst">
                                    <el-input
                                        v-model="formData.update_gst"
                                        type="text"
                                        placeholder="Please Enter GSTIN"
                                    />
                                </el-form-item>
                                <!--end::Input-->
                            </div>

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semobold mb-2"
                                    >Company</label
                                >
                                <!--end::Label-->

                                <!--begin::Input-->
                                <el-form-item prop="update_company">
                                    <el-input
                                        v-model="formData.update_company"
                                        type="text"
                                        placeholder="Please Enter Company Name"
                                    />
                                </el-form-item>
                                <!--end::Input-->
                            </div>

                            <div
                                id="kt_modal_add_customer_billing_info"
                                class="collapse show"
                            >
                                <!--begin::Input group-->
                                <div class="flex-column mb-7 fv-row">
                                    <!--begin::Label-->
                                    <label
                                        class="required fs-6 fw-semobold mb-2"
                                        >Billing Address</label
                                    >
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <el-form-item prop="update_address">
                                        <el-input
                                            v-model="formData.update_address"
                                            placeholder="Please Enter Billing Address"
                                        />
                                    </el-form-item>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->

                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semobold mb-2"
                                        >Shipping Address</label
                                    >
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <el-form-item
                                        prop="update_shopping_address"
                                    >
                                        <el-input
                                            v-model="
                                                formData.update_shopping_address
                                            "
                                            type="text"
                                            placeholder="Please Enter Shipping Address"
                                        />
                                    </el-form-item>
                                    <!--end::Input-->
                                </div>

                                <el-form-item prop="uuid">
                                    <el-input
                                        v-model="formData.uuid"
                                        type="hidden"
                                    />
                                </el-form-item>

                            </div>
                            <!--end::Billing form-->
                        </div>
                        <!--end::Scroll-->
                    </div>
                    <!--end::Modal body-->

                    <!--begin::Modal footer-->
                    <div class="modal-footer flex-center">
                        <!--begin::Button-->

                        <!--end::Button-->

                        <!--begin::Button-->
                        <button
                            :data-kt-indicator="loading ? 'on' : null"
                            class="btn btn-lg btn-primary"
                            type="submit"
                        >
                            <span v-if="!loading" class="indicator-label">
                                Save
                            </span>
                            <span v-if="loading" class="indicator-progress">
                                Please wait...
                                <span
                                    class="spinner-border spinner-border-sm align-middle ms-2"
                                ></span>
                            </span>
                        </button>
                        <!--end::Button-->
                    </div>
                    <!--end::Modal footer-->
                </el-form>
                </div>
                
                <el-form
                v-else
                ref="passRef"
                @submit.prevent="changePassword()"
                :model="adminFormdata"
                :rules="passRules"
                >
                    <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semobold mb-2"
                                    >New Password</label
                                >
                                <!--end::Label-->

                                <!--begin::Input-->
                                <el-form-item prop="update_password">
                                    <el-input
                                        v-model="adminFormdata.update_password"
                                        type="password"
                                        placeholder="Please Enter Password"
                                        id="userName"
                                    />
                                </el-form-item>
                                <!--end::Input-->
                            </div>
                    <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semobold mb-2"
                                    >Confirm Password</label
                                >
                                <!--end::Label-->

                                <!--begin::Input-->
                                <el-form-item prop="confirm_password">
                                    <el-input
                                        v-model="adminFormdata.confirm_password"
                                        type="password"
                                        placeholder="Please Enter Confirm Password"
                                        id="userName"
                                    />
                                </el-form-item>
                                <!--end::Input-->
                            </div>
                            <div class="modal-footer flex-center">
                        <!--begin::Button-->

                        <!--end::Button-->

                        <!--begin::Button-->
                        <button
                            :data-kt-indicator="loading ? 'on' : null"
                            class="btn btn-lg btn-primary"
                            type="submit"
                        >
                            <span v-if="!loading" class="indicator-label">
                                Save
                            </span>
                            <span v-if="loading" class="indicator-progress">
                                Please wait...
                                <span
                                    class="spinner-border spinner-border-sm align-middle ms-2"
                                ></span>
                            </span>
                        </button>
                        <!--end::Button-->
                    </div>
                </el-form>
                <!--end::Form-->
            </div>
        </div>
      </div>
      <!--end::Content-->
    </div>
    <!--end::Layout-->
  
    <NewCardModal></NewCardModal>
  </template>
  
  <script lang="ts">
  import { getAssetPath } from "@/core/helpers/assets";
  // import { defineComponent } from "vue";
  import Dropdown3 from "@/components/dropdown/Dropdown3.vue";
  import NewCardModal from "@/components/modals/forms/NewCardModal.vue";
  import PaymentRecords from "@/components/customers/cards/overview/PaymentRecords.vue";
  import PaymentMethods from "@/components/customers/cards/overview/PaymentMethods.vue";
  import CreditBalance from "@/components/customers/cards/overview/CreditBalance.vue";
  import Invoices from "@/components/customers/cards/overview/Invoices.vue";
  
  import Events from "@/components/customers/cards/events-and-logs/Events.vue";
  import Logs from "@/components/customers/cards/events-and-logs/Logs.vue";
  
  import Earnings from "@/components/customers/cards/statments/Earnings.vue";
  import Statement from "@/components/customers/cards/statments/Statement.vue";
  import { defineComponent, nextTick, onMounted, ref, watch } from "vue";
  import ApiService from "@/core/services/ApiService";
  import { PasswordMeterComponent } from "@/assets/ts/components";
  import * as Yup from "yup";
  import { ErrorMessage, Field, Form as VForm } from "vee-validate";
  import Swal from "sweetalert2/dist/sweetalert2.js";
  export default defineComponent({
    name: "edit-profile",
    components: {
        PaymentRecords,
        PaymentMethods,
        CreditBalance,
        Invoices,
        Events,
        Logs,
        Earnings,
        Statement,
        Dropdown3,
        NewCardModal,
        Field,
        VForm,
        ErrorMessage,
    },
    setup() {
        const formRef = ref<null | HTMLFormElement>(null);
        const passRef = ref<null | HTMLFormElement>(null);
        const addCustomerModalRef = ref<null | HTMLElement>(null);
        const loading = ref<boolean>(false);
        const userPass = ref<boolean>(false);
        const formData = ref({
            update_name: "",
            update_email: "",
            update_message: "",
            update_alt_mobile: "",
            update_mobile: "",
            update_address: "",
            update_company: "",
            update_gst: "",
            update_shopping_address: "",
            update_designation: "",
            uuid: "",
        });
        const adminFormdata = ref({
            update_password: "",
            confirm_password: ""
        });
      const customerData = ref("");

      const rules = ref({
            update_name: [
                {
                    required: true,
                    message: "Client name is required",
                    trigger: "change",
                },
            ],
            update_email: [
                {
                    required: true,
                    message: "Client email is required",
                    trigger: "change",
                },
                {
                    validator: (rule, value, callback) => {
                        const emailRegex =
                            /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                        if (!value) {
                            callback(new Error("Client email is required"));
                        } else if (!emailRegex.test(value)) {
                            callback(
                                new Error("Please enter a valid email address")
                            );
                        } else {
                            callback();
                        }
                    },
                },
            ],
            update_address: [
                {
                    required: true,
                    message: "Address  is required",
                    trigger: "change",
                },
            ],
            update_message: [
                {
                    required: true,
                    message: "Message is required",
                    trigger: "change",
                },
            ],
            update_mobile: [
                {
                    required: true,
                    message: "Mobile number is required",
                    trigger: "change",
                },
            ],
            update_company: [
                {
                    required: true,
                    message: "Company name is required",
                    trigger: "change",
                },
            ],
            update_gst: [
                {
                    validator: (rule, value, callback) => {
                        const gstRegex =
                            /^([0][1-9]|[1-2][0-9]|[3][0-7])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/;

                        if (value && !gstRegex.test(value)) {
                            callback(new Error("Invalid GST format."));
                        } else {
                            callback();
                        }
                    },
                    trigger: "blur",
                },
            ],
        });
        const passRules = ref({
            update_password: [
                {
                    required: true,
                    message: "Password is required",
                    trigger: "change",
                },
                {
                    pattern:
                        /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$/,
                    message:
                        "Password must have at least 6 characters with at least 1 special character, a lowercase letter, an uppercase letter, and a number.",
                    trigger: "blur",
                },
            ],
            confirm_password: [
                {
                    required: true,
                    message: "Password is required",
                    trigger: "change",
                },
                {
                    pattern:
                        /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$/,
                    message:
                        "Password must have at least 6 characters with at least 1 special character, a lowercase letter, an uppercase letter, and a number.",
                    trigger: "blur",
                },
            ],
        })
        const fetchUser = (data) => {
            ApiService.post("/api/get-client",data)
          .then(({data}) => {
          if(data.success == true){
              console.log(data);
  
              customerData.value = data.data;
          }else{
  
          }
          })
          .catch(({ response }) => {
              console.log(response);
          });
        }
      onMounted(() => {

          const id = localStorage.getItem('selectedID');
  
          const requestData = {
              user_uuid:id
          }
          fetchUser(requestData);
      });
      watch(
            () => customerData?.value,
            () => {
                formData.value = {
                    update_name: customerData.value.name,
                    update_email: customerData.value.email,
                    update_alt_mobile: customerData.value.alt_mobile,
                    update_mobile: customerData.value.mobile,
                    update_address: customerData.value.address,
                    update_company: customerData.value.company,
                    update_gst: customerData.value.gst,
                    update_shopping_address: customerData.value.shopping_address,
                    uuid: customerData.value.uuid,
                };
            }
        );
        const changePassword = () => {
            if (!passRef.value) {
                return;
            }

            passRef.value.validate((valid: boolean) => {
                if (valid) {
                    loading.value = true;
                    const update_password = adminFormdata.value.update_password;
                    const confirm_password = adminFormdata.value.confirm_password;
                      if (update_password === confirm_password) { 
                    const requestData = {
                        password: confirm_password,
                        user_uuid: localStorage.getItem('selectedID'),
                        isMail: false
                    };

                    ApiService.post("/api/edit-client", requestData)
                        .then(({ data }) => {
                            loading.value = false;
                            if (data.success) {

                                Swal.fire({
                                    text: "Password has been successfully Updated!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    heightAuto: false,
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                    },
                                }).then(() => {
                                });
                            } else {
                                Swal.fire({
                                    text: "Submission failed. Please try again later.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    heightAuto: false,
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                    },
                                });
                            }
                        })
                        .catch((error) => {
                            console.error(error);
                            loading.value = false;
                          });
                        } else {
                            Swal.fire({
                        text: "Password did not match",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        heightAuto: false,
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                              });
                              loading.value = false;
                }
                } else {
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        heightAuto: false,
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                    });
                }
            });
        }
      const submit = () => {
            // alert(formRef);
            if (!formRef.value) {
                return;
            }

            formRef.value.validate((valid: boolean) => {
                if (valid) {
                    loading.value = true;
                    const requestData = {
                        user_uuid: formData.value.uuid,
                        name: formData.value.update_name,
                        email: formData.value.update_email,
                        address: formData.value.update_address,
                        mobile: formData.value.update_mobile,
                        alt_mobile: formData.value.update_alt_mobile,
                        company: formData.value.update_company,
                        gst: formData.value.update_gst,
                        shopping_address:
                            formData.value.update_shopping_address,
                        isMail: false
                    };

                    ApiService.post("/api/edit-client", requestData)
                        .then(({ data }) => {
                            loading.value = false;
                            if (data.success) {
                                const requestData = {
                                    user_uuid:formData.value.uuid
                                }
                                fetchUser(requestData);
                                Swal.fire({
                                    text: "Form has been successfully submitted!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    heightAuto: false,
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                    },
                                }).then(() => {
                                    const event = new Event("customerAdded");
                                    document.dispatchEvent(event);
                                });
                            } else {
                                Swal.fire({
                                    text: "Submission failed. Please try again later.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    heightAuto: false,
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                    },
                                });
                            }
                        })
                        .catch((error) => {
                            console.error(error);
                            loading.value = false;
                        });
                } else {
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        heightAuto: false,
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                    });
                }
            });
        };
        const nameKeydown = (e, field)=> {
            if (/^\d$/.test(e.key)) {
                return;
            }

            if (e.key === "Backspace") {
                if (this.formData[field].length > 0) {
                    // If Backspace is pressed and there is content in the field, remove one character
                    this.formData[field] = this.formData[field].slice(0, -1);
                }
            }
            e.preventDefault();
        }
          return {
              getAssetPath,
            customerData,
            formData,
            loading,
            submit,
            nameKeydown,
            rules,
            formRef,
            passRef,
            adminFormdata,
            passRules,
                changePassword,
            userPass
      };
    },
  });
  </script>
  