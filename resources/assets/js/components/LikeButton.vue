<template>
    <div v-if="canLike" class="row like">

        <div class="col-xs-6 text-center" title="Views">
            <i v-if="canLike" class="fa icon-xl fa fa-heart" v-bind:class="{ 'fa-heart': likeState, 'fa-heart-o': !likeState }" v-on:click="toggleLike()" ></i>
            <i v-else class="fa icon-xl fa fa-heart fa-heart-o"></i>
        </div>
        <div class="col-xs-6 text-center" title="Downloads">
            <div v-if="isBuildoff">
                <p>
                    <span v-if="liked"> You like this </span>
                    <span v-else> You didn't like this yet </span>
                </p>

                <b>
                    {{ likeCount }}
                </b>
            </div>
            <div v-else>

                <p v-if="likeCount == 1">
                    Person like this
                </p>
                <p v-else>
                    People like this
                </p>

                <b>
                    {{ likeCount }}
                </b>
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
        props: ['type','id','liked','canLike','isBuildoff',"numLikes"],
        data: function() {
          return {
              likeCount: this.numLikes,
              likeState: (this.liked == 'true' || this.liked=== true)
          };
        },
        methods: {
            toggleLike: function()
            {
                if(this.likeState) {
                    this.unlike()
                } else {
                    this.like()
                }
            },
            like: function() {
                this.likeState = true;

                if(this.likeCount != null) {
                    this.likeCount++;
                }

                axios.post('/api/likes/like/' + this.type + '/' + this.id);
            },
            unlike: function() {
                this.likeState = false;
                if(this.likeCount != null) {
                    this.likeCount--;
                }
                axios.delete('/api/likes/unlike/' + this.type + '/' + this.id);

            }
        }
    }
</script>