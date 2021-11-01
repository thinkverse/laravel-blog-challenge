import Alpine from 'alpinejs';
import axios from 'axios';

window.Alpine = Alpine;

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Alpine.start();
