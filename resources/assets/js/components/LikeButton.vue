<template>

    <div v-if="canLike" class="row like">

        <div class="col-xs-6 text-center" title="Views">
            <i v-if="canLike" class="fa icon-xl fa fa-heart" v-bind:class="{ 'fa-heart': likeState, 'fa-heart-o': !likeState }" v-on:click="toggleLike()" ></i>
            <i v-else class="fa icon-xl fa fa-heart fa-heart-o"></i>
        </div>
        <div class="col-xs-6 text-center" title="Downloads">
            <div v-if="!hideCount">

                <b>
                    {{ likeCount }}
                </b>

                <p v-if="likeCount == 1">
                    Person liked this
                </p>
                <p v-else>
                    People liked this
                </p>
            </div>

        </div>
    </div>
    <div  class="text-muted" v-else>
        This {{ type }} is participating in a build-off, voting starts
    </div>

</template>

<script>
    import axios from 'axios'

    export default{
        props: ['type','id','liked','canLike','hideCount',"numLikes"],
        data: function() {
            return {
                likeState: (this.liked == 'true' || this.liked=== true)
            };
        },

        computed: {
            likeCount() {
                return (Number(this.numLikes) + ((this.liked == 'true' || this.liked === true) ? 1 : 0));
            }
        },

        methods: {
            toggleLike: function()
            {
                if(this.canLike) {
                    if (this.likeState) {
                        this.unlike()
                    } else {
                        this.like()
                    }
                }
            },
            like: function() {
                this.likeState = true;

                if(this.numLikes != null) {
                    this.numLikes++;
                }

                axios.post('/api/likes/like/' + this.type + '/' + this.id);
            },
            unlike: function() {
                this.likeState = false;
                if(this.numLikes != null) {
                    this.numLikes--;
                }
                axios.delete('/api/likes/unlike/' + this.type + '/' + this.id);
            }
        }
    }
</script>