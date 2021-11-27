

<template >
  <div class="mantainer-home">
    <div v-if="loader" class="loader"></div>
    <div>
      <div>
        <div class="grid-home">
          <div class="grid-home-div1">
            <div class="card-percentage">
              <div class="card-percentage-head"><i class="fas fa-circle circle-generic"></i> Bienvenido</div>
              <hr class='card-divisor'>
              <div class="card-percentage-body-row1">
                <div class="grid-welcome">
                
                  <div class="grid-welcome-div2"><span class="color-orange-generic">Usuario</span>:  </div>
                  <div v-if="infoReports.auth.user" class="grid-welcome-div3">{{ infoReports.auth.user.name }}</div>
                  <div class="grid-welcome-div4"><span class="color-orange-generic">Bar</span>: </div>
                  <div v-if="infoReports.auth.company" class="grid-welcome-div5">{{ infoReports.auth.company.name }}</div> 
                  <div class="grid-welcome-div6"><span class="color-orange-generic">Correo</span>: </div>
                  <div v-if="infoReports.auth.company" class="grid-welcome-div7">{{ infoReports.auth.user.email }}</div>                  
                  <div class="grid-welcome-div9">
                    <router-link to="/me">
                      <a class="pointer" href="#">
                          Ver mi perfil
                      </a>                               
                    </router-link>
                  </div>
                  
                </div>
              </div>
              <hr class='card-divisor'>
              <div class="card-percentage-footer"> 
                <a class="pointer" href="#list-manages">
                  *Listado de gestiones  
                </a>
                <span class="float-right">
                </span>               
              </div>
            </div>
          </div>
          <div class="grid-home-div2">            
            <div class="card-percentage">
              <div class="card-percentage-head"><i class="fas fa-circle circle-generic"></i> Resumen mensual</div>
              <hr class='card-divisor'>
              <div class="card-percentage-body-row1">
                <div class="grid-historic">
                  <div class="grid-historic-div1">
                      <ResumenTotal :width="50" :height="100" ></ResumenTotal>

                  </div>
                  <div class="grid-historic-div2">Mañana: <i class="fas fa-sun"></i>: </div>
                  <div v-if="infoReports.totals.morning" class="grid-historic-div3">{{ infoReports.totals.morning.total | currency }}</div>
                  <div class="grid-historic-div4">Tarde: <i class="fas fa-adjust"></i>: </div>
                  <div v-if="infoReports.totals.noon" class="grid-historic-div5">{{ infoReports.totals.noon.total | currency  }}</div>
                  <div class="grid-historic-div6">Noche: <i class="fas fa-moon"></i>:</div>
                  <div v-if="infoReports.totals.night" class="grid-historic-div7">{{ infoReports.totals.night.total | currency  }}</div>
                  <div class="grid-historic-div8">Total: <i class="fas fa-circle"></i>:</div>
                  <div v-if="infoReports.totals.total" class="grid-historic-div9">{{ infoReports.totals.total | currency  }}</div>
                </div>
              </div>
              <hr class='card-divisor'>
              <div class="card-percentage-footer"> 
                <a class="pointer" href="#list-manages">
                  *Listado de gestiones  
                </a>
                <span class="float-right">
                </span>               
              </div>
            </div>
          </div>
          <div class="grid-home-div3">
            <div class="card-percentage">
              <div class="card-percentage-head"><i class="fas fa-circle circle-generic"></i> {{ infoReports.license }}</div>
              <hr class='card-divisor'>
              <div class="card-percentage-body-row1">
                <div class="grid-license">
                  <div class="grid-license-div1">
                      <License
                        :width="50"
                        :height="100"                   
                      ></License>
                  </div>
                  <div class="grid-license-div2">Usuarios <i class="fas fa-circle circle-red-sm"></i>: </div>
                  <div class="grid-license-div3">{{ infoReports.user.total }} / {{ infoReports.user.license }}</div>
                  <div class="grid-license-div4">Staffs <i class="fas fa-circle  circle-blue-sm"></i>: </div>
                  <div class="grid-license-div5">{{ infoReports.staff.total }} / {{ infoReports.staff.license }}</div>
                  <div class="grid-license-div6">Tips <i class="fas fa-circle  circle-yellow-sm"></i>:</div>
                  <div class="grid-license-div7">{{ infoReports.work.total }} / {{ infoReports.work.license }}</div>
                </div>
              </div>
              <hr class='card-divisor'>
              <div class="card-percentage-footer"> 
                <a class="pointer" href="#list-manages">
                  *Listado de gestiones  
                </a>
                <span class="float-right">
                </span>               
              </div>
            </div>
          </div>

          <div class="grid-home-div4">
            <div class="card-percentage">
              <div class="card-percentage-head"><i class="fas fa-circle circle-generic"></i>Resumen de propinas global</div>
              <hr class='card-divisor'>
              <div class="card-percentage-body">
                <div class="card-percentage-body">
                  <GlobalChart :width="50" :height="180" ></GlobalChart>
                </div>
              </div>
            </div>
          </div>

          <div class="grid-home-div5">
            <div class="card-percentage">
              <div class="card-percentage-head">Resumen porcentajes</div>
              <hr class='card-divisor'>
              <div class="card-percentage-body-chart">
                  <ChartPercentages
                    :width="charts.percentage.size.width"
                    :height="charts.percentage.size.height"                   
                  ></ChartPercentages>
              </div>
            </div>
          </div>

          <div class="grid-home-div6">
            <div class="card-percentage">
              <div class="card-percentage-head"><i class="fas fa-circle circle-garzon"></i> Garzones</div>
              <hr class='card-divisor'>
              <div class="card-percentage-body">
                <input
                  class="input-percentage"
                  type="text"
                  v-model="percentages.garzon"
                  maxlength="2"
                  max="100"
                />
              </div>
              <hr class='card-divisor'>

              <div class="card-percentage-footer"> 
                <span>
                  Guardar  
                </span>
                <span class="float-right">
                  <i class="far fa-save btn-save-percentage" title="Guardar configuración" @click="calculateTotal()"></i>
                </span>               
              </div>
            </div>
          </div>

          <div class="grid-home-div7">
            <div class="card-percentage">
              <div class="card-percentage-head"> <i class="fas fa-circle circle-garzon"></i> Runners</div>
              <hr class='card-divisor'> 
              <div class="card-percentage-body">
                <input
                  class="input-percentage"
                  type="text"
                  v-model="percentages.runner"
                  maxlength="2"
                  max="100"
                />
              </div>
              <hr class='card-divisor'>

              <div class="card-percentage-footer"> 
                <span>
                  Guardar  
                </span>
                <span class="float-right">
                  <i class="far fa-save btn-save-percentage" title="Guardar configuración" @click="calculateTotal()"></i>
                </span>               
              </div>
            </div>
          </div>

          <div class="grid-home-div8">
            <div class="card-percentage">
              <div class="card-percentage-head"><i class="fas fa-circle circle-garzon"></i> Barra</div>
              <hr class='card-divisor'>
              <div class="card-percentage-body">
                <input
                  class="input-percentage"
                  type="text"
                  v-model="percentages.bartender"
                  maxlength="2"
                  max="100"
                />
              </div>
              <hr class='card-divisor'>

              <div class="card-percentage-footer"> 
                <span>
                  Guardar  
                </span>
                <span class="float-right">
                  <i class="far fa-save btn-save-percentage" title="Guardar configuración" @click="calculateTotal()"></i>
                </span>               
              </div>
            </div>
          </div>

          <div class="grid-home-div9">
            <div class="card-percentage">
              <div class="card-percentage-head"><i class="fas fa-circle circle-garzon"></i> Cocina</div>
              <hr class='card-divisor'>
              <div class="card-percentage-body">
                <input
                  class="input-percentage"
                  type="text"
                  v-model="percentages.cheff"
                  maxlength="2"
                  max="100"
                />
              </div>
              <hr class='card-divisor'>
              <div class="card-percentage-footer"> 
                <span>
                  Guardar  
                </span>
                <span class="float-right">
                  <i class="far fa-save btn-save-percentage" title="Guardar configuración" @click="calculateTotal()"></i>
                </span>               
              </div>
            </div>
          </div>

          <div class="grid-home-div10">
            <div class="card-percentage">
              <div class="card-percentage-head"><i class="fas fa-circle circle-garzon"></i> Copería</div>
              <hr class='card-divisor'>

              <div class="card-percentage-body">
                <input
                  class="input-percentage"
                  type="text"
                  v-model="percentages.copper"
                  maxlength="2"
                  max="100"
                />
              </div>
              <hr class='card-divisor'>

              <div class="card-percentage-footer"> 
                <span>
                  Guardar  
                </span>
                <span class="float-right">
                  <i class="far fa-save btn-save-percentage" title="Guardar configuración" @click="calculateTotal()"></i>
                </span>               
              </div>
            </div>
          </div>

          <div class="grid-home-div11" id="list-manages">
            <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
              <h2 class="tm-block-title mantainer-title">Propinas</h2>
              <hr class="mantainer-divisor" />
              <v-client-table
                class="index-table"
                :data="tableData"
                :columns="columns"
                :options="options"
              >
                <span slot="actions" slot-scope="props">
                  <router-link v-if="!props.row.deleted_at" :to="'/tip/see/'+props.row.id">
                    <i class="actions fas fa-eye"></i>
                  </router-link>
                </span>
              </v-client-table>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>


