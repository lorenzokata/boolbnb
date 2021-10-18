import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Home from './pages/Home';
import Dashboard from './pages/Dashboard';
import Show from './pages/Apartment/Show';
import Create from './pages/Apartment/Create';
import Edit from './pages/Apartment/Edit';
import Email from './pages/Apartment/Email';
import Sponsor from './pages/Apartment/Sponsor';
import Stats from './pages/Apartment/Stats';
import SearchResults from './pages/SearchResults';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: "home",
            component: Home
        },
        {
            path: '/dashboard',
            name: "dashboard",
            component: Dashboard
        },
        {
            path: '/apartment/create',
            name: "create",
            component: Create
        },
        {
            path: '/apartment/show',
            name: "show",
            component: Show
        },
        {
            path: '/apartment/edit',
            name: "edit",
            component: Edit
        },
        {
            path: '/apartment/stats',
            name: "stats",
            component: Stats
        },
        {
            path: '/apartment/:slug-app/sponsor',
            name: "sponsor",
            component: Sponsor
        },
        {
            path: '/apartment/email/:id',
            name: "email",
            component: Email
        },
        {
            path: '/apartment/results/:userInput',
            name: "results",
            component: SearchResults,
            props: true
        },
    ]
});

export default router;