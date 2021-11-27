

<script>
import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
  props: ['options'],
  mounted () {
     this.renderChart({

      labels: ['Mañana', 'Tarde', 'Noche'],
      
      datasets: [
        {
          label: 'Efectivo',
          backgroundColor: ["#53C491", "#53C491", "#53C491"],
          data: [15000, 12555, 12512,]
        },
        {
          label: 'Débito',
          backgroundColor: ["#E8AC0C", "#E8AC0C", "#E8AC0C"],
          data: [12000, 16999, 12541,]
        },
        {
          label: 'Crédito',
          backgroundColor: ["#6E63FB", "#6E63FB", "#6E63FB"],
          data: [25000, 45860, 45866]
        }
      ]
    }, {responsive: true, maintainAspectRatio: false})
  }
}
</script>
<style>
</style>