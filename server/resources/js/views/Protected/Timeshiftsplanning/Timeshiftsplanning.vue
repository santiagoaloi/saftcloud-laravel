<template>
  <div>
    <base-flex-container>
      <template #top>
        <div class="d-flex align-center">
          <v-tooltip bottom max-width="250">
            <template #activator="{ on }">
              <v-btn icon class="ma-2" v-on="on" @click="$refs.calendar.prev()">
                <v-icon>mdi-chevron-left</v-icon>
              </v-btn>
            </template>
            Previous Month
          </v-tooltip>
          <!-- 
          <v-responsive width="170">
            <v-toolbar-title v-if="$refs.calendar">
              {{ $refs.calendar.title }}
            </v-toolbar-title>
          </v-responsive> -->

          <v-menu
            v-model="selectedDateTrigger"
            :close-on-content-click="false"
            transition="scale-transition"
            offset-y
            min-width="auto"
          >
            <template #activator="{ on }">
              <v-btn class="mx-2" color="#393d47" v-on="on">
                <v-tooltip bottom max-width="250">
                  <template #activator="{ on }">
                    <v-icon left class="mr-5" v-on="on" @click.stop="previousDay()"> mdi-chevron-left</v-icon>
                  </template>
                  Previous day
                </v-tooltip>

                {{ calendar }}

                <v-tooltip bottom max-width="250">
                  <template #activator="{ on }">
                    <v-icon right class="ml-5" v-on="on" @click.stop="nextDay()"> mdi-chevron-right</v-icon>
                  </template>
                  Next day
                </v-tooltip>
              </v-btn>
            </template>
            <v-date-picker v-model="calendar" show-week no-title scrollable @change="selectedDateTrigger = false">
            </v-date-picker>
          </v-menu>

          <v-select
            v-model="type"
            :menu-props="{ 'transition': 'slide-y-transition', 'offset-y': true }"
            item-color="bluegrey"
            :items="types"
            dense
            hide-details
            class="ma-2"
            label="type"
            solo
          >
            <template #selection="{ item, index }">
              <v-chip small>
                <span> Displaying {{ item }} view</span>
              </v-chip>
            </template>
          </v-select>
          <v-select
            v-if="type !== 'month'"
            v-model="mode"
            :menu-props="{ 'transition': 'slide-y-transition', 'offset-y': true }"
            item-color="bluegrey"
            :items="modes"
            dense
            solo
            hide-details
            label="event-overlap-mode"
            class="ma-2"
          >
            <template #selection="{ item, index }">
              <v-chip small>
                <span> {{ item }} format </span>
              </v-chip>
            </template>
          </v-select>
          <v-select
            v-model="weekday"
            :menu-props="{ 'transition': 'slide-y-transition', 'offset-y': true }"
            item-color="bluegrey"
            :items="weekdays"
            dense
            solo
            hide-details
            label="weekdays"
            class="ma-2"
          ></v-select>

          <v-tooltip bottom>
            <template #activator="{ on }">
              <v-btn small fab icon v-on="on" @click="openTimeShiftDialog()"> <v-icon> mdi-plus</v-icon></v-btn>
            </template>
            <span>Add new event</span>
          </v-tooltip>

          <v-btn color="#393d47" class="ma-2" @click="clearEvents()"> <v-icon left>mdi-close</v-icon> Clear events </v-btn>

          <v-tooltip bottom max-width="250">
            <template #activator="{ on }">
              <v-btn icon class="ma-2" v-on="on" @click="$refs.calendar.next()">
                <v-icon>mdi-chevron-right</v-icon>
              </v-btn>
            </template>
            Next Month
          </v-tooltip>

          <!-- <v-btn v-if="type === 'day'" icon @click="type = 'month'">
            <v-icon>mdi-close</v-icon>
          </v-btn> -->
        </div>
      </template>

      <v-calendar
        ref="calendar"
        v-model="calendar"
        show-week
        :weekdays="weekday"
        :type="type"
        :events="events"
        :event-overlap-mode="mode"
        :event-overlap-threshold="30"
        :event-color="getEventColor"
        interval-height="100"
        first-interval="9"
        interval-count="7"
        :categories="categories"
        category-show-all
        @click:event="eventDay"
        @change="getEvents"
      >
        <template v-if="type === 'day'" #event="{ event, timed, eventSummary }">
          <v-card color="#222530" flat tile height="100%">
            <v-list-item>
              <v-hover>
                <v-hover v-slot="{ hover }">
                  <v-list-item-avatar v-if="!hover">
                    <v-img :src="`https://i.pravatar.cc/150?img=${Math.random().toFixed(2)}`">
                      <template #placeholder>
                        <v-row class="fill-height ma-0" align="center" justify="center">
                          <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                        </v-row>
                      </template>
                    </v-img>
                  </v-list-item-avatar>

                  <v-list-item-avatar v-else>
                    <v-tooltip bottom>
                      <template #activator="{ on }">
                        <v-btn color="white" outlined text fab icon @click="removeEventTrigger(event)" v-on="on">
                          <v-icon> mdi-delete-outline</v-icon>
                        </v-btn>
                      </template>
                      {{ event.name }}
                    </v-tooltip>
                  </v-list-item-avatar>
                </v-hover>
              </v-hover>

              <v-list-item-content>
                <v-list-item-title> {{ event.name }} </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-card>
        </template>

        <template #day-label="{ day, date }">
          <div v-if="type === 'month'" class="d-flex justify-center align-center pa-5">
            <v-btn
              fab
              :icon="date !== calendar ? true : false"
              :color="date === calendar ? 'primary' : null"
              x-small
              @click="viewDay(date)"
              >{{ day }}
            </v-btn>
          </div>
        </template>

        <template #category="{ category }">
          <div class="text-center mb-4">
            <v-avatar size="80" :color="iconColor">
              <v-img :src="`https://i.pravatar.cc/150?img=${Math.floor(Math.random() * 10)}`">
                <template #placeholder>
                  <v-row class="fill-height ma-0" align="center" justify="center">
                    <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                  </v-row>
                </template>
              </v-img>
            </v-avatar>
          </div>

          <div class="text-center">{{ category }}</div>
          <!-- <v-img :src="getCategoryImage(category)"></v-img> -->
        </template>

        <template #day-body="{ day, date }">
          <div class="d-flex justify-center align-center pa-5">
            <v-btn
              fab
              :icon="date !== calendar ? true : false"
              :color="date === calendar ? 'primary' : null"
              x-small
              @click="viewDay(date)"
              >{{ day }}
            </v-btn>
          </div>
        </template>
      </v-calendar>
    </base-flex-container>

    <base-dialog
      v-if="dialogRemoveEvent"
      v-model="dialogRemoveEvent"
      width="40vw"
      title="Remove event"
      icon="mdi-delete-outline"
      persistent
      close-only
      @close="dialogRemoveEvent = false"
    >
      <v-card-text>
        <p class="text-h5 text--primary">Are you sure you want to remove {{ removeName }} ?</p>
        <p class="mt-n3">This action cannot be undone</p>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn large color="primary" @click="dialogRemoveEvent = false"> Cancel </v-btn>
        <v-btn large color="primary" @click="removeEvent()"> <v-icon left> mdi-delete-outline</v-icon> Remove </v-btn>
      </v-card-actions>
    </base-dialog>

    <base-dialog
      v-if="dialogTimeShift"
      v-model="dialogTimeShift"
      width="50vw"
      title="Time shift"
      icon="mdi-calendar-account"
      persistent
      @save="validateEventForm()"
      @close="closeDialogTimeShift()"
    >
      <v-form @submit.prevent="validateEventForm()">
        <ValidationObserver ref="eventForm" slim>
          <v-row>
            <v-col sm="6">
              <baseFieldLabel required label="Employee" />
              <validation-provider v-slot="{ errors }" name="Employee" rules="required">
                <v-autocomplete
                  v-model="selectedEmployee"
                  :error="errors.length > 0"
                  :error-messages="errors[0]"
                  return-object
                  :menu-props="{ 'transition': 'slide-y-transition', 'offset-y': true }"
                  item-color="bluegrey"
                  :multiple="!editing"
                  hide-details
                  :items="allUsers"
                  hide-no-data
                  :item-text="
                    (item) => {
                      return fullEmployeeName(item);
                    }
                  "
                  dense
                  solo
                  height="55"
                  :background-color="isDark ? '#28292b' : 'white'"
                >
                  <template v-if="!editing" #prepend-item>
                    <v-list-item @click="toggleEmployees">
                      <v-list-item-avatar size="25">
                        <v-icon :color="selectedEmployee.length > 0 ? 'white' : ''">
                          {{ icon }}
                        </v-icon>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-title> Select All Employees </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-divider></v-divider>
                  </template>

                  <template #item="data">
                    <v-list-item-avatar size="25">
                      <v-img :src="`https://i.pravatar.cc/150?img=${Math.floor(Math.random() * 10)}`">
                        <template #placeholder>
                          <v-row class="fill-height ma-0" align="center" justify="center">
                            <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                          </v-row>
                        </template>
                      </v-img>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-title> {{ fullEmployeeName(data.item) }} </v-list-item-title>
                    </v-list-item-content>
                  </template>

                  <template #selection="{ item, index }">
                    <v-chip v-if="index === 0">
                      <v-avatar left>
                        <v-img :src="item.avatar || 'storage/defaults/avatar.png'">
                          <template #placeholder>
                            <v-row class="fill-height ma-0" align="center" justify="center">
                              <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                            </v-row>
                          </template>
                        </v-img>
                      </v-avatar>
                      <span>{{ fullEmployeeName(item) }}</span>
                    </v-chip>
                    <span v-if="index === 1" class="white--text"> (+{{ selectedEmployee.length - 1 }} others) </span>
                  </template>
                </v-autocomplete>
              </validation-provider>
            </v-col>

            <v-col sm="6">
              <baseFieldLabel required label="Full time" />
              <v-switch v-model="fullTime" inset hide-details class="mt-4 ml-2" color="indigo lighten-2" />
            </v-col>

            <v-col cols="6">
              <v-menu
                ref="menu"
                v-model="menuStart"
                :close-on-content-click="false"
                :return-value.sync="event.date"
                transition="scale-transition"
                offset-y
                min-width="auto"
              >
                <template #activator="{ on, attrs }">
                  <baseFieldLabel required label="Start Date" />
                  <validation-provider v-slot="{ errors }" name="Date" rules="required">
                    <v-text-field
                      :value="computedDateFormattedMomentjs"
                      :error="errors.length > 0"
                      :error-messages="errors[0]"
                      height="55"
                      solo
                      prepend-inner-icon="mdi-calendar"
                      :outlined="isDark"
                      :color="isDark ? '#208ad6' : 'grey'"
                      :background-color="isDark ? '#28292b' : 'white'"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </validation-provider>
                </template>
                <v-date-picker v-model="event.date" range show-week no-title scrollable @change="$refs.menu.save(event.date)">
                </v-date-picker>
              </v-menu>
            </v-col>
            <v-col sm="3">
              <baseFieldLabel required label="Start Time" />
              <validation-provider v-slot="{ errors }" name="Start time" rules="required">
                <v-select
                  v-model="event.timeStart"
                  :menu-props="{ 'transition': 'slide-y-transition', 'offset-y': true }"
                  :error="errors.length > 0"
                  :error-messages="errors[0]"
                  item-color="bluegrey"
                  height="55"
                  :background-color="isDark ? '#28292b' : 'white'"
                  :items="hours"
                  hide-no-data
                  solo
                  :disabled="fullTime"
                  hide-details
                  prepend-inner-icon="mdi-clock-outline"
                />
              </validation-provider>
            </v-col>

            <v-col sm="3">
              <baseFieldLabel required label="End Time" />
              <validation-provider v-slot="{ errors }" name="End time" rules="required">
                <v-select
                  v-model="event.timeEnd"
                  :menu-props="{ 'transition': 'slide-y-transition', 'offset-y': true }"
                  :error="errors.length > 0"
                  :error-messages="errors[0]"
                  item-color="bluegrey"
                  height="55"
                  :background-color="isDark ? '#28292b' : 'white'"
                  :items="hours"
                  hide-no-data
                  solo
                  :disabled="fullTime"
                  hide-details
                  prepend-inner-icon="mdi-clock-outline"
                />
              </validation-provider>
            </v-col>
          </v-row>
        </ValidationObserver>
        <v-btn v-show="false" type="submit" />
      </v-form>
    </base-dialog>
  </div>
