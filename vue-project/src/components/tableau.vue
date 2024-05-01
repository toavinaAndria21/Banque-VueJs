

<template>
    <div>
        <headBe v-bind:scrollToGraphicChart="scrollToGraphicChart"
                v-bind:scrollToList="scrollToList"
        ></headBe>
        <div id="idListContainer" class="madiv" :style="{ marginTop: navHeight + 'px'}">

        <button type="button" class="btn btn-outline-primary" v-on:click="modaleAdd">Ajouter</button>
        <div class="divSearch input-group">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input v-model="searchKey" v-on:keyup="searchFunctions" type="text" class="form-control" placeholder="N° De Compte ou Nom" aria-label="Username" aria-describedby="basic-addon1">
        </div>
            <table class="table table-striped table-hover"> 
                <thead>
                        <tr>
                        <th scope="col">N° De Compte</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Solde</th>
                        <th scope="col">Obsérvation</th>
                        <th scope="col">Actions</th>
                        </tr>
                </thead>        
                <tbody>
                        <tableLine 
                            v-for="(tuple, index) in data_list" :key = "index" :dataTuple = "tuple"
                            v-bind:modaleUsed="modaleUsed" v-bind:useModale="useModale"
                            v-bind:modaleUpdate="modaleUpdate"
                            v-bind:deleteProcess="deleteProcess"
                            v-on:deleting="getSenderId($event)"
                            v-on:updating="getValuesToUpdate($event)"
                        ></tableLine>
                </tbody> 
                </table>
        </div>

            <tableFoot v-bind:minMax="minMax"></tableFoot>

            <addModale v-if="modaleUsed" 
                    v-bind:modaleUsed="modaleUsed" 
                    v-bind:useModale="useModale" 
                    v-bind:addOrUpdate="addOrUpdate"
                    v-bind:arrayValuesToUpdate="arrayValuesToUpdate"
                  
            ></addModale>

            <deleteAlert v-if="areYouSureToDelete"  
                        v-bind:deleteProcess="deleteProcess"
                        v-bind:areYouSureToDelete="areYouSureToDelete"
                        v-bind:useModale="useModale" 
                        v-bind:idClient="idClient"
            ></deleteAlert>
            
            <GraphicChart></GraphicChart>    
    </div>
  
</template>

<script>
import axios from "../../node_modules/axios"
import tableLine from "./tableRow.vue"
import headBe from "./header.vue"
import tableFoot from "./tableFoot.vue"
import addModale from "./Modale/modale.vue"
import deleteAlert from "./Modale/deleteConfirmation.vue"
import GraphicChart from "./graphicChart.vue"

export default {
    name: "MonTableau",
    components:{ 
        tableLine : tableLine,
        headBe : headBe,
        tableFoot: tableFoot,
        addModale : addModale,
        deleteAlert : deleteAlert,
        GraphicChart : GraphicChart
    },
    data() {
        return {
            data_list: [],
            minMax: [],
            modaleUsed: false,
            addOrUpdate: 'add',
            areYouSureToDelete : false,
            idClient : '',
            arrayValuesToUpdate : [],
            searchKey : ''
 
        }
    },

    mounted(){
        this.printClientOnTable()
        this.getMinMaxSolde()
    },

    methods:{
        useModale: function()
         {
            this.modaleUsed = !this.modaleUsed
         },
        deleteProcess: function()
         {
            this.areYouSureToDelete = !this.areYouSureToDelete
         },
        modaleAdd: function()
         {
             this.addOrUpdate = 'add',
             this.modaleUsed = !this.modaleUsed
            
         },
         modaleUpdate: function()
         {
            this.addOrUpdate = 'update',
            this.modaleUsed = !this.modaleUsed
         },
        printClientOnTable: function()
         {  
            axios.get("http://localhost:8000/getClient.php")
            .then(response => {
                this.data_list = response.data
               
            })
         },
        getMinMaxSolde: async function()
         {  
            await axios.get("http://localhost:8000/soldeMinMax.php")
            .then(response => {
                this.minMax = response.data
            });
         
         },
         searchFunctions: function()
         {
            fetch("http://localhost:8000/searchClient.php?search="+ this.searchKey)
            .then(response => response.json())
            .then(data => {
                  this.data_list = data
            })
         },
         getSenderId: function(clientId)
         {
            this.idClient = clientId
         },
         getValuesToUpdate: function(valuesToUpdate)
         {
            this.arrayValuesToUpdate = valuesToUpdate
         }, 
        // Méthode pour faire défiler jusqu'à l'élément ayant l'ID "idGraphicChart"
        scrollToGraphicChart: function() {           
            // Faire défiler la page vers l'élément
            window.scrollTo({
               top: 500,
               behavior: 'smooth'
              });
        },
        scrollToList: function() {
        // Faire défiler la page vers le haut
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
              });
        }
    }
}
</script>

<style scoped>
*{
    margin: 0;
    padding: 0;
}
.divSearch{
    width: 30%;
    float: right;
    margin-top: 30px;
    margin-right: 20px;
}
span{
    background-color: rgb(30, 119, 197);
    color: #f1f1f1; 
    font-weight: bold;
}
.table{
    margin-top: 10px;
    width: 100%;
    text-align: center; 
    
    border: 4px solid rgb(30, 119, 197);
}
.btn{
    margin-top: 30px;
    margin-left: 10px;
    width: 130px;
    height: 40px;   

}
.madiv{
    width: 70%;
    height: 400px;
    margin: auto;
    margin-top: 8% !important; 
    border: 4px solid rgb(96, 197, 30);
    overflow: auto;
    z-index: 1;
}
tbody{
    overflow: auto;
    
}

</style>
