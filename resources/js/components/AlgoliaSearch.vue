<template>
    <ais-instant-search
        :search-client="searchClient"
        index-name="users"
    >
        <!-- Other search components go here -->
        <ais-search-box placeholder="Search contacts..."></ais-search-box>
        <ais-hits>
            <template
                slot="item"
                slot-scope="{ item }"
            >
                <h1>
                    <ais-highlight
                        :hit="item"
                        attribute="name"
                    />
                </h1>
                <!-- no need this
                <h4>
                    <ais-highlight
                        :hit="item"
                        attribute="company"
                    /> -
                    <ais-highlight
                        :hit="item"
                        attribute="state"
                    />
                </h4>
                <ul>
                    <li>{{ item.email }}</li>
                </ul>
                -->
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
            };
        }
    }
</script>

<style scoped>

</style>
