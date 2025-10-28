/**
 * Video Slider Widget JavaScript
 * Initializes Swiper carousel for video slideshows
 */

(function() {
    'use strict';

    // Initialize video sliders on page load and when Elementor updates
    function initVideoSliders() {
        const sliders = document.querySelectorAll('.video-slider-container');

        sliders.forEach(slider => {
            // Skip if already initialized
            if (slider.swiper) {
                return;
            }

            const autoplay = slider.dataset.autoplay === 'true';
            const autoplayInterval = parseInt(slider.dataset.autoplayInterval) || 5000;
            const transitionSpeed = parseInt(slider.dataset.transitionSpeed) || 1000;
            const loop = slider.dataset.loop === 'true';
            const effect = slider.dataset.effect || 'fade';

            // Swiper configuration
            const swiperConfig = {
                effect: effect,
                speed: transitionSpeed,
                loop: loop,
                watchSlidesProgress: true,
                
                autoplay: autoplay ? {
                    delay: autoplayInterval,
                    disableOnInteraction: false,
                    stopOnLastSlide: !loop,
                } : false,

                // Optional: Add keyboard navigation
                keyboard: {
                    enabled: true,
                    onlyInViewport: true,
                }
            };

            // Create new Swiper instance
            const swiperInstance = new Swiper(slider, swiperConfig);

            // Pause autoplay on video play
            const videos = slider.querySelectorAll('video');
            videos.forEach(video => {
                video.addEventListener('play', () => {
                    if (swiperInstance.autoplay) {
                        swiperInstance.autoplay.stop();
                    }
                });

                video.addEventListener('pause', () => {
                    if (autoplay && swiperInstance.autoplay) {
                        swiperInstance.autoplay.start();
                    }
                });
            });
        });
    }

    // Initialize on document ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initVideoSliders);
    } else {
        initVideoSliders();
    }

    // Reinitialize when Elementor updates (for live editing)
    if (window.elementorFrontend) {
        elementorFrontend.hooks.addAction('frontend/element_ready/video_slider.default', function() {
            initVideoSliders();
        });
    }

    // Also watch for dynamic content updates
    window.addEventListener('elementor/render', function() {
        setTimeout(initVideoSliders, 100);
    });
})();
