import {defineStore} from 'pinia'
import {del, getWithParams, post} from "../utils/fetchAPI.js";
import {errorToast, successToast, confirm} from "../utils/swalUtil.js";

export const usePreOrderStore = defineStore('preOrder', {
    state: () => {
        return {
            shortBy: [],
            isLoading: false,
            errors: [],
            preOrders: [],
            pagination: {
                total: 0
            },
            preOrderForm: {
                name: '',
                email: '',
                phone: '',
                delivery_address: '',
                products: [],
            },
            cart: {
                product: null,
                quantity: 1,
            },
            g_recaptcha_response: '',
        }
    },
    getters: {
        getError: (state) => {
            return (key) => !!state.errors && state.errors[key] !== undefined ? state.errors[key][0] : null
        },
        showPhoneField: (state) => state.preOrderForm.email.includes('@xyz.com')
    },
    actions: {
        updateShortBY(val) {
            this.shortBy = val
        },
        async getPreOrders(props) {
            this.isLoading = true
            const fields = 'id,customer_id,total,status'
            const withs = JSON.stringify(['customer:id,name,email']);
            const payload = {
                short_by: this.shortBy,
                page: props?.page || 1,
                per_page: props?.itemsPerPage,
                search: props?.search,
                with: withs,
                fields
            }

            await getWithParams('/pre-orders', payload)
                .then(res => {
                    let {data, ...rest} = res?.data?.data
                    this.preOrders = data
                    this.pagination = rest
                }).finally(_ => this.isLoading = false)
        },
        async handleSave(action = 'add', id = null) {
            let apiUrl = `/pre-orders`
            if (action === 'edit') {
                apiUrl = `/pre-orders/${id}`
                this.preOrderForm._method = 'PUT'

                if (!id) {
                    errorToast('Something went wrong')
                    return;
                }
            }

            await post(apiUrl, {...this.preOrderForm, 'g_recaptcha_response' : this.g_recaptcha_response})
                .then(res => {
                    const data = res?.data?.data;
                    if (action === 'edit') {
                        this.updatePreOrder(id, data)
                    } else {
                        this.preOrders.unshift(data)
                    }
                    // this.preOrderForm = {}
                    successToast(res?.data?.message)
                    grecaptcha.reset();
                    this.$reset();
                    // need to work
                    // this.router.push('/pre-orders')
                }).catch(err => {
                    const {errors, message} = err?.response?.data
                    errorToast(message)
                    this.errors = errors
                })
        },
        async deletePreOrder(id) {
            const result = await confirm();
            if (result.value) {
                await del(`/pre-orders/${id}`)
                    .then(res => {
                        successToast(res?.data?.message)
                        this.preOrders = this.preOrders.filter(preOrder => preOrder.id !== id);
                    })
            }
        },
        addToCart() {
            // Find if the product already exists in cart
            let exists = this.preOrderForm.products.find((product) => product.id === this.cart.product.id);

            // If it exists, increment the quantity
            if (exists) {
                exists.quantity += this.cart.quantity;
            } else {
                const newProduct = {
                    ...this.cart.product,
                    quantity: this.cart.quantity
                };

                this.preOrderForm.products.unshift(newProduct);
            }

            // Reset
            this.cart = {
                product: null,
                quantity: 1
            };
            this.clearError('products')
        },
        removeCart(id) {
            this.preOrderForm.products = this.preOrderForm.products.filter(cart => cart.id !== id)
        },
        clearError(key){
            if (key) {
                const updatedError = { ...this.errors };
                delete updatedError[key];
                this.errors =  updatedError;
            } else {
                return null;
            }
        },
        handleSuccess(response) {
            this.g_recaptcha_response = response;
        }
    }
})
