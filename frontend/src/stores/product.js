import {defineStore} from 'pinia'
import {getWithParams} from "../utils/fetchAPI.js";

export const useProductStore = defineStore('product', {
    state: () => {
        return {
            isLoading: false,
            errors: [],
            products: [],
            next_cursor: ''
        }
    },
    getters: {
        getError: (state) => {
            return (key) => !!state.errors && state.errors[key] !== undefined ? state.errors[key][0] : null
        },
    },
    actions: {
        async getProducts(page =1, search = '') {
            this.isLoading = true
            const fields = 'id,name,price,image'
            const payload = {
                page,
                search,
                fields
            }

            await getWithParams('/products', payload)
                .then(res => {
                    let {data, next_cursor, ...rest} = res?.data?.data
                    this.products = data
                    this.next_cursor = next_cursor
                }).finally(_ => this.isLoading = false)
        },
    }
})
