<template>
    <ais-instant-search
        :search-client="searchClient"
        index-name="users"
        class="w-full"
    >
        <!-- Other search components go here -->
        <ais-search-box>
            <div slot-scope="{ currentRefinement, isSearchStalled, refine }">
                <input
                    class="bg-gray-200 px-4 py-2 rounded text-gray-700 border focus:outline-none focus:border-indigo-500 w-full pl-12"
                    type="search"
                    placeholder="Are you looking for someone...?"
                    v-model="currentRefinement"
                    @keyup="showResults"
                    @input="refine($event.currentTarget.value)"
                >
                <!-- @keyup == when type words in input tag showResults method call -->
                <!--<span :hidden="!isSearchStalled">Loading...</span>-->
            </div>
        </ais-search-box>
        <ais-hits v-if="show" class="absolute bg-white rounded shadow-lg p-4 w-full">
            <!-- v-if="show" == show search suggestions or not , all users -->
            <template
                slot="item"
                slot-scope="{ item }"
            >
                <!-- :href="item.path" , item == user you want to search , path == path column in algolia site in users index -->
                <!-- item.path == /users/id , open user dashboard -->
                <!-- <a> tag open href="" address with GET method , go to controller with GET method -->
                <a :href="item.path" class="text-gray-500 block py-2 hover:bg-indigo-100 px-2 rounded mb-1">
                    <ais-highlight
                        :hit="item"
                        attribute="name"
                    />
                </a>
            </template>
        </ais-hits>
    </ais-instant-search>
</template>

<script>
    import algoliasearch from 'algoliasearch/lite';

    export default {
        name: "AlgoliaSearch",

        props: ['token', 'identification'],
        // attrs from custom tag , API Keys from algolia site
        // 'token' == Search-Only API Key
        // 'identification' == Application ID

        data() {
            return {
                searchClient: algoliasearch(
                    this.identification,
                    this.token
                    //process.env.MIX_ALGOLIA_APP_ID,
                    //process.env.MIX_ALGOLIA_SEARCH
                ),
                show: false // in default dont show search suggestions
            };
        },

        methods: {
            showResults(event) {
                // console.log(event); // keyup { target: input.styles, key: "i", charCode: 0, keyCode: 73 }
                // console.log(event.target); // <input class="styles" type="search" placeholder="Are you looking for someone...?">
                // console.log(event.target.value); // value attr in input tag , john , search for john
                if (event.target.value === '') {
                    // when erase input tag , when press backspace to erase input tag value
                    // when input tag is empty , value attr is empty
                    this.show = false; // dont show search suggestions
                    return; // dont run this.show = true;
                }
                this.show = true; // show search suggestions
            }
        }
    }
</script>

<style>
    /* mark class for highlight background color search */
    mark {
        background-color: transparent;
        color: #667eea;
    }
</style>
