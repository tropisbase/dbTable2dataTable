=== DbTable to DataTable ===
Contributors: rikemsen
Tags: datatable, jquery, mysql, table, sortable
Requires at least: 4.4
Tested up to: 4.4
Stable tag: 4.4
License: GPLv2 or later

Display mysql datas into datatable.

== Description ==

This plugin allows you to display the content of MySql tables into sortable html tables thanks to the DataTable jQuery Plugin.

You don't need any configuration and once installed, it is ready to use.

Simply add the shortcode `[dbtable]` into an article or a page and you will have a nice and clean table.

###Examples:

All parameters that contain more than one value have to be separated by commas without spaces.

Minimum needed : `[dbtable from=MysqlTableName]`

1. `select=field1,field2,field3` will display all rows of the table and only specified fields
2. `except=field1,field2,field3` will display all rows of the table except specified fields
3. `cssClass=class1,class2` will add class1 and class2 to the <table class=""> attribut
4. `comments=true|(false)` true will use comments specified in each field of the MySql table as datatable column names. If true and if a comment is missing, the plugin fallback on field name only for the one missing, not for the entire table.
5. `pagination=true|(false)` will show/hide the bottom pagination links. If false, make sure you have the limit parameter large enough to display all your datas
6. `limit=25` Display 25 rows by default.

== Installation ==

= From your WordPress dashboard =

1. Visit 'Plugins > Add New'
2. Search for 'DbTable to DataTable'
3. Activate DbTable to DataTable from your Plugins page.
4. That's it!

= From WordPress.org =

1. Download DbTable to DataTable.
2. Upload the 'DbTable2DataTable' directory to your '/wp-content/plugins/' directory, using your favorite method (ftp, sftp, scp, etc...)
3. Activate 'DbTable to DataTable' from your Plugins page.
4. That's it !

== Screenshots ==


== Frequently Asked Questions ==

= How do I change default values? =

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

You can remove the security check `line 58` by deleting ` or substr($atts['from'], 0,strlen($wpdb->prefix)) === $wpdb->prefix` 

= Why the language doesn't change? =

You probably misstyped the language name. Make sure you write it exactly with the correct name.
Refer to : https://www.datatables.net/plug-ins/i18n/

E.g for french : `//cdn.datatables.net/plug-ins/1.10.10/i18n/French.json` , the parameter will be `French` with the first letter in uppercase.

== Changelog ==

= 0.1 =
* First version

== Upgrade Notice ==
