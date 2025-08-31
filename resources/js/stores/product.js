import { defineStore } from "pinia";
import ApiService from "@/core/services/ApiService";

export const useProductStore = defineStore("productStore", {
    state: () => ({
        cachedProduct: {},
        productData: [],
        productMeta: {},
        loading: false,
    }),
    getters: {
        getProductDataByID() {
            return async (uuid) => {
                if (!uuid) return {};
                let item = this.productData.find(i => i.uuid == uuid);
                if (!item) {
                    await this.fetchProductDataById(uuid);
                }
                return this.productData.find(i => i.uuid === uuid) || {};
            }
        },
        getProductData: (state) => state.productData,
        getProductMeta: (state) => state.productMeta, 
        isLoading: (state) => state.loading,
    },
    actions: {
        handleError(msg, error) {
            console.error("Error in Fetching " + msg + " : ", error);
        },
        async fetchProductData(rqData) {
            this.loading = true;
            const queryString = `?per_page=${rqData.perPage}&page=${rqData.page}&startDate=${rqData.startDate}&endDate=${rqData.endDate}&filter=${rqData.filter}&oid=${rqData.orderId}&search=${rqData.search}&`; 

            if (Object.keys(this.cachedProduct).length !==0 && this.cachedProduct[queryString]) {
                this.productData = this.cachedProduct[queryString]?.data || [];
                this.productMeta = this.cachedProduct[queryString]?.meta || {};
                this.loading = false;
                return; 
            }
            try {
                const { data } = await ApiService.get(`api/get-product?${queryString}`); //
                if (data.success) {
                    this.productData = data.data; 
                    this.productMeta = data.meta; 

                    this.cachedProduct[queryString] = {
                        data: data.data,
                        meta: data.meta,
                    };
                }
            } catch (e) {
                this.handleError("api/get-product", e);
            } finally {
                this.loading = false;
            }
        },
        async fetchProductDataById(uuid) {
            try {
                const { data } = await ApiService.get(`api/get-product/${uuid}`);
                if (data.success) {
                    this.setUniqueData(data,this.productData);
                }
            } catch (e) {
                this.handleError("api/get-product/" + uuid, e);
            }
        },
        addProductData(data) {
            this.cachedProductData = {};
            this.productData.splice(0, 0, data);
        },
        deleteProduct(uuid) {
            this.cachedProductData = {};
            this.productData = this.productData.filter(i => i.uuid != uuid);
        },
        updateProduct(data) {
            this.cachedProductData = {};
            const index = this.productData.findIndex(i => i.uuid == data.uuid);
            if (index == -1) {
                return;
            } else {
                this.productData[index] = data;
            }
        },
    }
})