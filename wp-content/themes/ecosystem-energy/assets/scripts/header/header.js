import Menu from './menu';
import Search from './search';
import Country from './country';

export default class Header {
  mainElement = document.getElementById('main-pane');

  // Children js elements
  menu;
  search;
  country;

  previousScrollPosition = window.scrollY;
  scrollOffset = 90;

  constructor () {
    // Initialize children
    this.menu = new Menu(this);
    this.search = new Search(this);
    this.country = new Country(this);

    // Change menu display on scroll
    document.addEventListener('scroll', () => {
      const { scrollY: pos } = window;
      
      // Show header if on top of the page
      if (pos <= this.scrollOffset) this.showHeader();

      // Else determine if it is shown or hidden, depending on scroll position
      else {
        if (this.previousScrollPosition <= pos) this.hideHeader();
        else this.showHeader();
      }
      
      this.previousScrollPosition = pos;
    });
  }

  // Display management
  showHeader = () => { this.mainElement.classList.add('show'); }
  hideHeader = () => { this.mainElement.classList.remove('show'); }

  // Callback from children element to manage panels display
  hideAllPanels = () => { 
    this.search.hideSearch();
    this.country.hideCountry();
  }
}
