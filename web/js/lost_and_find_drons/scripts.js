$('#find').on('click', () => {
    document.getElementById('find_form').classList.toggle('hidden');
    document.querySelector('.img-one').classList.toggle('img-container--left');
    document.querySelector('.img-two').classList.toggle('img-container--right');
});
$('#lost').on('click', () => {
    document.getElementById('lost_form').classList.toggle('hidden');
    document.querySelector('.img-one').classList.toggle('img-container--left');
    document.querySelector('.img-two').classList.toggle('img-container--right');
});