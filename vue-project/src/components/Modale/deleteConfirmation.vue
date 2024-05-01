<template>
  <div class="bloc-modale">
            <div class="overlay" v-on:click="deleteProcess"> </div>
                <div class="modale card">
                    <div class="btnClose btn btn-danger" v-on:click="deleteProcess">X</div>
                        <div class="container">
                                <h6 class="confirmMessage">Etes-vous sûr de vouloir supprimer ?</h6>
                
                            <button type="button" class="validationBtn btn btn-outline-success" v-on:click="deletingConfirmed(idClient)">Oui</button>
                            <button type="button" class="validationBtn2 btn btn-outline-danger" v-on:click="deletingCancelled">Non</button>
                        </div>
                </div>
  </div> 
</template>

<script>
import axios from 'axios';

    export default {
        name: "deleteAlert",
        props: ['deleteProcess', 'useModale', 'areYouSureToDelete', 'idClient'],
        data(){
            return{
                client_Id:[]
            }
        },
        methods: {
           deletingConfirmed: function(idOfClient)
           {
            this.client_Id.push(idOfClient)    
            this.deleteProcess()     
               axios.post("http://localhost:8000/deleteClient.php", this.client_Id[0])
                     .then(response =>{
                        window.location.reload()    
                     })
                     .catch(error =>{
                        console.error(error)
                     });
               
           },
           deletingCancelled: function()
           {
               this.deleteProcess()
           }
        }
    }
</script>t

<style  src="./deleteConfirmation.css">
</style>