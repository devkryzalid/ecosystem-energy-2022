export default class Menu {
  // Header class reference (for callbacks)
  header;

  // DOM elements
  body = document.body;
  container = document.getElementById('menu');
  button = document.getElementById('menu-toggle');
  
  visible = false;

  constructor (headerRef) {
    this.header = headerRef;
    
    // Add click listener to burger/close menu button
    this.button.addEventListener('click', () => this.toggle());

    // Add click listener to all secondary menu triggers
    document.querySelectorAll('.secondary-link').forEach(link => {
      link.addEventListener('click', this.openSecondaryMenu)
    })
  }

  // Menu display toggler
  toggle = (forcedValue = null) => {
    this.closeAllSecondaryMenus();

    // Set forced value if available, otherwise set to opposite of current value
    this.visible = forcedValue === null
      ? !this.visible
      : !!forcedValue;

    if (this.visible) this.openMainMenu();
    else this.closeMainMenu();
  }

  // Primary menu controls
  openMainMenu = () => {
    this.container.classList.add('show');
    this.body.classList.add('menu-open');
  }

  closeMainMenu = () => {
    this.container.classList.remove('show');
    this.body.classList.remove('menu-open');
  }

  // Secondary menu controls
  openSecondaryMenu = event => {
    this.closeAllSecondaryMenus();
    const menu = event.target.parentNode.querySelector('.secondary-menu');
    menu.classList.add('show')
  }

  closeAllSecondaryMenus = () => {
    document.querySelectorAll('.secondary-menu').forEach(menu => {
      menu.classList.remove('show');
    })
  }
}