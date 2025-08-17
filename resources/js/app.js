import './bootstrap';

// import "jsvectormap/dist/jsvectormap.min.css";
// import "flatpickr/dist/flatpickr.min.css";
// import "dropzone/dist/dropzone.css";
import './../css/app.css';

import Alpine from "alpinejs";
import persist from "@alpinejs/persist";
import flatpickr from "flatpickr";
// import Dropzone from "dropzone";


// import "./components/calendar-init.js";
// import "./components/image-resize";

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
    // eslint-disable-next-line no-param-reassign
    instance.element.value = dateStr.replace("to", "-");
    const customClass = instance.element.getAttribute("data-class");
    instance.calendarContainer.classList.add(customClass);
  },
  onChange: (selectedDates, dateStr, instance) => {
    // eslint-disable-next-line no-param-reassign
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

// For Copy//
document.addEventListener("DOMContentLoaded", () => {
  const copyInput = document.getElementById("copy-input");
  if (copyInput) {
    // Select the copy button and input field
    const copyButton = document.getElementById("copy-button");
    const copyText = document.getElementById("copy-text");
    const websiteInput = document.getElementById("website-input");

    // Event listener for the copy button
    copyButton.addEventListener("click", () => {
      // Copy the input value to the clipboard
      navigator.clipboard.writeText(websiteInput.value).then(() => {
        // Change the text to "Copied"
        copyText.textContent = "Copied";

        // Reset the text back to "Copy" after 2 seconds
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

  // Function to focus the search input
  function focusSearchInput() {
    searchInput.focus();
  }

  // Add click event listener to the search button
  searchButton.addEventListener("click", focusSearchInput);

  // Add keyboard event listener for Cmd+K (Mac) or Ctrl+K (Windows/Linux)
  document.addEventListener("keydown", function (event) {
    if ((event.metaKey || event.ctrlKey) && event.key === "k") {
      event.preventDefault(); // Prevent the default browser behavior
      focusSearchInput();
    }
  });

  // Add keyboard event listener for "/" key
  document.addEventListener("keydown", function (event) {
    if (event.key === "/" && document.activeElement !== searchInput) {
      event.preventDefault(); // Prevent the "/" character from being typed
      focusSearchInput();
    }
  });
});


console.log("sahosss");


// public/js/modals-and-dropdowns.js (or resources/js/app.js)

document.addEventListener('DOMContentLoaded', function() {
    // Modal functions - Define filterModal here to ensure it's in the DOM
    const filterModal = document.getElementById('filterModal');
    const openModalButton = document.getElementById('openFilterModalButton');

    if (openModalButton) {
        openModalButton.addEventListener('click', function() {
            if (filterModal) {
                filterModal.classList.remove('hidden'); // Remove hidden to show modal (flex should apply)
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
                filterModal.classList.add('hidden'); // Add hidden to hide modal
                console.log('Modal closed. Hidden class added.');
            } else {
                console.error('Filter Modal element not found!');
            }
        });
    }

    // Modal এর বাইরে ক্লিক করলে বন্ধ করার জন্য
    window.addEventListener('click', function(event) {
        if (event.target === filterModal) { // নিশ্চিত করুন যে ক্লিকটি Modal এর ব্যাকড্রপে হয়েছে
            if (filterModal && !filterModal.classList.contains('hidden')) { // Only close if it's open
                filterModal.classList.add('hidden');
                console.log('Modal closed by outside click. Hidden class added.');
            }
        }
    });

    // Escape কী চাপলে Modal বন্ধ করার জন্য
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            if (filterModal && !filterModal.classList.contains('hidden')) { // Only close if it's open
                filterModal.classList.add('hidden');
                console.log('Modal closed by Escape key. Hidden class added.');
            }
        }
    });

    // প্রজেক্ট অ্যাকশন ড্রপডাউন টগল করার জন্য
    document.querySelectorAll('[id^="options-menu-"]').forEach(button => {
        button.addEventListener('click', function() {
            const dropdown = this.nextElementSibling; // বর্তমান ক্লিক করা বাটনের ড্রপডাউন
            const allDropdowns = document.querySelectorAll('[id^="options-menu-"] + div'); // সকল ড্রপডাউন

            // সকল খোলা ড্রপডাউন বন্ধ করুন, যদি সেটি বর্তমান ড্রপডাউন না হয়
            allDropdowns.forEach(otherDropdown => {
                if (otherDropdown !== dropdown && !otherDropdown.classList.contains('hidden')) {
                    otherDropdown.classList.add('hidden');
                }
            });

            // বর্তমান ড্রপডাউন টগল করুন
            dropdown.classList.toggle('hidden');
        });
    });

    // ড্রপডাউন বন্ধ করুন যদি ড্রপডাউন বাটন বা ড্রপডাউন মেনুর বাইরে ক্লিক করা হয়
    window.addEventListener('click', function(event) {
        // নিশ্চিত করুন যে ক্লিকটি কোনো ড্রপডাউন বাটন বা ড্রপডাউন মেনুর অংশ নয়
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
