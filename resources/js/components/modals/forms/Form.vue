<template>
    <div class="modal fade" id="kt_modal_add_form" ref="addModalRef" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered mw-650px">

            <div class="modal-content">

                <div class="modal-header" id="kt_modal_add_customer_header">

                    <h2 class="fw-bold">{{ name }}</h2>

                    <div id="kt_modal_add_customer_close" data-bs-dismiss="modal"
                        class="btn btn-icon btn-sm btn-active-icon-primary" @click="closeModalAndEmit">
                        <KTIcon icon-name="cross" icon-class="fs-1" />
                    </div>
                </div>
                <el-form @submit.prevent="submit" :model="formData" :rules="formRules" ref="formRef">
                    <div class="modal-body py-10 px-lg-17">
                        <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true"
                            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_add_customer_header"
                            data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">
                            <div v-for="(field, index) in formFields" class=" d-flex flex-wrap fv-row mb-7">
                                <label class="required fs-6 fw-semobold mb-2">{{ field?.label || "label not provided"
                                    }}</label>

                                <el-form-item :prop="field.prop">

                                    <!-- Select -->
                                    <template v-if="field.type.toLowerCase() === 'select'">
                                        <el-select v-model="formData[field.prop]" :class="field?.class && field.class"
                                            :multiple="field?.multiple && field.multiple"
                                            :placeholder="field.placeholder"
                                            @change="field?.change && handleChange($event, field)"
                                            :disabled="field.disabled">

                                            <el-option v-for="(item, idx) in dropdownOptions(field.prop)"
                                                :key="item?.key || item?.value || idx" :label="item.label"
                                                :value="item.value" />

                                        </el-select>

                                    </template>

                                    <!-- Textarea -->
                                    <template v-else-if="field.type.toLowerCase() === 'textarea'">
                                        <el-input v-model="formData[field.prop]" type="textarea"
                                            @change="field?.change && field.change($event)"
                                            :maxlength="field?.max || 1000" :minlength="field?.min || 0"
                                            :disabled="field.disabled" :class="field?.class && field.class"
                                            :placeholder="field?.placeholder || 'Start writing paragraph here..'" />

                                    </template>
                                    <!-- Date Range -->
                                    <template v-else-if="field.type.toLowerCase() === 'daterange'">
                                        <el-date-picker v-model="formData[field.prop]" :type="field.type"
                                            value-format="yyyy-MM-dd" :class="field?.class && field.class"
                                            :start-placeholder="field?.start_placeholder || field.placeholder"
                                            :end-placeholder="field?.end_placeholder || field.placeholder"
                                            @change="field?.change && field.change($event)"
                                            :disabled="field.disabled" />

                                    </template>
                                    <!-- Date/Datetime -->
                                    <template
                                        v-else-if="field.type.toLowerCase() === 'date' || field.type.toLowerCase() === 'datetime'">
                                        <el-date-picker v-model="formData[field.prop]" :type="field.type"
                                            :value-format="field.type.toLowerCase() === 'datetime' ? 'yyyy-MM-dd HH:mm:ss' : 'yyyy-MM-dd'"
                                            :class="field?.class && field.class"
                                            @change="field?.change && field.change($event)"
                                            :disabled="field.disabled" />

                                    </template>

                                    <!-- Input with select -->
                                    <!-- <template v-if="field.inpClass.toLowerCase() === 'input-with-select'">
                                        <el-input v-model="formData[field.prop]" :type="field.type"
                                            :class="`${field.inpClass} ${field?.class && field.class}`"
                                            @change="field?.change && field.change($event)" :disabled="field.disabled"
                                            :placeholder="field?.placeholder || 'Enter input'">
                                             <template #prepend>
                                                <component :is="field?.prependElement && field.prependElement" />
                                            </template>
                                            <template #append>
                                                <component :is="field?.appendElement && field.appendElement" />
                                            </template>
                                        </el-input>

                                    </template> -->

                                    <template v-else-if="field.type.toLowerCase() === 'switch'">
                                        <el-switch v-model="formData[field.prop]" :class="field?.class && field.class"
                                            @change="field?.change && field.change($event)" :disabled="field.disabled"
                                            :inactive-action-icon="field?.inactiveIcon || ''"
                                            :active-text="field?.activeText || 'Active'"
                                            :inactive-text="field?.inactiveText || 'Inactive'"
                                            :active-action-icon="field.activeIcon" :placeholder="field.placeholder" />
                                    </template>
                                    <!-- Regular Inputs Strings/Number -->
                                    <template v-else>

                                        <el-input v-model="formData[field.prop]" :type="field.type"
                                            :class="field?.class && field.class"
                                            @change="field?.change && field.change($event)" :disabled="field.disabled"
                                            :placeholder="field.placeholder">
                                            <template v-if="field.prependElement" #prepend>
                                                <component :is="field?.prependElement && field.prependElement" />
                                            </template>
                                            <template v-if="field.appendElement" #append>
                                                <component :is="field?.appendElement && field.appendElement" />
                                            </template>
                                        </el-input>

                                    </template>
                                    <!-- options== { label: 'label', value: 'value'} || {name:"",uuid:"",....} -->
                                </el-form-item>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer flex-center">

                        <button :data-kt-indicator="loading ? 'on' : null" class="btn btn-lg btn-primary" type="submit"
                            :disabled="loading">
                            <span v-if="!loading" class="indicator-label d-flex align-items-center">
                                Submit
                                <KTIcon icon-name="arrow-right" icon-class="fs-2 me-2 me-0" />
                            </span>
                            <span v-if="loading" class="indicator-progress">
                                Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </el-form>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import {
    defineComponent,
    onMounted,
    ref,
    getCurrentInstance,
    watch,
    computed
} from "vue";
import { hideModal, showModal } from "@/core/helpers/dom";
import { ElMessage } from "element-plus";
// import { countries } from "@/core/data/countries";

