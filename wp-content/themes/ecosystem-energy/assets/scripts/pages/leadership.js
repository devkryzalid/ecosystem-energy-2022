import SidePanel from '../utils/side-panel';

const sidePanel = new SidePanel({ containerId: 'panel-body', onDataLoaded: id => setNav(id) });

// Set data-id for prev/next buttons
function setNav (id) {
  const allIds = [...document.querySelectorAll('.leader-content')].map(el => el.dataset.id);
  const index = allIds.indexOf(id);
  document.getElementById('panel-prev').setAttribute('data-id', allIds[index - 1] || allIds.length);
  document.getElementById('panel-next').setAttribute('data-id', allIds[index + 1] || allIds[0]);
}