// Dependancies
import axios from 'axios';

// Default values
const defaultFormId = 'ajax-form'
const defaultContainerId = 'ajax-content'
const defaultSettingsId = 'ajax-settings'

const loadingClass = 'loading';
const innerClass = 'inner';

export default class AjaxForm {
  // DOM containers for form and ajax html results
  formContainer;
  contentContainer;
  innerContainer;

  loading = false;
  error = false;

  url;
  limit;

  // Callbacks
  onDataChange = () => {};
  onLoadChange = () => {};

  constructor (
    { formId = defaultFormId, containerId = defaultContainerId, settingsId = defaultSettingsId } = {}, 
    onDataChangeCallback = null, onLoadChangeCallback = null
  ) {
    // Set form and container DOM elements
    this.formContainer = document.getElementById(formId);
    if (!this.formContainer) console.log('Error - Ajax form container #' + formId + ' can\'t be found');

    this.contentContainer = document.getElementById(containerId);
    if (!this.contentContainer) console.log('Error - Ajax content container #' + containerId + ' can\'t be found');

    this.innerContainer = this.contentContainer.querySelector('.' + innerClass);
    if (!this.innerContainer) console.log('Error - Ajax .inner content container can\'t be found');

    // Get form settings from hidden input
    const { url, limit } = document.getElementById(settingsId).dataset;
    this.url = url;
    this.limit = limit;

    // Add callback if needed
    if (onDataChangeCallback) this.onDataChange = onDataChangeCallback;
    if (onLoadChangeCallback) this.onLoadChange = onLoadChangeCallback;

    // Add change listener to form
    this.formContainer.addEventListener('change', this.onFormChange);

    // Apply filters from url query string
    this.toggleCheckFromUrl();
  }

  // Main form change callback
  onFormChange = async () => {
    this.updateContentHtml();
    this.toggleLoading(true);

    const params = this.getFormData();
    const { data } = await this.fetchAjax(params);
    this.updateCurrentUrl(params);

    this.toggleLoading(false);
    this.updateContentHtml(data);
    this.onDataChange(data);

  }

  // Return all form data in object format
  getFormData = () => {
    const pairs = new FormData(this.formContainer).entries();
    return [...pairs].reduce((params, [key, value]) => ({ ...params, [key]: [...(params[key] || []), value] }), {});
  }

  //
  toggleCheckFromUrl = () => {
    new URL(window.location.href).searchParams.forEach((values, param) => {
      values.split(',').forEach(id => {
        const el = document.getElementById(`${param}-${id}`);
        if (el) el.checked = true;
      });
    })
  }

  // Axios ajax call
  fetchAjax = async data => {
    const query = new URLSearchParams(data).toString();
    console.log('AJAX REQUEST:', this.url, query);

    return await axios.post(this.url, query)
      .then(response => { 
        console.log('AJAX RESPONSE:', response); 
        return response;
      })
      .catch(error => { 
        console.log('AJAX ERROR:', error); 
        return false;
      });
  }

  // Toggle loading status, add class to container and throw callback
  toggleLoading = (isLoading = null) => {
    this.loading = isLoading === null 
      ? !this.loading
      : !!isLoading;

    if (this.loading) this.contentContainer.classList.add(loadingClass);
    else this.contentContainer.classList.remove(loadingClass);

    this.onLoadChange(this.loading)
  }

  // Update the content container with new html content
  updateContentHtml = (html = '') => {
    this.innerContainer.innerHTML = html;
  }

  // Replace current url param string with new params
  updateCurrentUrl = params => {
    const searchParams = new URLSearchParams(params).toString();
    const urlPrefix = this.currentUrlPrefix();
    const title = 'Ajax';
    const url = urlPrefix + (Object.keys(params).length ? '?' + searchParams : '');

    history.replaceState({ title, url }, title, url);
  }

  // Fetch first part of current url, and remove trailing slash
  currentUrlPrefix = () => {
    const urlPrefix = window.location.href.split('?')[0]
    return urlPrefix.slice(-1) === '/' ? urlPrefix.slice(0, -1) : urlPrefix;
  }
}