(function() {
    // Register buttons
    tinymce.create('tinymce.plugins.MyButtons', {
        init: function( editor, url ) {
            // Add button that inserts shortcode into the current position of the editor
            editor.addButton( 'my_button', {
                title: 'Buy Now Button',
                icon: false,
                onclick: function() {
                    // Open a TinyMCE modal
                    editor.windowManager.open({
                        title: 'Buy Now Button',
                        body: [{
                            type: 'textbox',
                            name: 'label',
                            label: 'Label'
                        },{
                            type: 'textbox',
                            name: 'link',
                            label: 'Link URL'
                        },{
                            type: 'textbox',
                            name: 'price',
                            label: 'Price'
                        }],
                        onsubmit: function( e ) {
                            editor.insertContent( '[buybutton link="' + e.data.link + '" label="' + e.data.label + '" price="' + e.data.price + '"]' );
                        }
                    });
                }
            });
        },
        createControl: function( n, cm ) {
            return null;
        }
    });
    // Add buttons
    tinymce.PluginManager.add( 'my_button_script', tinymce.plugins.MyButtons );
})();