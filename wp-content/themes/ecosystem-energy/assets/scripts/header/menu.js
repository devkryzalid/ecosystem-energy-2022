export default class Menu {
  // Header class reference (for callbacks)
  header;

  // DOM elements
  body = document.body;
  container = document.getElementById('menu');
  button = document.getElementById('menu-toggle');
  image = document.getElementById('menu-image');
  primaryMenu = document.getElementById('primary-menu');
  
  visible = false;
  open = false;
  transition = false;

  constructor (headerRef) {
    this.header = headerRef;
    
    // Add click listener to burger/close menu button and image
    this.button.addEventListener('click', () => this.toggle());
    this.image.addEventListener('click', () => this.toggle());

    // Add click listener to all secondary menu triggers
    document.querySelectorAll('.secondary-link').forEach(link => {
      link.addEventListener('click', this.openSecondaryMenu)
    })

    // Add click listener to all back links (to close secondary menus)
    document.querySelectorAll('.secondary-menu .back').forEach(link => {
      link.addEventListener('click', this.closeAllSecondaryMenus)
    })

    // Get current section from URL, and select corresponding menu item
    const section = window.location.pathname
      .split('/')
      .filter(p => p !== '' && p !== 'fr')[0];
      
    if (section) {
      const selectedMenuItem = document.querySelector(`.primary-link[href*="/${ section }"]`);
      if (selectedMenuItem) selectedMenuItem.classList.add('selected');
    }
  }

  // Menu display toggler
  toggle = (forcedValue = null) => {
    // Complete animation if currently in transition
    if (this.transition) this[this.open ? 'onMenuClosed' : 'onMenuComplete']();

    this.closeAllSecondaryMenus();

    // Set forced value if available, otherwise set to opposite of current value
    this.visible = forcedValue === null
      ? !this.visible
      : !!forcedValue;

    this[this.visible ? 'openMainMenu' : 'closeMainMenu']();
  }

  // Start menu opening animation
  openMainMenu = () => {
    this.header.toggleSticky(false);
    this.transition = true;
    this.body.classList.add('menu-opening');
    this.image.addEventListener('transitionend', this.onMenuComplete);
  }

  // Menu opening animation complete
  onMenuComplete = () => {
    this.open = true;
    this.body.classList.add('menu-open');
    this.transition = false;
    this.body.classList.remove('menu-opening');
    this.image.removeEventListener('transitionend', this.onMenuComplete);
  }

  // Hide primary menu
  closeMainMenu = () => {
    if (!this.header.onTopOfPage()) this.header.toggleSticky(true);
    this.open = false;
    this.transition = true;
    this.body.classList.remove('menu-open');
    this.body.classList.add('menu-closing');
    this.container.addEventListener('transitionend', this.onMenuClosed);
  }

  // Switch on closed status (on transition end)
  onMenuClosed = () => {
    this.transition = false;
    this.body.classList.remove('menu-closing');
    this.container.removeEventListener('transitionend', this.onMenuClosed);
  }

  // Secondary menu controls
  openSecondaryMenu = event => {
    this.closeAllSecondaryMenus();
    const itemContainingMenu = event.target.parentNode;
    itemContainingMenu.classList.add('show');

    // Set secondary-menu top padding based on the position of the first main menu item
    if (window.innerWidth > 991) {
      const top = document.querySelector('.primary-inner').offsetTop;
      itemContainingMenu.querySelector('.secondary-menu').style.paddingTop = top + 'px';
    }
  }

  closeAllSecondaryMenus = () => {
    document.querySelectorAll('li.show').forEach(menu => menu.classList.remove('show'))
  }
}