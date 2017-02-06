<template>
    <div>
        <h3>Active Dependencies</h3>
        <div class="dependency-list">
            <div v-if="dependencies.length === 0">
                None
            </div>
            <div v-for="dependency in dependencies" >
                {{ dependency.name }}
                <input type="hidden" name="dependencies[]" v-bind:value="dependency.identifier">
                <div class="pull-right">
                    <button v-on:click="remove(dependency)" type="button" class="btn btn-default btn-sm btn-danger">Remove</button>
                </div>
            </div>
        </div>
        <h3>Inactive Dependencies</h3>
        <input type="text" class="form-control" placeholder="Search" v-model="assetSearch" debounce="500"  @keyup.enter="updateEntries()" >
        <div class="dependency-list pre-scrollable">
            <div v-for="asset in assets" >
                {{ asset.name }}
                <div class="pull-right">
                    <button v-on:click="add(asset)"  type="button" class="btn btn-default btn-sm">Add</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios'

    export  default {
        props: ['identifier', 'type'],
        created: function () {


            this.updateEntries();
            this.updateDependencyList();

        },
        data: function () {
            return {
                assets: [],
                dependencies: [],
                assetSearch: ""
            }

        },
        watch: {
            assetSearch: {
                handler: function (search) {
                    this.updateEntries();
                }
            }
        },
        methods: {
            updateEntries: function () {
                var self = this;
                axios.get("/api/assets/?type=" + this.type + "&name=" + this.assetSearch).then(function (response) {
                    if (response.data !== "") {
                        self.assets = response.data.data;
                        self.intersection();
                    }
                });

            },
            updateDependencyList: function () {
                var self = this;
                if (this.identifier !== "") {
                    axios.get("/api/assets/" + this.identifier + "/dependencies").then(function (response) {
                        if (response.data !== "") {
                            self.dependencies = response.data.data;
                            self.intersection();
                        }
                    });
                }
            },
            intersection: function () {
                var self = this;
                if (self.dependencies != "undefined") {
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
                assets.sort(function (a, b) {
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
            add: function (asset) {
                var index = this.assets.indexOf(asset);
                this.dependencies.push(asset);
                this.assets.splice(index, 1);
            }

        }
    }
</script>