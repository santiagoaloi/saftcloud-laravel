import Vue from 'vue';
import moment from 'moment';

Vue.filter('capitalize', (value) => {
  if (!value) return '';
  value = value.toString();
  return value.charAt(0).toUpperCase() + value.slice(1);
});

Vue.filter('momentDate', (value) => {
  //  moment.locale("es");
  value = moment(value).format('lll');
  return value;
});

Vue.filter('momentDateAgo', (value) => {
  //  moment.locale("es");
  const formatted = moment(value).fromNow();
  return formatted;
});
