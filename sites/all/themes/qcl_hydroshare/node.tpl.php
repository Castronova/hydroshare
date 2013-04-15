<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

    <?php 
    if( !empty( $content ) and !empty($content['body']) and ( strpos( $content['body']['#bundle'], "hydroshare_" ) !== false ) ) {
        print $user_picture; 
        print render($title_prefix); 
	    print( '<div class="subHeader">' );
	    print( '<h1'. $title_attributes.'><a href="'.$node_url.'">'.$title.'</a></h1>');
	    print('<p>Resource Details</p>
	           </div><!-- subHeader -->
	    <BR><BR><BR>
		<div class="myContentSub">
		    <div class="myContentSubInner">');
                    // =-=-=-=-=-=-=-
                    // wire up export button
                    // NOTE:: this was extraced from printing the $content variable.
                    //        there HAS to be a better way....
                    $real_path = drupal_realpath( $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_file['und'][0]['uri'] ); 
 
                    // =-=-=-=-=-=-=-
                    // extract the metadata and display it 
                    $contrib = "";
                    $tmp_arr = $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_contributor;
                    if( !empty( $tmp_arr ) ) {
                        $contrib = $tmp_arr['und'][0]['safe_value']; 
                    }

                    $subject = "";
                    $tmp_arr = $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_subject;
                    if( !empty( $tmp_arr ) ) {
                        $subject = $tmp_arr['und'][0]['safe_value']; 
                    }
                    
                    $relation = "";
                    $tmp_arr = $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_relation;
                    if( !empty( $tmp_arr ) ) {
                        $relation = $tmp_arr['und'][0]['safe_value']; 
                    }
                    
                    $source = "";
                    $tmp_arr = $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_source;
                    if( !empty( $tmp_arr ) ) {
                        $source = $tmp_arr['und'][0]['safe_value']; 
                    }
                    
                    $type = "";
                    $tmp_arr = $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_type;
                    if( !empty( $tmp_arr ) ) {
                        $type = $tmp_arr['und'][0]['safe_value']; 
                    }
                    
                    $coverage = "";
                    $tmp_arr = $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_coverage;
                    if( !empty( $tmp_arr ) ) {
                        $coverage = $tmp_arr['und'][0]['safe_value']; 
                    }
                    
                    $rights = "";
                    $tmp_arr = $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_rights;
                    if( !empty( $tmp_arr ) ) {
                        $rights = $tmp_arr['und'][0]['safe_value']; 
                    }
                    
                    $format = "";
                    $tmp_arr = $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_format;
                    if( !empty( $tmp_arr ) ) {
                        $format = $tmp_arr['und'][0]['safe_value']; 
                    }

                    // =-=-=-=-=-=-=-
                    // get the file directory
                    $dir = drupal_dirname( $real_path );
                    $dir = drupal_dirname( $dir );

                    // =-=-=-=-=-=-=-
                    // get the zip name of the directory
                    $zip_file = NULL;
                    if( data_model_zip_file_name( $dir, $zip_file ) == false ) {
                        error_log( "data_model_node_view :: data_model_zip_file_name failed for $dir" );
                        return NULL;

                    }
                    
                    // =-=-=-=-=-=-=-
                    // build the java script operation
                    $hostname = $_SERVER['SERVER_NAME'];
                    $op = "http://$hostname/export.php?file=" . $zip_file;
 
                    $edit_url = "http://$hostname/?q=node/" . $content[ 'comments' ][ 'comment_form' ][ '#node' ]->nid . "/edit";
                    $delete_url = "http://$hostname/?q=node/" . $content[ 'comments' ][ 'comment_form' ][ '#node' ]->nid . "/delete";
                    print( '<div class="contentListWrapper">');
                        print( '<a href="" class="greyButton">EXECUTE</a>');
                        print( '<a href="" class="greyButton">SHARE</a>');
                        print( '<a href="'.$op.'" class="greyButton">EXPORT</a>');
                        print( '<a href="'.$edit_url.'" class="greyButton">EDIT</a>');
                        print( '<a href="'.$delete_url.'" class="greyButton">DELETE</a>');
                    print( '</div> <!-- contentListWrapper --> ');


                    $render = render( $content );
                    $matches = NULL;
                    print( '<div id="hydroshare_vizualization"></div>' );
                    $ret = preg_match( '/<script>render_single_time_series.*<\/script>/i', $render, $matches );
                    if( $ret ) {
                        print( $matches[0] );
                    } 

                    $pos0 = strpos( $submitted, "Submitted by " );
                    $pos1 = strpos( $submitted, " on " );

                    $type    = "Time Series";
                    $author  = substr( $submitted, $pos0, $pos1 - $pos0 );
                    $created = substr( $submitted, $pos1, strlen( $submitted ) - $pos1 );
                    print( '<BR><BR>' );
                    print( '<div class="half-column">' );
                        print( '<p><span class="bold">Resource Type:</span> '.$type.'</p>');
                        print( '<p><span class="bold">Created by:</span> '.$author.'</p>');
                        print( '<p><span class="bold">Created: </span>'.$created.'</p>');
                    print( '</div> <!-- half-column -->' );
      
                    print( '<div class="half-column-right">' );
                        print( '<p><span class="bold">Contributors: </span>'.$contrib.'</p>');
                        print( '<p><span class="bold">Subject: </span>'.$subject.'</p>');
                        print( '<p><span class="bold">Relation: </span>'.$relation.'</p>');
                        print( '<p><span class="bold">Source: </span>'.$source.'</p>');
                        print( '<p><span class="bold">Type: </span>'.$type.'</p>');
                        print( '<p><span class="bold">Coverage: </span>'.$coverage.'</p>');
                        print( '<p><span class="bold">Rights: </span>'.$rights.'</p>');
                        print( '<p><span class="bold">Format: </span>'.$format.'</p>');
                    print( '</div> <!-- half-column -->' );
      
                    print('<div class="full-column">');
 			print( '<div class="starWrapper">');
			    print( render( $content['field_rating'] ) ); 
			print('</div>');

			print( '<span class="bold">Tags: </span>' );
			$tags = $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_tags['und'];
			foreach( $tags as $tag ) {
			    print( $tag['taxonomy_term']->name.', ');
			}
                   
                        print('<h2>Resource Description</h2>');
                        print( render( $content['body'] ) );
 
                    print( '</div> <!-- full-column -->' );
              
        
                print( '</div> <!-- myContentSubInner -->');

print('</div> <!-- mycontentSub -->');
    } else {

	  print( '<div class = "content clearfix">');// . $content_attributes.' >');
	      print( render( $content[ 'comments' ] ) ); 
	  print( '</div>' );

	  print( render($title_suffix) );
          print( '<div class="content clearfix">');// . $content_attributes . ' >');
              //if( !empty( $content['comments'] ) {
	      //    print( hide($content['comments']) );
              //}
              //if( !empty( $content['links'] ) {
	      //    print( hide($content['links']) );
              //}
	      print( render($content) );
	  print( '</div>' );

	  print( '<div class="clearfix">');
	      if (!empty($content['links'])) { 
	           print( ' <div class="links">' );
                   print render($content['links']); 
                   print( '</div>');
	      }

	      print( render($content['comments']) ); 
	  print( '</div>' );

    } 
?>
   
</div>