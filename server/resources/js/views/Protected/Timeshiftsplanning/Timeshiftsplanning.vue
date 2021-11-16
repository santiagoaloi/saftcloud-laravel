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

          <v-toolbar-title v-if="$refs.calendar" class="mr-2">
            {{ $refs.calendar.title }}
          </v-toolbar-title>

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
            item-color="bluegrey"
            :items="types"
            dense
            hide-details
            class="ma-2"
            label="type"
            solo
          ></v-select>
          <v-select
            v-model="mode"
            item-color="bluegrey"
            :items="modes"
            dense
            solo
            hide-details
            label="event-overlap-mode"
            class="ma-2"
          ></v-select>
          <v-select
            v-model="weekday"
            item-color="bluegrey"
            :items="weekdays"
            dense
            solo
            hide-details
            label="weekdays"
            class="ma-2"
          ></v-select>

          <v-tooltip v-if="type === 'day'" bottom>
            <template #activator="{ on }">
              <v-btn small fab icon v-on="on" @click="openTimeShiftDialog()"> <v-icon> mdi-plus</v-icon></v-btn>
            </template>
            <span>Add new event</span>
          </v-tooltip>

          <v-spacer></v-spacer>

          <v-btn color="#393d47" class="ma-2" @click="clearEvents()"> <v-icon left>mdi-close</v-icon> Clear events </v-btn>

          <v-tooltip v-if="type === 'day'" bottom max-width="250">
            <template #activator="{ on }">
              <v-btn icon v-on="on" @click="type = 'month'">
                <v-icon>mdi-close</v-icon>
              </v-btn>
            </template>
            Close day view
          </v-tooltip>

          <v-tooltip bottom max-width="250">
            <template #activator="{ on }">
              <v-btn icon class="ma-2" v-on="on" @click="$refs.calendar.next()">
                <v-icon>mdi-chevron-right</v-icon>
              </v-btn>
            </template>
            Next Month
          </v-tooltip>
        </div>
      </template>

      <v-calendar
        :key="calKey"
        ref="calendar"
        v-model="calendar"
        show-week
        class="overflow-x-hidden"
        :weekdays="weekday"
        :type="type"
        :events="events"
        :event-overlap-mode="mode"
        :event-overlap-threshold="30"
        :event-color="getEventColor"
        @click:event="eventDay"
      >
        <template #day-label="{ day, date }">
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
      v-if="dialogTimeShift"
      v-model="dialogTimeShift"
      width="50vw"
      title="Time shift"
      icon="mdi-calendar-account"
      persistent
      @save="saveEvent()"
      @close="(dialogTimeShift = false), (fullTime = false)"
    >
      <v-form @submit.prevent="addRecord()">
        <v-row>
          <v-col sm="6">
            <baseFieldLabel required label="Employee" />
            <v-select
              v-model="selectedEmployee"
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
              item-value="entity.id"
              dense
              solo
              height="55"
              :background-color="isDark ? '#28292b' : 'white'"
            >
              <template v-if="!editing" #prepend-item>
                <v-list-item @click="toggleEmployees">
                  <v-list-item-action>
                    <v-icon :color="selectedEmployee.length > 0 ? 'white' : ''">
                      {{ icon }}
                    </v-icon>
                  </v-list-item-action>
                  <v-list-item-content>
                    <v-list-item-title> Select All Employees </v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
              </template>

              <template #selection="{ item, index }">
                <v-chip v-if="index === 0">
                  <span>{{ fullEmployeeName(item) }}</span>
                </v-chip>
                <span v-if="index === 1" class="white--text"> (+{{ selectedEmployee.length - 1 }} others) </span>
              </template>
            </v-select>
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
                <v-text-field
                  v-model="event.date"
                  height="55"
                  solo
                  prepend-inner-icon="mdi-account"
                  :outlined="isDark"
                  :color="isDark ? '#208ad6' : 'grey'"
                  :background-color="isDark ? '#28292b' : 'white'"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="event.date"
                show-week
                no-title
                scrollable
                @change="
                  $refs.menu.save(event.date);
                  menuStart = false;
                "
              >
              </v-date-picker>
            </v-menu>
          </v-col>
          <v-col sm="3">
            <baseFieldLabel required label="Start Time" />
            <v-select
              v-model="event.timeStart"
              item-color="bluegrey"
              height="55"
              :background-color="isDark ? '#28292b' : 'white'"
              :items="hours"
              hide-no-data
              solo
              :disabled="fullTime"
            />
          </v-col>

          <v-col sm="3">
            <baseFieldLabel required label="End Time" />
            <v-select
              v-model="event.timeEnd"
              item-color="bluegrey"
              height="55"
              :background-color="isDark ? '#28292b' : 'white'"
              :items="hours"
              hide-no-data
              solo
              :disabled="fullTime"
            />
          </v-col>
        </v-row>
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

  const randomHexColor = require('random-hex-color');

  const initialEvent = () => ({
    date: '',
    timeStart: '',
    timeEnd: '',
  });

  export default {
    name: 'Timeshiftsplanning',
    mixins: [activeView],
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
      types: ['month', 'week', 'day', '4day'],
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
      colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],
      names: ['Meeting', 'Holiday', 'PTO', 'Travel', 'Event', 'Birthday', 'Conference', 'Party'],
    }),
    computed: {
      ...sync('eventsManagement', ['events']),
      ...sync('entitiesManagement', ['allUsers']),

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

    mounted() {
      this.calKey += 1;
    },

    methods: {
      ...call('snackbar/*'),

      toggleEmployees() {
        this.$nextTick(() => {
          if (this.selectedAllEmployees) {
            this.selectedEmployee = [];
          } else {
            for (const employee of this.allUsers) {
              this.selectedEmployee.push(employee.entity.id);
            }
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
        this.selectedEmployee.push(this.event.id);
        this.editing = true;
      },

      lookupEmployee(id) {
        return this.allUsers.find((e) => e.entity.id === id);
      },

      fullEmployeeName(item) {
        if (this.editing) {
          return 'item.name';
        }
        return `${capitalize(item.entity.first_name)} ${capitalize(item.entity.last_name)} `;
      },

      saveEvent() {
        if (this.editing) {
          this.event.start = `${this.event.date} ${this.event.timeStart}`;
          this.event.end = `${this.event.date} ${this.event.timeEnd}`;
          this.event.id = this.selectedEmployee;
          this.event.name = this.fullEmployeeName(this.lookupEmployee(this.event.id));
          store.set(`eventsManagement/events@${this.eventIndex}`, this.event);
          this.editing = false;
          this.calendar = this.event.date;
          this.snackbarSuccess(`Event saved, current date: ${moment(this.event.date).format('MMMM Do')}`, 'centered');
          this.dialogTimeShift = false;
          this.fullTime = false;
        } else {
          for (const employee of this.selectedEmployee) {
            const payload = {
              color: randomHexColor(),
              name: this.fullEmployeeName(this.lookupEmployee(employee)),
              id: this.lookupEmployee(employee).entity.id,
              end: this.selectedDatetimeEnd,
              start: this.selectedDatetimeStart,
              timed: false,
              timeStart: this.event.timeStart,
              timeEnd: this.event.timeEnd,
              date: this.event.date,
            };

            store.set(`eventsManagement/events@${this.events.length}`, payload);

            if (this.selectedEmployee[this.selectedEmployee.length - 1] === employee) {
              this.snackbarSuccess(`Event created, current date: ${moment(this.event.date).format('MMMM Do')}`, 'centered');
              this.dialogTimeShift = false;
              this.fullTime = false;
            }
          }
        }

        this.calendar = this.event.date;
      },

      viewDay(date) {
        this.type = 'day';
        this.calendar = date;
      },

      getEvents({ start, end }) {
        const events = [];

        const min = new Date(`${start.date}T00:00:00`);
        const max = new Date(`${end.date}T23:59:59`);
        const days = (max.getTime() - min.getTime()) / 86400000;
        const eventCount = this.rnd(days, days + 20);

        for (let i = 0; i < eventCount; i++) {
          const allDay = this.rnd(0, 3) === 0;
          const firstTimestamp = this.rnd(min.getTime(), max.getTime());
          const first = new Date(firstTimestamp - (firstTimestamp % 900000));
          const secondTimestamp = this.rnd(2, allDay ? 288 : 8) * 900000;
          const second = new Date(first.getTime() + secondTimestamp);

          events.push({
            name: this.names[this.rnd(0, this.names.length - 1)],
            start: first,
            end: second,

            color: this.colors[this.rnd(0, this.colors.length - 1)],
            timed: !allDay,
          });
        }

        this.events = events;
      },
      getEventColor(event) {
        return event.color;
      },
      rnd(a, b) {
        return Math.floor((b - a + 1) * Math.random()) + a;
      },
    },
  };
</script>