<script>
import Notifications        from "../mixins/Notifications.js"
import Utilities            from '../mixins/Utilities.js'
import Swal                 from "sweetalert2"
import ChartPercentages     from "../charts/Percentages.vue"
import ResumenTotal         from "../charts/ResumenTotal.vue"
import MonthTips            from "../charts/MonthTips.vue"
import CompareWorkDays      from "../charts/CompareWorkDays.vue"
import GlobalChart          from "../charts/GlobalChart.vue"
import License              from "../charts/License.vue"


export default {
  name: "home-general",
  components: { ChartPercentages,
                ResumenTotal,
                MonthTips,
                CompareWorkDays,
                License,
                GlobalChart },
  mixins: [Notifications, Utilities],
  data() {
    return {
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      infoReports: {
        license: '',
        staff: {},
        work : {},
        totals: {},
        user: {},
        auth: {}
      },
      percentages: {
        garzon: 0,
        runner: 0,
        bartender: 0,
        cheff: 0,
        copper: 0
      },
      columns: [
        "created_at",
        "description",
        "working.label",
        "amount_cash",
        "amount_debit",
        "amount_credit",
        "total_amount",
        "actions"
      ],
      tableData: [],
      options: {
        headings: {
          created_at: "Ingreso",
          description: "Descripción",
          "working.label": "Jornada",
          amount_cash: "Efectivo",
          amount_debit: "Débito",
          amount_credit: "Credito",
          total_amount: "Total",
          actions: "Acciones"
        },
        sortable: ["description"],
        texts: {
          count:
            "Mostarndo del {from} al {to} de un total de {count} registros|{count} Registros|un registro",
          first: "Primera",
          last: "Última",
          filter: "",
          filterPlaceholder: "",
          limit: "",
          page: "Página:",
          noResults: "No se encontraron resultados",
          filterBy: "Filtrar tabla",
          loading: "Cargando información",
          defaultOption: "Seleccionar {column}",
          columns: "Columnas"
        }
      },

      charts: {
        percentage: {
          data: {
            labels: [],
            datasets: [
              {
                backgroundColor: [],
                data: [],
                borderWidth: 0
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
              display: false
            }
          },
          size: { width: 97, height: 97 }
        }
      }
    };
  },
  created() {
    this.getStaffPercentages()
    this.getDataTable()
    this.getInfoReports()
  },
  mounted() {
    var self = this
    setTimeout(function(){ 
      self.loader = false
     }, 1500)    
  },
  methods: {
    getDataTable() {
      var self = this;
      this.$http.get("/tip-table-list").then(
        function(response) {
          self.tableData = response.body
        },
        function() {
          alert("Error!")
        }
      )
    },   
    calculateTotal() {
      var total =
        parseInt(this.percentages.garzon) +
        parseInt(this.percentages.runner) +
        parseInt(this.percentages.bartender) +
        parseInt(this.percentages.cheff) +
        parseInt(this.percentages.copper);

      if (total == 100) {
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
          },
          buttonsStyling: false
        });
        swalWithBootstrapButtons
          .fire({
            title: "¿Esta seguro de cambiar los procentajes?",
            text:
              "El resultado de las propinas desde ahora se basara en su nueva configuración",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, seguro!",
            cancelButtonText: "No, cancelar!",
            reverseButtons: true
          })
          .then(result => {
            if (result.value) {
              var data = {
                _token: this.csrf,
                garzon: this.percentages.garzon,
                runner: this.percentages.runner,
                bartender: this.percentages.bartender,
                cheff: this.percentages.cheff,
                copper: this.percentages.copper
              }
              this.$http.post("/percentage-update", data).then(response => {
                this.ttSuccess(
                  "Se ha ingresado la nueva configuración con éxito"
                )
              })
            }
          })
      } else {
        this.ttDanger(
          "No se há podido guardar la nueva configuración debido a que la suma de los porcentajes ingresados supera el 100%"
        )
      }
    },
    getStaffPercentages() {
      this.commune_id = ""
      var self = this
      this.$http.get("/staff-percentages").then(
        function(response) {
          response.body.forEach(function(row) {
            switch (row.name) {
              case "GARZON":
                  self.percentages.garzon = row.percentage;
                break;
              case "RUNNER":
                 self.percentages.runner = row.percentage;
                break;
              case "COCINA":
                  self.percentages.cheff = row.percentage;
                break;
              case "BARRA":
                  self.percentages.bartender = row.percentage;
                break;
              case "COPERIA":
                  self.percentages.copper = row.percentage;
                break;
            }
          })
        },
        function() {
          this.$toasted.global.APP_GENERAR_ERROR();
        }
      )
    },
    getInfoReports() {
      this.commune_id = "";
      var self = this;
      this.$http.get("/get-info-total-reports").then(
        function(response) {          
          this.infoReports.staff   = response.body.staff
          this.infoReports.license = response.body.license
          this.infoReports.work    = response.body.work
          this.infoReports.totals  = response.body.totals
          this.infoReports.user    = response.body.user
          this.infoReports.auth    = response.body.auth
        },
        function() {
          this.$toasted.global.APP_GENERAR_ERROR()
        }
      )
    },
  },
  filters: {
    upper: function(value) {
      return value.toUpperCase();
    }
  },
  computed: {
    rows() {
      return this.items.length;
    }
  }
};
</script>



