<?php
/*
Plugin Name: Covoituristes.fr
Plugin URI: http://www.covoituristes.fr
Description: Covoiturage pour votre site WordPress. Solution 100% intégrée dans votre site. Covoiturage événementiel. Cliquez RÉGLAGES (SETTINGS) dans le Tableau de bord et choissisez covoituristes.
Version: 0.1.0
Author: LaDauze
Author URI: http://www.covoituristes.fr
License:  This plugin is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or (at your option) any later version. ShopAdder is freemium ware. A version is 
available free of charge and a pro version with advanced extras is available for a small charge per year.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
*/
$var_header = "not_yet_set";

if(!class_exists('WP_covoiturageclass'))
{
    class WP_covoiturageclass
    {
    
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
            
            // register actions
            add_action('admin_init', array(&$this, 'admin_init'));
            add_action('admin_menu', array(&$this, 'add_menu'));            

        } // END public function __construct
        
        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init() {
            
            // register your plugin's settings
            register_setting('wp_covoiturageclass-group', 'covoiturage_header');

            // add your settings section
            add_settings_section(
                'wp_covoiturageclass-section', 
                '', 
                array(&$this, 'settings_section_wp_covoiturageclass'), 
                'wp_covoiturageclass'
            );
            
            // add your setting's fields
            add_settings_field(
                'wp_covoiturageclass-setting_a', 
                'Collez le code de covoituristes.fr :', 
                array(&$this, 'settings_field_input_text'), 
                'wp_covoiturageclass', 
                'wp_covoiturageclass-section',
                array(
                    'field' => 'covoiturage_header'
                )
            );

            // Possibly do additional admin_init tasks
        } // END public static function activate
         
        /**
         * add a menu
         */        
        public function add_menu()
        {
            // Add a page to manage this plugin's settings
            add_options_page(
                'Covoituristes Réglages', 
                'Covoituristes', 
                'manage_options', 
                'wp_covoiturageclass', 
                array(&$this, 'covoiturageplugin_settings_page')
            );
        } // END public function add_menu()
    
        /**
         * Menu Callback
         */        
        public function covoiturageplugin_settings_page() {
            global $sa_productArray;
            if(!current_user_can('manage_options')) {
                wp_die(__('You do not have sufficient permissions to access this page.'));
            }
                        
            $testoption = get_option("covoiturage_header");
            if($testoption === "") {
                update_option("covoiturage_header","");

            } else {
                
            }
            
?>

            <div class="wrap">
                <a href="http://www.covoituristes.fr" target="_blank">
                    <?php
                    echo '<img src="' . plugins_url( 'covoituristes_fr_95x50.png', __FILE__ ) . '" alt="covoiturage par Covoituristes.fr" style="float:right"> ';
                    ?>
                </a>
                <style>
                    .marleft { margin-left: 50px; }
                    .marinp {  position: relative; left: 100px;}
                    .instruct { font-size: 85%; color: gray;}
                    .greenbar {
                            background-color: #B3CFEC;
                            padding-top:10px;padding-bottom:10px;padding-left: 5px;
                    }
                </style>
                <script>
                    function newaccount(){
                        var tmpurl = "http://app.applix.fr/openaccount?wp=true&lang=1&aid=cov&mid=ax&mail=" + document.getElementById('mail63636').value + "&id="+ document.getElementById('name63636').value;
                        var ow = window.open(tmpurl, "owin", 'menubar=no,scrollbars=yes,status=no,width=800,height=600,left=0,top=0');
                        if (!ow){
                            document.getElementById('do63636').href = tmpurl;
                            return true;                    
                        } else {
                            return false;
                        }
                    }
                    function createevent(){
                        document.getElementById('ta63636').value = "[covoiturage:" + document.getElementById('date63636').value + ":" + document.getElementById('title63636').value + "]";
                    }
                    
                </script>
                
                <h3>Félicitations!</h3>
                <p style="font-size:105%">Vous venez d'ajouter un système de covoiturage très innovant à votre site WordPress.<br></p>
                
                <?php if (get_option("covoiturage_header")) { ?>
                <h3 class="greenbar">Étape 1 : déjà fait</h3>
                <div class="marleft">
                <ul id="newaccount63636">
                    <a href="http://www.covoituristes.fr" target="_blank" class="marleft">covoituristes.fr</a>
                <ul>
                </div>
                <?php } else { ?>
                <h3 class="greenbar">Étape 1 : Créer un nouveau compte sur <a href="http://www.covoituristes.fr" target="_blank">www.covoituristes.fr</a></h3>
                <div class="marleft">
                <ul id="newaccount63636">
                    Si vous n'avez pas encore un compte vous pouvez entrer votre nom et votre adresse mail ici :
                    <table class="form-table">
                    
                    <tr>
                        <th>Votre nom : </th>
                        <td><input type="text" id="name63636" value=""></td>
                    </tr>
                    <tr>
                        <th>Votre mail :</th>
                        <td><input type="text" id="mail63636" value=""></td>
                    </tr>
                    <tr>
                        <th></th>
                        <td><a href="http://www.covoituristes.fr" target="_blank" onclick="return newaccount();" id="do63636"><button class="button button-primary">Créer un nouveau compte</button></a></td>
                    </tr>
                    </table>
                <ul>
                </div>
                <?php } ?>
                <h3 class="greenbar">Étape 2 : Coller le code :</h3>
                <div class="marleft">
                <ul>
                    <li>Si vous avez copié le code vous pouvez coller ce code ici :</li>
                </ul>
                    <form method="post" action="options.php"> 
                    <?php @settings_fields('wp_covoiturageclass-group'); ?>
                    <?php @do_settings_fields('wp_covoiturageclass-group'); ?>
                    <?php do_settings_sections('wp_covoiturageclass'); ?>
                    <table class="form-table">
                        <tr>
                            <th></th>
                            <td>
                            <?php @submit_button(); ?>
                            </td>
                       </tr>
                    </table>
                    </form>
                </div>
                
                <h3 class="greenbar">Étape 3 : Créer un nouvel événement :</h3>
                <div class="marleft">
                    <ul>
                        <li>Vous pouvez facilement créer un nouvel événement; remplissez le formulaire ci-dessous :</li>
                    </ul>
                
                    <table class="form-table">
                    <tr>
                        <th>
                            Titre : 
                         </th>
                         <td>
                            <input type="text" id="title63636" value="" onkeyup="createevent()">
                         </td>
                    </tr>
                    <tr>
                        <th>
                            Date :
                        </th>
                            <td><input type="text" id="date63636" value="" onkeyup="createevent()"> <span class="instruct">Format : YYYYMMDD par exemple : 20151231</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Code à copier et coller :
                        </th>
                        <td>   
                            <textarea id="ta63636" cols=50 rows=5>
                            </textarea>
                        </td>
                    </tr>
                    </table>
                    
                    <ul>
                        <li>Vous pouvez aussi créer des nouveaux événements en tapant le code directement dans vos messages.</li>
                        <li>Entrez <b>[covoiturage:20150131:Titre d'un nouvel événement]</b> pour créer un nouvel événement.</li>
                        <li>20151031 c'est le date (YYYYMMDD) pour 31 Janvier 2015</li>
                    </ul>
                    
                </div>
                <hr>
                <a href="http://www.covoituristes.fr" target="_blank">Covoituristes.fr</a>  
                <hr>
                
            
            </div>

<?php
        } // END public function plugin_settings_page()
        
        
        /**
         * Settings intro
         */                
        public function settings_section_wp_covoiturageclass() {
            // Think of this as help text for the section.
            //echo '</ol>';
        }
        
        /**
         * This function provides text inputs for settings fields
         */
        public function settings_field_input_text($args) {
            // Get the field name from the $args array
            $field = $args['field'];
            // Get the value of this setting
            $value = get_option($field);
            // echo a proper input type="text"
            echo sprintf('<textarea cols=50 rows=5 name="%s" id="%s">%s</textarea>', $field, $field, $value);
        } // END public function settings_field_input_text($args)
                
                
        /**
         * Activate the plugin
         */
        public static function activate() {
            // Do nothing
        } // END public static function activate
    
        /**
         * Deactivate the plugin
         */        
        public static function deactivate() {
            // Do nothing
        } // END public static function deactivate
    } // END class WP_covoiturageclass
} // END if(!class_exists('WP_covoiturageclass'))

if( !class_exists( 'WP_Http' ) ) {
    include_once( ABSPATH . WPINC. '/class-http.php' );
}

if(class_exists('WP_covoiturageclass')) {
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('WP_covoiturageclass', 'activate'));
    register_deactivation_hook(__FILE__, array('WP_covoiturageclass', 'deactivate'));

    // instantiate the plugin class
    $covoiturage = new WP_covoiturageclass();

    $var_header = get_option("covoiturage_header");
    if(strlen($var_header)<1) { $var_header = "alert('Please get a covoiturage code at www.covoituristes.fr first!')"; }

    if($var_header){
        
        add_action('wp_footer', 'covoiturage_ldr_loader_js');

    } else {
        
        // find something to alert user
        
    }
        
    // Add a link to the settings page onto the plugin page
    
    if(isset($covoiturage)) {
        // reserved
    }
    
}

function covoiturage_ldr_loader_js() {
    global $var_header;
    echo $var_header;
}
