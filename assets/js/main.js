//ПОДКЛЮЧЕНИЕ slick-слайдера (для секции section class="carousel"):

$(function () {

	// обратмся к родителю всех внутренних элементов слайдера и подключить функцию slick() из соотвествующей библиотеки:
	$('.carousel__inner').slick({
		// укажем все необходимые свойства слайдера:
		arrows: false,
		dots: true,
		slidesToShow: 3,
		responsive: [
			{
				breakpoint: 841,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 601,
				settings: {
					slidesToShow: 1
				}
			},
		]
	});

	wow = new WOW(
		{
			boxClass: 'wow',      // default
			animateClass: 'animate__animated', // default
			offset: 0,          // default
			mobile: true,       // default
			live: true        // default
		}
	)
	wow.init();


});