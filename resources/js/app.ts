import { createApp } from 'vue';
import App from '@/App.vue';

const appElement = document.getElementById('app');

if (appElement !== null) {
  createApp(App).mount(appElement);
}
