<template>
       <div>
            <div class="card">
                <div class="card-body">
                   <p>Solde Minimal: {{  minMax[0] }} Ariary</p>
                   <p>Solde Maximal: {{  minMax[1] }} Ariary</p>
                   <p>Solde Total: {{  minMax[2] }} Ariary</p>
                </div>
            </div>
       </div>
</template>

<script>
     export default {
        name: "tableFoot",
        props: ['minMax'],
        data(){
          return{
            minMaxSolde: this.minMax
          }
        }
     }
     
</script>

<style scoped>
.card{
    width: 70%;
    margin: auto;
    border: 2px solid rgba(0, 0, 0, 0.5);
}
.card-body{
    display: flex;
    justify-content: space-around;
}

</style>