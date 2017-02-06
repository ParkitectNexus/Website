import './bootstrap'

import LikeButton from './components/LikeButton'
import LikeThumbnail from './components/LikeThumbnail'
import LikeForumPost from './components/LikeForumPost'
import ClientHistory from './components/ClientHistory'
import DependencyList from './components/DependencyList'

new Vue({
    el: '#app',

    components: {
        LikeButton,
        LikeThumbnail,
        LikeForumPost,
        ClientHistory,
        DependencyList
    }
})

import './tag-filters'


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