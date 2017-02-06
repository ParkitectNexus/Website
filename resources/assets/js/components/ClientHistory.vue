<template>
    <div class="history-container">
        <div v-if="results" v-for="result in results" class="history-entry">
            <a v-bind:href="result.html_url"><h4>{{result.tag_name}}</h4></a>
            <div class="body" v-html="result.body"></div>
        </div>
    </div>

</template>

<script>
    var githubAPIURL = "https://api.github.com";
    export default{
        props: ['repository','user'],
        data: function () {
          return {"results": []}
        },
        created: function () {
            this.fetchData();
        },
        methods: {
            fetchData: function () {
                var xhr = new XMLHttpRequest();
                var self = this;
                xhr.open('GET', githubAPIURL +"/repos/" + this.user + "/"+ this.repository + "/releases")
                xhr.onload = function () {

                    var res = JSON.parse(xhr.responseText);

                    var reader = new commonmark.Parser();
                    var writer = new commonmark.HtmlRenderer();

                    for (var i = res.length - 1; i >= 0; i--) {
                        res[i].body = writer.render( reader.parse(res[i].body));
                    }

                    Vue.set(self, 'results', res);

                };
                xhr.send()
            }
        }
    }
</script>