<template>
    <div>
        <file-uploader @uploaded="attachToPosts"></file-uploader>

        <div class="flex flex-wrap -mx-6">

            <!-- @foreach ($posts as $post) -->
            <div v-for="post of posts" class="w-1/3 mb-12">
                <div class="px-6">
                    <div :style="style(post)" class="w-full h-64 rounded"></div>
                </div>
            </div>
            <!-- @endforeach -->
        </div>
    </div>
</template>

<script>
    import FileUploader from "../components/FileUploader";
    export default {
        name: "PostPage",
        components: {FileUploader},

        props: ['data'], // all records in posts table

        created() {
            this.posts = this.data;
        },

        data() {
            return {
                posts: []
            }
        },

        methods: {
            style(post) {
                // post == one record in posts table in db
                return `background-image: url(/storage/${post.path}); background-repeat: no-repeat; background-size: cover;`;
            },
            attachToPosts(post) {
                // post == response from controller , new record
                // console.log(post); // Object { path: "images/hLQtr1kFVdwHyjwU1xgJ6Xv3B5VX5IPu86rjqVmB.jpeg", updated_at: "2019-10-08 18:59:49", created_at: "2019-10-08 18:59:49", id: 3 }
                this.posts.push(post);
            }
        }
    }
</script>

<style scoped>

</style>
