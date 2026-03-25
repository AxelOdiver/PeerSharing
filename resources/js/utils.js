// Global utility functions

export function toast(type, message) {
  let bgClass = 'bg-success-subtle text-success';
  
  if (type === 'error') {
    bgClass = 'bg-danger-subtle text-danger';
  }

  window.Swal.fire({
    toast: true,
    position: 'top-end',
    icon: type,
    title: message,
    showConfirmButton: false,
    timer: 2500,
    timerProgressBar: true,
    customClass: {
      popup: bgClass
    }
  });
}

export function handleSessionToast() {
  const pendingToast = sessionStorage.getItem('toast');

  if (pendingToast) {
    try {
      const { type, message } = JSON.parse(pendingToast);
      sessionStorage.removeItem('toast');

      if (type && message) {
        toast(type, message);
      }
    } catch (error) {
      sessionStorage.removeItem('toast');
    }
  }

  // Also handle session messages from Laravel
  if (document.body.dataset.errorMessage) {
    toast('error', document.body.dataset.errorMessage);
  } else if (document.body.dataset.successMessage) {
    toast('success', document.body.dataset.successMessage);
  }
}

export function getPreferredTheme() {
  const storedTheme = localStorage.getItem('theme');

  if (storedTheme) {
    return storedTheme;
  }

  return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

export function setTheme(theme) {
  if (theme === 'auto') {
    document.documentElement.setAttribute(
      'data-bs-theme',
      window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light',
    );
  } else {
    document.documentElement.setAttribute('data-bs-theme', theme);
  }
}
