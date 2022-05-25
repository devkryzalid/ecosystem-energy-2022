import AjaxForm from '../utils/ajax';

// Initialize ajax form 
const ajaxForm = new AjaxForm();

//
document.getElementById('search-clear').addEventListener('click', () => {
  document.getElementById('s').value = '';
  document.querySelector('#ajax-content .inner').innerHTML = '';
})