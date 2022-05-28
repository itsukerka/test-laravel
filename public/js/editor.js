let _editor;
document.addEventListener("DOMContentLoaded", function(event) {
    _editor = new EditorJS({
        /**
         * Id of Element that should contain the Editor
         */
        holder: 'editorjs',

        /**
         * Available Tools list.
         * Pass Tool's class or Settings object for each Tool you want to use
         */
        tools: {
            header: {
                class: Header,
                inlineToolbar: ['link']
            },
            embed: Embed,
            list: {
                class: NestedList,
                inlineToolbar: true,
            },
            Marker: {
                class: Marker,
                shortcut: 'CMD+SHIFT+M',
            },
            quote: {
                class: Quote,
                inlineToolbar: true,
                shortcut: 'CMD+SHIFT+O',
                config: {
                    quotePlaceholder: 'Enter a quote',
                    captionPlaceholder: 'Quote\'s author',
                },
            },
            code: CodeTool,
        },
        data: _page.blocks
    })

    $('body').on('click', '#_save_post', function(){
        _editor.save().then((outputData) => {
            $.ajax({
                method: 'POST',
                dataType: 'json',
                data: {
                    data: JSON.stringify(outputData),
                    _token: $('[name="_token"]').val()
                },
                beforeSend: function () {

                },
                success: function (response) {
                    alert('Success!')
                },
                error: function (response) {

                }
            });
        }).catch((error) => {
            alert(error);
        });
        return false;
    });

    $('body').on('click', '#_publish_post', function(){
        _editor.save().then((outputData) => {
            $.ajax({
                method: 'POST',
                dataType: 'json',
                data: {
                    data: JSON.stringify(outputData),
                    status: 'publish',
                    _token: $('[name="_token"]').val()
                },
                beforeSend: function () {

                },
                success: function (response) {
                    alert('Success!')
                },
                error: function (response) {

                }
            });
        }).catch((error) => {
            alert(error);
        });
        return false;
    });

});
