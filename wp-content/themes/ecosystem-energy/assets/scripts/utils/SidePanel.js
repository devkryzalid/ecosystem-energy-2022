// Dependancies
import axios from 'axios';

export default class SidePanel {
  container;
  visible;

  constructor () {
    this.container = document.getElementById('side-panel');
    
    // Add click listeners to all grid items
    document.querySelectorAll('.expertise-item').forEach(link => {
      link.addEventListener('click', this.openPanel);
    })
  }

  // Toggle
  togglePanel = (visible = null) => {
    this.visible = visible === null
      ? !this.visible
      : !!visible;

    if (this.visible) this.container.classList.add('show');
    else this.container.classList.remove('show');
  }

  replaceHTML = html => {
    this.container.innerHTML = html || 'NO DATA';
    // document.getElementById('panel-prev').addEventListener('click', this.loadNextPage)
    // document.getElementById('panel-next').addEventListener('click', this.loadPreviousPage)
    document.getElementById('panel-close').addEventListener('click', () => this.togglePanel(false))
  }

  getExpertise = async id => {
    return await axios.post('/ajax/fr/expertise/' + id)
      .then(response => {
        console.log('AJAX RESPONSE:', response);
        return response;
      })
      .catch(error => {
        console.log('AJAX ERROR:', error);
        return false;
      });
  }

  openPanel = async event => {
    this.togglePanel(true);
    const id = event.target.dataset.expertise;
    console.log('OPEN ID:', id);
    const { data } = await this.getExpertise(id);
    this.replaceHTML(data);
  }

  loadNextPage = () => {

  }

  loadPreviousPage = () => {
    
  }
}