<style>
  .color-orange-generic{
          color: #f5a623;

  }
  .welcome-ico-user {
    font-size:100px;
      color: #f5a623;

  }
  .grid-welcome { 
    display: grid; 
    grid-template-columns: 0fr 0fr 1fr 2fr; 
    grid-template-rows: repeat(4, 1fr); 
    grid-column-gap: 0px;
    grid-row-gap: 0px; 
    color: white;
    font-size: 12px;
  }

  .grid-welcome-div1 { grid-area: 1 / 1 / 5 / 3; } 
  .grid-welcome-div2 { grid-area: 1 / 3 / 2 / 4; } 
  .grid-welcome-div3 { grid-area: 1 / 4 / 2 / 5; } 
  .grid-welcome-div4 { grid-area: 2 / 3 / 3 / 4; } 
  .grid-welcome-div5 { grid-area: 2 / 4 / 3 / 5; } 
  .grid-welcome-div6 { grid-area: 3 / 3 / 4 / 4; } 
  .grid-welcome-div7 { grid-area: 3 / 4 / 4 / 5; } 
  .grid-welcome-div8 { grid-area: 4 / 3 / 5 / 4; } 
  .grid-welcome-div9 { grid-area: 4 / 4 / 5 / 5; } 


  .grid-historic { 
    display: grid; 
    grid-template-columns: 1fr; 
    grid-template-rows: repeat(4, 1fr); 
    grid-column-gap: 0px;
    grid-row-gap: 0px;  
    color: white;
    font-size: 12px;
  }

  .grid-historic-div1 { grid-area: 1 / 1 / 5 / 3; } 
  .grid-historic-div2 { grid-area: 1 / 3 / 2 / 4; } 
  .grid-historic-div3 { grid-area: 1 / 4 / 2 / 5; } 
  .grid-historic-div4 { grid-area: 2 / 3 / 3 / 4; } 
  .grid-historic-div5 { grid-area: 2 / 4 / 3 / 5; } 
  .grid-historic-div6 { grid-area: 3 / 3 / 4 / 4; } 
  .grid-historic-div7 { grid-area: 3 / 4 / 4 / 5; } 
  .grid-historic-div8 { grid-area: 4 / 3 / 5 / 4; } 
  .grid-historic-div9 { grid-area: 4 / 4 / 5 / 5; } 

  .grid-license { 
    display: grid; 
    grid-template-columns: repeat(4, 1fr); 
    grid-template-rows: repeat(3, 1fr); 
    grid-column-gap: 0px;
    grid-row-gap: 0px; 
    color: white;
    font-size: 12px;
  }

  .grid-license-div1 { grid-area: 1 / 1 / 4 / 3; } 
  .grid-license-div2 { grid-area: 1 / 3 / 2 / 4; } 
  .grid-license-div3 { grid-area: 1 / 4 / 2 / 5; } 
  .grid-license-div4 { grid-area: 2 / 3 / 3 / 4; } 
  .grid-license-div5 { grid-area: 2 / 4 / 3 / 5; } 
  .grid-license-div6 { grid-area: 3 / 3 / 4 / 4; } 
  .grid-license-div7 { grid-area: 3 / 4 / 4 / 5; } 


  .info-total-report{
    -webkit-appearance: none;
    margin-right: 0 !important;
    background-color: #6d8da6;
    color: white;
    margin: 0px 5px 5px 5px;
    text-align: center;
    font-size: 30px;
    width: 70px;
    height: 70px;
    border-radius: 200px 200px 200px 200px;
    -moz-border-radius: 200px 200px 200px 200px;
    -webkit-border-radius: 200px 200px 200px 200px;
    border: 0px solid #000000;
    border: 0;
  }

