<!--
  - Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
  - You may use, distribute and modify this code under the
  - terms of the MIT license.
  -->
<template>
    <p>{{ greeting }} World!</p>
</template>

<script>
    module.exports = {
        data: function () {
            return {
                greeting: 'This is Hello'
            }
        }
    }
</script>

<style scoped>
    p {
        font-size: 2em;
        text-align: center;
    }
</style>