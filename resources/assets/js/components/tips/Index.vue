<template>
  <div class>
    <div v-if="loader" class="loader"></div>
    <div v-if="config_percentages" class="neo-grid">
      <div class="neo-grid-div1">
        <div class="card-tip tm-bg-primary-dark tm-block tm-block-h-auto">
          <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="form-group">
              <label for>
                Jornada
                <i
                  class="fas fa-info-circle mantainer-info"
                  title="Escoja una jornada para este trabajo. Puede ser Mañana, Tarde o Noche."
                ></i>
                <span v-if="errors.jornada">
                  <i class="fas fa-exclamation-triangle"></i>
                </span>
              </label>
              <div class="grid-working form-group group-work-day">
                <div class="grid-working-div1">
                  <i
                    v-if="work_day_list.morning"
                    class="fas fa-sun working-day-selected"
                    @click="changeWorkDaySelected('morning')"
                  ></i>
                  <i v-else class="fas fa-sun" @click="changeWorkDaySelected('morning')"></i>
                </div>
                <div class="grid-working-div2">
                  <i
                    v-if="work_day_list.noon"
                    class="fas fa-adjust working-day-selected"
                    @click="changeWorkDaySelected('noon')"
                  ></i>
                  <i v-else class="fas fa-adjust" @click="changeWorkDaySelected('noon')"></i>
                </div>
                <div class="grid-working-div3">
                  <i
                    v-if="work_day_list.night"
                    class="fas fa-moon working-day-selected"
                    @click="changeWorkDaySelected('night')"
                  ></i>
                  <i v-else class="fas fa-moon" @click="changeWorkDaySelected('night')"></i>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for>
                Descripción
                <i
                  class="fas fa-info-circle mantainer-info"
                  title="Ingrese una referencia respecto al trabajo."
                ></i>
                <span v-if="errors.description">
                  <i class="fas fa-exclamation-triangle"></i>
                </span>
              </label>
              <input
                type="text"
                class="form-control form-control-sm input-for-tips"
                v-model="data_head.description"
              />
            
              <span class="errors" v-if="errors && errors.name">{{errors.name[0] }}</span>
            </div>

            <div class="form-group">
              <div class="grid-working">
                <template v-if="list_days.length <= 0">
                  <div class="grid-working-div1">
                    <i
                      class="far fa-play-circle tips-event-init"
                      title="Comenzar trabajo"
                      @click="init()"
                    >
                      <span class="init-hover"></span>
                    </i>
                  </div>
                  <div class="grid-working-div3">
                    <i
                      v-if="exist_last"
                      class="fab fa-codiepie tips-event-continue"
                      title="Continuar trabajo anterior"
                      @click="editLast()"
                    >
                      <span class="init-hover"></span>
                    </i>
                  </div>
                </template>

                <template v-else>
                  <div class="grid-working-div1">
                    <span @click="go('/home', 'home')" title="Cancelar" class="tips-event-cancel">
                      <i class="fas fa-ban"></i>
                    </span>
                  </div>
                  <div class="grid-working-div2">
                    <span @click="save()" title="Guardar trabajo" class="tips-event-save">
                      <i class="far fa-check-circle"></i>
                    </span>
                  </div>
                  <div class="grid-working-div3">
                    <span
                      v-if="list_days.length < 7"
                      title="Añadir otro día"
                      class="tips-event-plus"
                      @click="init()"
                    >
                      <i class="fas fa-plus-circle"></i>
                    </span>
                  </div>
                </template>
              </div>
            </div>
          </div>
        </div>
        <div class="card-tip tm-bg-primary-dark tm-block tm-block-h-auto">
          <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="total-cash">
              <div class="div1">
                <i title="Total efectivo acumulado" class="far fa-money-bill-alt total-accumulated"></i> Efectivo
              </div>
              <div class="div2">{{ data_head.amounts.cash | currency }}</div>
              <div class="div3">
                <i title="Total débito acumulado" class="fas fa-credit-card total-accumulated"></i> Débito
              </div>
              <div class="div4">{{ data_head.amounts.debit | currency }}</div>
              <div class="div5">
                <i title="Total crédito acumulado" class="far fa-credit-card total-accumulated"></i> Crédito
              </div>
              <div class="div6">{{ data_head.amounts.credit | currency }}</div>
              <div class="div7">
                <i title="Total acumulado" class="fas fa-credit-card total-accumulated"></i> Total
              </div>
              <div class="div8">{{ data_head.amounts.total | currency }}</div>
            </div>
          </div>
        </div>
        <div v-if="list_staffs_in_work.length > 0" class="container-resumen">
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
                        <div class="row">
                          <div class="form-group col-md-3">
                            <label for>
                              <span class="day-define">Día {{ key_list +1 }}</span>  
                              <span v-if="day.errors">
                                <i class="fas fa-exclamation-triangle"></i>
                              </span>
                            </label>
                            <input
                              type="date"
                              class="form-control form-control-sm input-for-tips input-date"
                              v-model="day.day"
                            />
                            <span class="errors" v-if="errors && errors.rut">{{errors.rut[0] }}</span>
                          </div>
                          <div class="form-group col-md-2">
                            <label for>
                              Efectivo
                              <i
                                title="Sumar propinas en efectivo"
                                class="fas fa-calculator btn-vauchers"
                                @click="showModalVauchers('cash', key_list)"
                              ></i>
                            </label>
                            <input
                              readonly
                              maxlength="6"
                              type="text"
                              class="form-control form-control-sm input-for-tips"
                              v-model="day.amounts.cash"
                              @keyup="calculate(day)"
                            />
                            <span class="errors" v-if="errors && errors.rut">{{errors.rut[0] }}</span>
                          </div>
                          <div class="form-group col-md-2">
                            <label for>
                              Débito
                              <i
                                title="Sumar propinas en débito"
                                class="fas fa-calculator btn-vauchers"
                                @click="showModalVauchers('debit', key_list)"
                              ></i>
                            </label>
                            <input
                              readonly
                              type="text"
                              class="form-control form-control-sm input-for-tips"
                              v-model="day.amounts.debit"
                              @keyup="calculate(day)"
                            />
                            <span class="errors" v-if="errors && errors.rut">{{errors.rut[0] }}</span>
                          </div>
                          <div class="form-group col-md-2">
                            <label for>
                              Crédito
                              <i
                                title="Sumar propinas en crédito"
                                class="fas fa-calculator btn-vauchers"
                                @click="showModalVauchers('credit', key_list)"
                              ></i>
                            </label>
                            <input
                              readonly 
                              type="text"
                              class="form-control form-control-sm input-for-tips"
                              v-model="day.amounts.credit"
                              @keyup="calculate(day)"
                            />
                            <span class="errors" v-if="errors && errors.name">{{errors.name[0] }}</span>
                          </div>
                          <div class="form-group col-md-2">
                            <label for>Total día</label>
                            <input
                              disabled
                              type="text"
                              class="form-control form-control-sm input-for-tips"
                              v-model="day.amounts.total"
                              @keyup="calculate(day)"
                            />
                            <span class="errors" v-if="errors && errors.name">{{errors.name[0] }}</span>
                          </div>
                          <div class="form-group col-md-1">
                            <label for>Acciones</label>
                            <div class="form-group group-work-day div3">
                              <i
                                class="far fa-times-circle action-options"
                                title="Eliminar día"
                                @click="removeDay(day)"
                              ></i>
                              <i
                                v-if="list_days.length < 7"
                                class="fas fa-redo-alt action-options"
                                title="Repetir día"
                                @click="repeatDay(day)"
                              ></i>
                            </div>
                          </div>
                        </div>

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
                            <select
                              v-if="percentages.garzon > 0"
                              class="form-control form-control-sm select-for-tips"
                              v-model="garzon"
                              @change="add_to_list('garzon', day)"
                            >
                              <option
                                v-for="(list, index) in day.list_staff"
                                :key="index"
                                :value="list"
                              >{{ list.name }}</option>
                            </select>
                          </div>

                          <div class="staff-selector-div2">
                            <ul class>
                              <li
                                v-for="(list, key) in day.staffs.list_garzones"
                                :key="key"
                                class="special-li"
                              >
                                {{list.name}}
                                <span
                                  class="float-right"
                                  @click="removeItemSelected(day, list, 'garzon')"
                                >
                                  <i class="far fa-times-circle mantainer-pointer"></i>
                                </span>
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
                            <select
                              v-if="percentages.runner > 0"
                              class="form-control form-control-sm select-for-tips"
                              v-model="runner"
                              @change="add_to_list('runner', day)"
                            >
                              <option
                                v-for="(list, index) in day.list_staff"
                                :key="index"
                                :value="list"
                              >{{ list.name }}</option>
                            </select>
                          </div>

                          <div class="staff-selector-div4">
                            <ul class>
                              <li
                                v-for="(list, key) in day.staffs.list_runners"
                                :key="key"
                                class="special-li"
                              >
                                {{list.name}}
                                <span
                                  class="float-right"
                                  @click="removeItemSelected(day, list, 'runner')"
                                >
                                  <i class="far fa-times-circle mantainer-pointer"></i>
                                </span>
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
                            <select
                              v-if="percentages.bartender > 0"
                              class="form-control form-control-sm select-for-tips"
                              v-model="bartender"
                              @change="add_to_list('bartender', day)"
                            >
                              <option
                                v-for="(list, index) in day.list_staff"
                                :key="index"
                                :value="list"
                              >{{ list.name }}</option>
                            </select>
                          </div>

                          <div class="staff-selector-div6">
                            <ul>
                              <li
                                v-for="(list, key) in day.staffs.list_bartenders"
                                :key="key"
                                class="special-li"
                              >
                                {{list.name}}
                                <span
                                  class="float-right"
                                  @click="removeItemSelected(day, list, 'bartender')"
                                >
                                  <i class="far fa-times-circle mantainer-pointer"></i>
                                </span>
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
                            <select
                              v-if="percentages.cheff > 0"
                              class="form-control form-control-sm select-for-tips"
                              v-model="cheff"
                              @change="add_to_list('cheff', day)"
                            >
                              <option
                                v-for="(list, index) in day.list_staff"
                                :key="index"
                                :value="list"
                              >{{ list.name }}</option>
                            </select>
                          </div>

                          <div class="staff-selector-div8">
                            <ul class>
                              <li
                                v-for="(list, key) in day.staffs.list_cheffs"
                                :key="key"
                                class="special-li"
                              >
                                {{list.name}}
                                <span
                                  class="float-right"
                                  @click="removeItemSelected(day, list, 'cheff')"
                                >
                                  <i class="far fa-times-circle mantainer-pointer"></i>
                                </span>
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
                            <select
                              v-if="percentages.copper > 0"
                              class="form-control form-control-sm select-for-tips"
                              v-model="copper"
                              @change="add_to_list('copper', day)"
                            >
                              <option
                                v-for="(list, index) in day.list_staff"
                                :key="index"
                                :value="list"
                              >{{ list.name }}</option>
                            </select>
                          </div>

                          <div class="staff-selector-div10">
                            <ul class>
                              <li
                                v-for="(list, key) in day.staffs.list_coppers"
                                :key="key"
                                class="special-li"
                              >
                                {{list.name}}
                                <span
                                  class="float-right"
                                  @click="removeItemSelected(day, list, 'copper')"
                                >
                                  <i class="far fa-times-circle mantainer-pointer"></i>
                                </span>
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
        <div class="submit col-12"></div>
      </div>
    </div>

    <modal class="modal-calculadora" name="calculator-modal">
       
      <div class="vauchers-grid">       
        <div class="vauchers-grid-div1">
          <div class="title-calculate">
            <div>Calculadora de propinas</div>
          </div>
          <div class="description-calculate">
            Para calcular las propinas solo ingresa el o los montos a calcular
          </div>
          <div class="description-calculate">
            Ejemplo: [ 1000 + 2000 + 3000 + 6500 ]
          </div>
          
          <div class="div-calculadora">
            <textarea class="vauchers" v-model="vauchers_to_see.vauchers" rows="2"></textarea>
          </div>          
        </div>
        <div class="vauchers-grid-div2">
          <div class="description-calculate">
            Una vez ingresados los montos presiona
          </div>
          <i
            class="far fa-play-circle btn-vauchers"
            @click="totalizeVauchers(vauchers_to_see.type_amount, vauchers_to_see.key_day)"
          ></i>
        </div>
      </div>
    </modal>
  </div>
