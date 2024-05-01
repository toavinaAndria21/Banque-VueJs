<template>
      <div class="bloc-modale" v-if="modaleUsed">
            <div class="overlay" v-on:click="useModale"> </div>
                <div class="modale card">
                    <div class="btnClose btn btn-danger" v-on:click="useModale">X</div>
                        <div class="container">
                                <h2>{{ titre }}</h2>
                            <div class="input-box">
                              <!-- v-bind:id="test ? 'addClient' : 'updateCllient'" -->
                                    <input ref="numCompteInput" id="numCompteClient" required>
                                    <label>N° de compte</label>
                            </div>
                            <div class="input-box">
                                    <input id="nomClient" required>
                                    <label>Nom</label>
                            </div>
                            <div class="input-box">
                                    <input id="soldeClient"required>
                                    <label>Solde</label>
                            </div>
                            <button type="button" class="btn btn-outline-success" v-on:click="onSave">Enregistrer</button>
                        </div>
                </div>
            </div>     
</template>

<script>
import axios from 'axios';

    export default {
        name: "addModale",
        data(){
            return {
                titre : 'Ajouter',
                isAdding : false
        
            }
        },
        props: ['modaleUsed', 'useModale', 'addOrUpdate', 'arrayValuesToUpdate'],

        mounted()
        {
                if(this.addOrUpdate == 'add')
                   {  
                     this.isAdding = true;
                     this.titre = 'Ajouter'
                       document.getElementById('numCompteClient').value = ''
                       document.getElementById('nomClient').value = ''
                       document.getElementById('soldeClient').value = ''
                   }
                else if(this.addOrUpdate == 'update')
                   {
                     this.titre = 'Modifier'
                     this.$refs.numCompteInput.style.pointerEvents = "none"
                      document.getElementById('numCompteClient').value = this.arrayValuesToUpdate[0]
                      document.getElementById('nomClient').value = this.arrayValuesToUpdate[1]
                      document.getElementById('soldeClient').value = this.arrayValuesToUpdate[2]
                   }   
            },
         methods: {
          saveAdd: function()
            {  
                let clientData = {
                  numCompte: document.getElementById('numCompteClient').value,
                  nom: document.getElementById('nomClient').value,
                  solde: document.getElementById('soldeClient').value
                }
                axios.post("http://localhost:8000/addClient.php", clientData)
                     .then(response =>{
                        this.useModale()
                        window.location.reload()
                     })
                     .catch(error =>{
                        console.error(error)
                     });
            },
          saveUpdate: function()
            { 
              let clientData = {
                  numCompte: document.getElementById('numCompteClient').value,
                  nom: document.getElementById('nomClient').value,
                  solde: document.getElementById('soldeClient').value
                }
              axios.post("http://localhost:8000/updateClient.php", clientData)
                     .then(response =>{
                        this.useModale()
                        window.location.reload()
                     })
                     .catch(error =>{
                        console.error(error)
                     });
            },
          onSave: function()
            {
              if(this.isAdding) this.saveAdd()
              else this.saveUpdate() 
            }

         }   
        
    }
</script>

<style  src="./modale.css">

</style>
