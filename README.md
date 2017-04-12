# Better Theme Customizer
- [Project Summary](#summary)
- [Features](#features)
- [Installation](#installation)
- [Customizer](#customizer)
- [Usage](#usage)

<a name="summary"></a>
## Project Summary
Better Theme Customizer acts as an API for WordPress' [Theme Modification API](https://developer.wordpress.org/themes/customize-api/) with some extra features built in to the display functionality.

<a name="features"></a>
## Features
- Easily add theme mods using a config file. Now supporting YAML.
- Add theme mods for selecting taxonomies, posts, post_types, terms, images, etc
- Works for multi-site setups
- Comes with some sample options in the config file to get you started ('/options/btc-options.yml')

<a name="installation"></a>
## Installation
Download or clone this plugin, install and activate in through WordPress. Once activated it is setup and ready to use.
To start configuring, copy the btc-options.yml file from the options directory in the plugin and place it within the theme
directory either under an ```/inc``` or ```/includes``` directory

<a name="customizer"></a>
## Customizer
### What's What?
In the WP Customizer, there are four different elements to note:

1. Panels - Top level element that can only contain sections.
2. Sections - Can only contain controls. Can be top level or inside a panel.
3. Settings - Defines the default value, the name of the setting, and how it is stored in the database.
4. Controls - Controls can only be placed inside a section, they define what the input type is (e.g. textarea, dropdown, etc.) and make a setting something controllable and visible.

In our theme customizer, this has all been simplified into a YAML file where settings and controls are merged into one element (referred to as an option, for clarity).

### Option Format
The options file contains some code to tie the variable into WordPress. The $settings_array variable holds our array of elements and uses the following format:

- Top level can contain panels and sections
   * If top level is panel, sections go here
      - Options go here
   * If top level is section, controls go here
   
### Possible Values
#### Panels
Panels can contain sections and require an array value with the key _panel to be processed as a panel. The panel ID will be auto prefixed with an internal value to avoid conflicts. The value associated with the key _panel should be an array and can contain any of the following:

* title - String value, the user viewable title of the panel (required)
* description - String value, user readable description of what this panel contains
* capability - Capability user needs to see this panel. See WP Roles & Capabilities
* theme_supports - Theme feature that needs to be enabled to see this panel, see Theme Support
* active_callback - Valid callback function, used to determine if the panel should be visible or not
* priority - Integer, determines the order this panel appears in. Recommended to leave alone to avoid issues. By default the order it appears in the file is the order it is output.

#### Sections
Sections can be top level or inside a panel. All sections use an array value with the key _section to be processed as a section. The section ID will be auto prefixed with an internal value to avoid conflicts. The value associated with the key _section should be an array and can contain any of the following:

* title - String value, the user viewable title of the section (required)
* description - String value, user readable description of what this section contains
* capability - Capability user needs to see this section. See WP Roles & Capabilities
* theme_supports - Theme feature that needs to be enabled to see this section, see Theme Support
* active_callback - Valid callback function, used to determine if the section should be visible or not
* priority - Integer, determines the order this section appears in. Recommended to leave alone to avoid issues. By default the order it appears in the file is the order it is output.
* panel - ID of a panel, by default if this section is defined inside a panel in the options file, it will automatically be placed inside that panel. This can be set to the ID of a WordPress defined panel if you want to add this section to that panel.

#### Options
Options can only be placed inside sections. The array key should be the option ID and should be unique across all custom and WordPress defined customizer options. The array value should be an array and can contain any of the following:

* label - String value, the user viewable label of the option (required)
* description - String value, user readable description of what this option is/does
* type - String, determines the type of control this is, can be any of the following:
  - text - Standard, single line input field, default
  - textarea - Multi-line input
  - checkbox OR radio
    * Requires choices to be set with an array as the value using the following format: array( 'value' => 'Readable Label' )
    * NOTE: If you only need 1 checkbox, you can exclude the choices option. The label on the checkbox itself will become the main label option.
  - select - Dropdown with custom options
    * Requires choices to be set with an array as the value using the following format: array( 'value' => 'Readable Label' )
  - dropdown-pages - Gives a dropdown of all pages
    * When retrieving this value, it will return the ID of the page.
  - dropdown-gform - Gives a dropdown of all created Gravity Forms
    * When retrieving this value, it will return the ID of the form.
  - dropdown-post-types - Gives a dropdown of all public post types
    * When retrieving this value, it will return the internal name of the post type.
  - dropdown-posts - Gives a dropdown of all posts
    * Requires the extra option post_type to be passed in string format with the name of the post type to be used
    * When retrieving this value, it will return the ID of the post.
    * IMPORTANT: Be careful using this with posts or other custom post types that could potentially have hundreds or thousands of posts as it can cause the customizer to be slow and/or crash!
  - dropdown-taxonomies - Gives a dropdown of all public taxonomies
    * When retrieving this value, it will return the internal name of the taxonomy.
  - dropdown-terms - Gives a dropdown of all terms in the specified taxonomy
    * Requires the extra option taxonomy to be set as a string value containing the taxonomy you want to list terms from.
    * When retrieving this value, it will return the ID of the taxonomy term.
  - media-library - Adds option to add image or file via media library
    * When retrieving this value, it will return the ID of the file/image in the media library.
* capability - Capability user needs to see/edit this option. See WP Roles & Capabilities
* theme_supports - Theme feature that needs to be enabled to see/edit this option, see Theme Support
* priority - Integer, determines the order this option appears in. Recommended to leave alone to avoid issues. By default the order it appears in the file is the order it is output.
* storage_type - Determines how the value is stored.
    - theme_mod - Default method, recommended.
    - option - Stores value as an option in the options table. Use only if you really have a reason to. Not a common need.
    - infinite_site_option - Stores value as a default WordPress site option. Only works in multisite!

<a name="usage"></a>
## Usage
The static methods in Customizer_Helper can be called directly or you can use the function helper we have created by
calling the better_theme_customizer() function with a varying number of arguments. The first argument is always the method
 you want to call and is required.

- the_mod - Echos out the theme mod
   * ```$mod_name``` string - Unique name identifying the theme mod
   * ```$args``` array (Optional)
    - ```$before``` string Is echoed out before the theme_mod value
    - ```$after``` string Is echoed out after the theme_mod value
    - ```$esc_callback``` string Used to escape the output, can pass any valid callback. False will force no callback.
   ```php
      better_theme_customizer( 'the_mod', $mod_name, $args ); 
   ```
- get_mod - Returns the theme mod text
   * ```$mod_name``` string - Unique name identifying the theme mod
   ```php
      better_theme_customizer( 'get_mod', $mod_name ); 
   ```
- the_image_mod - Echos out the image HTML for the theme mod
   * ```$mod_name``` string - Unique name identifying the theme mod
   * ```$image_size``` string|array (Optional) -  Image size. Accepts any valid image size, or an array of width and height values in pixels (in that order)
   * ```$icon``` bool (Optional)- Whether the image should be treated as an icon.
   * ```$attr``` string|array (Optional) - Attributes for the image markup.
  ```php
      better_theme_customizer( 'the_image_mod', $mod_name, $image_size, $icon = false, $attr );
  ```
- get_image_mod - Returns the image HTML for the theme mod
   * ```$mod_name``` string - Unique name identifying the theme mod
   * ```$image_size``` string|array (Optional) -  Image size. Accepts any valid image size, or an array of width and height values in pixels (in that order)
   * ```$icon``` bool (Optional)- Whether the image should be treated as an icon.
  ```php
      better_theme_customizer( 'get_image_mod', $mod_name, $image_size, $icon );
  ```
- get_image_mod_url - Returns the images url for the theme mod
   * ```$mod_name``` string - Unique name identifying the theme mod
  ```php
      better_theme_customizer( 'get_image_mod_url', 'site_logo' );
  ```
- get_copyright - Returns the copyright text
  ```php
      better_theme_customizer( 'get_copyright' );
  ```
- get_social_media_icons - Returns HTML for social media icons.
  * ```$args``` array (Optional)
    - ```$before``` string HTML to output before icons
    - ```$after``` string HTML to output after icons
    - ```$use_square``` bool When true, will use the square version of icons if available
    - ```$size``` string FontAwesome size for the icon.
    - ```$text_only``` bool Whether to output text instead of the icons.
    - ```$break_after``` bool Number of icons to wait until adding a "`<br>`"
  ```php
      better_theme_customizer( 'the_social_media_icons', $args );
  ```
- the_social_media_icon - Echos HTML for social media icons.
  * ```$args``` array (Optional)
    - ```$before``` string HTML to output before icons
    - ```$after``` string HTML to output after icons
    - ```$use_square``` bool When true, will use the square version of icons if available
    - ```$size``` string FontAwesome size for the icon.
    - ```$text_only``` bool Whether to output text instead of the icons.
    - ```$break_after``` bool Number of icons to wait until adding a "`<br>`"
  ```php
      better_theme_customizer( 'get_social_media_icons', $args );
  ```