</template>
<script>
  import Notifications from "../mixins/Notifications.js"
  import Utilities     from "../mixins/Utilities.js"
  import Swal          from "sweetalert2"
  export default {
    name: "tips",
    mixins: [Notifications, Utilities],
    data() {
      return {
        loader : true,
        csrf   : document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content"),
        errors      : {},
        check_event : false,
        for_repeat_list_staff : [],
        historic_staff : [],
        list_days : [],
        list_staffs_in_work : [],
        garzon    : "",
        runner    : "",
        bartender : "",
        cheff     : "",
        copper    : "",
        work_day_selected: false,
        work_day_list : {
          night   : false,
          noon    : false,
          morning : false
        },
        percentages: {
          garzon    : 0,
          runner    : 0,
          bartender : 0,
          cheff     : 0,
          copper    : 0
        },
        data_head: {
          since: "",
          until: "",
          description: "",
          jornada: "",
          amounts: {
            cash   : 0,
            debit  : 0,
            credit : 0,
            total  : 0
          }
        },
        errors : {
          description : false,
          jornada     : false
        },
        exist_last         : this.existLast(),
        config_percentages : true,
        vauchers_to_see    : {}
      };
    },
    created() {
      this.getStaff()
      this.getStaffPercentages()
    },
    mounted() {
      this.loader = false
    },
    methods: {
      format(type_amount, key_day) {
        var vauchers_amounts = this.vauchers_to_see.vauchers.split("+")
        var day = this.list_days[key_day]
        var self = this;
        this.vauchers_to_see.vauchers = ""
        vauchers_amounts.forEach(function(vaucher) {
          if (Number.isInteger(parseInt(vaucher)) && !isNaN(vaucher * 1)) {
            day.vauchers += number_format(vaucher)
          }
        })
      },
      totalizeVauchers(type_amount, key_day) {
        var totalize = 0
        var vauchers_amounts = this.vauchers_to_see.vauchers.split("+")
        var day = this.list_days[key_day]
        var self = this
        vauchers_amounts.forEach(function(vaucher) {
          if (Number.isInteger(parseInt(vaucher)) && !isNaN(vaucher * 1)) {
            totalize += parseInt(vaucher)
          }
        })
        switch (type_amount) {
          case "cash":
            day.amounts.cash = totalize;
            this.list_days[key_day].vauchers.cash.total = totalize
            this.list_days[
              key_day
            ].vauchers.cash.detail = this.vauchers_to_see.vauchers

            break;
          case "debit":
            day.amounts.debit = totalize;
            this.list_days[key_day].vauchers.debit.total = totalize
            this.list_days[
              key_day
            ].vauchers.debit.detail = this.vauchers_to_see.vauchers

            break;
          case "credit":
            day.amounts.credit = totalize;
            this.list_days[key_day].vauchers.credit.total = totalize
            this.list_days[
              key_day
            ].vauchers.credit.detail = this.vauchers_to_see.vauchers

            break;
        }
        this.calculate(day);
        this.$modal.hide("calculator-modal", day);
      },
      showModalVauchers(type_amount, key_day) {
        var day = this.list_days[key_day];
        switch (type_amount) {
          case "cash":
            this.vauchers_to_see = {
              type_amount: type_amount,
              key_day: key_day,
              vauchers: day.vauchers.cash.detail
            };
            break;
          case "debit":
            this.vauchers_to_see = {
              type_amount: type_amount,
              key_day: key_day,
              vauchers: day.vauchers.debit.detail
            };
            break;
          case "credit":
            this.vauchers_to_see = {
              type_amount: type_amount,
              key_day: key_day,
              vauchers: day.vauchers.credit.detail
            };
            break;
        }
        this.$modal.show("calculator-modal", day)
      },
      hideModalVauchers() {
        this.$modal.hide("calculator-modal", {});
      },
      existLast() {
        var data = JSON.parse(localStorage.getItem("tips_work_day"));
        if (data) {
          return true;
        } else {
          return false;
        }
      },
      editLast() {
        var data = JSON.parse(localStorage.getItem("tips_work_day"));
        this.data_head = data.data_head;
        this.list_staffs_in_work = data.list_staffs_in_work;
        this.list_days = data.list_days;
        this.changeWorkDaySelected(this.data_head.jornada);
      },
      save() {
        this.validations();
      },
      validations() {
        var data = {
          _token: this.csrf,
          data_head: this.data_head,
          list_staffs_in_work: this.list_staffs_in_work,
          list_days: this.list_days,
          percentages: this.percentages
        }
        var error_head = this.validateHeads()
        var error_days = this.validateDays()
        if (!error_head && !error_days) {
          const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton : "btn btn-success",
              cancelButton  : "btn btn-danger"
            },
            buttonsStyling: false
          })
          var self = this
          var save_ok = false
          swalWithBootstrapButtons
            .fire({
              title : "¿Esta seguro de finalizar la gestión?",
              text  :  "Una vez guardado los datos no podras realizar cambios!",
              icon  :  "warning",
              showCancelButton: true,
              confirmButtonText: "Sí, seguro!",
              cancelButtonText:  "No, cancelar!",
              reverseButtons: true
            })
            .then(result => {
              if (result.value) {
                this.$http.post("/tips-store", data)
                .then(
                  response => {
                    self.ttSuccess(response.body.message)
                    localStorage.clear()
                    self.loader = true
                    setTimeout(function() {
                      self.$router.push({path: '/home'})
                    }, 3000)
                  },
                  response => {}
                );
              }
            })
        }
      },
      validateHeads() {
        var error_response = false;
        if (!this.data_head.jornada) {
          this.ttDanger("Debe seleccionar la jornada");
          this.errors.jornada = true;
          error_response = true;
        } else {
          this.errors.jornada = false;
          error_response = false;
        }
        if (!this.data_head.description) {
          this.ttDanger("Debe ingresar una descripción");
          this.errors.description = true;
          error_response = true;
        } else {
          this.errors.description = false;
          error_response = false;
        }
        return error_response;
      },
      validateDays() {
        var error_response = false;
        var self = this;
        this.list_days.forEach(function(row, index) {
          var total_amount_staff =
            parseInt(row.distribute.bartenders.unit) +
            parseInt(row.distribute.cheffs.unit) +
            parseInt(row.distribute.coppers.unit) +
            parseInt(row.distribute.garzones.unit) +
            parseInt(row.distribute.runners.unit);
          if (!row.day || row.day == null || row.day == "") {
            self.ttDanger(
              "Al día " +
                (parseInt(index) + parseInt(1)) +
                " no se le asigno fecha"
            );
            self.list_days[index].errors = true;
            error_response = true;
          } else if (row.amounts.total == 0) {
            self.ttDanger(
              "El día " + (parseInt(index) + parseInt(1)) + " no persenta montos"
            );
            self.list_days[index].errors = true;
            error_response = true;
          } else if (
            row.staffs.list_bartenders.length == 0 &&
            row.staffs.list_cheffs.length == 0 &&
            row.staffs.list_coppers.length == 0 &&
            row.staffs.list_garzones.length == 0 &&
            row.staffs.list_runners.length == 0
          ) {
            self.ttDanger(
              "El día " +
                (parseInt(index) + parseInt(1)) +
                " no tiene staff ingresado "
            );
            self.list_days[index].errors = true;
            error_response = true;
          } else {
            self.list_days[index].errors = false;
          }
        });
        return error_response;
      },
      neoListRepeat(list) {
        var new_list = [];
        list.forEach(function(row) {
          new_list.push(row);
        });
        return new_list;
      },
      repeatDay(day) {
        event.preventDefault();
        this.list_days.push({
          day: "",
          list_staff: this.neoListRepeat(day.list_staff),
          staffs: {
            list_garzones: this.neoListRepeat(day.staffs.list_garzones),
            list_runners: this.neoListRepeat(day.staffs.list_runners),
            list_bartenders: this.neoListRepeat(day.staffs.list_bartenders),
            list_cheffs: this.neoListRepeat(day.staffs.list_cheffs),
            list_coppers: this.neoListRepeat(day.staffs.list_coppers)
          },
          amounts: {
            cash: 0,
            debit: 0,
            credit: 0,
            other: 0,
            total: 0
          },
          distribute: {
            garzones: { total: 0, unit: 0 },
            runners: { total: 0, unit: 0 },
            bartenders: { total: 0, unit: 0 },
            cheffs: { total: 0, unit: 0 },
            coppers: { total: 0, unit: 0 }
          },
          errors: false,
          vauchers: {
            cash: { total: 0, detail: "" },
            debit: { total: 0, detail: "" },
            credit: { total: 0, detail: "" }
          }
        });
        this.calculate(day);
        this.recalculateFinalStaff();
        this.setLocalStorage();
      },
      removeDay(day) {
        var index_day = this.list_days.indexOf(day);
        if (index_day !== -1) {
          this.list_days.splice(index_day, 1);
        }
        this.recalculateFinalStaff();
        this.setLocalStorage();
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
      init() {
        if (!this.validateHeads()) {
          this.getStaff()
          this.addDay()
        }
      },
      getStaff() {
        this.commune_id = "";
        var self = this;
        this.$http.get("/staff-select-list").then(
          function(response) {
            self.for_repeat_list_staff = response.body;
            self.historic_staff = response.body;
          },
          function() {
            this.$toasted.global.APP_GENERAR_ERROR();
          }
        );
      },
      getStaffPercentages() {
        this.commune_id = "";
        var self = this;
        this.$http.get("/staff-percentages").then(
          function(response) {
            if (response.body.length > 0)
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
              });
            else {
              this.config_percentages = false;
              Swal.queue([
                {
                  title: "Error",
                  confirmButtonText: "Editar porcentaje",
                  text:
                    "No se ha encontrado una configuración válida para los porcentajes de Staff",
                  showLoaderOnConfirm: true,
                  preConfirm: () => {
                    self.$router.push({
                      path: "/home"
                    });
                  }
                }
              ]);
            }
          },
          function() {
            this.$toasted.global.APP_GENERAR_ERROR()
          }
        );
      },
      addDay() {
        event.preventDefault()
        this.list_days.push({
          day: "",
          list_staff: this.historic_staff,
          staffs: {
            list_garzones   : [],
            list_runners    : [],
            list_bartenders : [],
            list_cheffs     : [],
            list_coppers    : []
          },
          amounts: {
            cash   : 0,
            debit  : 0,
            credit : 0,
            other  : 0,
            total  : 0
          },
          distribute: {
            garzones   : { total: 0, unit: 0 },
            runners    : { total: 0, unit: 0 },
            bartenders : { total: 0, unit: 0 },
            cheffs     : { total: 0, unit: 0 },
            coppers    : { total: 0, unit: 0 }
          },
          errors: false,
          vauchers: {
            cash   : { total: 0, detail: "" },
            debit  : { total: 0, detail: "" },
            credit : { total: 0, detail: "" }
          }
        })
        this.setLocalStorage()
      },
      calculate(day) {
        var index_day = this.list_days.indexOf(day)
        var amounts   = this.list_days[index_day].amounts
        var cash      = isNaN(amounts.cash) ? 0 : amounts.cash
        var debit     = isNaN(amounts.debit) ? 0 : amounts.debit
        var credit    = isNaN(amounts.credit) ? 0 : amounts.credit
        var total_day = parseInt(cash) + parseInt(debit) + parseInt(credit)
        amounts.total = total_day
        this.list_days[index_day].amounts = amounts
        this.calculateTotal()
        this.calculateTotalTipStaff(index_day)
        this.calculateUnitTipStaff(index_day)
        this.recalculateFinalStaff()
        this.setLocalStorage()
      },
      calculateTotal() {
        this.data_head.amounts.cash   = 0
        this.data_head.amounts.debit  = 0
        this.data_head.amounts.credit = 0
        this.data_head.amounts.total  = 0
        var self = this
        this.list_days.forEach(function(row) {
          self.data_head.amounts.cash   =
            parseInt(self.data_head.amounts.cash) + parseInt(row.amounts.cash)
          self.data_head.amounts.debit  =
            parseInt(self.data_head.amounts.debit) + parseInt(row.amounts.debit)
          self.data_head.amounts.credit =
            parseInt(self.data_head.amounts.credit) +
            parseInt(row.amounts.credit)
          self.data_head.amounts.total  =
            parseInt(self.data_head.amounts.total) + parseInt(row.amounts.total)
        })
      },
      calculateTotalTipStaff(index_day) {
        this.list_days[index_day].distribute.garzones.total = Math.round(
          (parseInt(this.list_days[index_day].amounts.total) / 100) *
            this.percentages.garzon
        )
        this.list_days[index_day].distribute.runners.total = Math.round(
          (parseInt(this.list_days[index_day].amounts.total) / 100) *
            this.percentages.runner
        )
        this.list_days[index_day].distribute.bartenders.total = Math.round(
          (parseInt(this.list_days[index_day].amounts.total) / 100) *
            this.percentages.bartender
        )
        this.list_days[index_day].distribute.cheffs.total = Math.round(
          (parseInt(this.list_days[index_day].amounts.total) / 100) *
            this.percentages.cheff
        );
        this.list_days[index_day].distribute.coppers.total = Math.round(
          (parseInt(this.list_days[index_day].amounts.total) / 100) *
            this.percentages.copper
        );
      },
      calculateUnitTipStaff(index_day) {
        this.list_days[index_day].distribute.garzones.unit =
          this.list_days[index_day].staffs.list_garzones.length > 0
            ? Math.round(
                ((parseInt(this.list_days[index_day].amounts.total) / 100) *
                  this.percentages.garzon) /
                  this.list_days[index_day].staffs.list_garzones.length
              )
            : 0
        this.list_days[index_day].distribute.runners.unit =
          this.list_days[index_day].staffs.list_runners.length > 0
            ? Math.round(
                ((parseInt(this.list_days[index_day].amounts.total) / 100) *
                  this.percentages.runner) /
                  this.list_days[index_day].staffs.list_runners.length
              )
            : 0
        this.list_days[index_day].distribute.bartenders.unit =
          this.list_days[index_day].staffs.list_bartenders.length > 0
            ? Math.round(
                ((parseInt(this.list_days[index_day].amounts.total) / 100) *
                  this.percentages.bartender) /
                  this.list_days[index_day].staffs.list_bartenders.length
              )
            : 0
        this.list_days[index_day].distribute.cheffs.unit =
          this.list_days[index_day].staffs.list_cheffs.length > 0
            ? Math.round(
                ((parseInt(this.list_days[index_day].amounts.total) / 100) *
                  this.percentages.cheff) /
                  this.list_days[index_day].staffs.list_cheffs.length
              )
            : 0
        this.list_days[index_day].distribute.coppers.unit =
          this.list_days[index_day].staffs.list_coppers.length > 0
            ? Math.round(
                ((parseInt(this.list_days[index_day].amounts.total) / 100) *
                  this.percentages.copper) /
                  this.list_days[index_day].staffs.list_coppers.length
              )
            : 0
      },
      add_to_list(list, day) {
        switch (list) {
          case "garzon":
            if (this.garzon) {
              var index_day = this.list_days.indexOf(day)
              this.list_days[index_day].staffs.list_garzones.push(this.garzon)
              this.removeItemInListStaffDay(this.garzon, index_day)
              var old_unit = this.list_days[index_day].distribute.garzones.unit
              this.calculate(day)
              var unit = this.list_days[index_day].distribute.garzones.unit
              this._add_or_less_new_tip_unit_to_staff(unit, index_day, "garzon")
              this.calculate(day)
            }
            break;
          case "runner":
            if (this.runner) {
              var index_day = this.list_days.indexOf(day)
              this.list_days[index_day].staffs.list_runners.push(this.runner)
              this.removeItemInListStaffDay(this.runner, index_day)
              var old_unit = this.list_days[index_day].distribute.runners.unit
              this.calculate(day)
              var unit = this.list_days[index_day].distribute.runners.unit
              this._add_or_less_new_tip_unit_to_staff(unit, index_day, "runner")
              this.calculate(day)
            }
            break;
          case "bartender":
            if (this.bartender) {
              var index_day = this.list_days.indexOf(day)
              this.list_days[index_day].staffs.list_bartenders.push(
                this.bartender
              )
              this.removeItemInListStaffDay(this.bartender, index_day)
              var old_unit = this.list_days[index_day].distribute.bartenders.unit
              this.calculate(day)
              var unit = this.list_days[index_day].distribute.bartenders.unit
              this._add_or_less_new_tip_unit_to_staff(
                unit,
                index_day,
                "bartender"
              )
              this.calculate(day)
            }
            break;
          case "cheff":
            if (this.cheff) {
              var index_day = this.list_days.indexOf(day)
              this.list_days[index_day].staffs.list_cheffs.push(this.cheff)
              this.removeItemInListStaffDay(this.cheff, index_day)
              var old_unit = this.list_days[index_day].distribute.cheffs.unit
              this.calculate(day)
              var unit = this.list_days[index_day].distribute.cheffs.unit
              this._add_or_less_new_tip_unit_to_staff(unit, index_day, "cheff")
              this.calculate(day)
            }
            break;
          case "copper":
            if (this.copper) {
              var index_day = this.list_days.indexOf(day)
              this.list_days[index_day].staffs.list_coppers.push(this.copper)
              this.removeItemInListStaffDay(this.copper, index_day)
              var old_unit = this.list_days[index_day].distribute.coppers.unit
              this.calculate(day)
              var unit = this.list_days[index_day].distribute.coppers.unit
              this._add_or_less_new_tip_unit_to_staff(unit, index_day, "copper")
              this.calculate(day)
            }
            break;
        }
        this.setLocalStorage();
      },
      removeItemSelected(day, item_list, type) {
        var index_day = ""
        var index_item_list = ""
        switch (type) {
          case "garzon":
            index_day = this.list_days.indexOf(day)
            index_item_list = this.list_days[
              index_day
            ].staffs.list_garzones.indexOf(item_list)
            if (index_item_list !== -1) {
              this.list_days[index_day].staffs.list_garzones.splice(
                index_item_list,
                1
              )
            }
            this.list_days[index_day].list_staff.push(item_list)
            var old_unit = this.list_days[index_day].distribute.garzones.unit
            this.calculate(day)
            var unit = this.list_days[index_day].distribute.garzones.unit
            this._add_or_less_new_tip_unit_to_staff(unit, index_day, "garzon")
            this._removeStaffInFinalList(item_list)
            break;
          case "runner":
            index_day = this.list_days.indexOf(day)
            index_item_list = this.list_days[
              index_day
            ].staffs.list_runners.indexOf(item_list)
            if (index_item_list !== -1) {
              this.list_days[index_day].staffs.list_runners.splice(
                index_item_list,
                1
              )
            }
            this.list_days[index_day].list_staff.push(item_list)
            var old_unit = this.list_days[index_day].distribute.runners.unit
            this.calculate(day)
            var unit = this.list_days[index_day].distribute.runners.unit
            this._add_or_less_new_tip_unit_to_staff(unit, index_day, "runner")
            this._removeStaffInFinalList(item_list)
            break;
          case "bartender":
            index_day = this.list_days.indexOf(day)
            index_item_list = this.list_days[
              index_day
            ].staffs.list_bartenders.indexOf(item_list)
            if (index_item_list !== -1) {
              this.list_days[index_day].staffs.list_bartenders.splice(
                index_item_list,
                1
              )
            }
            this.list_days[index_day].list_staff.push(item_list)
            var old_unit = this.list_days[index_day].distribute.bartenders.unit
            this.calculate(day)
            var unit = this.list_days[index_day].distribute.runners.unit
            this._add_or_less_new_tip_unit_to_staff(unit, index_day, "bartender")
            this._removeStaffInFinalList(item_list)
            break;
          case "cheff":
            index_day = this.list_days.indexOf(day)
            index_item_list = this.list_days[
              index_day
            ].staffs.list_cheffs.indexOf(item_list)
            if (index_item_list !== -1) {
              this.list_days[index_day].staffs.list_cheffs.splice(
                index_item_list,
                1
              )
            }
            this.list_days[index_day].list_staff.push(item_list)
            var old_unit = this.list_days[index_day].distribute.cheffs.unit
            this.calculate(day)
            var unit = this.list_days[index_day].distribute.cheffs.unit
            this._add_or_less_new_tip_unit_to_staff(unit, index_day, "cheff")
            this._removeStaffInFinalList(item_list)
            break;
          case "copper":
            index_day = this.list_days.indexOf(day)
            index_item_list = this.list_days[
              index_day
            ].staffs.list_coppers.indexOf(item_list)
            if (index_item_list !== -1) {
              this.list_days[index_day].staffs.list_coppers.splice(
                index_item_list,
                1
              )
            }
            this.list_days[index_day].list_staff.push(item_list)
            var old_unit = this.list_days[index_day].distribute.coppers.unit
            this.calculate(day)
            var unit = this.list_days[index_day].distribute.runners.unit
            this._add_or_less_new_tip_unit_to_staff(unit, index_day, "copper")
            this._removeStaffInFinalList(item_list)
            break;
        }
        this.setLocalStorage()
      },
      removeItemInListStaffDay(item, index_day) {
        event.preventDefault()
        var index = this.list_days[index_day].list_staff.indexOf(item)
        if (index !== -1) {
          this.list_days[index_day].list_staff.splice(index, 1)
        }
        this.setLocalStorage()
      },
      _removeStaffInFinalList(staff) {
        event.preventDefault()
        var to_be = false
        var self = this
        this.list_days.forEach(function(day) {
          var index_garzones = self.__suport_removeStaffInFinalList(
            day.staffs.list_garzones,
            staff.id
          )
          var index_runners = self.__suport_removeStaffInFinalList(
            day.staffs.list_runners,
            staff.id
          )
          var index_bartenders = self.__suport_removeStaffInFinalList(
            day.staffs.list_bartenders,
            staff.id
          )
          var index_coppers = self.__suport_removeStaffInFinalList(
            day.staffs.list_cheffs,
            staff.id
          )
          var index_cheffs = self.__suport_removeStaffInFinalList(
            day.staffs.list_coppers,
            staff.id
          )
          if (
            index_garzones ||
            index_runners ||
            index_bartenders ||
            index_coppers ||
            index_cheffs
          ) {
            to_be = true
          }
        })
        if (!to_be) {
          this.list_staffs_in_work.forEach(function(row, index) {
            if (row.id == staff.id) {
              self.list_staffs_in_work.splice(index, 1)
            }
          })
        }
      },
      __suport_removeStaffInFinalList(day, staff_id) {
        var to_be = false
        day.forEach(function(row) {
          if (row.id == staff_id) {
            to_be = true
          }
        });
        return to_be
      },
      isNumber: function(evt) {
        evt = evt ? evt : window.event
        var charCode = evt.which ? evt.which : evt.keyCode
        if (
          charCode > 31 &&
          (charCode < 48 || charCode > 57) &&
          charCode !== 46
        ) {
          evt.preventDefault()
        } else {
          return true
        }
      },
      _add_or_less_new_tip_unit_to_staff(unit, day, _case, id_staff) {
        var self = this
        switch (_case) {
          case "garzon":
            this.list_days[day].staffs.list_garzones.forEach(function(row, key) {
              self.list_days[day].staffs.list_garzones[key].total_tips = unit
            })
            break
          case "runner":
            this.list_days[day].staffs.list_runners.forEach(function(row, key) {
              self.list_days[day].staffs.list_runners[key].total_tips = unit
            })
            break
          case "bartender":
            this.list_days[day].staffs.list_bartenders.forEach(function(
              row,
              key
            ) {
              self.list_days[day].staffs.list_bartenders[key].total_tips = unit
            })
            break
          case "cheff":
            this.list_days[day].staffs.list_cheffs.forEach(function(row, key) {
              self.list_days[day].staffs.list_cheffs[key].total_tips = unit
            })
            break
          case "copper":
            this.list_days[day].staffs.list_coppers.forEach(function(row, key) {
              self.list_days[day].staffs.list_coppers[key].total_tips = unit
            })
            break
        }
      },
      _totalizeTotalTipsForStaff() {
        this.list_staffs_in_work = [];
        var self = this;
        this.list_days.forEach(function(day) {
          self.___support_one_totalize_amount_staff(day);
        });
      },
      ___support_one_totalize_amount_staff(day) {
        var self = this
        day.staffs.list_garzones.forEach(function(row) {
          self.___support_two_totalize_amount_staff(row)
        })
        day.staffs.list_runners.forEach(function(row) {
          self.___support_two_totalize_amount_staff(row)
        })
        day.staffs.list_bartenders.forEach(function(row) {
          self.___support_two_totalize_amount_staff(row)
        })
        day.staffs.list_cheffs.forEach(function(row) {
          self.___support_two_totalize_amount_staff(row)
        })
        day.staffs.list_coppers.forEach(function(row) {
          self.___support_two_totalize_amount_staff(row)
        })
      },
      ___support_two_totalize_amount_staff(_case) {
        var data = {
          id: _case.id,
          name: _case.name,
          total_tips: _case.total_tips
        }
        if (this.list_staffs_in_work.length == 0) {
          this.list_staffs_in_work.push(data)
        } else {
          var to_be = false
          var index_update = false
          this.list_staffs_in_work.forEach(function(final_staff, index) {
            if (final_staff.id == _case.id) {
              to_be = true
              index_update = index
            }
          })
          if (to_be) {
            this.list_staffs_in_work[index_update].total_tips += _case.total_tips
          } else {
            this.list_staffs_in_work.push(data)
          }
        }
      },
      recalculateFinalStaff() {
        this.list_staffs_in_work = []
        var self = this
        this.list_days.forEach(function(day) {
          self.____support_recalculateFinalStaff(day)
        })
      },
      ____support_recalculateFinalStaff(day) {
        var self = this
        day.staffs.list_garzones.forEach(function(row) {
          row.total_tips = day.distribute.garzones.unit
          self.____support_recalculateFinalStaff_b(day, row)
        })
        day.staffs.list_runners.forEach(function(row) {
          row.total_tips = day.distribute.runners.unit
          self.____support_recalculateFinalStaff_b(day, row)
        })
        day.staffs.list_bartenders.forEach(function(row) {
          row.total_tips = day.distribute.bartenders.unit
          self.____support_recalculateFinalStaff_b(day, row)
        })
        day.staffs.list_cheffs.forEach(function(row) {
          row.total_tips = day.distribute.cheffs.unit
          self.____support_recalculateFinalStaff_b(day, row)
        })
        day.staffs.list_coppers.forEach(function(row) {
          row.total_tips = day.distribute.coppers.unit
          self.____support_recalculateFinalStaff_b(day, row)
        })
      },
      ____support_recalculateFinalStaff_b(day, _case) {
        if (this.list_staffs_in_work.length == 0) {
          this.list_staffs_in_work.push({
            id: _case.id,
            name: _case.name,
            total_tips: _case.total_tips
          })
        } else {
          var to_be = false
          var index_update = false
          this.list_staffs_in_work.forEach(function(final_staff, index) {
            if (final_staff.id == _case.id) {
              to_be = true
              index_update = index
            }
          })
          if (to_be) {
            this.list_staffs_in_work[index_update].total_tips += _case.total_tips
          } else {
            this.list_staffs_in_work.push({
              id: _case.id,
              name: _case.name,
              total_tips: _case.total_tips
            })
          }
        }
      },
      setLocalStorage() {
        localStorage.clear()
        var data = {
          _token: this.csrf,
          data_head: this.data_head,
          list_staffs_in_work: this.list_staffs_in_work,
          list_days: this.list_days,
          percentages: this.percentages
        }
        localStorage.setItem("tips_work_day", JSON.stringify(data))
      }
    },

    filters: {
      upper: function(value) {
        return value.toUpperCase();
      }
    }
  }
