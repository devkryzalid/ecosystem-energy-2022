import AjaxForm from '../utils/ajax';

// Initialize ajax form 
const ajaxForm = new AjaxForm();

// Filters DOM elements
const formContainer = document.getElementById('ajax-form');
const toggleButton = document.getElementById('toggle-filters');

// Assign toggle function to button and window resize
const toggleFilter = () => {
  if (formContainer.classList.contains('show')) {
    formContainer.classList.remove('show');
    toggleButton.classList.remove('open');
    formContainer.style.height = 0;
  }
  else {
    formContainer.classList.add('show');
    toggleButton.classList.add('open');
    formContainer.style.height = formContainer.scrollHeight + 'px';
  }
}

toggleButton.addEventListener('click', toggleFilter);
window.addEventListener('resize', toggleFilter);