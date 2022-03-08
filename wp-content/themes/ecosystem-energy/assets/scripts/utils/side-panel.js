// Dependancies
import axios from 'axios';

export default class SidePanel {
  container = document.getElementById('side-panel-ctn');
  innerContainer = document.getElementById('panel-content');

  visible = false;

  constructor () {
    // Add click listeners to all grid items
    document.querySelectorAll('.expertise-item').forEach(link => {
      link.addEventListener('click', this.openPanel);
    })

    // Close panel when overlay is clicked
    this.container.querySelector('#panel-overlay').addEventListener('click', () => this.togglePanel(false))
  }

  // Toggle panel visibility
  togglePanel = (visible = null) => {
    this.visible = visible === null
      ? !this.visible
      : !!visible;

    if (this.visible) this.container.classList.add('show');
    else this.container.classList.remove('show');
  }

  // Load data and render template with event listeners
  loadExpertise = async id => {
    const { data } = await this.getExpertise(id);
    this.innerContainer.innerHTML = data;

    document.getElementById('panel-prev').addEventListener('click', this.replaceExpertise)
    document.getElementById('panel-next').addEventListener('click', this.replaceExpertise)
    document.getElementById('panel-close').addEventListener('click', () => this.togglePanel(false))
  }

  // Fetch ajax template
  getExpertise = async id => {
    return await axios.post('/ajax/fr/expertise/' + id)
      .then(response => {
        // console.log('AJAX RESPONSE:', response);
        return response;
      })
      .catch(error => {
        console.log('AJAX ERROR:', error);
        return false;
      });
  }

  // Open panel and load expertise when grid item clicked
  openPanel = event => {
    this.togglePanel(true);
    const id = event.target.dataset.expertise;
    this.loadExpertise(id);
    window.scrollTo({ top: 0 })
  }

  // Replace expertise when prev/next button clicked
  replaceExpertise = event => {
    const id = event.target.dataset.expertise;
    this.loadExpertise(id);
  }
}