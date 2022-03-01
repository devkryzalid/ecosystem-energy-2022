export default class Search {
  header; // Header class reference (for callbacks)
  headerElement = document.getElementById('header');
  searchElement = document.getElementById('search-pane');
  searchVisible = false;

  constructor (headerRef) {
    this.header = headerRef;
    document.getElementById('search-close').addEventListener('click', () => this.toggleSearch(false));
    document.getElementById('search-toggle').addEventListener('click', () => this.toggleSearch());
  }
  
  // Getter
  isVisible = () => this.searchVisible;

  // Search display toggler
  toggleSearch = (forcedValue = null) => {
    // Set forced value if available, otherwise set to opposite of current value
    const show = forcedValue === null
      ? !this.searchVisible
      : !!forcedValue;

    // Hide similar panels
    this.header.hideAllPanels();

    // Toggle panel visibility
    if (show) this.showSearch();
    else this.hideSearch();
  }

  // Show top search element and focus on input field
  showSearch = () => {
    this.searchVisible = true;
    this.headerElement.classList.add('show-search-pane');
    this.searchElement.querySelector('input').focus();
  }

  // Blur top search field input and hide element
  hideSearch = () => {
    this.searchVisible = false;
    this.searchElement.querySelector('input').blur();
    this.headerElement.classList.remove('show-search-pane');
  }
}
