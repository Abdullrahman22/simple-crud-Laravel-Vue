
import Posts from "../components/Posts.vue";  // import this component
import Register from "../components/Register.vue";  // import this component
import Login from "../components/Login.vue";  // import this component

const routes = [    // here we put all info of component (whice use as routes to SPA )  
    { path: '/posts', component: Posts },
    { path: '/register', component: Register },
    { path: '/login', component: Login }
]

export default routes;  // when import this file return routes