<template>
  <div>
    <base-flex-container>
      <template #top>
        <div class="d-flex align-center">
          <v-btn icon class="ma-2" @click="$refs.calendar.prev()">
            <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
          <v-select
            v-model="type"
            :items="types"
            dense
            hide-details
            class="ma-2"
            label="type"
            solo
          ></v-select>
          <v-select
            v-model="mode"
            :items="modes"
            dense
            solo
            hide-details
            label="event-overlap-mode"
            class="ma-2"
          ></v-select>
          <v-select
            v-model="weekday"
            :items="weekdays"
            dense
            solo
            hide-details
            label="weekdays"
            class="ma-2"
          ></v-select>

          <v-btn
            v-if="type === 'day'"
            small
            fab
            icon
            @click="
              dialogTimeShift = true;
              event.date = calendar;
            "
          >
            <v-icon> mdi-plus</v-icon></v-btn
          >

          <v-spacer></v-spacer>
          <v-btn icon class="ma-2" @click="$refs.calendar.next()">
            <v-icon>mdi-chevron-right</v-icon>
          </v-btn>
          <v-btn v-if="type !== 'month'" icon class="ma-2 mr-4" @click="type = 'month'">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </div>
      </template>

      <v-calendar
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
            <v-btn x-small fab icon @click="viewDay(date)">{{ day }} </v-btn>
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
      @save="saveEvent()"
      @close="dialogTimeShift = false"
    >
      <v-form @submit.prevent="addRecord()">
        <v-row>
          <v-col sm="6">
            <baseFieldLabel required label="Employee" />
            <v-select
              v-model="event.selectedEmployee"
              hide-details
              :items="employees"
              hide-no-data
              dense
              solo
              height="55"
              :background-color="isDark ? '#28292b' : 'white'"
              :menu-props="{
                transition: 'slide-y-transition',
              }"
            />
          </v-col>

          <v-col sm="6"> </v-col>

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
              height="55"
              :background-color="isDark ? '#28292b' : 'white'"
              :items="hours"
              hide-no-data
              solo
            />
          </v-col>

          <v-col sm="3">
            <baseFieldLabel required label="End Time" />
            <v-select
              v-model="event.timeEnd"
              height="55"
              :background-color="isDark ? '#28292b' : 'white'"
              :items="hours"
              hide-no-data
              solo
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
  import { sync } from 'vuex-pathify';
  import activeView from '@/mixins/activeView';
  import { store } from '@/store';

  export default {
    name: 'Timeshiftsplanning',
    mixins: [activeView],
    data: () => ({
      eventIndex: 0,
      editing: false,
      event: {
        date: '',
        timeStart: '',
        timeEnd: '',
        selectedEmployee: '',
      },

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
      ],

      employees: ['Pablo', 'Rene', 'Santiago'],
      dialogTimeShift: false,
      type: 'month',
      types: ['month', 'week', 'day', '4day'],
      mode: 'stack',
      modes: ['stack', 'column'],
      weekday: [0, 1, 2, 3, 4, 5, 6],
      weekdays: [
        { text: 'Sun - Sat', value: [0, 1, 2, 3, 4, 5, 6] },
        { text: 'Mon - Sun', value: [1, 2, 3, 4, 5, 6, 0] },
        { text: 'Mon - Fri', value: [1, 2, 3, 4, 5] },
        { text: 'Mon, Wed, Fri', value: [1, 3, 5] },
      ],
      calendar: '',
      colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],
      names: ['Meeting', 'Holiday', 'PTO', 'Travel', 'Event', 'Birthday', 'Conference', 'Party'],
    }),
    computed: {
      ...sync('eventsManagement', ['events']),

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

    methods: {
      eventDay(event) {
        this.dialogTimeShift = true;
        this.eventIndex = this.events.findIndex((e) => e.id === event.event.id);
        this.event = this.events[this.eventIndex];
        this.editing = true;
      },

      saveEvent() {
        if (this.editing) {
          this.event.start = `${this.event.date} ${this.event.timeStart}`;
          this.event.end = `${this.event.date} ${this.event.timeEnd}`;
          this.event.name = this.event.selectedEmployee;
          store.set(`eventsManagement/events@${this.eventIndex}`, this.event);
          this.editing = false;
        } else {
          const payload = {
            id: uuidv4(),
            name: this.event.selectedEmployee,
            selectedEmployee: this.event.selectedEmployee,
            color: 'primary',
            start: this.selectedDatetimeStart,
            end: this.selectedDatetimeEnd,
            timed: false,
            timeStart: this.event.timeStart,
            timeEnd: this.event.timeEnd,
            date: this.event.date,
          };

          store.set(`eventsManagement/events@${this.events.length}`, payload);
        }

        this.dialogTimeShift = false;
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
