const addStyleOnForm = (formID) => {
	let is_close = $('.img-one').hasClass('img-container--left') && $('.img-two').hasClass('img-container--right');
	
	if (is_close){
		document.getElementById('lost_form').classList.add('hidden');
		document.getElementById('find_form').classList.add('hidden');
		document.getElementById('findedDronePhoneForm').classList.add('hidden');
	} else {
		document.getElementById(`${formID}_form`).classList.toggle('hidden');
		document.getElementById('findedDronePhoneForm').classList.toggle('hidden');
	}
};
const toggleStyle = () => {
	document.querySelector('.img-one').classList.toggle('img-container--left');
	document.querySelector('.img-two').classList.toggle('img-container--right');
	document.querySelector('.box').classList.toggle('padding-area');
	document.querySelector('.form').classList.toggle('form__padding');
};

$('#find').on('click', () => {
	addStyleOnForm('find');

	toggleStyle();
});
$('#lost').on('click', () => {
	addStyleOnForm('lost');

	toggleStyle();
});
