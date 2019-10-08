<template>
    <div>
        <file-uploader @uploaded="attachToPosts"></file-uploader>

        <div class="flex flex-wrap -mx-6">
            <div v-for="post of posts" class="w-1/3 mb-12">
                <!-- use posts property , all records in it -->
                <!-- v-for == like foreach -->
                <div class="px-6">
                    <div :style="style(post)" class="w-full h-64 rounded"></div>
                    <!-- run style() method and send each record to it -->
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import FileUploader from "../components/FileUploader";
    export default {
        name: "PostPage",
        components: {FileUploader},

        props: ['data'], // all records in posts table , $posts

        created() {
            // created() func run automatic
            this.posts = this.data; // add all records to posts property
        },

        data() {
            return {
                posts: [] // posts property , all records
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
                this.posts.push(post); // add new record to posts property
            }
        }
    }
</script>

<style scoped>

</style>
