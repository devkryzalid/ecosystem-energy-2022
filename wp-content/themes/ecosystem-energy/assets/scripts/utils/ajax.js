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

  loading = false;

  url;
  limit;

  // Callbacks
  onDataChange = () => {};
  onLoadChange = () => {};

  constructor ({ 
    formId = defaultFormId, 
    containerId = defaultContainerId,
    settingsId = defaultSettingsId 
    }, onDataChangeCallback, onLoadChangeCallback
  ) {
    // Set form and container DOM elements
    this.formContainer = document.getElementById(formId);
    this.contentContainer = document.getElementById(containerId);

    // Get form settings from hidden input
    const { url, limit } = this.formContainer.querySelector('#' + settingsId).dataset;
    this.url = url;
    this.limit = limit;

    // Add callback if needed
    if (onDataChangeCallback) this.onDataChange = onDataChangeCallback;
    if (onLoadChangeCallback) this.onLoadChange = onLoadChangeCallback;

    // Add change listener to form
    this.formContainer.addEventListener('change', this.onFormChange);
  }

  // Main form change callback
  onFormChange = async () => {
    this.updateContentHtml();
    this.toggleLoading(true);

    const params = this.getFormData();
    const { data } = await this.fetchAjax(params);
    this.updateUrl(params);

    this.toggleLoading(false);
    this.updateContentHtml(data.html);
    this.onDataChange(data);

  }

  // Return all form data in object format
  getFormData = () => {
    const pairs = new FormData(this.formContainer).entries();
    return [...pairs].reduce((params, [key, value]) => ({ ...params, [key]: [...(params[key] || []), value] }), {});
  }

  // Axios ajax call
  fetchAjax = async data => {
    return await axios.post(this.url, data)
      .then(response => { 
        // console.log('RESPONSE:', response); 
        return response;
      })
      .catch(error => { 
        console.log('ERROR:', error); 
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
    this.contentContainer.querySelector('.' + innerClass).innerHTML = html;
  }

  // Replace current url param string with new params
  updateUrl = params => {
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