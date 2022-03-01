export default class Country {
  header; // Header class reference (for callbacks)
  headerElement = document.getElementById('header');
  countryVisible = false;

  constructor (headerRef) {
    this.header = headerRef;

    // Toggle buttons
    document.getElementById('country-close').addEventListener('click', () => this.toggleCountry(false));
    document.getElementById('country-toggle').addEventListener('click', () => this.toggleCountry());

    // Submit button
    document.getElementById('country-set').addEventListener('click', () => console.log('SET COUNTRY'));
  }

  // Country display toggler
  toggleCountry = (forcedValue = null) => {
    // Set forced value if available, otherwise set to opposite of current value
    const show = forcedValue === null
      ? !this.countryVisible
      : !!forcedValue;

    // Hide similar panels
    this.header.hideAllPanels();
    
    // Toggle panel visibility
    if (show) this.showCountry();
    else this.hideCountry();
  }

  // 
  showCountry = () => {
    this.countryVisible = true;
    this.headerElement.classList.add('show-country-pane');
  }

  // 
  hideCountry = () => {
    this.countryVisible = false;
    this.headerElement.classList.remove('show-country-pane');
  }
}
