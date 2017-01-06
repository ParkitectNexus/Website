Vue.component('dependency-list',{
    template: '#dependency-list-template',
    props: ['identifier','type'],
    created: function () {


        this.updateEntries();
        this.updateDependencyList();

    },
    data: function(){
            return  {assets: [],
            dependencies:[],
            assetSearch : ""}

    },
    watch:{
        assetSearch: {
            handler: function (search) {
                this.updateEntries();
            }
        }
    },
    methods: {
        updateEntries: function () {
            var self = this;
            this.$http.get("/api/assets/?type=" + this.type + "&name=" + this.assetSearch,function (data){
                if(data !== ""){
                    self.assets = data.data;
                    self.intersection();
                }

            });
        },
        updateDependencyList: function () {
            var self = this;
            if(this.identifier !== "") {
                this.$http.get("/api/assets/" + this.identifier + "/dependencies", function (data) {
                    if (data !== "") {
                        self.dependencies = data.data;
                        self.intersection();
                    }
                });
            }
        },
        intersection: function () {
            var self = this;
            if(self.dependencies != "undefined") {
                for (var x = 0; x < self.dependencies.length; ++x) {
                    this.assets = self.assets.filter(function (e) {
                        return e.identifier !== self.dependencies[x].identifier;
                    });
                }
                this.assetsSort(self.dependencies);
                this.assetsSort(self.assets);
            }

        },
        assetsSort: function (assets) {
            assets.sort(function(a, b) {
                var nameA = a.name.toUpperCase(); // ignore upper and lowercase
                var nameB = b.name.toUpperCase(); // ignore upper and lowercase
                if (nameA < nameB) {
                    return -1;
                }
                if (nameA > nameB) {
                    return 1;
                }

                // names must be equal
                return 0;
            });
        },
        remove: function (asset) {
            var index = this.dependencies.indexOf(asset);
            this.assets.push(asset);
            this.dependencies.splice(index, 1);
        },
        add:function (asset) {
            var index = this.assets.indexOf(asset);
            this.dependencies.push(asset);
            this.assets.splice(index, 1);
        }

    }
});