.grid-home {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    grid-template-rows: repeat(4, 0.5fr);
    grid-column-gap: 0px;
    grid-row-gap: 0px;
}

.grid-home-div1 { grid-area: 1 / 1 / 2 / 3; }
.grid-home-div2 { grid-area: 1 / 3 / 2 / 5; }
.grid-home-div3 { grid-area: 1 / 5 / 2 / 7; }
.grid-home-div4 { grid-area: 2 / 1 / 3 / 7; }
.grid-home-div5 { grid-area: 3 / 1 / 4 / 2; }
.grid-home-div6 { grid-area: 3 / 2 / 4 / 3; }
.grid-home-div7 { grid-area: 3 / 3 / 4 / 4; }
.grid-home-div8 { grid-area: 3 / 4 / 4 / 5; }
.grid-home-div9 { grid-area: 3 / 5 / 4 / 6; }
.grid-home-div10 { grid-area: 3 / 6 / 4 / 7; }
.grid-home-div11 { grid-area: 4 / 1 / 5 / 7; } 

.title-percentage {
  margin-top: 25px;
  color: #f5a623;
  text-align: left;
  font-size: 14px;
  font-weight: bold;
}

.input-percentage {
  font-family: Audiowide;
  -webkit-appearance: none;
  background-color: #6d8da6;
  color: white;
  margin: 0px 5px 5px 5px;
  text-align: center;
  font-size: 30px;
  width: 70px;
  height: 70px;
  border-radius: 200px 200px 200px 200px;
  -moz-border-radius: 200px 200px 200px 200px;
  -webkit-border-radius: 200px 200px 200px 200px;
  border: 0px solid #000000;
  border: 0;
}

