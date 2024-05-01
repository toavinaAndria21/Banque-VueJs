<template>
        <tr>
            
            <td v-for="(element, index) in dataTuple" :key="index" > {{ element }}</td>
            <td>
                <button class="btn btn-outline-warning"  v-on:click="getIdClientToUpdate">Modifier</button>  
                <button class="btn btn-outline-danger" v-on:click="getIdClientToDelete"> Supprimer </button>
            </td>
      
        </tr>

</template>

<script>
export default { 
    name: "tableLine",
    props: ['dataTuple', 'modaleUsed', 'useModale', 'modaleUpdate', 'deleteProcess'],
    data(){
       return {
        clientId : '',
        valuesToUpdate: []
       }
    },
    methods:{
        getIdClientToDelete: function()
        {
            this.deleteProcess()
            this.clientId = this.dataTuple['numCompte']
            this.$emit('deleting', this.clientId)
        },
        getIdClientToUpdate: function()
        {
            this.modaleUpdate()
            this.valuesToUpdate.push(this.dataTuple['numCompte'])
            this.valuesToUpdate.push(this.dataTuple['nom'])
            this.valuesToUpdate.push(this.dataTuple['solde'])
            this.$emit('updating', this.valuesToUpdate)  
        }   
    }
    }
</script>

<style scoped>

td{ 
    height: 50px;
    text-align: center;
}
td:last-child{
    display: flex;
    justify-content: center;
    /*width: 250px;*/
}
button{
    margin-left: 25px;
    width: 100px;
} 
</style>