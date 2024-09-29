import { useRouter } from 'vue-router';

export const piniaPluginRouter = ({ store }) => {
    store.router = useRouter();
};
