import Menu from './menu';
import Search from './search';
import Country from './country';

export default class Header {
  // DOM elements
  headerElement = document.getElementById('header');
  mainElement = document.getElementById('main-pane');

  // Children js elements
  menu;
  search;
  country;

  // Scroll controls
  previousScrollPosition = window.scrollY;
  scrollOffset = 70;

  constructor () {
    // Initialize children
    this.menu = new Menu(this);
    this.search = new Search(this);
    this.country = new Country(this);

    // Change menu display on scroll
    document.addEventListener('scroll', () => {
      const { scrollY: y } = window;
      
      // Hide header if scrolling down
      if (!this.onTopOfPage() && this.previousScrollPosition <= y) this.hideHeader();
      else this.showHeader();
      
      this.previousScrollPosition = y;
    });
  }

  // Show header main panel, and add sticky if not scrolled up
  showHeader = () => { 
    this.headerElement.classList.add('show-main-pane'); 
    this.toggleSticky(!this.onTopOfPage());
  }

  // Hide header main panel and sticky classes
  hideHeader = () => { 
    this.headerElement.classList.remove('show-main-pane', 'sticky'); 
  }

  // Check if the current window scroll is within header height threshold
  onTopOfPage = () => window.scrollY <= this.scrollOffset;

  // Callback from children element to manage panels display
  hideAllPanels = () => { 
    this.search.hideSearch();
    this.country.hideCountry();
  }
  
  //
  toggleSticky = visible => {
    this.headerElement.classList[visible ? 'add' : 'remove']('sticky');
  }
}