</script>
<style>
    .vauchers {
      height: 90px!important;
      width: 70%!important;
      margin: 5px 60px!important;
      padding:3px 5px!important;
    }
    .vauchers-grid {
      display               : grid;
      grid-template-columns : 1fr;
      grid-template-rows    : repeat(2, 1fr);
      grid-column-gap       : 0px;
      grid-row-gap          : 0px;
            text-align: center!important;

    }
    .vauchers-grid-div1 {
      grid-area : 1 / 1 / 2 / 2;
    }
    .vauchers-grid-div1 .title-calculate {
      padding: 15px!important;
      font-size: 20px!important;
      color: #f5a623 !important;
    }

    .vauchers-grid-div1 .description-calculate {
      padding: 0px 25px!important;
      font-size: 12px!important;
      color: #fff !important;
    }
    .vauchers-grid-div2 {
      grid-area  : 2 / 1 / 3 / 2;
      text-align : center;
      color      : #f5a623 !important;
      font-size  : 25px;
    }

    .vauchers-grid-div2 .description-calculate {
      padding: 0px 25px!important;
      font-size: 12px!important;
      color: #fff !important;
    }
    .btn-vauchers {
      cursor     : pointer;
      font-size  : 20px!important;
    }
    .btn-vauchers:hover {
      font-size           : 30;
      color               : #ffbf00 !important;
      transition-duration : 0.4s;
      -webkit-transform:scale(1.3);transform:scale(1.3);
    }

      .v--modal-box {
        background-color: #394f62 !important;
      }

    .vauchers {
      background-color: #54657d !important;
      margin-top: 25px;
      margin-right: 40px;
      margin-bottom: 25px;
      margin-left: 40px;
      padding: 20px;
      color: #f5a623 !important;
    }

    .fa-exclamation-triangle {
      color: red !important;
      font-size: 10px;
      margin-left: 3px;
    }

    .fa-users,
    .fa-user {
      font-size: 11px;
    }

    .btn-events {
      margin-left: 100px !important;
      margin-right: 100px !important;
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
      background-color: #323f4f !important;
      -webkit-box-shadow: 10px 10px 5px -6px rgba(0, 0, 0, 0.75);
      -moz-box-shadow: 10px 10px 5px -6px rgba(0, 0, 0, 0.75);
      box-shadow: 10px 10px 5px -6px rgba(0, 0, 0, 0.75);
    }

    .card-tip-day {
      background-color: #323f4f !important;
      padding-top: 15px !important;
      padding-bottom: 15px !important;
      margin-right: 15px !important;
      margin-top: 0px !important;
      padding-top: 15px !important;
      padding-bottom: 15px !important;
      margin-right: 15px !important;
      margin-top: 0px !important;
      -webkit-box-shadow: 10px 10px 5px -6px rgba(0, 0, 0, 0.75);
      -moz-box-shadow: 10px 10px 5px -6px rgba(0, 0, 0, 0.75);
      box-shadow: 10px 10px 5px -6px rgba(0, 0, 0, 0.75);
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
      font-size: 11px !important;
      background-color: #04b431;
      color: whitesmoke;
      padding: 5px;
      padding-left: 15px;
      margin-bottom: 5px;
      -webkit-box-shadow: 0px 0px 11px -2px rgba(0, 0, 0, 0.75);
      -moz-box-shadow: 0px 0px 11px -2px rgba(0, 0, 0, 0.75);
      box-shadow: 0px 0px 11px -2px rgba(0, 0, 0, 0.75);
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
      border-top: solid 0.7px;
      margin-top: 10px;
      padding-top: 10px;
      border-color: #f5a623 !important;
    }

    .staff-selector-div1 {
      margin-right: 3px;
      grid-area: 1 / 1 / 2 / 2;
    }
    .staff-selector-div2 {
      margin-top: 10px;
      margin-right: 3px;
      grid-area: 2 / 1 / 3 / 2;
    }
    .staff-selector-div3 {
      margin-right: 3px;
      grid-area: 1 / 2 / 2 / 3;
    }
    .staff-selector-div4 {
      margin-top: 10px;
      margin-right: 3px;
      grid-area: 2 / 2 / 3 / 3;
    }
    .staff-selector-div5 {
      margin-right: 3px;
      grid-area: 1 / 3 / 2 / 4;
    }
    .staff-selector-div6 {
      margin-top: 10px;
      margin-right: 3px;
      grid-area: 2 / 3 / 3 / 4;
    }
    .staff-selector-div7 {
      margin-right: 3px;
      grid-area: 1 / 4 / 2 / 5;
    }
    .staff-selector-div8 {
      margin-top: 10px;
      margin-right: 3px;
      grid-area: 2 / 4 / 3 / 5;
    }
    .staff-selector-div9 {
      margin-right: 3px;
      grid-area: 1 / 5 / 2 / 6;
    }
    .staff-selector-div10 {
      margin-top: 10px;
      margin-right: 3px;
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
      text-align: right;
      grid-area: 2 / 2 / 3 / 3;
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

    .input-for-tips {
      height: 1em !important;
      padding-top: 15px !important;
      padding-bottom: 15px !important;
      text-align: right;
    }

    .select-for-tips {
      height: 1em !important;
      padding-top: 5px !important;
      padding-bottom: 5px !important;
    }

    .tips-divisor {
      border-color: #f5a623 !important;
      margin: 10px !important;
    }

    .tips-event-init {
      margin-top: 15px;
      color: #f5a623 !important;
      font-size: 30px;
      cursor: pointer;
    }

    .tips-event-continue {
      margin-top: 15px;
      color: #f5a623 !important;
      font-size: 30px;
      cursor: pointer;
    }

    .tips-event-save {
      float: center;
      color: #53c491;
      font-size: 30px;
      cursor: pointer;
    }

    .tips-event-cancel {
      float: center;
      color: #b83e3e;
      font-size: 30px;
      cursor: pointer;
    }

    .tips-event-plus {
      float: center;
      color: #6e63fb;
      font-size: 30px;
      cursor: pointer;
    }

    .total-accumulated {
      color: #f5a623 !important;
      cursor: pointer;
    }

    .fa-calculator {
      font-size   : 10px;
    }
    .day-define{
      color       : #f5a623 !important;
      font-weight : bold;

    }

    .input-date {
      padding: 5px 15px 25px!important;
    }
 
</style>

@endsection