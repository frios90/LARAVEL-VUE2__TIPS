<template>
  <div class>
    <div class="neo-grid">
      <div class="neo-grid-div1">
        <div class="card-tip tm-bg-primary-dark tm-block tm-block-h-auto">
          <div class="col-xl-12 col-lg-12 col-md-12">            
            <div class="form-group">
              <label for>Jornada <span v-if="errors.jornada"><i class="fas fa-exclamation-triangle"></i></span></label>
              <div class="grid-working form-group group-work-day">
                <div class="grid-working-div1">
                  <i
                    v-if="work_day_list.morning" class="fas fa-sun working-day-selected"></i>
                  <i v-else class="fas fa-sun" ></i>
                </div>
                <div class="grid-working-div2">
                  <i v-if="work_day_list.noon" class="fas fa-adjust working-day-selected"></i>
                  <i v-else class="fas fa-adjust"></i>
                </div>
                <div class="grid-working-div3">
                  <i v-if="work_day_list.night" class="fas fa-moon working-day-selected"></i>
                  <i v-else class="fas fa-moon" ></i>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for>Descripción <span v-if="errors.description"><i class="fas fa-exclamation-triangle"></i></span></label>
              <input
                type="text" disabled
                class="form-control form-control-sm input-for-tips"
                v-model="data_head.description"
              />
              <span class="errors" v-if="errors && errors.name">{{errors.name[0] }}</span>
            </div>
          </div>
        </div>
        <div class="card-tip tm-bg-primary-dark tm-block tm-block-h-auto total-general-amounts">
          <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="total-cash">
              <div class="div1">
                <i class="far fa-money-bill-alt"></i> Efectivo
              </div>
              <div class="div2">{{ data_head.amounts.cash | currency }}</div>
              <div class="div3">
                <i class="fas fa-credit-card"></i> Débito
              </div>
              <div class="div4">{{ data_head.amounts.debit | currency }}</div>
              <div class="div5">
                <i class="far fa-credit-card"></i> Crédito
              </div>
              <div class="div6">{{ data_head.amounts.credit | currency }}</div>
              <div class="div7">
                <i class="fas fa-credit-card"></i> Total
              </div>
              <div class="div8">{{ data_head.amounts.total | currency }}</div>
            </div>
          </div>
        </div>
        <div class="container-resumen">
          <div class="total-staff-cash" v-for="(resumen, key) in list_staffs_in_work" :key="key">
            <div class="container-resumen-div1">{{ resumen.name }}</div>
            <div class="container-resumen-div2">{{ resumen.total_tips | currency }}</div>
          </div>
        </div>
      </div>

      <div class="neo-grid-div4">
        <div
          v-for="(day, key_list) in list_days"
          :key="key_list"
          class="tm-mt-big tm-mb-big new-day"
        >
          <div class>
            <div class="card-tip-day tm-bg-primary-dark tm-block tm-block-h-auto">
              <div class="row">
                <div class="col-12">
                  <div class="row tm-edit-product-row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                      <form action class="tm-edit-product-form">
                        <div class="mounts-day">
                          <div class="form-group mounts-day-div1">
                            <label for>Día {{ key_list +1 }}<span v-if="day.errors"><i class="fas fa-exclamation-triangle"></i></span></label>
                            <input
                              type="date" disabled
                              class="form-control form-control-sm input-for-tips"
                              v-model="day.day"
                            />
                          </div>
                          <div class="form-group mounts-day-div2">
                            <label for>Efectivo</label>
                            <input
                              type="text" disabled
                              class="form-control form-control-sm input-for-tips"
                              v-model="day.amounts.cash"
                              @keyup="calculate(day)"
                            />
                          </div>
                          <div class="form-group mounts-day-div3">
                            <label for>Débito</label>
                            <input
                              type="text" disabled
                              class="form-control form-control-sm input-for-tips"
                              v-model="day.amounts.debit"
                              @keyup="calculate(day)"
                            />
                          </div>
                          <div class="form-group mounts-day-div4">
                            <label for>Crédito</label>
                            <input
                              type="text" disabled
                              class="form-control form-control-sm input-for-tips"
                              v-model="day.amounts.credit"
                              @keyup="calculate(day)"
                            />
                          </div>
                          <div class="form-group mounts-day-div5">
                            <label for>Total día</label>
                            <input
                              disabled
                              type="text" 
                              class="form-control form-control-sm input-for-tips"
                              v-model="day.amounts.total"
                              @keyup="calculate(day)"
                            />
                          </div>
                          
                        </div>
                        <hr>
                        <div class="staff-selector">
                          <div class="staff-selector-div1">
                            <div>
                              <div class="grid-total-unit">
                                <div class="grid-total-unit-div1">Garzón</div>
                                <div class="grid-total-unit-div2">
                                  <i class="fas fa-users" title="Total del día para el grupo"></i>
                                  {{ day.distribute.garzones.total | currency}}
                                </div>
                                <div class="grid-total-unit-div3">
                                  <i class="fas fa-user" title="Total por staff en el grupo"></i> 
                                  {{ day.distribute.garzones.unit | currency }}
                                </div>
                              </div>
                            </div>
                          
                          </div>

                          <div class="staff-selector-div2">
                            <ul class>
                              <li
                                v-for="(list, key) in day.staffs.list_garzones"
                                :key="key"
                                class="special-li"
                              >
                                {{list.name}}
                                
                              </li>
                            </ul>
                          </div>

                          <div class="staff-selector-div3">
                            <div>
                              <div class="grid-total-unit">
                                <div class="grid-total-unit-div1">Runner</div>
                                <div class="grid-total-unit-div2">
                                  <i class="fas fa-users" title="Total del día para el grupo"></i>
                                  {{ day.distribute.runners.total | currency}}
                                </div>
                                <div class="grid-total-unit-div3">
                                  <i class="fas fa-user" title="Total por staff en el grupo"></i>
                                  {{ day.distribute.runners.unit | currency }}
                                </div>
                              </div>
                            </div>
                            
                          </div>

                          <div class="staff-selector-div4">
                            <ul class>
                              <li
                                v-for="(list, key) in day.staffs.list_runners"
                                :key="key"
                                class="special-li"
                              >
                                {{list.name}}
                              
                              </li>
                            </ul>
                          </div>

                          <div class="staff-selector-div5">
                            <div class="grid-total-unit">
                              <div class="grid-total-unit-div1">Barra</div>
                              <div class="grid-total-unit-div2">
                                <i class="fas fa-users" title="Total del día para el grupo"></i>
                                {{ day.distribute.bartenders.total | currency}}
                              </div>
                              <div class="grid-total-unit-div3">
                                <i class="fas fa-user" title="Total por staff en el grupo"></i>
                                {{ day.distribute.bartenders.unit | currency }}
                              </div>
                            </div>
                            
                          </div>

                          <div class="staff-selector-div6">
                            <ul>
                              <li
                                v-for="(list, key) in day.staffs.list_bartenders"
                                :key="key"
                                class="special-li"
                              >
                                {{list.name}}
                              
                              </li>
                            </ul>
                          </div>

                          <div class="staff-selector-div7">
                            <div class="grid-total-unit">
                              <div class="grid-total-unit-div1">Cocina</div>
                              <div class="grid-total-unit-div2">
                                <i class="fas fa-users" title="Total del día para el grupo"></i>
                                {{ day.distribute.cheffs.total | currency}}
                              </div>
                              <div class="grid-total-unit-div3">
                                <i class="fas fa-user" title="Total por staff en el grupo"></i>
                                {{ day.distribute.cheffs.unit | currency }}
                              </div>
                            </div>
                            
                          </div>

                          <div class="staff-selector-div8">
                            <ul class>
                              <li
                                v-for="(list, key) in day.staffs.list_cheffs"
                                :key="key"
                                class="special-li"
                              >
                                {{list.name}}
                              
                              </li>
                            </ul>
                          </div>

                          <div class="staff-selector-div9">
                            <div class="grid-total-unit">
                              <div class="grid-total-unit-div1">Copero</div>
                              <div class="grid-total-unit-div2">
                                <i class="fas fa-users" title="Total del día para el grupo"></i>
                                {{ day.distribute.coppers.total | currency}}
                              </div>
                              <div class="grid-total-unit-div3">
                                <i class="fas fa-user" title="Total por staff en el grupo"></i>
                                {{ day.distribute.coppers.unit | currency }}
                              </div>
                            </div>
                            
                          </div>

                          <div class="staff-selector-div10">
                            <ul class>
                              <li
                                v-for="(list, key) in day.staffs.list_coppers"
                                :key="key"
                                class="special-li"
                              >
                                {{list.name}}
                                
                              </li>
                            </ul>
                          </div>
                        </div>
                       
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</template>
<script>
import Notifications from '../mixins/Notifications.js';

