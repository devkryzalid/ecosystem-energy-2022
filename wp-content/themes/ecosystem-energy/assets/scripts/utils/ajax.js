/*
  AjaxForm class
  This script wraps the structure of a page to automate ajax data fetching on form change.
  It also manages pagination and updates the current url params to match selected fields.

  The page must contain the following elements:
    - A form (default #ajax-form)
    - A hidden input (default #ajax-settings) inside the form element with options (data-url, data-limit, etc)
    - An ajax outer container (default #ajax-content), containing an element where data will be loaded (default .inner)

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

export default class AjaxForm {
  // DOM containers for form and ajax html results
  formContainer;
  contentContainer;
  innerContainer;

  // Status 
  loading = false;
  error = false;

  // Properties
  url;
  limit;
  currentPage;
  nbPages;
  // filtersVisible;
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
    if (!this.innerContainer) console.log('Error - Ajax content container .' + innerClass + ' not found');

    // Get form settings from hidden input
    const { url, limit = 9 } = document.getElementById(settingsId).dataset || {};
    this.limit = limit;

    this.url = url;
    if (!this.url) console.log('Error - Ajax url not found');

    // Attach callback functions if available
    if (onDataChangeCallback) this.onDataChange = onDataChangeCallback; // Called when ajax data is changed
    if (onLoadChangeCallback) this.onLoadChange = onLoadChangeCallback; // Called when loading status is changed

    // Add change listener to form checkboxes
    this.formContainer.addEventListener('change', this.onFormChange);

    // Add click listener to clear button
    const clearButton = document.getElementById('clear-filters');
    if (clearButton) clearButton.addEventListener('click', this.clearFilters);

    // Apply filters from url query string
    this.applyFiltersFromUrl();

    // Initialize pagination for non-ajax first load
    this.initPagination();

    // Set clear button visibility
    this.toggleClearButton();
    
    // Set filters counter on button
    this.setActiveFiltersCount();
  }

  // Main form change callback
  onFormChange = async () => {
    this.updateContentHtml();
    this.scrollToContent();
    this.toggleLoading(true);

    const params = this.getFormData();
    const { data } = await this.fetchAjax(params);
    await this.timeout(300);  // Optionnal - delay before loader fadeout
    this.updateCurrentUrl(params);

    this.toggleLoading(false);
    this.updateContentHtml(data);
    this.onDataChange(data);
    this.toggleClearButton();
    this.setActiveFiltersCount();
  }

  //
  setActiveFiltersCount = () => {
    const counter = document.getElementById('filters-count');
    counter.innerHTML = '';
    const nb = this.countActiveFilters();
    if (counter && nb) counter.innerHTML = `(${ nb })`;
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
    if (this.currentPage > 1) params.pg = this.currentPage;
    return { ...params, limit: this.limit };
  }

  // Parse current url and check all checkboxes accordingly
  applyFiltersFromUrl = () => {
    new URL(window.location.href).searchParams.forEach((values, param) => {
      // Change page if in params
      if (param === 'pg') this.currentPage = values;
      // Checkbox management
      else {
        values.split(',').forEach(id => {
          const el = document.getElementById(`${param}-${id}`);
          if (el) el.checked = true;
        });
      }
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
  
  // Show/hide clear button depending on checked filters
  toggleClearButton = () => {
    const filtersActive = !![...this.formContainer.querySelectorAll('input:checked')].length;
    document.getElementById('clear-filters').style.display = filtersActive ? 'block' : 'none';
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

  // Un-check all boxes and reload data
  clearFilters = () => {
    this.formContainer.querySelectorAll('input:checked').forEach(i => { i.checked = false; });

    // Check the current locale
    const locale = document.querySelector('#header .countries input:checked');
    if (locale) {
      const cb = this.formContainer.querySelector('#locale-' + locale.value);
      if (cb) cb.checked = true;
    }

    this.onFormChange();
  }

  // Fetch first part of current url, and remove trailing slash
  getCurrentUrlPrefix = () => {
    const urlPrefix = window.location.href.split('?')[0];
    return urlPrefix.slice(-1) === '/' ? urlPrefix.slice(0, -1) : urlPrefix;
  }

  // Set event listeners on pagination elements
  initPagination = () => {
    const container = document.getElementById(paginationId);
    if (!container) return false;

    const pageButtons = container.querySelectorAll('.ajax-page');
    this.nbPages = parseInt(pageButtons[pageButtons.length - 2].innerText);

    // Set disabled class on prev/next if needed
    if (this.currentPage === 1) container.querySelector('.prev').classList.add('disabled');
    if (this.currentPage == this.nbPages) container.querySelector('.next').classList.add('disabled');
    
    // Set click listener on page buttons
    pageButtons.forEach(page => { page.addEventListener('click', e => this.pageChange(e.target)); });
  }

  // Change current page and trigger ajax fetch
  pageChange = pageElement => {
    const value = pageElement.getAttribute('value');

    // Ignore '...' buttons
    if (!['prev', 'next', 'prec', 'suiv'].includes(value) && isNaN(parseInt(value))) return;
    
    // Toggle selected classes
    document.querySelector('.ajax-page.current').classList.remove('current');
    pageElement.classList.add('current');

    // Set current page
    if (value === 'prev') 
      this.currentPage = this.currentPage > 1 ? this.currentPage - 1 : 1;
    else if (value === 'next') 
      this.currentPage = this.currentPage < this.nbPages ? this.currentPage + 1 : this.nbPages;
    else this.currentPage = +value;
  
    // Reload ajax content
    this.scrollToContent();
    this.onFormChange();
  }

  // Count total active filters
  countActiveFilters = () => {
    return this.formContainer.querySelectorAll('input:checked').length;
  }

  // Scroll to loaded ajax content
  scrollToContent = () => {
    setTimeout(() => { window.scroll({ top: this.formContainer.offsetTop - 150, behavior: 'smooth' }); }, 10); 
  }
  
  // Delay helper
  timeout = async ms => {
    return new Promise(resolve => setTimeout(resolve, ms));
  }
}