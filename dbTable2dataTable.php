<?php
  /**
   * Plugin Name: DbTable to DataTable
   * Description: Display data from a custom database table into a datatable
   * Version: 0.1
   * Author: Guillaume Raineri
   * Author URI: https://github.com/rikemsen/
   * License: GPLv2 or later
   */

class dbTable2dataTable
{
    protected static $instance;

    protected $defaults = array();
    protected $jsObject = array();
    
    /**
     * Singleton Factory
     *
     * @return object
     */
    public static function instance() {
        if ( !isset( self::$instance ) )
            self::$instance = new dbTable2dataTable();

        return self::$instance;
    }

    /**
     * Construct
     *
     * @uses function add_shortcode
     */
    protected function __construct() {
        add_shortcode( 'dbtable', array( $this, 'shortcode' ) ); // New shortcode.
        $this->defaults = array(
              'from'        => null,    // Source file url.
              'select'      => null,    // column ignored
              'except'      => null,    // column ignored
              'cssclass'    => null,    // Specify custom CSS class for the <table>
              'comments'    => false,   // Use field comments instead of column name
              'pagination'  => false,   // Enable / Disable pagination
              'limit'       => 25,      // Limit of results per page
              'language'    => 'English' // Default language : French
            );
    }

    /**
     * Construct
     *
     * @uses function shortcode_atts
     */
    function shortcode( $atts ) {
      global $wpdb;

      $atts = shortcode_atts($this->defaults, $atts);
      if(is_null($atts['from']) or substr($atts['from'], 0,strlen($wpdb->prefix)) === $wpdb->prefix){
        return '<span style="color:red;">You can not display datas from all tables starting with "'.$wpdb->prefix.'" or you have forgotten to specify the "from" parameter.</span>';
      }

      // Enqueue plugin CSS only on pages where shortcode is used.
      wp_enqueue_style('dbtable2table', plugin_dir_url(__FILE__).'css/datatables.min.css', array(), '1.0', true);

      // Enqueue plugin JS only on pages where shortcode is used.
      // ---- Lib DataTable
      wp_enqueue_script('dbtable2tableLib', plugin_dir_url(__FILE__).'js/datatables.min.js', array(), '1.0', true);
      // ---- Custom Script
      $jsObject = array('language' => $atts['language'], 'limit' => (int)$atts['limit'], 'pagination' => ((bool)$atts['pagination'] ? 'true' : 'false'), 'filter');
      wp_register_script( 'dbtable2tableMain', plugin_dir_url(__FILE__).'js/main.js', array( 'jquery' )); //if jQuery is not needed just remove the last argument. 
      wp_localize_script( 'dbtable2tableMain', 'dbtable2tableOptions', $jsObject ); //pass 'object_name' to script.js
      wp_enqueue_script( 'dbtable2tableMain' );   
      add_action( 'wp_enqueue_scripts', 'dbtable2tableMain' );

      // Render table and return HTML string.
      return $this->renderTable($atts);
    }

    /**
     * Construct
     *
     * @uses global variable $wpdb
     */
    function renderTable($atts){
      global $wpdb;

      $tableRendered = $cssClass = '';
      $select = $except = array();

      if(is_null($atts['from']))
        return null;

      if(is_null($atts['select'])){
        if(!is_null($atts['except'])){
          if(strpos($atts['except'], ','))
            $except = explode(',', $atts['except']);
          else
            $except[] = $atts['except'];
        }
      }else{
          if(strpos($atts['select'], ','))
            $select = explode(',', $atts['select']);
          else
            $select[] = $atts['select'];
      }
      
      $cssClass = (!is_null($atts['cssclass']) AND strpos($atts['cssclass'], ',')) ? str_replace(',', ' ', $atts['cssclass']) : $atts['cssclass'];

      $tableRendered .= '<table class="dbtable2databable '.$cssClass.'">';
        $tableRendered .= '<thead>';
          $tableRendered .= '<tr>';

            //We get column names
            $myrows = $wpdb->get_results('SHOW full COLUMNS FROM '.$atts['from']);
            foreach ($myrows as $oneColumn) {

              if(is_null($atts['select'])){
                if(!in_array($oneColumn->Field, $except)){
                  if($atts['comments'] && strlen($oneColumn->Comment) > 0){
                    $tableRendered .= '<th>'.$oneColumn->Comment.'</th>';
                  }else{
                    $tableRendered .= '<th>'.$oneColumn->Field.'</th>';
                  }
                }
              }else{
                if(in_array($oneColumn->Field, $select)){
                  if($atts['comments'] && strlen($oneColumn->Comment) > 0){
                    $tableRendered .= '<th>'.$oneColumn->Comment.'</th>';
                  }else{
                    $tableRendered .= '<th>'.$oneColumn->Field.'</th>';
                  }
                }
              }

            }

          $tableRendered .= '</tr>';
        $tableRendered .= '</thead>';
        $tableRendered .= '<tbody>';

          //We add datas to the table
          $myrows = $wpdb->get_results('SELECT * FROM '.$atts['from']);

          foreach ($myrows as $oneRow) {
            $tableRendered .= '<tr>';
              foreach ($oneRow as $key => $value) {
                if(is_null($atts['select'])){
                  if(!in_array($key, $except))
                    $tableRendered .= '<td>'.$value.'</td>';
                }else{
                  if(in_array($key, $select))
                    $tableRendered .= '<td>'.$value.'</td>';
                }
              }
            $tableRendered .= '</tr>';
          }

        $tableRendered .= '</tbody>';
      $tableRendered .= '</table>';

      return $tableRendered;
    }

}
dbTable2dataTable::instance();
