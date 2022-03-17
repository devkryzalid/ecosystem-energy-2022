document.querySelectorAll('.office-link').forEach(link => {
  link.addEventListener('click', e => {
    const content = e.target.nextElementSibling.innerHTML;
    document.getElementById('office-info').innerHTML = content;

    const option = document.querySelector(`.office-field option[value="${ e.target.text }"]`);
    if (option) option.selected = true;
  })
});