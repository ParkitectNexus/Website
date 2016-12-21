var githubAPIURL = "https://api.github.com";
Vue.component('client-history',{
  template: '#client-history-template',
  props: ['repository','user'],
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
       
        Vue.set(self, 'results', res)
        

        console.log(self.results);
      }
      xhr.send()
    }
  }
});

