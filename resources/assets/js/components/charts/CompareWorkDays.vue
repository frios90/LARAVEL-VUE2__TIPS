

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
          data: [12000, 5900, 23000]
        },
        {
          label: 'Débito',  
          backgroundColor: ["#E8AC0C", "#E8AC0C", "#E8AC0C"],
          data: [10000, 7000, 24000,]
        },
        {
          label: 'Crédito',
          backgroundColor: ["#6E63FB", "#6E63FB", "#6E63FB"],
          data: [12000, 6000, 45866]
        }
      ]
    }, {responsive: true, maintainAspectRatio: false})
  }
}
</script>

<style>
</style>