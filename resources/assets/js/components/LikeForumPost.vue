<template>
    <span >
       <span>
          <i class="fa" v-bind:class="{ 'fa-heart': likeState, 'fa-heart-o': !likeState }" v-on:click="toggleLike"></i>
        </span>
        {{ likeCount }}

        <span v-if="likeCount > 0">
            <span v-if="likeCount == 1">
                Person liked this
            </span>
            <span v-if="likeCount != 1">
                People liked this
            </span>
        </span>
        |

    </span>
</template>
<script>
    import LikeButton from './LikeButton'
    export default {extends: LikeButton}
</script>