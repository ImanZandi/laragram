<template>
    <!-- change <form> to <div> because we cant use @csrf in form -->
    <div class="mb-8">
        <input-file name="image" @uploaded="uploaded"></input-file>
        <button @click="send" class="bg-blue-300 text-white px-12 py-2 rounded-full" type="submit">Upload</button>
    </div>
</template>

<script>
    import InputFile from "./InputFile";
    export default {
        name: "FileUploader",
        components: {InputFile},

        data() {
            return {
                image: ''
            }
        },

        methods: {
            // @uploaded attr
            uploaded(file) {
                // console.log(file); // File { name: "2.jpg", lastModified: 1569959238449, webkitRelativePath: "", size: 22276, type: "image/jpeg" }
                this.image = file; // add file to image property
            },

            send() {
                // when click on button send() method will call
                let data = new FormData();
                data.append('image', this.image); // 'image' == like name attr , use in controller for check validation and etc
                axios.post('/posts', data).then(response => {
                    // after upload get response from controller , $post
                    // console.log(response.data); // Object { path: "images/CcQILzWJThbKQYYuzuKhZ7bFAKeTxSksAsvMHePE.jpeg", updated_at: "2019-10-06 16:08:20", created_at: "2019-10-06 16:08:20", id: 5 }
                    this.$emit('uploaded', response.data); // run event
                    // send response to PostPage.vue for add/push new image to view , show new image
                }).catch(error => {
                    console.log(error.response.data.errors);
                });
            }
        }
    }
</script>

<style scoped>

</style>
