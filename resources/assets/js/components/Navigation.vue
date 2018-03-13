<template>
        <ul class="" style="font-size: 1.2em">
            <li class="title"><i class="fa fa-compass fa-2x"> </i> Navigation</li>
            <li>test 1-1</li>
            <li>
                test 1-2
                <ul>
                    <li>test 2-1</li>
                    <li>test 2-2</li>
                    <li>test 2-3</li>
                </ul>
            </li>
            <li>
                test 1-3
                <ul>
                    <li>test 2-4</li>
                    <li>test 2-5</li>
                    <li>test 2-6</li>
                </ul>
            </li>

        </ul>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
