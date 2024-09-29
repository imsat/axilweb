import {defineStore} from 'pinia'
import {get, remove, set} from "../utils/localStorage.js";
import {post} from "../utils/fetchAPI.js";
import {errorToast, successToast} from "../utils/swalUtil.js";

export const useAuthStore = defineStore('auth', {
    state: () => {
        return {
            errors: [],
            token: get('token') || null,
            user: get('user') || null,
            loginForm: {
                email: '',
                password: '',
            },
            isLoading: false
        }
    },
    getters: {
        getError: (state) => {
            return (key) => !!state.errors && state.errors[key] !== undefined ? state.errors[key][0] : null
        },
    },
    actions: {
        async login() {
            this.isLoading = true
            await post('/login', this.loginForm)
                .then(res => {
                    const {token, user} = res.data.data
                    set('token', token)
                    set('user', user)
                    this.token = token
                    this.user = user
                    successToast(res?.data?.message)
                    this.router.push('/')
                }).catch(err => {
                    const {data, message} = err?.response?.data
                    errorToast(message)
                    this.errors = data
                }).finally(_ => this.isLoading = false)

        },
        async logout() {
            this.isLoading = true
            await post('/logout').then(res => {
                remove('token')
                remove('user')
                // Resetting the state
                this.$reset();
                successToast(res?.data?.message)
                this.router.push('/login');
            }).finally(_ => this.isLoading = false)

        },
        setLoginForm(value){
            this.loginForm = value
        }
    }
})
