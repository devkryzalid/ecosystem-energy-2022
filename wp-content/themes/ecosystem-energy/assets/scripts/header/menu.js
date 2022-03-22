export default class Menu {
  // Header class reference (for callbacks)
  header;

  // DOM elements
  body = document.body;
  container = document.getElementById('menu');
  button = document.getElementById('menu-toggle');
  primaryMenu = document.getElementById('primary-menu');
  
  visible = false;
  open = false;
  transition = false;

  constructor (headerRef) {
    this.header = headerRef;
    
    // Add click listener to burger/close menu button and image
    this.button.addEventListener('click', () => this.toggle());
    this.container.querySelector('#menu-image').addEventListener('click', () => this.toggle());

    // Add click listener to all secondary menu triggers
    document.querySelectorAll('.secondary-link').forEach(link => {
      link.addEventListener('click', this.openSecondaryMenu)
    })

    // Add click listener to all back links (to close secondary menus)
    document.querySelectorAll('.secondary-menu .back').forEach(link => {
      link.addEventListener('click', this.closeAllSecondaryMenus)
    })
  }

  // Menu display toggler
  toggle = (forcedValue = null) => {
    // 
    if (this.transition) {
      if (this.open) this.onMenuClosed();
      else this.onMenuComplete();
    }

    this.closeAllSecondaryMenus();

    // Set forced value if available, otherwise set to opposite of current value
    this.visible = forcedValue === null
      ? !this.visible
      : !!forcedValue;

    if (this.visible) this.openMainMenu();
    else this.closeMainMenu();
  }

  // Show primary menu
  openMainMenu = () => {
    this.transition = true;
    this.container.classList.add('show');
    this.primaryMenu.addEventListener('transitionend', this.onMenuComplete);
    this.body.classList.add('menu-open');
  }

  // Hide primary menu
  closeMainMenu = () => {
    this.transition = true;
    this.container.classList.remove('show');
    this.container.addEventListener('transitionend', this.onMenuClosed);
    this.body.classList.remove('menu-open');
  }

  // Switch on opened status (on transition end)
  onMenuComplete = () => {
    this.open = true;
    this.transition = false;
    this.container.classList.add('-on');
    this.primaryMenu.removeEventListener('transitionend', this.onMenuComplete);
  }

  // Switch on closed status (on transition end)
  onMenuClosed = () => {
    this.open = false;
    this.transition = false;
    this.container.classList.remove('-on');
    this.container.removeEventListener('transitionend', this.onMenuClosed);
  }

  // Secondary menu controls
  openSecondaryMenu = event => {
    this.closeAllSecondaryMenus();
    const itemContainingMenu = event.target.parentNode;
    itemContainingMenu.classList.add('show')
  }

  closeAllSecondaryMenus = () => {
    document.querySelectorAll('li.show').forEach(menu => {
      menu.classList.remove('show');
    })
  }
}