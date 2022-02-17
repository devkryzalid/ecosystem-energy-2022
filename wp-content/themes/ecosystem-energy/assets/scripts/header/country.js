export default class Country {
  // Header class reference (for callbacks)
  header;

  // DOM elements
  countryElement = document.getElementById('country-pane');
  countryToggleElement = document.getElementById('country-toggle');
  countrySetElement = document.getElementById('country-set');
  countryCloseElement = document.getElementById('country-close');

  countryVisible = false;

  constructor (headerRef) {
    this.header = headerRef;

    this.countryToggleElement.addEventListener('click', () => this.toggleCountry());
    this.countrySetElement.addEventListener('click', () => console.log('BLOP'));
    this.countryCloseElement.addEventListener('click', () => this.toggleCountry(false));
  }

  // Country display toggler
  toggleCountry = (forcedValue = null) => {
    // Hide similar panels
    this.header.hideAllPanels();

    // Set forced value if available, otherwise set to opposite of current value
    const show = forcedValue === null
      ? !this.countryVisible
      : !!forcedValue;
      
    if (show) this.showCountry();
    else this.hideCountry();
  }

  // 
  showCountry = () => {
    this.countryVisible = true;
    this.countryElement.classList.add('show');
  }

  // 
  hideCountry = () => {
    this.countryVisible = false;
    this.countryElement.classList.remove('show');
  }
}
