import Vue from "vue";
import moment from "moment";

Vue.filter("capitalize", function(value) {
 if (!value) return "";
 value = value.toString();
 return value.charAt(0).toUpperCase() + value.slice(1);
});

Vue.filter("momentDate", function(value) {
 //  moment.locale("es");
 value = moment(value).format("lll");
 return value;
});

Vue.filter("momentDateAgo", function(value) {
 //  moment.locale("es");
 let formatted = moment(value).fromNow();
 return formatted;
});
