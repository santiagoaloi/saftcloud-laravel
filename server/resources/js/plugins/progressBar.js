import Vue from "vue";
import VueProgressBar from "vue-progressbar";

const options = {
  color: "#00BFA5",
  thickness: "4px",
  transition: {
    speed: "0.6s",
    opacity: "0.5s",
    termination: 1200,
  },
  autoRevert: false,
  location: "top",
  inverse: false,
  position: "absolute",
  autoFinish: true,
};

Vue.use(VueProgressBar, options);
