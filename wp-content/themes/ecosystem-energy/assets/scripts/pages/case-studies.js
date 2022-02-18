import AjaxForm from '../utils/ajax'

const form = new AjaxForm();

let showFilters = false;
const formElement = document.getElementById('ajax-form');
const btnElement = document.getElementById('toggle-filters');

btnElement.addEventListener('click', () => {
  showFilters = !showFilters;
  if (showFilters) formElement.classList.add('show');
  else formElement.classList.remove('show');
})