export default {
  name: "edit",
  mixins: [Notifications],
  data() {
    return {
      id : this.$route.params.id,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      errors                : {},
      check_event           : false,
      for_repeat_list_staff : [],
      historic_staff        : [],
      list_days             : [],
      list_staffs_in_work   : [],
      garzon                : "",
      runner                : "",
      bartender             : "",
      cheff                 : "",
      copper                : "",
      work_day_selected     : false,
      work_day_list         : {
        night   : false,
        noon    : false,
        morning : false
      },
      percentages           : {
        garzon    : 0,
        runner    : 0,
        bartender : 0,
        cheff     : 0,
        copper    : 0
      },
      data_head             : {
        since       : "",
        until       : "",
        description : "",
        jornada     : "",
        amounts     : {
          cash   : 0,
          debit  : 0,
          credit : 0,
          total  : 0
        }
      },
      errors        : {         
          description : false,
          jornada     : false,
      }
    }
  },
  created() {
    this.getTipWork()
  },
  methods: {
    getTipWork () {
        var self = this
        this.$http.get('/get-tip-work', {params: {id: self.id}})
        .then(response => {
          var response_data_head = response.body.meta_data_head
          var response_list_days           = response.body.meta_list_days
          var response_list_staffs_in_work = response.body.meta_list_staffs_in_work
          var response_percentage          = response.body.meta_percentage
          self.changeWorkDaySelected(response_data_head.jornada) 
          self.data_head           = response_data_head
          self.list_days           = response_list_days
          self.list_staffs_in_work = response_list_staffs_in_work
          self.percentage          = response_percentage
         
        }, response => {                 
          self.$toasted.global.APP_GENERAL_ERROR()
        })
    },   
   changeWorkDaySelected(work) {
        this.work_day_selected = work;
        switch (work) {
          case "morning":
            if (this.work_day_list.morning) {
              this.work_day_list.night = false;
              this.work_day_list.noon = false;
              this.work_day_list.morning = false;
              this.data_head.jornada = false;
            } else {
              this.work_day_list.night = false;
              this.work_day_list.noon = false;
              this.work_day_list.morning = true;
              this.data_head.jornada = "morning";
            }
            break;
          case "noon":
            if (this.work_day_list.noon) {
              this.work_day_list.night = false;
              this.work_day_list.noon = false;
              this.work_day_list.morning = false;
              this.data_head.jornada = false;
            } else {
              this.data_head.jornada = "noon";
              this.work_day_list.night = false;
              this.work_day_list.noon = true;
              this.work_day_list.morning = false;
            }
            break;
          case "night":
            if (this.work_day_list.night) {
              this.work_day_list.night = false;
              this.work_day_list.noon = false;
              this.work_day_list.morning = false;
              this.data_head.jornada = false;
            } else {
              this.data_head.jornada = "night";
              this.work_day_list.night = true;
              this.work_day_list.noon = false;
              this.work_day_list.morning = false;
            }
            break;
        }
      },
   
  
 
    
    isNumber: function(evt) {
      evt = evt ? evt : window.event;
      var charCode = evt.which ? evt.which : evt.keyCode;
      if (
        charCode > 31 &&
        (charCode < 48 || charCode > 57) &&
        charCode !== 46
      ) {
        evt.preventDefault();
      } else {
        return true;
      }
    },
  
  },
  filters: {
    upper: function(value) {
      return value.toUpperCase();
    }
  }
};
</script>

