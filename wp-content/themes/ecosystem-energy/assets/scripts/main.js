// Animate on scroll library
import './utils/aos';
// 
import './utils/jsBlockLink';
// Custom gutenberg blocks
import './utils/custom-blocks';
// Initialize contact-cta spinner animation
import './utils/cta-spinner';

// Initialize header, which manages search field, country toggler and menu 
import Header from './header/header';
const header = new Header();

// Change WPML selector tag
const wpmlSelector = document.querySelector('.wpml-ls-native');
if (wpmlSelector) wpmlSelector.innerHTML = wpmlSelector.innerHTML.slice(0, 2).toUpperCase();