<template>
    <div id="chartContainer">
        <div id="idgraphicContainer" class="graphicContainer">
            <canvas id="graphicChart"> </canvas>
        </div>
    </div>    
</template>
<script>
import Chart from "chart.js/auto";
import axios from "axios"

export default {
    name: "GraphicChart",
    data(){
        return{
            canvasTag: '',
            graphicData: {},
            options: {},
            chartGraphic:'',
            minMaxTotal: []
        }
    },
    mounted: async function(){
       await this.getMinMaxSolde()
        this.getStarted()
        this.showGraphicChart()
    },
    methods: {

        getMinMaxSolde: async function()
         {  
            await axios.get("http://localhost:8000/soldeMinMax.php")
            .then(response => {
                this.minMaxTotal = response.data
            });
        },
        showGraphicChart: function()
          {
             this.chartGraphic = new Chart(this.canvasTag, {
                    type: 'doughnut',
                    data: this.graphicData,
                    options: this.options
             });
          },
        getStarted: function()
          {
            this.canvasTag = document.getElementById('graphicChart').getContext('2d')

                this.graphicData = {
                    labels: ["Minimum", "Maximum", "Total"],
                    datasets: [{
                        label: "Solde des Clients",
                        // backgroundColor: "rgba(54, 162, 235, 0.2)",
                        // borderColor: "rgba(54, 162, 235, 1)",
                        borderWidth: 1,
                        data: [this.minMaxTotal[0], this.minMaxTotal[1], this.minMaxTotal[2]],
                    }]
                };
                this.options = {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                };
           }
    }
}
</script>

<style scoped>
.graphicContainer{
        width: 450px;
        height: 450px;
        margin: auto;
        background-color: rgba(233,229,205, 0.5 )
}
#chartContainer{
         width: 70%;
        height: 450px;
        margin: auto;
        margin-top: 60px;
        border-radius: 2%;
        background-color: rgba(128,185,186, 1);
        margin-bottom: 50px;
}
</style>