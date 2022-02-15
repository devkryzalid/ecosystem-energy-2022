import AjaxForm from '../utils/ajax'

const form = new AjaxForm(
  { 
    // Override default element ids
    formId: 'side-filters',
    containerId: 'js-api-container',
    settingsId: 'ajax-settings'
  }, 
  // Optional callbacks
  data => {  },
  loading => {  }
);

console.log('page1');