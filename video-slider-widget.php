<?php
/**
 * Custom Elementor Video Slider Widget
 * Auto-sliding video carousel without navigation buttons
 */

if (!defined('ABSPATH')) {
    exit;
}

class Video_Slider_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'video_slider';
    }

    public function get_title() {
        return 'Video Slider';
    }

    public function get_icon() {
        return 'eicon-video-camera';
    }

    public function get_categories() {
        return ['media'];
    }

    public function get_script_depends() {
        return ['swiper', 'video-slider-script'];
    }

    public function get_style_depends() {
        return ['swiper-style', 'video-slider-style'];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Videos', 'elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'video_source',
            [
                'label' => esc_html__('Video Source', 'elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'upload',
                'options' => [
                    'upload' => esc_html__('Upload Video', 'elementor'),
                    'url' => esc_html__('Video URL', 'elementor'),
                ],
            ]
        );

        $repeater->add_control(
            'video_file',
            [
                'label' => esc_html__('Upload Video', 'elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => 'video',
                'condition' => [
                    'video_source' => 'upload',
                ],
            ]
        );

        $repeater->add_control(
            'video_url',
            [
                'label' => esc_html__('Video URL', 'elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('https://example.com/video.mp4', 'elementor'),
                'label_block' => true,
                'condition' => [
                    'video_source' => 'url',
                ],
            ]
        );

        $repeater->add_control(
            'enable_poster',
            [
                'label' => esc_html__('Enable Poster Image', 'elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor'),
                'label_off' => esc_html__('No', 'elementor'),
                'default' => '',
            ]
        );

        $repeater->add_control(
            'video_poster',
            [
                'label' => esc_html__('Poster Image', 'elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
                'condition' => [
                    'enable_poster' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'videos',
            [
                'label' => esc_html__('Video Slides', 'elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'video_source' => 'upload',
                    ],
                ],
                'title_field' => '<# if (video_source === "upload") { #>Uploaded Video<# } else { #>{{{ video_url }}}<# } #>',
            ]
        );

        $this->end_controls_section();

        // Settings Section
        $this->start_controls_section(
            'settings_section',
            [
                'label' => esc_html__('Settings', 'elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor'),
                'label_off' => esc_html__('No', 'elementor'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_interval',
            [
                'label' => esc_html__('Slide Duration (seconds)', 'elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'max' => 60,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'transition_speed',
            [
                'label' => esc_html__('Transition Speed (ms)', 'elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 1000,
                'min' => 300,
                'max' => 5000,
            ]
        );

        $this->add_control(
            'effect',
            [
                'label' => esc_html__('Transition Effect', 'elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'fade',
                'options' => [
                    'fade' => esc_html__('Fade', 'elementor'),
                    'slide' => esc_html__('Slide', 'elementor'),
                    'cube' => esc_html__('Cube', 'elementor'),
                    'coverflow' => esc_html__('Coverflow', 'elementor'),
                ],
            ]
        );

        $this->add_control(
            'loop',
            [
                'label' => esc_html__('Loop Slides', 'elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor'),
                'label_off' => esc_html__('No', 'elementor'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'video_height',
            [
                'label' => esc_html__('Video Height (px)', 'elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 500,
                'min' => 200,
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'container_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .video-slider-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'container_shadow',
            [
                'label' => esc_html__('Box Shadow', 'elementor'),
                'type' => \Elementor\Controls_Manager::BOX_SHADOW,
                'default' => [
                    'horizontal' => 0,
                    'vertical' => 5,
                    'blur' => 15,
                    'spread' => 0,
                    'color' => 'rgba(0, 0, 0, 0.3)',
                ],
                'selectors' => [
                    '{{WRAPPER}} .video-slider-container' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Video Style Section
        $this->start_controls_section(
            'video_style_section',
            [
                'label' => esc_html__('Video Style', 'elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'video_border_radius',
            [
                'label' => esc_html__('Video Border Radius', 'elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .video-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        if (empty($settings['videos'])) {
            echo esc_html__('No videos added', 'elementor');
            return;
        }

        $autoplay = $settings['autoplay'] === 'yes' ? 'true' : 'false';
        $autoplay_interval = intval($settings['autoplay_interval']) * 1000;
        $transition_speed = intval($settings['transition_speed']);
        $loop = $settings['loop'] === 'yes' ? 'true' : 'false';
        $effect = sanitize_text_field($settings['effect']);
        $video_height = intval($settings['video_height']);
        ?>

        <div class="video-slider-wrapper" style="height: <?php echo esc_attr($video_height); ?>px;">
            <div class="swiper video-slider-container" 
                 data-autoplay="<?php echo esc_attr($autoplay); ?>"
                 data-autoplay-interval="<?php echo esc_attr($autoplay_interval); ?>"
                 data-transition-speed="<?php echo esc_attr($transition_speed); ?>"
                 data-loop="<?php echo esc_attr($loop); ?>"
                 data-effect="<?php echo esc_attr($effect); ?>">
                
                <div class="swiper-wrapper">
                    <?php foreach ($settings['videos'] as $video) : 
                        // Get video URL based on source
                        if ($video['video_source'] === 'upload' && !empty($video['video_file']['url'])) {
                            $video_url = esc_url($video['video_file']['url']);
                        } else {
                            $video_url = esc_url($video['video_url']);
                        }

                        // Get poster URL if enabled
                        $poster_url = '';
                        if ($video['enable_poster'] === 'yes' && !empty($video['video_poster']['url'])) {
                            $poster_url = esc_url($video['video_poster']['url']);
                        }
                    ?>
                        <div class="swiper-slide">
                            <video class="video-slide" 
                                   width="100%" 
                                   height="<?php echo esc_attr($video_height); ?>" 
                                   controls 
                                   style="display: block; width: 100%; height: 100%; object-fit: cover;"
                                   <?php if (!empty($poster_url)) : ?>
                                       poster="<?php echo esc_attr($poster_url); ?>"
                                   <?php endif; ?>>
                                <source src="<?php echo esc_attr($video_url); ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <?php
    }

    protected function content_template() {
        ?>
        <div class="video-slider-wrapper" style="height: 500px;">
            <div class="swiper video-slider-container">
                <div class="swiper-wrapper">
                    <# _.each(settings.videos, function(video) { 
                        var videoUrl = video.video_source === 'upload' && video.video_file.url ? video.video_file.url : video.video_url;
                        var posterUrl = video.enable_poster === 'yes' && video.video_poster.url ? video.video_poster.url : '';
                    #>
                        <div class="swiper-slide">
                            <video class="video-slide" width="100%" height="500" controls style="display: block; width: 100%; height: 100%; object-fit: cover;" <# if(posterUrl) { #>poster="{{{ posterUrl }}}"<# } #>>
                                <source src="{{{ videoUrl }}}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <# }); #>
                </div>
            </div>
        </div>
        <?php
    }
}

// Register the widget
add_action('elementor/widgets/register', function($widgets_manager) {
    require_once(__FILE__);
    $widgets_manager->register(new Video_Slider_Widget());
});
