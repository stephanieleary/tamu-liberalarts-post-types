=== Liberal Arts Custom Post Types and Taxonomies ===
Contributors: sillybean
Requires at least: 3.1
Tested up to: 4.0
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Creates CPTs and taxonomies; adds options page to manage staff directory; filters post title placeholders and post labels.

== Description ==

= Custom Post Types, Taxonomies, and Fields =

The custom post types and taxonomies are defined in the main file, libarts-cpts.php. 

Custom post types:

* people
* course
* degree_requirement
* publications
* dissertation (or thesis)

Taxonomies:

* classification (for people)
* area (for people)
* research (for people)
* departments (for courses and people)

There are four default terms inserted into the classification taxonomy:

* Faculty
* Staff
* Guest Lecturer
* Graduate Assistant

Custom fields are created via Advanced Custom Fields. This plugin includes an activation class that prompts admins to install or activate ACF if it is missing.

= Options =

The options screen allows you to select which of the custom post types will be used on each subsite of the network.

There is also a textarea where the contents of a single person's profile can be specified. This section can contain HTML, and will appear before the standard post content. To include custom fields in the profile layout, use the Advanced Custom Fields shortcode: [acf field="name"].

= Title and Label Filters =

The new post title placeholder is filtered, to prompt users to enter the full name on people posts.

There is no filter available to change the admin menu labels for posts. Therefore, there is a function hooked to 'wp_loaded', which runs after all the post types have been registered, to change these labels directly in the global array.