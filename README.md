# Video Slider Widget for Elementor

A custom Elementor widget that creates auto-sliding video carousels without navigation buttons.

## Features

- ✅ Self-hosted video support
- ✅ Auto-play with configurable interval
- ✅ Multiple transition effects (fade, slide, cube, coverflow)
- ✅ No navigation buttons (clean interface)
- ✅ Video controls (play/pause/progress bar)
- ✅ Poster image support
- ✅ Keyboard navigation
- ✅ Autoplay pauses when video is playing
- ✅ Responsive design
- ✅ Live Elementor preview support

## Installation

### Step 1: Create Plugin Directory
```bash
mkdir -p /path/to/wordpress/wp-content/plugins/video-slider-elementor
cd /path/to/wordpress/wp-content/plugins/video-slider-elementor
```

### Step 2: Copy Files
Move these files to the plugin directory:
- `video-slider-plugin.php` → Main plugin file (rename to `video-slider-elementor.php`)
- `video-slider-widget.php` → Widget class
- `video-slider-widget.js` → JavaScript initialization
- `video-slider-widget.css` → Styling

Your structure should look like:
```
wp-content/plugins/video-slider-elementor/
├── video-slider-elementor.php (main plugin file)
├── video-slider-widget.php
├── video-slider-widget.js
└── video-slider-widget.css
```

### Step 3: Activate Plugin
1. Go to WordPress Admin → Plugins
2. Find "Video Slider for Elementor"
3. Click "Activate"

### Step 4: Verify Installation
1. Open Elementor page builder
2. Search for "Video Slider" widget in the widget panel
3. Drag it to your page

## Usage

### Basic Setup
1. Add the "Video Slider" widget to your Elementor page
2. Go to "Videos" tab
3. Click "Add Item" to add video slides
4. Enter video URL (MP4 format recommended)
5. Optionally add poster image

### Configuration Options

#### Videos Tab
- **Video URL**: Direct URL to MP4 file (required)
- **Poster Image**: Thumbnail shown before video plays

#### Settings Tab
- **Autoplay**: Enable/disable auto-sliding
- **Slide Duration**: Time each video displays (seconds)
- **Transition Speed**: Duration of transition effect (milliseconds)
- **Transition Effect**: 
  - Fade (recommended for videos)
  - Slide
  - Cube
  - Coverflow
- **Loop Slides**: Repeat from beginning when reaching end
- **Video Height**: Set height in pixels

#### Style Tab
- **Border Radius**: Rounded corners
- **Box Shadow**: Add shadow effect

## Browser Support

- Chrome/Edge: Full support
- Firefox: Full support
- Safari: Full support
- IE11: Not supported (use modern browsers)

## Video Format Requirements

- **Format**: MP4 (H.264 codec recommended)
- **Bitrate**: 2-5 Mbps for web
- **Resolution**: 1920x1080 or smaller
- **Frame Rate**: 24-30 fps

## Example Video URLs

```
https://example.com/videos/video1.mp4
https://cdn.example.com/path/to/video.mp4
/wp-content/uploads/videos/sample.mp4
```

## Common Issues

### Videos not appearing
- Check video URL is correct and accessible
- Ensure CORS headers allow embedding
- Verify video format is MP4

### Autoplay not working
- Check browser autoplay policy (Chrome requires muted audio)
- Verify "Autoplay" toggle is enabled in settings
- Check console for JavaScript errors

### Navigation buttons showing
- Clear WordPress cache
- Verify `video-slider-widget.css` is loaded
- Check for conflicting custom CSS

## Performance Tips

1. **Compress videos**: Use tools like HandBrake
2. **Use CDN**: Host videos on CDN for faster loading
3. **Lazy load**: Enable lazy loading in Elementor
4. **Limit slides**: 3-5 videos recommended for performance
5. **Optimize images**: Compress poster images

## Advanced Customization

### Custom CSS
Add to your theme's `custom.css`:

```css
/* Customize video slider appearance */
.video-slider-wrapper {
    border-radius: 20px;
    overflow: hidden;
}

.video-slide {
    filter: brightness(0.9);
}

/* Add overlay effect */
.video-slider-container::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.3));
    pointer-events: none;
}
```

### Video Controls Styling
```css
/* Customize HTML5 video player controls */
video::-webkit-media-controls {
    background-color: rgba(0, 0, 0, 0.8);
}

video::-webkit-media-controls-panel {
    background-color: rgba(0, 0, 0, 0.9);
}
```

## Troubleshooting

### Widget doesn't appear in Elementor
- Ensure Elementor is activated
- Deactivate/reactivate plugin
- Clear all caches (WordPress + browser)

### CSS/JS not loading
- Check file paths in `video-slider-plugin.php`
- Verify file permissions (644 for files, 755 for folders)
- Check console for 404 errors

### Videos lagging during transition
- Reduce video bitrate
- Reduce transition speed
- Use fade effect instead of 3D effects

## Support

For issues or feature requests, check:
- Browser console for JavaScript errors
- WordPress error logs
- Elementor system info (Help → System Info)

## Version History

### v1.0.0
- Initial release
- Swiper.js carousel integration
- Multiple transition effects
- Auto-play functionality
- Responsive design

## License

GPL v2 or later. See LICENSE file for details.

## Credits

- Built with [Swiper.js](https://swiperjs.com/)
- Elementor widget framework
