import $ from 'jquery';
window.$ = $;
window.jQuery = $;

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import Swal from 'sweetalert2';
window.Swal = Swal;

import 'admin-lte/dist/js/adminlte.js'

// Import utilities and make them global
import { toast, handleSessionToast, getPreferredTheme, setTheme } from './utils.js';
window.toast = toast;

// Import page-specific scripts
import './pages/dashboard.js'
import './pages/favorites.js'
import './pages/auth.js'
import './pages/register.js'
import './pages/schedule.js'
import './pages/profile.js'

// Initialize on DOM ready
$(document).ready(function() {
  handleSessionToast();
});