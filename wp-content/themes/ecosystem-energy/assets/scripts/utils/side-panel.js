/*
  SidePanel class
  This script allows loading of custom content into an overlayed ajax page
*/

// Dependancies
import axios from 'axios';

export default class SidePanel {
  container = document.getElementById('side-panel-ctn');
  body = document.body;
  innerContainer;

  transition = false;
  visible = false;
  url;

  onDataLoaded = () => {};

  constructor ({ url, containerId = 'panel-content', onDataLoaded } = {}) {
    this.url = url || null;

    // Set container where content will be loaded
    this.innerContainer = document.getElementById(containerId);

    // 
    if (onDataLoaded) this.onDataLoaded = onDataLoaded;

    // Add click listeners to all grid items
    document.querySelectorAll('.link-item').forEach(link => {
      link.addEventListener('click', this.openSidePanel);
    })

    // Close panel when overlay is clicked
    this.container.querySelector('#panel-overlay').addEventListener('click', () => this.hidePanel())
  }

  // Toggle panel visibility
  togglePanel = (visible = null) => {
    this.visible = visible === null
      ? !this.visible
      : !!visible;

    if (this.visible) this.showPanel();
    else this.hidePanel();
  }

  // Load data and render template with event listeners
  loadData = async id => {
    this.container.classList.add('loading');
    await this.timeout(500);

    // Fetch ajax if url is supplied, else clone DOM node
    const { data } = this.url 
      ? await this.fetchData(id)
      : this.fetchHtml(id);

    this.innerContainer.innerHTML = data;
    this.onDataLoaded(id);
    
    await this.timeout(200);
    this.container.classList.remove('loading');

    document.getElementById('panel-prev').addEventListener('click', this.replaceData);
    document.getElementById('panel-next').addEventListener('click', this.replaceData);
    document.getElementById('panel-close').addEventListener('click', () => this.togglePanel(false));
  }

  // Clone target DOM node to the panel
  fetchHtml = id => {
    const data = document.getElementById('content-' + id).cloneNode(true).innerHTML;
    return { data }
  }

  // Fetch ajax template
  fetchData = async id => {
    return await axios.post(`${ this.url }/${ id }`)
      .then(response => {
        // console.log('AJAX RESPONSE:', response);
        return response;
      })
      .catch(error => {
        console.log('AJAX ERROR:', error);
        return false;
      });
  }

  // Open panel and load data when grid item clicked
  openSidePanel = async event => {
    this.togglePanel(true);
    const id = event.target.dataset.id;

    await this.timeout(700);
    this.loadData(id);
    this.innerContainer.scrollTo({ top: 0 });
  }

  // Replace data when prev/next button clicked
  replaceData = event => {
    const id = event.target.dataset.id;
    this.loadData(id);
  }

  // Show panel
  showPanel = () => {
    this.container.classList.add('loading');
    this.container.classList.add('show');
    this.container.addEventListener('transitionend', this.onPanelShown);
    this.body.classList.add('panel-open');
  }

  // Hide panel
  hidePanel = () => {
    this.container.classList.add('loading');
    this.container.classList.remove('show');
    this.container.addEventListener('transitionend', this.onPanelHidden);
    this.body.classList.remove('panel-open');
  }

  // Switch on opened status (on transition end)
  onPanelShown = () => {
    this.transition = false;
    this.container.classList.add('-shown');
    this.container.removeEventListener('transitionend', this.onPanelShown);
  }

  // Switch on closed status (on transition end)
  onPanelHidden = () => {
    this.transition = false;
    this.container.classList.remove('-shown');
    this.container.removeEventListener('transitionend', this.onPanelHidden);
  }

  //
  timeout = async ms => {
    return new Promise(resolve => setTimeout(resolve, ms));
  }
}