<style>
  .mounts-day { 
    display: grid; 
    grid-template-columns: repeat(5, 1fr); 
    grid-template-rows: 1fr; 
    grid-column-gap: 0px;
    grid-row-gap: 0px; 
  }

    .mounts-day-div1 { grid-area: 1 / 1 / 2 / 2; } 
    .mounts-day-div2 { grid-area: 1 / 2 / 2 / 3; } 
    .mounts-day-div3 { grid-area: 1 / 3 / 2 / 4; } 
    .mounts-day-div4 { grid-area: 1 / 4 / 2 / 5; } 
    .mounts-day-div5 { grid-area: 1 / 5 / 2 / 6; } 



.fa-exclamation-triangle{
  color:red!important;
}
.btn-init{
  margin-top:15px;
  color: #f5a623 !important;
  font-size:50px;
  cursor:pointer;
}
.btn-init:hover{
  font-size:55px;
  color: #ffbf00 !important;
  transition-duration: 0.4s;
}
.fa-users, .fa-user{
  font-size: 11px;
}

.btn-events{
  margin-left:100px!important;
  margin-right:100px!important;

}
.tip-work {
  font-size: 12px !important;
}

.card-tip {
  padding-left: 15px !important;
  padding-right: 15px !important;
  padding-top: 15px !important;
  padding-bottom: 15px !important;
  margin-top: 15px !important;
  background-color: #323F4F!important;
-webkit-box-shadow: 10px 10px 5px -6px rgba(0,0,0,0.75);
-moz-box-shadow: 10px 10px 5px -6px rgba(0,0,0,0.75);
box-shadow: 10px 10px 5px -6px rgba(0,0,0,0.75);
}