.input-info-report {
  font-family: Audiowide;
  -webkit-appearance: none;
  background-color: #6d8da6;
  color: white;
  margin: 0px 5px 5px 5px;
  text-align: center;
  font-size: 15px;
  padding: 5px 25px 5px 25px;
  border-radius: 200px 200px 200px 200px;
  -moz-border-radius: 200px 200px 200px 200px;
  -webkit-border-radius: 200px 200px 200px 200px;
  border: 0px solid #000000;
  border: 0;
}

.mantainer-home {
  margin: 25px 80px 25px 80px !important;
  padding-bottom: 25px 25px 25px 25px !important;
}

.card-info {
  background-color: #f5a623 !important;
  height: 75%;
  margin-top: 25px;
  margin-left: 5px;
  margin-right: 5px;
  padding: 15px;
}
.chart-percentage {
  height: 50px;
}

.card-main {
  margin: 10px;
  padding: 5px 10px 5px 10px;
  background-color: #323f4f;
}

.card-percentage {
  background-color: #323f4f;
  margin: 3px 2px 0px 2px;
}

.card-percentage-head {
  color: white;
  font-size:12px;
  padding: 1px 10px 1px 10px;
}

.card-percentage-body-chart {
  
    padding: 10px 10px 10px 10px;

}
.card-percentage-body {
    padding: 5px 10px 5px 10px;
    text-align: right;
}
.card-percentage-body-row1 {
    height: 159px!important;
    padding: 5px 10px 5px 10px;
    text-align: right;
}

