export default class Search {
  // Header class reference (for callbacks)
  header;

  // DOM elements
  searchElement = document.getElementById('search-pane');
  searchToggleElement = document.getElementById('search-toggle');
  searchCloseElement = document.getElementById('search-close');

  searchVisible = false;

  constructor (headerRef) {
    this.header = headerRef;

    this.searchToggleElement.addEventListener('click', () => this.toggleSearch());
    this.searchCloseElement.addEventListener('click', () => this.toggleSearch(false));
  }

  // Search display toggler
  toggleSearch = (forcedValue = null) => {
    // Hide similar panels
    this.header.hideAllPanels();
    
    // Set forced value if available, otherwise set to opposite of current value
    const show = forcedValue === null
      ? !this.searchVisible
      : !!forcedValue;

    if (show) this.showSearch();
    else this.hideSearch();
    console.log(this.searchVisible);
  }

  // Show top search element and focus on input field
  showSearch = () => {
    this.searchVisible = true;
    this.searchElement.classList.add('show');
    this.searchElement.querySelector('input').focus();
  }

  // Blur top search field input and hide element
  hideSearch = () => {
    this.searchVisible = false;
    this.searchElement.querySelector('input').blur();
    this.searchElement.classList.remove('show');
  }
}
