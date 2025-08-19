import { defineStore } from "pinia";
import ApiService from "@/core/services/ApiService";

export const useInventoryStore = defineStore("inventoryStore", {
    state: () => ({
        cachedInventory: {},
        inventoryData: [],
        inventoryMeta: {},
        loading: false,
    }),
    getters: {
        // getInventoryData() {
        //     return (rqData) => {
        //         let result = [...this.inventoryData];

        //         if (rqData.search) {
        //             const search = rqData.search.toLowerCase();
        //             result = result.filter(item => {
        //                 const name = item.item?.name?.toLowerCase() || "";
        //                 const seller = item.item?.seller?.toLowerCase() || "";
        //                 const location = item.item?.location?.toLowerCase() || "";
        //                 return name.startsWith(search) ||
        //                     seller.startsWith(search) ||
        //                     location.startsWith(search);
        //             });
        //         }
        //         if (rqData.filter) {
        //             result = result.filter(item => item.status === rqData.filter);
        //         }
        //         if (rqData.startDate && rqData.endDate) {
        //             const start = new Date(rqData.startDate);
        //             const end = new Date(rqData.endDate);
        //             result = result.filter(item => {
        //                 const created = new Date(item.created_at);
        //                 return created >= start && created <= end;
        //             });
        //         }
        //         if(rqData.page && rqData.perPage) {
        //             // result = [];
        //             const startIndex = (rqData.page - 1) * rqData.perPage;
        //             const endIndex = startIndex + rqData.perPage;
        //             result = result.slice(startIndex, endIndex);
        //         }

        //         return result;
        //     }
        // },
        getInventoryDataByID() {
            return async (uuid) => {
                if (!uuid) return {};
                let item = this.inventoryData.find(i => i.uuid == uuid);
                if (!item) {
                    await this.fetchInventoryDataById(uuid);
                }
                return this.inventoryData.find(i => i.uuid === uuid) || {};
            }
        },
        getInventoryData: (state) => state.inventoryData,
        getInventoryMeta: (state) => state.inventoryMeta, 
        isLoading: (state) => state.loading,
    },
    actions: {
        handleError(msg, error) {
            console.error("Error in Fetching " + msg + " : ", error);
        },
        setUniqueData(data,targetData) {
            const existingUuids = new Set(targetData.map(i => i.uuid));
            const newItems = data.data.filter(item => !existingUuids.has(item.uuid));
            targetData.push(...newItems);
        },
        // async fetchInventoryData(rqData) {
        //     try {
        //         const { data } = await ApiService.get(`api/get-inventory/?per_page=${rqData.perPage}&page=${rqData.page}&startDate=${rqData.startDate}&endDate=${rqData.endDate}&filter=${rqData.filter}&oid=${rqData.orderId}&search=${rqData.search}&`);
        //         if (data.success) {
        //             this.setUniqueData(data,this.inventoryData);
        //             this.inventoryMeta = data.meta;
        //             // this.inventoryData.forEach(i=>{
        //             //     i.item = JSON.parse(i.item);
        //             // })
        //             // console.log("InventoryData: ",this.inventoryData,"==> Data.data: ",data.data,"=> data: ",data);
        //         }
        //     } catch (e) {
        //         this.handleError("api/get-inventory", e);
        //     }
        // },
        async fetchInventoryData(rqData) {
            this.loading = true;
            const queryString = `?per_page=${rqData.perPage}&page=${rqData.page}&startDate=${rqData.startDate}&endDate=${rqData.endDate}&filter=${rqData.filter}&oid=${rqData.orderId}&search=${rqData.search}&`; 

            if (Object.keys(this.cachedInventory).length !==0 && this.cachedInventory[queryString]) {
                this.inventoryData = this.cachedInventory[queryString]?.data || [];
                this.inventoryMeta = this.cachedInventory[queryString]?.meta || {};
                this.loading = false;
                return; 
            }
            try {
                const { data } = await ApiService.get(`api/get-inventory?${queryString}`); //
                if (data.success) {
                    this.inventoryData = data.data; 
                    this.inventoryMeta = data.meta; 

                    this.cachedInventory[queryString] = {
                        data: data.data,
                        meta: data.meta,
                    };
                }
            } catch (e) {
                this.handleError("api/get-inventory", e);
            } finally {
                this.loading = false;
            }
        },

        async fetchInventoryDataById(uuid) {
            try {
                const { data } = await ApiService.get(`api/get-inventory/${uuid}`);
                if (data.success) {
                    this.setUniqueData(data,this.inventoryData);
                }
            } catch (e) {
                this.handleError("api/get-inventory/" + uuid, e);
            }
        },
        addInventoryData(data) {
            this.cachedInventoryData = {};
            this.inventoryData.splice(0, 0, data);
        },
        deleteInventory(uuid) {
            this.cachedInventoryData = {};
            this.inventoryData = this.inventoryData.filter(i => i.uuid != uuid);
        },
        updateInventory(data) {
            this.cachedInventoryData = {};
            const index = this.inventoryData.findIndex(i => i.uuid == data.uuid);
            if (index == -1) {
                return;
            } else {
                this.inventoryData[index] = data;
            }
        },
    }
})