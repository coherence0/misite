$('#find').on('click', () => {
    document.getElementById('findedDroneForm').classList.toggle('hidden');
    document.querySelector('.img-one').classList.toggle('img-container--left');
    document.querySelector('.img-two').classList.toggle('img-container--right');
});
$('#lost').on('click', () => {
    document.getElementById('lostedDroneForm').classList.toggle('hidden');
    document.querySelector('.img-one').classList.toggle('img-container--left');
    document.querySelector('.img-two').classList.toggle('img-container--right');
});