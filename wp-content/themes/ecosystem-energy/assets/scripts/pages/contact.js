document.querySelectorAll('.office-link').forEach(link => {
  link.addEventListener('click', ({ target }) => {

    // Toggle selected state
    document.querySelectorAll('.office-link.selected').forEach(el => el.classList.remove('selected'));
    target.classList.add('selected');

    // Change office-info content
    const infoBox = document.getElementById('office-info');
    const content = target.nextElementSibling.innerHTML;
    infoBox.innerHTML = content;

    // Scroll to office info box
  //  infoBox.scrollIntoView({ behavior: 'smooth', block: 'start' });
  const y = infoBox.getBoundingClientRect().top + window.pageYOffset - 50;
  window.scrollTo({top: y, behavior: 'smooth'});

    // Select office in form
    const option = document.querySelector(`.office-field option[value="${ target.text }"]`);
    if (option) option.selected = true;
  })
});