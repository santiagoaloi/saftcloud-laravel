import Vue from "vue";
import moment from "moment";

Vue.filter("mpagoFormat", function (value) {
  if (!value) return "";
  value = value.replace("efectivo", "EF");
  value = value.replace("tarjetadebito", "TD");
  value = value.replace("tarjetacredito", "TC");
  value = value.replace("cuentacorriente", "CC");
  return value;
});

Vue.filter("redondeo", function (value) {
  if (!value) return "";
  value = parseFloat(value).toFixed(2);
  return value;
});

Vue.filter("sinCeros", function (value) {
  if (!value) return "";
  value = parseFloat(value);
  return value;
});

Vue.filter("capitalize", function (value) {
  if (!value) return "";
  value = value.toString();
  return value.charAt(0).toUpperCase() + value.slice(1);
});

Vue.filter("momentDate", function (value) {
  moment.locale("es");
  value = moment(value).format("Do MMM YYYY");
  return value;
});

Vue.filter("momentDateAgo", function (value) {
  moment.locale("es");
  let formatted = moment(value).fromNow();
  return formatted;
});
