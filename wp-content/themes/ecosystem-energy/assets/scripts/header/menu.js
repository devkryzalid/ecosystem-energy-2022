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

  // Start menu opening animation
  openMainMenu = () => {
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

  // toggleMenu = open => {
  //   this.open = !!open;
  //   if (this.open) this.body.classList.add('menu-open');
  //   else this.body.classList.remove('menu-open');
  // }

  // toggleTransition = enable => {
  //   this.transition = !!enable;
  //   if (this.transition) this.body.classList.add('menu-transition');
  //   else this.body.classList.remove('menu-transition');
  // }

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