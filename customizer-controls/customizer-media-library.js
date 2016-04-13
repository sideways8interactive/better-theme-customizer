/*
 * Custom JS used to add the media library to the theme customizer.
 */
jQuery( document ).ready( function ( $ ) {
    var s8_customizer_file_frame,
        s8_current_item,
        s8_identifier;
    // Attach the upload/add button to our functionality
    $( '.s8_customizer_uploader' ).on( 'click', function ( e ) {
        e.preventDefault();
        s8_current_item = $( this );
        s8_identifier = $( this ).attr( 'id' );
        // Create media frame using data elements from the clicked element
        s8_customizer_file_frame = wp.media.frames.file_frame = wp.media( {
            title: $( this ).data( 'title' ),
            button: { text: $( this ).data( 'button' ) },
            class: s8_identifier
        } );
        // What to do when the image/file is selected
        s8_customizer_file_frame.on( 'select', function () {
            var attachment = s8_customizer_file_frame.state().get( 'selection' ).first().toJSON(),
                file_type = s8_current_item.data( 'upload-type' );
            if ( 'image' == file_type ) {
                // Have the image be visible immediately
                $( '.s8_customizer_uploader_output.' + s8_identifier ).attr( 'src', attachment.url )
                    .css( 'opacity', 1 );
            } else {
                // Show the file name
                $( '.s8_customizer_uploader_output.' + s8_identifier ).html( attachment.filename )
                    .css( 'opacity', 1 );
            }
            // Put the attachment ID where we can save it
            $( '.s8_customizer_uploader_output_id.' + s8_identifier ).attr( 'value', attachment.id )
                .trigger( 'change' ); // Trigger a change event so we can save it!
            // Show the remove button
            $( '.s8_customizer_uploader_remove.' + s8_identifier ).removeAttr( 'disabled' );
        } );
        // Open the modal
        s8_customizer_file_frame.open();
        // Fix CSS
        $( 'body > div[id^=__wp-uploader-id-]' ).css( 'z-index', '600000' ).css( 'position', 'relative' );
    } );
    // Attach the remove button to our functionality
    $( '.s8_customizer_uploader_remove' ).on( 'click', function ( e ) {
        e.preventDefault();
        s8_identifier = $( this ).data( 'id' );
        $( this ).attr( 'disabled', 'disabled' );
        $( '.s8_customizer_uploader_output.' + s8_identifier ).css( 'opacity', 0 );
        $( '.s8_customizer_uploader_output_id.' + s8_identifier ).attr( 'value', '' )
            .trigger( 'change' ); // Trigger a change event so we can save it!
    } );
} );