.card-tip-day {
  background-color: #323F4F!important;
  padding-top: 15px !important;
  padding-bottom: 15px !important;
  margin-right: 15px !important;
  margin-top: 0px !important;
  padding-top: 15px !important;
  padding-bottom: 15px !important;
  margin-right: 15px !important;
  margin-top: 0px !important;
  -webkit-box-shadow: 10px 10px 5px -6px rgba(0,0,0,0.75);
  -moz-box-shadow: 10px 10px 5px -6px rgba(0,0,0,0.75);
  box-shadow: 10px 10px 5px -6px rgba(0,0,0,0.75);

}

.new-work {
  margin-top: 15px !important;
  margin-bottom: 15px !important;
}

.new-day {
  margin-top: 15px !important;
  margin-bottom: 15px !important;
}
ul {
  margin-left: 0px !important;
  padding-left: 0px !important;
}
.special-li {
  list-style: none;
  text-align: center;
  font-size: 10px !important;
  background-color: #04B431;
  color: whitesmoke;
  padding: 5px;
  padding-left: 15px;
  margin-bottom: 5px;
  -webkit-box-shadow: 0px 0px 11px -2px rgba(0,0,0,0.75);
  -moz-box-shadow: 0px 0px 11px -2px rgba(0,0,0,0.75);
  box-shadow: 0px 0px 11px -2px rgba(0,0,0,0.75);

}
.form-group {
  margin-bottom: 2px !important;
  padding: 2px !important;
}
.form-group label {
  margin-bottom: 2px !important;
}

input:disabled {
  color: whitesmoke;
  background-color: #202020 !important;
}

/**.grid head*/
.grid-head {
  display: grid;
  grid-template-columns: repeat(2, 1fr) 0.3fr 0.5fr;
  grid-template-rows: repeat(2, 1fr);
  grid-column-gap: 0px;
  grid-row-gap: 0px;
}

.div1 {
  grid-area: 1 / 1 / 2 / 2;
}
.div2 {
  grid-area: 1 / 2 / 2 / 3;
}
.div3 {
  grid-area: 1 / 3 / 2 / 4;
}
.div4 {
  grid-area: 2 / 1 / 3 / 4;
}
.div5 {
  grid-area: 1 / 4 / 3 / 5;
  margin: 0px 0px 0px 0px !important;
  padding: 0px 0px 0px 0px !important;
}

