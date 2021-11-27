

<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  props: ['options'],
  mounted () {

    var self = this;
    this.$http.get("/get-charts-progress-week").then(
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