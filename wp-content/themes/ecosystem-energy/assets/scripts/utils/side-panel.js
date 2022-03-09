/*
  SidePanel class
  This script allows loading of custom content into an overlayed ajax page
*/

// Dependancies
import axios from 'axios';

export default class SidePanel {
  container = document.getElementById('side-panel-ctn');
  innerContainer = document.getElementById('panel-content');

  visible = false;
  url;

  constructor ({ url } = {}) {
    this.url = url || null;

    // Add click listeners to all grid items
    document.querySelectorAll('.link-item').forEach(link => {
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
  loadData = async id => {
    const { data } = this.url 
      ? await this.fetchData(id)
      : this.fetchHtml(id);
    this.innerContainer.innerHTML = data;
    
    document.getElementById('panel-prev').addEventListener('click', this.replaceData);
    document.getElementById('panel-next').addEventListener('click', this.replaceData);
    document.getElementById('panel-close').addEventListener('click', () => this.togglePanel(false));
  }

  fetchHtml = id => {
    const data = document.getElementById('content-' + id).innerHTML;
    return { data }
  }

  // Fetch ajax template
  fetchData = async id => {
    return await axios.post(`${ this.url }/${ id }`)
      .then(response => {
        console.log('AJAX RESPONSE:', response);
        return response;
      })
      .catch(error => {
        console.log('AJAX ERROR:', error);
        return false;
      });
  }

  // Open panel and load data when grid item clicked
  openPanel = event => {
    this.togglePanel(true);
    const id = event.target.dataset.id;
    this.loadData(id);
    window.scrollTo({ top: 0 })
  }

  // Replace data when prev/next button clicked
  replaceData = event => {
    const id = event.target.dataset.id;
    this.loadData(id);
  }
}