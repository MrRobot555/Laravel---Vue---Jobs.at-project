import Home from './components/Home.vue';
import AddJobs from './components/AddJobs';
import Login from './components/Login';
export const routes = [{
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'add',
        path: '/add',
        component: AddJobs
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
   
];