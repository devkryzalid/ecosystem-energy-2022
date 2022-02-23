/*
  AjaxForm class
  This script wraps the structure of a page to automate ajax fetching on form change.
  It also manages pagination and updates the current url to match selected fields.

  The page must contain the following elements:
    - A form (#ajax-form)
    - A hidden input (#ajax-settings) inside the form element with optional 'data-url' and 'data-limit' properties
    - An ajax outer container (#ajax-content), containing an inner element where data will be loaded (.inner)

  Elements ids and classes can be overridden by passing their value to the constructor
*/

// Dependancies
import axios from 'axios';

// Default values
const defaultFormId = 'ajax-form'
const defaultContainerId = 'ajax-content'
const defaultSettingsId = 'ajax-settings'

const loadingClass = 'loading';
const innerClass = 'inner';
const paginationId = 'ajax-pagination'
// TODO: Add more custom class possibilities (ex: pagination elements)

export default class AjaxForm {
  // DOM containers for form and ajax html results
  formContainer;
  contentContainer;
  innerContainer;

  loading = false;
  error = false;

  url;
  limit;
  currentPage;
  nbPages;
  filtersVisible;

  previousParams;

  // Callbacks
  onDataChange = () => { };
  onLoadChange = () => { };

  constructor(
    // Custom element names can be passed in constructor
    { formId = defaultFormId, containerId = defaultContainerId, settingsId = defaultSettingsId } = {},
    // ... as well as callback functions
    onDataChangeCallback = null, onLoadChangeCallback = null
  ) {
    // Set form and container DOM elements
    this.formContainer = document.getElementById(formId);
    if (!this.formContainer) {
      console.log('Error - Ajax form container #' + formId + ' not found');
      return;
    }

    this.contentContainer = document.getElementById(containerId);
    if (!this.contentContainer) console.log('Error - Ajax content container #' + containerId + ' not found');

    this.innerContainer = this.contentContainer.querySelector('.' + innerClass);
    if (!this.innerContainer) console.log('Error - Ajax .inner content container not found');

    // Get form settings from hidden input
    const { url, limit = 9, page = 1 } = document.getElementById(settingsId).dataset || {};
    this.limit = limit;
    this.currentPage = page;

    this.url = url;
    if (!this.url) console.log('Error - Ajax url not found');

    // Attach callback functions if available
    if (onDataChangeCallback) this.onDataChange = onDataChangeCallback;
    if (onLoadChangeCallback) this.onLoadChange = onLoadChangeCallback;

    // Add change listener to form checkboxes
    this.formContainer.addEventListener('change', this.onFormChange);

    // Apply filters from url query string
    this.applyFiltersFromUrl();

    // Initialize pagination for non-ajax first load
    this.initPagination();

    // Set filters toggler
    document.getElementById('toggle-filters').addEventListener('click', () => {
      this.filtersVisible = !this.filtersVisible;
      if (this.filtersVisible) this.formContainer.classList.add('show');
      else this.formContainer.classList.remove('show');
    })
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
    // Fetch all current form values
    const pairs = new FormData(this.formContainer).entries();
    const params = [...pairs].reduce((params, [key, value]) => ({ ...params, [key]: [...(params[key] || []), value] }), {});

    // Reset page to 1 if filters have been modified
    const jsonParams = JSON.stringify(params);
    if (this.previousParams && this.previousParams !== jsonParams) this.currentPage = 1;
    this.previousParams = jsonParams;
    
    // Add paged param if needed
    if (this.currentPage > 1) params.paged = this.currentPage;
    return { ...params, limit: this.limit };
  }

  // Parse current url and check all checkboxes accordingly
  applyFiltersFromUrl = () => {
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
    // console.log('AJAX REQUEST:', this.url, query);

    return await axios.post(this.url, query)
      .then(response => {
        // console.log('AJAX RESPONSE:', response);
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
    if (document.getElementById(paginationId)) this.initPagination();
  }

  // Replace current url param string with new params
  updateCurrentUrl = params => {
    // Get current URL and remove unused params
    const searchParams = new URLSearchParams(params);
    searchParams.delete('limit');

    // Build new url query string
    const urlPrefix = this.getCurrentUrlPrefix();
    const title = 'Ajax';
    const url = urlPrefix + (Object.keys(params).length ? '?' + searchParams.toString() : '');

    history.replaceState({ title, url }, title, url);
  }

  // Fetch first part of current url, and remove trailing slash
  getCurrentUrlPrefix = () => {
    const urlPrefix = window.location.href.split('?')[0];
    return urlPrefix.slice(-1) === '/' ? urlPrefix.slice(0, -1) : urlPrefix;
  }

  // Set event listeners on pagination elements
  initPagination = () => {
    const container = document.getElementById(paginationId);
    if (container) {
      const pageButtons = container.querySelectorAll('.ajax-page');
      this.nbPages = pageButtons.length - 2;  // Exclude prev/next

      // Set disabled class on prev/next if needed
      if (this.currentPage === 1) container.querySelector('.prev').classList.add('disabled');
      if (this.currentPage === this.nbPages) container.querySelector('.next').classList.add('disabled');
      
      // Set click listener on page buttons
      pageButtons.forEach(page => { page.addEventListener('click', e => this.pageChange(e.target)); });
    }
  }

  // Change current page and trigger ajax fetch
  pageChange = pageElement => {
    // Toggle selected classes
    document.querySelector('.ajax-page.current').classList.remove('current');
    pageElement.classList.add('current');

    // Set current page
    const value = pageElement.getAttribute('value');
    if (value === 'prev') 
      this.currentPage = this.currentPage > 1 ? this.currentPage - 1 : 1;
    else if (value === 'next') 
      this.currentPage = this.currentPage < this.nbPages ? this.currentPage + 1 : this.nbPages;
    else this.currentPage = +value;
  
    // Reload ajax content
    this.onFormChange();
  }
}