</template>

<script>
  import { v4 as uuidv4 } from 'uuid';
  import { sync, call } from 'vuex-pathify';
  import moment from 'moment';
  import { capitalize } from 'lodash';
  import activeView from '@/mixins/activeView';
  import { store } from '@/store';

  const initialEvent = () => ({
    date: '',
    timeStart: '',
    timeEnd: '',
    category: '',
  });

  export default {
    name: 'Timeshiftsplanning',
    mixins: [activeView],
    events: {
      timeShiftsPlanningCalNext() {
        this.calNext();
      },
    },
    data: () => ({
      selectedEmployee: [],
      calKey: 0,
      eventIndex: 0,
      editing: false,
      event: initialEvent(),
      selectedDate: '',
      fullTime: false,
      selectedDateTrigger: false,
      menuStart: false,
      menuEnd: false,
      hours: [
        '09:00',
        '09:15',
        '09:30',
        '09:45',
        '10:00',
        '10:15',
        '10:30',
        '10:45',
        '11:00',
        '11:15',
        '11:30',
        '11:45',
        '12:00',
        '12:15',
        '12:30',
        '12:45',
        '13:00',
        '13:15',
        '13:30',
        '13:45',
        '14:00',
        '14:15',
        '14:30',
        '14:45',
        '15:00',
      ],

      // employees: ['Pablo', 'Rene', 'Santiago'],
      dialogTimeShift: false,
      type: 'month',
      types: ['month', 'week', 'day', '4day', 'category'],
      mode: 'column',
      modes: ['stack', 'column'],
      weekday: [0, 1, 2, 3, 4, 5, 6],
      weekdays: [
        { text: 'Sun - Sat', value: [0, 1, 2, 3, 4, 5, 6] },
        { text: 'Mon - Sun', value: [1, 2, 3, 4, 5, 6, 0] },
        { text: 'Mon - Fri', value: [1, 2, 3, 4, 5] },
        { text: 'Mon, Wed, Fri', value: [1, 3, 5] },
      ],
      calendar: moment().format('YYYY-MM-DD'),

      dialogRemoveEvent: false,
      removeId: '',
      removeName: '',
      hello: '',
    }),
    computed: {
      ...sync('eventsManagement', ['events']),
      ...sync('entitiesManagement', ['allUsers']),

      categories() {
        return this.allUsers.map((user) => this.fullEmployeeName(user));
      },

      computedDateFormattedMomentjs() {
        return `${moment(this.event.date[0]).format('MMMM Do YYYY')} to ${moment(this.event.date[1]).format('MMMM Do YYYY')}`;
      },

      icon() {
        if (this.selectedAllEmployees) return 'mdi-close-box';
        if (this.selectedSomeEmployees) return 'mdi-minus-box';
        return 'mdi-checkbox-blank-outline';
      },

      selectedAllEmployees() {
        return this.selectedEmployee.length === this.allUsers.length;
      },

      selectedSomeEmployees() {
        return this.selectedEmployee.length > 0 && !this.selectedAllEmployees;
      },

      selectedDatetimeStart() {
        if (this.event.date && this.event.timeStart) {
          return `${this.event.date} ${this.event.timeStart}`;
        }
        return null;
      },

      selectedDatetimeEnd() {
        if (this.event.date && this.event.timeEnd) {
          return `${this.event.date} ${this.event.timeEnd}`;
        }
        return null;
      },
    },

    watch: {
      fullTime: {
        handler(val) {
          if (val) {
            [this.event.timeStart] = this.hours;
            this.event.timeEnd = this.hours[this.hours.length - 1];
          }
        },
        deep: true,
      },
    },

    methods: {
      ...call('snackbar/*'),

      // getCategoryImage(category){

      // let user = this.events.find((user) => user.name === category)

      // },

      calNext() {
        this.$refs.calendar.next();
      },

      getEvents({ start }) {
        const month = moment().month(start.month).format('MMMM');
        this.titleBarSlot = `${month} ${start.year}`;
      },

      removeEventTrigger(item) {
        this.dialogRemoveEvent = true;
        this.removeId = item.id;
        this.removeName = item.name;
      },

      removeEvent() {
        const events = this.events.filter((event) => event.id !== this.removeId);
        store.set(`eventsManagement/events`, events);
        this.dialogRemoveEvent = false;
        this.snackbarSuccess(`{this.removeName} is removed`);
      },

      closeDialogTimeShift() {
        this.dialogTimeShift = false;
        this.fullTime = false;
        this.editing = false;
        this.selectedEmployee = [];
      },

      toggleEmployees() {
        this.$nextTick(() => {
          if (this.selectedAllEmployees) {
            this.selectedEmployee = [];
          } else {
            this.selectedEmployee = this.allUsers.slice();
          }
        });
      },

      clearEvents() {
        store.set(`eventsManagement/events`, []);
        this.snackbarSuccess(`Events cleared`);
      },

      nextDay() {
        this.calendar = moment(this.calendar).add(1, 'd').format('YYYY-MM-DD');
      },

      previousDay() {
        this.calendar = moment(this.calendar).subtract(1, 'd').format('YYYY-MM-DD');
      },

      openTimeShiftDialog() {
        this.dialogTimeShift = true;
        Object.assign(this.event, initialEvent());
        this.event.date = this.calendar;
      },

      eventDay(event) {
        this.dialogTimeShift = true;
        this.eventIndex = this.events.findIndex((e) => e.id === event.event.id);
        this.event = this.events[this.eventIndex];
        this.selectedEmployee = this.event;
        this.editing = true;
      },

      fullEmployeeName(item) {
        return `${capitalize(item.entity.first_name)} ${capitalize(item.entity.last_name)}`;
      },

      validateEventForm() {
        this.$refs.eventForm.validate().then((success) => {
          if (success) {
            this.saveEvent();
          } else {
            this.snackbarError('There was an error saving');
          }
        });
      },

      saveEvent() {
        if (this.editing) {
          this.event.start = `${this.event.date} ${this.event.timeStart}`;
          this.event.end = `${this.event.date} ${this.event.timeEnd}`;
          this.event.name = this.fullEmployeeName(this.selectedEmployee);
          this.event.category = this.fullEmployeeName(this.selectedEmployee);
          this.event.entity = { ...this.selectedEmployee.entity };
          this.calendar = this.event.date;
          this.snackbarSuccess(`Event saved, current date: ${moment(this.event.date).format('dddd, MMMM Do YYYY')}`);
          store.set(`eventsManagement/events@${this.eventIndex}`, this.event);
          this.editing = false;
          this.fullTime = false;
          this.dialogTimeShift = false;
        } else {
          for (const employee of this.selectedEmployee) {
            const payload = {
              avatar: employee.avatar,
              // color: randomHexColor(),
              color: 'transparent',
              name: `${capitalize(employee.entity.first_name)} ${capitalize(employee.entity.last_name)}`,
              id: uuidv4(),
              end: this.selectedDatetimeEnd,
              start: this.selectedDatetimeStart,
              timed: false,
              timeStart: this.event.timeStart,
              entity: { ...employee.entity },
              timeEnd: this.event.timeEnd,
              date: this.event.date,
              category: `${capitalize(employee.entity.first_name)} ${capitalize(employee.entity.last_name)}`,
            };

            store.set(`eventsManagement/events@${this.events.length}`, payload);

            if (this.selectedEmployee[this.selectedEmployee.length - 1] === employee) {
              this.snackbarSuccess(`Event created, current date: ${moment(this.event.date).format('dddd, MMMM Do YYYY')}`);
              this.dialogTimeShift = false;
              this.fullTime = false;
            }
          }
        }

        this.calendar = this.event.date;
      },

      getEventColor(event) {
        return event.color;
      },

      viewDay(date) {
        this.type = 'day';
        this.calendar = date;
      },

      rnd(a, b) {
        return Math.floor((b - a + 1) * Math.random()) + a;
      },
    },
  };
</script>
<style scoped>
  ::v-deep .theme--dark.v-calendar-daily .v-calendar-daily__intervals-body .v-calendar-daily__interval-text {
    color: #fff;
  }

  ::v-deep .theme--dark.v-calendar-events .v-event-timed {
    border: 1px solid #424242 !important;
  }
</style>
