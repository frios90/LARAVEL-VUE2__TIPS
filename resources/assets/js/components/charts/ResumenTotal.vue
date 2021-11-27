

<script>
import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
  props: ['options'],
  mounted () {

     var self = this;
      this.$http.get("/get-charts-total-tips").then(
        function(response) {
            this.renderChart(response.body.data, response.body.options)
        },
        function() {
          alert("Error!");
        }
      )  
  }
}
</script>

<style>
</style>