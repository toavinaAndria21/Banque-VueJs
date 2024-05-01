<template>
    <div>   
        <nav class="navbar navbar-light bg-light">
            <form class="container-fluid justify-content-start">
                <button class="btn btn-outline-success me-2" type="button" @click="scrollToGraphicChart">CAMENBERT</button>
                <button class="btn btn-sm btn-outline-secondary" type="button" @click="scrollToList">LISTE</button>
            </form>
        </nav>
    </div>
      
</template>

<script>
    export default {
        name: "headBe",
        props:['scrollToGraphicChart', 'scrollToList']
    }
</script>

<style scoped>
div{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 999; 
}
nav{
    height: 80px;
    background-color: rgba(0, 0, 0)!important;
}
button{
    font-weight: bold;
}
</style>