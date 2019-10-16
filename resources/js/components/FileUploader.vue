<template>
    <!-- change <form> to <div> because we cant use @csrf in form -->
    <div class="mb-8">
        <input-file name="image" @uploaded="uploaded"></input-file>

        <div class="mb-3">
            <button @click="send" class="bg-blue-300 text-white px-12 py-2 rounded-full" type="submit">Upload</button>
        </div>

        <span class="feedback feedback--invalid" v-if="showError" v-text="errors.image"></span>
        <!-- v-if is condition , when v-if is false span tag not show and v-text not work -->
        <!-- v-text is text of span tag -->
    </div>
</template>

<script>
    import InputFile from "./InputFile";
    export default {
        name: "FileUploader",
        components: {InputFile},

        data() {
            return {
                image: '',
                errors: {}, // empty object , errors { image: "The image field is required." }
                showError: false
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
                    // if data not valid in controller , session set for error
                    // error name: image , array key , name attr

                    // Network Response: {"message":"The given data was invalid.","errors":{"image":["The image field is required."]}}

                    // console.log(error);
                    // Error: "Request failed with status code 422"

                    // console.log(error.response);
                    // { config {}, data {}, headers {}, request {}, status: 422, statusText: "Unprocessable Entity" }

                    // console.log(error.response.data);
                    // { message: "The given data was invalid.", errors: {...} }
                    // errors { image: Array [ "The image field is required." ] }

                    // console.log(error.response.data.errors);
                    // { image: Array [ "The image field is required." ] }

                    // console.log(error.response.data.errors['image'][0]);
                    // The image field is required.

                    this.showError = true;

                    this.errors.image = error.response.data.errors['image'][0];
                    // in errors object make image property , errors { image: }
                    // 'image' is error name that set in controller when data not valid
                    // this.errors.image = "The image field is required."
                    // errors { image: "The image field is required." }
                });
            }
        }
    }
</script>

<style scoped>

</style>
