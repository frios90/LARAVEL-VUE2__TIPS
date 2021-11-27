
<script>
import { Doughnut } from 'vue-chartjs'

export default {
  extends: Doughnut,  
  mounted () {     
    var self = this;
      this.$http.get("/get-info-charts-percentage").then(
        function(response) {
            this.renderChart(response.body.data, response.body.options)

        },
        function() {
          alert("Error!");
        }
      )
  },
  methods: {
    
  }
}
</script>

<style>
</style>