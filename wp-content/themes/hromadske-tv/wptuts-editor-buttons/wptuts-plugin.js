(function() {
    tinymce.create('tinymce.plugins.Wptuts', {
        init : function(ed, url) {
            ed.addButton('background-text', {
                title : wptuts_plugin.background_text_title,
                cmd : 'background-text',
                image : url + '/text_bacgraund.png'
            });

            ed.addButton('quote-type1', {
                title : wptuts_plugin.quote_type1_title,
                cmd : 'quote-type1',
                image : url + '/quote1.png'
            });

            ed.addButton('quote-type2', {
                title : wptuts_plugin.quote_type2_title,
                cmd : 'quote-type2',
                image : url + '/quote2.png'

            });

            ed.addCommand('background-text', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                return_text = '<span style="background-color: #fef3e6;">' + selected_text + '</span>';
                ed.execCommand('mceInsertContent', 0, return_text);
            });

            ed.addCommand('quote-type1', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                return_text = '<blockquote class="quote-type1" style="background-color: #eff2f7;">«' + selected_text + '»</blockquote>';
                ed.execCommand('mceInsertContent', 0, return_text);
            });

            ed.addCommand('quote-type2', function() {
                var selected_text = ed.selection.getContent();
                ed.windowManager.open({
                   title: wptuts_plugin.form_title,
                   body: [{
                        type: 'textbox',
                        name: 'name',
                        label: wptuts_plugin.label_name
                    },{
                       type: 'button',
                       name: 'select-file',
                       text: wptuts_plugin.label_button,
                       onclick: function() {
                           window.mb = window.mb || {};

                           window.mb.frame = wp.media({
                               library : {
                                   type : 'image'
                               },
                               multiple: false
                           });

                           window.mb.frame.on('select', function() {
                               var json = window.mb.frame.state().get('selection').first().toJSON();
                               if (0 > jQuery.trim(json.url.length)) {
                                   return;
                               }

                               jQuery('#photo-url').val(json.url);
                           });

                           window.mb.frame.open();
                       }
                   },{
                       type: 'textbox',
                       name: 'link',
                       label: wptuts_plugin.label_url,
                       id: 'photo-url'
                   },{
                        type: 'textbox',
                        name: 'description',
                        label: wptuts_plugin.label_description
                   }],
                    onsubmit: function( e ) {
                        var author_name = e.data.name ;
                        var author_photo = e.data.link ;
                        var author_description = e.data.description ;

                        var shortcode;
                        if (author_name !== null) {
                            shortcode = '[quote-type2 author_name="' + author_name + '" author_photo="' + author_photo + '" author_description="' + author_description + '"]' + selected_text + '[/quote-type2]';
                            ed.execCommand('mceInsertContent', 0, shortcode);
                        }
                    }
                });
            });
        }
        // ... Hidden code
    });
    // Register plugin
    tinymce.PluginManager.add( 'wptuts', tinymce.plugins.Wptuts );
})();



