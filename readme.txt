=== SBModal ===
Contributors: sevenbytes
Tags: modal, bootstrap, pop ups, bootstrap popup
Requires at least: 4.0.1
Tested up to: 4.1.1
Stable tag: 1.2
Plugin Name: SBModal
Plugin URI: http://sbmodal.seven-bytes.com/
Description: Ease usage of Bootstrap Modals in WordPress
License: MIT
License URI: http://opensource.org/licenses/MIT

Provides ease of Bootstrap Modals management. A lot of options and ease of extensibility.

== Description ==

You could easily create Bootstrap Modals.

It requires only:

1. Fill the Content section with needed data.
2. Provide call Selector (See "Usage" -> "Options" -> "Call Selector").

You may use all features of standard WP WYSIWYG editor for creating Modal content. E.g.: CF7 shortcodes to show the form.

== Installation ==

1. Upload `sbmodal` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. GOTO Usage.

== Screenshots ==

1. Modal edit page.
2. Modal in action.
3. Options Page

== Usage ==

= Plugin Settings =

**Enqueue bootstrap.js** (Yes or NO) - If you using `bootstrap.min.js` in your own theme (or plugin), use this option to remove this script from SBModal queue.

**Enqueue Bootstrap CSS Style**:

*	*Full Bootstrap.css* - Complete `bootstrap.min.css`.
*	*Styles ONLY for Modal* - Enqueue Bootstrap styles only for Modal.
*	*Do NOT Load CSS* - Do not load any Bootstrap styles.

= Create Modal =

1. GOTO "Modals" -> "Add New".
1. Add some data to Content section. This field mandatory. Title and Footer are optional.
1. Configure Modal behaviour in "Options" metabox (right sidebar).

= Options =

*	Select Template: Simple (display only content),  Middle (title + content), Full (title + content + footer).
*	Call Selector - jQuery selector of the element which will open Modal by click. (Examples: a[href="#OpenModal"], a#click_me, a.open-modal).
*	Width - Aliases for standart Bootstrap styles: Large (modal-lg), Middle (modal-md), Small (modal-sm).
*	Max Width - You could provide INT value to limit width of Modal (px).
*	Class - custom class.
*	ID - custom ID.

= Filters =

*	sbmodal_client_templates_path - path to the folder with templates. From template root.
*	sbmodal_templates - array of templates ('slug' => __('Template Name', 'sbmodal')). 
*	sbmodal_width_classes - array of modal width classes ('modal-width-class' => __('Class Name', 'sbmodal'), ...).


== Changelog ==

= 1.2 =
* Added setting page.
* Available to enqueue bootstrap styles only for Modal Component.
* Screenshots updated.

= 1.1 =
* Readme.txt updated.
* Screenshots added.

= 1.0 =
* Initial release.
