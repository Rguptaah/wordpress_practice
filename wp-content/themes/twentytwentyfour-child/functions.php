<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array(  ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

// END ENQUEUE PARENT ACTION

// Create Custom Upload Diectory
function create_custom_upload_dir() {
    $upload_dir = wp_upload_dir();
    $custom_dir = $upload_dir['basedir'] . '/contactform7_uploads';

    if (!file_exists($custom_dir)) {
        wp_mkdir_p($custom_dir);
    }
}

add_action('init', 'create_custom_upload_dir');

//function to create a table for storing contact form data
function create_custom_cf7_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'cf7_submissions';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        form_id mediumint(9) NOT NULL,
        form_data text NOT NULL,
        file_paths text,
        submission_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

add_action('after_switch_theme', 'create_custom_cf7_table');


// Hook to save cf7 file data
add_action('wpcf7_before_send_mail', 'save_cf7_submission');

function save_cf7_submission($contact_form) {
    global $wpdb;

    $submission = WPCF7_Submission::get_instance();
    if ($submission) {
        $data = $submission->get_posted_data();
        // $uploaded_files = $submission->uploaded_files();
        $form_id = $contact_form->id();

        // $upload_dir = wp_upload_dir();
        // $custom_dir = $upload_dir['basedir'] . '/contactform7_uploads';

        // $moved_files = [];

        // foreach ($uploaded_files as $key => $file) {
        //     if ($file) {
        //         $filename = basename($file);
        //         $new_path = $custom_dir . '/' . $filename;

        //         // Move the file
        //         if (rename($file, $new_path)) {
        //             $moved_files[$key] = $upload_dir['baseurl'] . '/contactform7_uploads/' . $filename;
        //         } else {
        //             $moved_files[$key] = $file; // If move fails, keep original path
        //         }
        //     }
        // }

        // Serialize form data and file paths for storage
        $form_data = maybe_serialize($data);
        // $file_paths = maybe_serialize($moved_files);

        // Save data to custom table
        $wpdb->insert(
            $wpdb->prefix . 'cf7_submissions',
            array(
                'form_id' => $form_id,
                'form_data' => $form_data,
                // 'file_paths' => $file_paths,
                'submission_date' => current_time('mysql')
            )
        );
    }
}


// Adding Menu to Admin Dashboard
add_action('admin_menu', 'cf7_custom_submissions_menu');

function cf7_custom_submissions_menu() {
    add_menu_page('CF7 Submissions', 'CF7 Submissions', 'manage_options', 'cf7-submissions', 'cf7_custom_submissions_page');
}

function cf7_custom_submissions_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'cf7_submissions';
    $results = $wpdb->get_results("SELECT * FROM $table_name");
    foreach($results as $key => $row){
        $arr = [];
        if($key == 0){
            $form_data = maybe_unserialize($row->form_data);
            if (is_array($form_data)) {
                foreach ($form_data as $key => $value) {
                    if (is_array($value)) {
                        foreach ($value as $sub_key => $sub_value) {
                            $arr[] = "File".$sub_key+1;
                        }
                    }
                    else {
                        $arr[] = esc_html(strtoupper(str_replace('-',' ',$key)));
                    } 
                }
            }
        }
    }
    echo '<div class="wrap"><h1>All Job Form Submissions</h1>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>ID</th><th>Form ID</th>';
    
    foreach($arr as $title){
        echo "<th>".$title."</th>";
    }
    
    echo '<th>Submission Date</th></tr></thead><tbody>';
    foreach ($results as $row) {
        echo '<tr>';
        echo '<td>' . esc_html($row->id) . '</td>';
        echo '<td>' . esc_html($row->form_id) . '</td>';
        echo '<td>';
        
        $form_data = maybe_unserialize($row->form_data);
        if (is_array($form_data)) {
            foreach ($form_data as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $sub_key => $sub_value) {
                        $file_extension = pathinfo($sub_value, PATHINFO_EXTENSION);
                        if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                            echo '<img src="' . esc_url($sub_value) . '" alt="' . esc_html(basename($sub_value)) . '" style="max-width: 150px; max-height: 150px; margin: 5px;" /><br>';
                        } elseif ($file_extension === 'pdf') {
                            echo '<embed src="' . esc_url($sub_value) . '" type="application/pdf" width="100%" height="200px" /><br>';
                        } elseif (in_array($file_extension, ['doc', 'docx'])) {
                            echo '<iframe src="https://docs.google.com/gview?url=' . esc_url($sub_value) . '&embedded=true" style="width:100%; height:200px;" frameborder="0"></iframe><br>';
                        }
                        // Provide a download link for all files
                        echo '<a href="' . esc_url($sub_value) . '" target="_blank">' . esc_html(basename($sub_value)) . '</a> (<a href="' . esc_url($sub_value) . '" download>Download</a>)<br>';
                    }
                }
                else {
                    echo '<strong>' . esc_html(strtoupper(str_replace('-',' ',$key))) . ':</strong> ' . esc_html($value) . '<br>';
                }
            }
        } else {
            echo esc_html($form_data);
        }

        echo '</td>';
        // echo '<td>';
        
        // $file_paths = maybe_unserialize($row->file_paths);
        // if (is_array($file_paths)) {
        //     foreach ($file_paths as $file_path) {
        //         echo '<a href="' . esc_url($file_path) . '" target="_blank">' . esc_html(basename($file_path)) . '</a><br>';
        //     }
        // } else {
        //     echo esc_html($file_paths);
        // }

        // echo '</td>';
        echo '<td>' . esc_html($row->submission_date) . '</td>';
        echo '</tr>';
    }
    
    echo '</tbody></table></div>';
}




