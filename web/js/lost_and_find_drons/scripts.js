const addStyleOnForm = (formID) => {
    let is_close =  $('.img-one').hasClass('img-container--left') && $('.img-two').hasClass('img-container--right');
    if (is_close){
        document.getElementById('lost_form').classList.add('hidden');
        document.getElementById('find_form').classList.add('hidden');
    } else {
        document.getElementById(`${formID}_form`).classList.toggle('hidden');
    }
};

$('#find').on('click', () => {
    addStyleOnForm('find');

    document.querySelector('.img-one').classList.toggle('img-container--left');
    document.querySelector('.img-two').classList.toggle('img-container--right');
});
$('#lost').on('click', () => {
    addStyleOnForm('lost');

    document.querySelector('.img-one').classList.toggle('img-container--left');
    document.querySelector('.img-two').classList.toggle('img-container--right');
});