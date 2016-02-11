=== DbTable2DataTable ===
Contributors: rikemsen
Tags: datatable, jquery, mysql, table, sortable
Requires at least: 4.4
Tested up to: 4.4
Stable tag: 4.4
License: Beerware
License URI: https://en.wikipedia.org/wiki/Beerware

Display mysql datas into datatable.

== Description ==

This plugin allows you to display the content of a mysql table into a sortable html table thanks to the DataTable jQuery Plugin

For backwards compatibility, if this section is missing, the full length of the short description will be used, and
Markdown parsed.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/dbTable2dataTable` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. No more step needed.

To use the plugin, simply add the shortcode `[dbtable]` in a page or article.

Minimum needed : `[dbtable from=MysqlTable]`

Optional parameters : `[dbtable from=MysqlTable optionName=optionValue]`

###Examples:

All parameters that can contains more than one value have to be separated by commas without spaces.

1. `select=field1,field2,field3` will display all rows of the table and only specified fields
2. `except=field1,field2,field3` will display all rows of the table but specified fields
3. `cssClass=class1,class2` will add class1 and class 2 to the <table class=""> attribut

== Frequently Asked Questions ==

= How do i change default values? =

You can edit the main `dbTable2dataTable.php` file and change these values :

        $this->defaults = array(
              'from'        => null,     // Mysql source table
              'select'      => null,     // Select specific columns
              'except'      => null,     // Ignore specific columns
              'cssclass'    => null,     // Specify custom CSS class for the <table>
              'comments'    => false,    // Use field comments instead of column name
              'pagination'  => false,    // Enable / Disable pagination
              'limit'       => 25,       // Limit of results per page
              'width'       => '100',    // Set width in % of the table
              'language'    => 'English' // Default language : French
            );


= What the `comments` attribut does? =

By default, column names will be the field name (e.g: product_id, custom_field). But if you want to have custom/pretty names you should modify your table and add comments to the fields (e.g : `ALTER TABLE product CHANGE product_id product_id INT( 11 ) COMMENT 'Product ID'`

= Why can't I display datas from a Wordpress Table ? =

This plugin is not intended to display WordPress datas. I blocked this for security reasons. It aims to give you the ability to show custom datas from custom tables. I had to extract informations from an ERP and display them.

= How can I force the plugin to shows WP tables ? =

You can remove the security check line `58` by deleting ` or substr($atts['from'], 0,strlen($wpdb->prefix)) === $wpdb->prefix` 

= Why the language doesn't change? =

You probably misstyped the language name. Make sure you write it exactly with the correct name.
Refer to : https://www.datatables.net/plug-ins/i18n/

E.g for french : `//cdn.datatables.net/plug-ins/1.10.10/i18n/French.json` , the parameter will be `French` with the first letter in uppercase.

== Changelog ==

= 0.1 =
* First version
