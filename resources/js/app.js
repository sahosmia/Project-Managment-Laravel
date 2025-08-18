import './bootstrap';


import './../css/app.css';

import Alpine from "alpinejs";
import persist from "@alpinejs/persist";
import flatpickr from "flatpickr";


Alpine.plugin(persist);
window.Alpine = Alpine;
Alpine.start();

// Init flatpickr
flatpickr(".datepicker", {
  mode: "range",
  static: true,
  monthSelectorType: "static",
  dateFormat: "M j, Y",
  defaultDate: [new Date().setDate(new Date().getDate() - 6), new Date()],
  prevArrow:
    '<svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.25 6L9 12.25L15.25 18.5" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
  nextArrow:
    '<svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.75 19L15 12.75L8.75 6.5" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
  onReady: (selectedDates, dateStr, instance) => {
    instance.element.value = dateStr.replace("to", "-");
    const customClass = instance.element.getAttribute("data-class");
    instance.calendarContainer.classList.add(customClass);
  },
  onChange: (selectedDates, dateStr, instance) => {
    instance.element.value = dateStr.replace("to", "-");
  },
});

// Init Dropzone
const dropzoneArea = document.querySelectorAll("#demo-upload");

if (dropzoneArea.length) {
  let myDropzone = new Dropzone("#demo-upload", { url: "/file/post" });
}



// Get the current year
const year = document.getElementById("year");
if (year) {
  year.textContent = new Date().getFullYear();
}

// For Copy
document.addEventListener("DOMContentLoaded", () => {
  const copyInput = document.getElementById("copy-input");
  if (copyInput) {
    const copyButton = document.getElementById("copy-button");
    const copyText = document.getElementById("copy-text");
    const websiteInput = document.getElementById("website-input");

    copyButton.addEventListener("click", () => {
      navigator.clipboard.writeText(websiteInput.value).then(() => {
        copyText.textContent = "Copied";

        setTimeout(() => {
          copyText.textContent = "Copy";
        }, 2000);
      });
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("search-input");
  const searchButton = document.getElementById("search-button");

  function focusSearchInput() {
    searchInput.focus();
  }

  searchButton.addEventListener("click", focusSearchInput);

  document.addEventListener("keydown", function (event) {
    if ((event.metaKey || event.ctrlKey) && event.key === "k") {
      event.preventDefault();
      focusSearchInput();
    }
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "/" && document.activeElement !== searchInput) {
      event.preventDefault();
      focusSearchInput();
    }
  });
});


console.log("sahosss");



document.addEventListener('DOMContentLoaded', function() {

        // Password toggle
    const togglePassword = document.querySelectorAll('.toggle-password');
    if (togglePassword) {
        togglePassword.forEach(function(element) {
            element.addEventListener('click', function() {
                const passwordInput = this.previousElementSibling;
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    }

    // Modal functions - Define filterModal here to ensure it's in the DOM
    const filterModal = document.getElementById('filterModal');
    const openModalButton = document.getElementById('openFilterModalButton');

    if (openModalButton) {
        openModalButton.addEventListener('click', function() {
            if (filterModal) {
                filterModal.classList.remove('hidden');
                console.log('Modal opened. Hidden class removed.');
            } else {
                console.error('Filter Modal element not found!');
            }
        });
    }

    // Modal close buttons
    const closeModalButton = filterModal ? filterModal.querySelector('#closeFilterModalButton') : null;
    if (closeModalButton) {
        closeModalButton.addEventListener('click', function() {
            if (filterModal) {
                filterModal.classList.add('hidden'); 
                console.log('Modal closed. Hidden class added.');
            } else {
                console.error('Filter Modal element not found!');
            }
        });
    }

    // Modal click outside
    window.addEventListener('click', function(event) {
        if (event.target === filterModal) {
            if (filterModal && !filterModal.classList.contains('hidden')) {
                filterModal.classList.add('hidden');
                console.log('Modal closed by outside click. Hidden class added.');
            }
        }
    });

    // Escape presh Modal for close
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            if (filterModal && !filterModal.classList.contains('hidden')) {
                filterModal.classList.add('hidden');
                console.log('Modal closed by Escape key. Hidden class added.');
            }
        }
    });


    // Dropdown
    document.querySelectorAll('[id^="options-menu-"]').forEach(button => {
        button.addEventListener('click', function() {
            const dropdown = this.nextElementSibling;
            const allDropdowns = document.querySelectorAll('[id^="options-menu-"] + div');

            allDropdowns.forEach(otherDropdown => {
                if (otherDropdown !== dropdown && !otherDropdown.classList.contains('hidden')) {
                    otherDropdown.classList.add('hidden');
                }
            });
            dropdown.classList.toggle('hidden');
        });
    });

    window.addEventListener('click', function(event) {
        if (!event.target.closest('[id^="options-menu-"]') && !event.target.closest('[role="menu"]')) {
            const allDropdowns = document.querySelectorAll('[id^="options-menu-"] + div');
            allDropdowns.forEach(dropdown => {
                if (!dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                }
            });
        }
    });
});