.grid-head .div5 {
  font-size: 16px;
  margin-left: 15px !important;
}

.grid-head td {
  color: whitesmoke;
  width: 50%;
  font-size: 12px;
}
.grid-head .td-amount {
  width: 100%;
  text-align: right !important;
  font-weight: bold;
}

.span-finish-amount {
  text-align: right !important;
  font-size: 12px;
  width: 50%;
}

.span-finish-name {
  width: 50%;
  text-align: left !important;
  font-size: 10px;
}

/*clases para jornada*/
.group-work-day {
  font-size: 15px;
}
.group-work-day {
  font-size: 15px;
}

/**CONTAINER RESUMEN */

 .container-resumen {
    color: white;
    background-color: #04b431 !important;
    margin-top: 15px !important;
    padding-left: 15px !important;
    padding-top: 15px !important;
    padding-right: 15px !important;
    padding-bottom: 15px !important;
    -webkit-box-shadow: 10px 10px 15px 0px rgba(0, 0, 0, 0.75);
    -moz-box-shadow: 10px 10px 15px 0px rgba(0, 0, 0, 0.75);
    box-shadow: 10px 10px 15px 0px rgba(0, 0, 0, 0.75);

    border-radius: 5px 5px 5px 5px;
    -moz-border-radius: 5px 5px 5px 5px;
    -webkit-border-radius: 5px 5px 5px 5px;
    border: 0px solid #000000;
  }
  .container-resumen-div1 {
    font-size: 12px;
    border-bottom: solid 0.5px;
    border-color: white;
  }
  .container-resumen-div2 {
    font-size: 12px !important;
    text-align: right;
    border-bottom: solid 0.5px;
    border-color: white;
  }
.working-day-selected {
  color: #f5a623 !important;
}
/*GRID PARA SELECTOR DE STAFF*/
.staff-selector {
  display: grid; 
grid-template-columns: repeat(5, 1fr); 
grid-template-rows: repeat(2, 0.2fr); 
grid-column-gap: 0px;
grid-row-gap: 0px; 
}

.staff-selector-div1 {
  margin-right:3px;
  grid-area: 1 / 1 / 2 / 2;
}
.staff-selector-div2 {
  margin-top: 10px;
  margin-right:3px;
  grid-area: 2 / 1 / 3 / 2;
}
.staff-selector-div3 {
  margin-right:3px;
  grid-area: 1 / 2 / 2 / 3;
}
.staff-selector-div4 {
    margin-top: 10px;

  margin-right:3px;
  grid-area: 2 / 2 / 3 / 3;
}
.staff-selector-div5 {
  margin-right:3px;
  grid-area: 1 / 3 / 2 / 4;
}
.staff-selector-div6 {
    margin-top: 10px;

  margin-right:3px;
  grid-area: 2 / 3 / 3 / 4;
}
.staff-selector-div7 {
  margin-right:3px;
  grid-area: 1 / 4 / 2 / 5;
}
.staff-selector-div8 {
    margin-top: 10px;

  margin-right:3px;
  grid-area: 2 / 4 / 3 / 5;
}
.staff-selector-div9 {
  margin-right:3px;
  grid-area: 1 / 5 / 2 / 6;
}
.staff-selector-div10 {
    margin-top: 10px;

  margin-right:3px;
  grid-area: 2 / 5 / 3 / 6;
}

/*GRID PARA TOTAL STAFF CHASH*/
.total-staff-cash {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  grid-template-rows: 0.3fr;
  grid-column-gap: 0px;
  grid-row-gap: 0px;
}

.total-staff-cash .div1 {
  grid-area: 1 / 1 / 2 / 2;
  font-size: 16px !important;
}
.total-staff-cash .div2 {
  grid-area: 1 / 2 / 2 / 3;
  font-size: 16px !important;
}
/*GRID PARA TOTAL CHASH*/
.total-cash {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  grid-template-rows: repeat(4, 1fr);
  grid-column-gap: 0px;
  grid-row-gap: 0px;
}

