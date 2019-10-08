<template>

    <label :for="name" class="border-dashed border-2 border-gray-400 px-12 py-12 rounded h-64 flex items-center text-center justify-center text-5xl text-gray-400 mb-4">
        +
        <input class="hidden" type="file" :name="name" :id="name" @change="change">
    </label>

</template>

<script>
    export default {
        name: "InputFile",
        props: ['name'], // input attr from custom tag

        data() {
            return {
                // property
                image: ''
            }
        },
        methods: {
            // @change attr
            change(e) {
                // e == event == file == image added to input tag
                // console.log('test');
                // console.log(e.target.value); // C:\fakepath\1.jpg
                // console.log(e.target); // <input id="image" class="hidden" data-v-2071d38b="" type="file" name="image" value="image">
                // console.log(e.target.files); // 0: File { name: "4.jpg", lastModified: 1569959285838, size: 167171 }
                // console.log(e.target.files[0]); // File { name: "3.jpg", lastModified: 1569959259243, webkitRelativePath: "", size: 180926, type: "image/jpeg" }
                // this.image = e.target.files[0]; // file/image store in image property

                this.$emit('uploaded', e.target.files[0]); // run event for export file/image to parent component
                // event name: 'uploaded'
                // parent component: FileUploader.vue

            }
        }
    }
</script>

<style scoped>

</style>
