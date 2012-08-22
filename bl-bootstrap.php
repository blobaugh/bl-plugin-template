<?php

$fields = array();
foreach( $_POST AS $k => $v ) {
    $k = str_replace( 'pluginception_', '', $k );
    $fields[$k] = $v;
}

$fields['prefix'] = str_replace( '-', '_', $fields['slug'] );
$fields['const_prefix'] = strtoupper( $fields['prefix'] );
echo '<pre>'; var_dump( $fields ); echo '</pre>';
extract( $fields );
echo "<p>slug $slug</p>";
/*
 * This is going to be rather complex. Create a list of files with the strings
 * to be replaced in them. The structure of this array will be
 * 
 * $replacements = array(
 *      'relative/file' => array(
 *          'string' => 'replacement'
 *      )
 * )
 */
$replacements = array(
    'bl-plugin-template.php'  => array(
        'bl-plugin-template-textdomain'   => $slug,
        'bl-plugin-template'              => $name,
        'bl-plugin-uri'                   => $uri,
        'bl-plugin-description'           => $description,
        'bl-plugin-version'               => $version,
        'bl-plugin-author-uri'            => $author_uri,
        'bl-plugin-author'                => $author,
        'bl-plugin-license-uri'           => $license_uri,
        'bl-plugin-license'               => $license,
        'bl_debug'                        => $prefix . "_debug",
        'bl_dump'                         => $prefix . "_dump",
    ),
    'lib/bl/bl-functions.php' => array(
        'bl_debug'                       => $prefix . "_debug",
        'bl_dump'                        => $prefix . "_dump",
        'bl-wp-admin-css'                => $prefix . "-wp-admin-css",
        'bl-wp-admin-js'                 => $prefix . "-wp-admin-js",
    ),
    'lib/bl/BLDebugBar.class.php' => array(
        'bl_load_debug_bar'             => $prefix . "_load_debug_bar",
        'bl-plugin-template-debug-bar'  => $name,
        'BLDebugBar'                    => $const_prefix . "DebugBar",
        'bl_debug'                      => $prefix . "_debug",
    )
);

// To replace in ALL plugin files
$global_replace = array(
    'BL_TEXTDOMAIN'                 => $const_prefix . '_TEXTDOMAIN',
    'BL_PLUGIN_DIR'                 => $const_prefix . '_PLUGIN_DIR',
    'BL_PLUGIN_URL'                 => $const_prefix . '_PLUGIN_URL',
    'BL_PLUGIN_FILE'                => $const_prefix . '_PLUGIN_FILE',
);



$plugin_dir = trailingslashit( $new_plugin_folder );

// Loop through each of the replacements and perform the string replacement 
foreach ( $replacements AS $file => $replace ) {
    $f = $plugin_dir . $file; // Full system path to plugin file to replace
    echo "<p>Looking for file $f</p>";
    echo "<ul>";
    $content = $wp_filesystem->get_contents( $f ); 
    $new_content = $content;
    foreach( $replace AS $k => $v ) {
        echo "<li>Replacing $k with $v</li>";
        $new_content = str_replace( $k, $v, $new_content );
    }
    echo "</ul>";
    
    $res = $wp_filesystem->put_contents( $f, $new_content );
    var_dump($res);
    
}


// Perform replacements that happen in every file
replace_in_all_files( $plugin_dir, $global_replace );

echo '<pre>'; var_dump($all_files); echo '</pre>';


function replace_in_all_files( $dir, $global_replace ) {
    global $wp_filesystem;
    $dir = trailingslashit( $dir );
    echo '<pre>'; var_dump($global_replace); echo '</pre>';
    echo "<p>Looking in $dir</p>";
    $files = $wp_filesystem->dirlist( $dir, false, false );
    foreach( $files AS $f ) {
        $file =  $dir . $f['name'];
        if( 'd' == $f['type'] ) {
            replace_in_all_files( $file, $global_replace );
        } else {
            echo "<p>Content in file $file</p>";
            $content = $wp_filesystem->get_contents( $file ); 
            $new_content = $content;
            foreach( $global_replace AS $k => $v ) {
                echo "<li>Replacing $k with $v</li>";
                $new_content = str_replace( $k, $v, $new_content );
            }
            echo "</ul>";

            $res = $wp_filesystem->put_contents( $file, $new_content );
            var_dump($res);
        }
    }
}