<!--
  - Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
  - You may use, distribute and modify this code under the
  - terms of the MIT license.
  -->
<template>
    <div>
        <p>Welcome {{username}}</p>
        <div>form will be here soon</div>
        <div><a href="/">back to home</a></div>
    </div>
</template>

<script>
    module.exports = {
        data: function () {
            return {
                username: 'John Doe'
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