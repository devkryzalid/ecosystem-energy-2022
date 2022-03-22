import SidePanel from '../utils/side-panel';

const { url } = { ...document.getElementById('ajax-settings').dataset };
const sidePanel = new SidePanel({ url });