<template>
<div
        class="modal fade"
        id="kt_modal_add_inventory"
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
                    <h2 class="fw-bold">Add a inventory</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div
                        id="kt_modal_add_customer_close"
                        data-bs-dismiss="modal"
                        class="btn btn-icon btn-sm btn-active-icon-primary"
                        @click="closeModal"
                    >
                        <KTIcon
                            icon-name="cross"
                            icon-class="fs-1"
                            @click="closeModal"
                        />
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Form-->
                <el-form
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
                                    >Service Name</label
                                >
                                <!--end::Label-->

                                <!--begin::Input-->
                                <el-form-item prop="name">
                                    <el-input
                                        v-model="formData.name"
                                        type="text"
                                        ref="serName"
                                        placeholder="Please Enter Service Name"
                                    />
                                </el-form-item>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semobold mb-2"
                                    >Service Image</label
                                >
                                <!--end::Label-->

                                <!--begin::Input-->
                                <el-form-item prop="files">
                                    <input
                                        type="file"
                                        ref="file"
                                        accept="image/*"
                                        @change="handleFile()"
                                        placeholder="Please Upload Image"
                                    />
                                </el-form-item>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <div v-if="selectedImages.length > 0" class="mb-3">
                                <h4>Selected Files:</h4>
                                <div
                                    class="mb-2"
                                    v-for="(file, index) in selectedImages"
                                    :key="index"
                                >
                                    <div class="d-flex align-items-center">
                                        <a :href="file.url" target="_blank">{{
                                            file.name
                                        }}</a>

                                        <a
                                            @click="removeFile(index)"
                                            class="btn btn-danger btn-sm ms-2"
                                        >
                                            <i class="fas fa-times fa-xs"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div
                                id="kt_modal_add_customer_billing_info"
                                class="collapse show"
                            ></div>
                            <!--end::Billing form-->
                        </div>
                        <!--end::Scroll-->
                    </div>
                    <!--end::Modal body-->

                    <!--begin::Modal footer-->
                    <div class="modal-footer flex-center">
                        <!--begin::Button-->
                        <!-- <button
                type="reset"
                id="kt_modal_add_customer_cancel"
                class="btn btn-light me-3"
              >
                Discard
              </button> -->
                        <!--end::Button-->

                        <!--begin::Button-->
                        <button
                            :data-kt-indicator="loading ? 'on' : null"
                            class="btn btn-lg btn-primary"
                            type="submit"
                        >
                            <span v-if="!loading" class="indicator-label d-flex align-items-center">
                                Submit
                                <KTIcon
                                    icon-name="arrow-right"
                                    icon-class="fs-2 me-2 me-0"
                                />
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
                <!--end::Form-->
            </div>
        </div>
    </div>
</template>
<script lang="ts">
</script>