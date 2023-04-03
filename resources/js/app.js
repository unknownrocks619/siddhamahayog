require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
import { createApp } from 'vue';
// import {createRouter,createWebHashHistory} from 'vue-router';
import NewProgram from './components/programs/NewProgram.vue'
import AddFee from './components/programs/AddFee.vue';
import NewMeeting from './components/zoom/NewMeeting.vue';
import EditProgram from './components/programs/EditMeeting.vue';

const app = createApp({ NewProgram });
app.component('NewProgram', NewProgram);
app.component('EditProgram', NewProgram);
app.component('AddFee', AddFee);
app.component('zoom-meeting', NewMeeting);
// app.use(router)
app.mount("#app");
// app.component('WaveComponent',WaveComponent);
// app.use(router).mount("#app");
