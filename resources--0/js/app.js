require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
import { createApp } from 'vue';
import {createRouter,createWebHashHistory} from 'vue-router';
import  NewProgram from './components/programs/NewProgram.vue'
// const routes  = [
//     {
//         path : "/wave",
//         name : 'wave',
//         component : WaveComponent
//     },
//     {
//         path: '/',
//         name: 'example',
//         component : ExamplComponent,
//         default: true
//     }
// ]
// const router = createRouter({
//     history : createWebHashHistory(),
//     routes
// });

const app = createApp({});
app.component('NewProgram',NewProgram)
// app.use(router)
app.mount("#app");
// app.component('WaveComponent',WaveComponent);
// app.use(router).mount("#app");