.card-percentage-footer {
    font-size: 10px;
    color: white;
    padding: 5px 10px 5px 10px;

}

.card-divisor {
    margin: 3px 3px 3px 3px!important;
    border-color: #f5a623 !important; 
}
/*["#53C491", "#E8AC0C", "#6E63FB", "#B83E3E", "#C84AF1"],*/
.circle-garzon{
  color: #53C491;
}
.circle-runner{
  color: #E8AC0C;
}
.circle-bar{
  color: #6E63FB;
}
.circle-cheff{
  color: #B83E3E;
}
.circle-copper{
  color: #C84AF1;
}
.circle-generic{
  color: #04B431;
}
.circle-generic-error{
  color: #B83E3E;
}

.btn-save-percentage{
  color: #f5a623 !important;
  cursor: pointer;
}
.circle-red-sm{
  color: #C84AF1;
}
.circle-blue-sm{
  color:  #6E63FB;
}
.circle-yellow-sm{
  color: #f5a623 !important;
}
  .pointer{
    cursor : pointer;
    color  : white!important;
  }
  .pointer:hover{
      color: #f5a623!important;

  }

.card-chart-work-day {
    background-color : #323f4f;
    padding          : 5px 10px 5px 10px;

}
.card-chart-work-day-head {
  color     : white;
  font-size :12px;
  padding   : 1px 10px 1px 10px;
}

.card-chart-work-day-body {  
    padding    : 5px 10px 5px 10px;
    text-align : right;
}
.card-chart-work-day-footer {
    font-size : 10px;
    color     : white;
    padding   : 5px 10px 5px 10px;

}


 @media only screen and (max-width: 700px) {              
        

              .card-percentage {
                width: 300px!important;
              }
              .card-chart-work-day {
                  width: 300px!important;    
              }             


              .grid-home{
                display: grid;
                grid-template-columns: 1fr;
                grid-template-rows: repeat(11, 0.5fr);
                grid-column-gap: 0px;
                grid-row-gap: 0px;
              }

              .grid-home-div1 { grid-area: 1 / 1 / 2 / 2; }
              .grid-home-div2 { grid-area: 2 / 1 / 3 / 2; }
              .grid-home-div3 { grid-area: 3 / 1 / 4 / 2; }
              .grid-home-div4 { grid-area: 4 / 1 / 5 / 2; }
              .grid-home-div5 { grid-area: 5 / 1 / 6 / 2; }
              .grid-home-div6 { grid-area: 6 / 1 / 7 / 2; }
              .grid-home-div7 { grid-area: 7 / 1 / 8 / 2; }
              .grid-home-div8 { grid-area: 8 / 1 / 9 / 2; }
              .grid-home-div9 { grid-area: 9 / 1 / 10 / 2; }
              .grid-home-div10 { grid-area: 10 / 1 / 11 / 2; }
              .grid-home-div11 { grid-area: 11 / 1 / 12 / 2; } 
                }
</style>
@endsection
