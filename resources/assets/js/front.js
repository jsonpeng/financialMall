var swiper = new Swiper('.swiper-container', {
	pagination: {
	el: '.swiper-pagination',
	dynamicBullets: true,
	},
	autoplay: {
	delay: 3000,
	},
	// Disable preloading of all images
	preloadImages: false,
	// Enable lazy loading
	lazy: true
});