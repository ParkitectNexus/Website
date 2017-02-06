import './bootstrap'


import LikeButton from './components/LikeButton'


new Vue({
    el: '#app',

    components: {
        LikeButton
    }
})

$('.dropdown-toggle').dropdown();

function registerDownload(type, id) {
    $.get('/api/downloads/add/' + type + '/' + id);
}

(function(){
    $(".markdown").markdown({
        autofocus: false, savable: false, fullscreen: false,
        onPreview: function (e) {
            var reader = new commonmark.Parser();
            var writer = new commonmark.HtmlRenderer();
            var parsed = reader.parse(e.getContent());
            return writer.render(parsed);
        }
    });
})();