const formRef = ref<null | HTMLFormElement>(null);
const addModalRef = ref<null | HTMLElement>(null);
const loading = ref<boolean>(false);
const componentInstance = ref(null);

export default defineComponent({
    name: "add-customer-modal",
    components: {},
    props: {
        name: String,
        formData: Object,
        formFields: Array,
        formRules: Object,
    },
    methods: {
        submit() {
            if (loading.value) return;
            loading.value = true;
            this.$refs.formRef.validate((valid) => {
                if (valid) {
                    this.$emit('submitForm')
                    this.closeModalAndEmit();
                    this.$refs.formRef.resetFields();
                    loading.value = false;

                } else {
                    this.$message({ message: "Form Validation Error(check console)", type: "errror" });
                }
            });
        },
    },
    setup(props) {
        console.log("FormData: ", props.formData);
        // console.log("FormFields: ", props.formFields);
        // console.log("FormRules: ", props.formRules);
        const dropdownOptions = computed(() => {
            return (prop) => {
                const field = props.formFields.find((f) => f.prop === prop);
                if (field && field.options) {
                    // console.log("Field Options: ", field);
                    return field.options.map(i => field.transformOptions(i));
                }
                return [];
            };
        });

        const handleChange = (e, prop) => {
            e.preventDefault();
            prop.change(e);
        }

        // console.log("DropdownOptions: ", dropdownOptions.value);
        onMounted(() => {
            showModal(addModalRef.value);
            componentInstance.value = getCurrentInstance();
            const modal = addModalRef.value;

            modal.addEventListener("click", (e) => {
                if (e.target === modal) {
                    closeModalAndEmit();
                }
            });
        });
        const closeModalAndEmit = () => {
            formRef.value.resetFields();
            loading.value = false;
            hideModal(addModalRef.value);
            if (componentInstance.value) {
                componentInstance.value.emit("cancel"); // Emit the event using the stored component instance
            }
            // const event = new Event("customerAdded");
            // document.dispatchEvent(event);
        };

        return {
            handleChange,
            dropdownOptions,
            formRef,
            loading,
            addModalRef,
            getAssetPath,
            // countries,
            // designations,
            closeModalAndEmit,
        };
    },
});
</script>