.total-cash .div1 {
  grid-area: 1 / 1 / 2 / 2;
}
.total-cash .div2 {
  grid-area: 1 / 2 / 2 / 3;
    text-align: right;

}
.total-cash .div3 {
  grid-area: 2 / 1 / 3 / 2;
}
.total-cash .div4 {
  grid-area: 2 / 2 / 3 / 3;
    text-align: right;

}
.total-cash .div5 {
  grid-area: 3 / 1 / 4 / 2;
}
.total-cash .div6 {
  grid-area: 3 / 2 / 4 / 3;
    text-align: right;

}
.total-cash .div7 {
  grid-area: 4 / 1 / 5 / 2;
}
.total-cash .div8 {
  grid-area: 4 / 2 / 5 / 3;
    text-align: right;

}
/*GRID PARA TOTAL UNIT*/

.grid-total-unit {
    display: grid;
    grid-template-columns: 1fr;
    grid-template-rows: repeat(3, 1fr);
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    color: white !important;
  }

  .grid-total-unit-div1 {
    grid-area: 1 / 1 / 2 / 2; 
    font-size: 12px!important;
    margin-right: 5px;
  }
  .grid-total-unit-div2 {
    grid-area: 2 / 1 / 3 / 2;
    text-align: right;
    margin-right: 5px;
    font-size: 12px!important;

  }
  .grid-total-unit-div3 {
    grid-area: 3 / 1 / 4 / 2;
    text-align: right;
    margin-right: 5px;
    font-size: 12px!important;

  }

/*grid para selector de jornada*/
.grid-working {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-template-rows: 1fr;
  grid-column-gap: 0px;
  grid-row-gap: 0px;
  font-size: 25px !important;
  text-align: center;
}

.grid-working-div1 {
  grid-area: 1 / 1 / 2 / 2;
}
.grid-working-div2 {
  grid-area: 1 / 2 / 2 / 3;
}
.grid-working-div3 {
  grid-area: 1 / 3 / 2 / 4;
}

/*nuevo grid de distribucion de los elementos*/
.neo-grid {
  display: grid;
  grid-template-columns: 0.4fr 1.6fr;
  grid-template-rows: repeat(3, 1fr);
  grid-column-gap: 0px;
  grid-row-gap: 0px;
}

.neo-grid-div1 {
  grid-area: 1 / 1 / 2 / 2;
  margin-left: 15px !important;
  margin-top: 0px !important;
  color: white;
  font-size: 14px;
}

.content-neo-grid-form {
  padding-bottom: 15px !important;
}
.neo-grid-div2 {
  grid-area: 2 / 1 / 3 / 2;
  margin-left: 15px !important;
  margin-top: 15px !important;
  color: white;
  font-size: 14px;
}
.neo-grid-div3 {
  grid-area: 3 / 1 / 4 / 2;
  margin-left: 15px !important;
  margin-top: 15px !important;
}
.neo-grid-div4 {
  grid-area: 1 / 2 / 4 / 3;
  margin-left: 15px !important;
  margin-top: 0px !important;
}

.action-options {
  color: #f5a623 !important;
  margin-left: 12px;
  margin-right: 12px;
  cursor: pointer;

}
.action-options:hover {
  color: #ffbf00 !important;
  transition-duration: 0.4s;
  -webkit-box-shadow: 10px 10px 91px -3px rgba(189, 129, 10, 1);
  -moz-box-shadow: 10px 10px 91px -3px rgba(189, 129, 10, 1);
  box-shadow: 10px 10px 91px -3px rgba(189, 129, 10, 1);
}
.container-head {
  margin-left: 50px !important;
  margin-right: 15px !important;
}

.submit {
  padding: 6px !important;
}
.simple-root {
  margin-top: 20%;
  margin-left: auto;
  margin-right: auto;
}

.help.is-danger {
  color: red;
}

.form-control.is-danger {
  border: 1px solid red;
}

.input-for-tips{
  height: 1em !important;
  padding-top: 15px !important;
  padding-bottom: 15px !important;
  text-align: right;
}

.select-for-tips{
  height: 1em !important;
  padding-top: 5px !important;
  padding-bottom: 5px !important;
}

</style>
@endsection