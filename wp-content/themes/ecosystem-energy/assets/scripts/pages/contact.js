document.querySelectorAll('.office-link').forEach(link => {
  link.addEventListener('click', ({ target }) => {

    // Toggle selected state
    document.querySelectorAll('.office-link.selected').forEach(el => el.classList.remove('selected'));
    target.classList.add('selected');

    // Change office-info content
    const content = target.nextElementSibling.innerHTML;
    document.getElementById('office-info').innerHTML = content;

    // Select office in form
    const option = document.querySelector(`.office-field option[value="${ target.text }"]`);
    if (option) option.selected = true;

  })
});